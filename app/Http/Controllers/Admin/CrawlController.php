<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktifitas;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use DOMDocument;
use DOMXPath;
use Throwable;

class CrawlController extends Controller
{
    public function index()
    {
        $pendingCount = Lowongan::where('sumber', 'crawl')
            ->where('status', 'draft')
            ->count();

        $crawlSummary = Cache::get($this->summaryKey(), [
            'status' => 'idle',
            'created' => 0,
            'skipped' => 0,
            'failed' => 0,
            'started_at' => null,
            'finished_at' => null,
            'source_count' => 0,
        ]);

        $lastRunAt = Cache::get($this->lastRunKey());
        $dailyRuns = (int) Cache::get($this->dailyCountKey(), 0);

        // Menampilkan lowongan hasil crawl yang butuh validasi
        $crawledLowongans = Lowongan::with(['perusahaan', 'jurusan'])
            ->where('sumber', 'crawl')
            ->where('status', 'draft')
            ->latest('tanggal_posting')
            ->paginate(15);

        $recentLogs = LogAktifitas::with('admin')
            ->where('aksi', 'crawl lowongan')
            ->latest()
            ->take(5)
            ->get();

        $crawlResults = Cache::get($this->resultsKey(), []);

        $cooldownRemaining = 0;
        if ($lastRunAt) {
            $cooldownEndsAt = \Carbon\Carbon::parse($lastRunAt)->addMinutes((int) config('crawl.cooldown_minutes', 240));
            $cooldownRemaining = max(0, now()->diffInMinutes($cooldownEndsAt, false));
        }

        return view('admin.crawl.index', compact(
            'crawledLowongans',
            'pendingCount',
            'crawlSummary',
            'dailyRuns',
            'cooldownRemaining',
            'recentLogs',
            'crawlResults'
        ));
    }

    public function process(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if (! $admin || (int) $admin->getAuthIdentifier() !== (int) config('crawl.main_admin_id', 1)) {
            abort(403, 'Hanya admin utama yang dapat menjalankan crawler.');
        }

        $validated = $request->validate([
            'source_urls' => ['nullable', 'string', 'max:5000'],
        ]);

        if ($this->isCoolingDown()) {
            return redirect()->route('admin.crawl.index')->with('error', 'Crawler masih dalam cooldown. Coba lagi nanti.');
        }

        $dailyLimit = (int) config('crawl.daily_limit', 3);
        $dailyRuns = (int) Cache::get($this->dailyCountKey(), 0);

        if ($dailyRuns >= $dailyLimit) {
            return redirect()->route('admin.crawl.index')->with('error', 'Limit crawling harian sudah habis.');
        }

        $sourceUrls = $this->normalizeSourceUrls($validated['source_urls'] ?? '');

        if (empty($sourceUrls)) {
            $sourceUrls = $this->normalizeSourceUrls(implode("\n", (array) config('crawl.default_source_urls', [])));
        }

        if (empty($sourceUrls)) {
            return redirect()->route('admin.crawl.index')->with('error', 'Masukkan minimal satu URL sumber yang valid dan diizinkan.');
        }

        $sourceUrls = array_slice($sourceUrls, 0, (int) config('crawl.max_urls_per_run', 5));

        Cache::put($this->lastRunKey(), now()->toDateTimeString(), now()->addDays(2));
        Cache::put($this->dailyCountKey(), $dailyRuns + 1, now()->endOfDay());
        Cache::put($this->statusKey(), 'queued', now()->addDays(2));
        Cache::put($this->summaryKey(), [
            'status' => 'queued',
            'created' => 0,
            'skipped' => 0,
            'failed' => 0,
            'started_at' => now()->toDateTimeString(),
            'finished_at' => null,
            'source_count' => count($sourceUrls),
        ], now()->addDays(2));

        $adminId = (int) $admin->getAuthIdentifier();

        app()->terminating(function () use ($sourceUrls, $adminId) {
            $this->runCrawlSourceUrls($sourceUrls, $adminId);
        });

        return redirect()->route('admin.crawl.index')->with('success', 'Proses crawling dijalankan setelah response selesai.');
    }

    public function status()
    {
        $summary = Cache::get($this->summaryKey(), [
            'status' => 'idle',
            'created' => 0,
            'skipped' => 0,
            'failed' => 0,
            'started_at' => null,
            'finished_at' => null,
            'source_count' => 0,
        ]);

        $lastRunAt = Cache::get($this->lastRunKey());
        $cooldownRemaining = 0;

        if ($lastRunAt) {
            $cooldownEndsAt = \Carbon\Carbon::parse($lastRunAt)->addMinutes((int) config('crawl.cooldown_minutes', 240));
            $cooldownRemaining = max(0, now()->diffInMinutes($cooldownEndsAt, false));
        }

        return response()->json([
            'status' => $summary['status'] ?? 'idle',
            'summary' => $summary,
            'daily_runs' => (int) Cache::get($this->dailyCountKey(), 0),
            'pending_count' => Lowongan::where('sumber', 'crawl')->where('status', 'draft')->count(),
            'cooldown_remaining' => $cooldownRemaining,
            'results' => Cache::get($this->resultsKey(), []),
            'recent_logs' => LogAktifitas::with('admin')
                ->where('aksi', 'crawl lowongan')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($log) {
                    return [
                        'aksi' => $log->aksi,
                        'detail' => $log->detail,
                        'admin' => $log->admin->nama ?? 'Admin',
                        'created_at' => $log->created_at?->diffForHumans(),
                    ];
                })
                ->values(),
        ]);
    }

    public function runCrawlSourceUrls(array $sourceUrls, int $adminId): array
    {
        $normalized = $this->normalizeSourceUrls(implode("\n", $sourceUrls));
        return $this->executeCrawl($normalized, $adminId);
    }

    public function approve($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->update(['status' => 'aktif']);

        return redirect()->route('admin.crawl.index')->with('success', 'Lowongan hasil crawl berhasil disetujui.');
    }

    private function executeCrawl(array $sourceUrls, int $adminId): array
    {
        $created = 0;
        $skipped = 0;
        $failed = 0;
        $results = [];

        Cache::put($this->statusKey(), 'running', now()->addDays(2));
        $summary = Cache::get($this->summaryKey(), []);
        $summary['status'] = 'running';
        $summary['started_at'] = $summary['started_at'] ?? now()->toDateTimeString();
        Cache::put($this->summaryKey(), $summary, now()->addDays(2));

        foreach ($sourceUrls as $sourceUrl) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                ])
                    ->timeout((int) config('crawl.timeout_seconds', 15))
                    ->retry((int) config('crawl.retry_times', 2), 300)
                    ->get($sourceUrl);

                if (! $response->successful()) {
                    $failed++;
                    $results[] = [
                        'source_url' => $sourceUrl,
                        'status' => 'failed',
                        'message' => 'Halaman tidak berhasil diambil (HTTP ' . $response->status() . ').',
                    ];
                    continue;
                }

                $blockedReason = $this->detectBlockedContent($sourceUrl, $response->body());

                if ($blockedReason) {
                    $failed++;
                    $results[] = [
                        'source_url' => $sourceUrl,
                        'status' => 'failed',
                        'message' => $blockedReason,
                    ];
                    continue;
                }

                $data = $this->extractLowonganData($sourceUrl, $response->body());

                if (empty($data['judul']) || empty($data['deskripsi'])) {
                    $skipped++;
                    $results[] = [
                        'source_url' => $sourceUrl,
                        'status' => 'skipped',
                        'message' => 'Konten lowongan tidak cukup jelas untuk diproses.',
                    ];
                    continue;
                }

                $perusahaan = Perusahaan::firstOrCreate(
                    ['nama_perusahaan' => $data['nama_perusahaan']],
                    [
                        'deskripsi' => $data['perusahaan_deskripsi'],
                        'sektor_industri' => 'Hasil crawl',
                        'logo' => null,
                        'is_mitra' => false,
                        'website' => $sourceUrl,
                    ]
                );

                $exists = Lowongan::where('sumber', 'crawl')
                    ->where(function ($query) use ($sourceUrl, $data, $perusahaan) {
                        $query->where('link_apply', $sourceUrl)
                            ->orWhere(function ($innerQuery) use ($data, $perusahaan) {
                                $innerQuery->where('judul', $data['judul'])
                                    ->where('perusahaan_id', $perusahaan->getKey());
                            });
                    })
                    ->exists();

                if ($exists) {
                    $skipped++;
                    $results[] = [
                        'source_url' => $sourceUrl,
                        'status' => 'skipped',
                        'message' => 'Lowongan sudah pernah tersimpan sebelumnya.',
                    ];
                    continue;
                }

                Lowongan::create([
                    'judul' => $data['judul'],
                    'deskripsi' => $data['deskripsi'],
                    'link_apply' => $data['link_apply'],
                    'sumber' => 'crawl',
                    'status' => 'draft',
                    'tanggal_posting' => now(),
                    'tanggal_expired' => now()->addDays((int) config('crawl.default_expired_days', 30)),
                    'lokasi' => $data['lokasi'],
                    'tipe_pekerjaan' => $data['tipe_pekerjaan'],
                    'gaji' => null,
                    'perusahaan_id' => $perusahaan->getKey(),
                    'jurusan_id' => null,
                    'admin_id' => $adminId,
                ]);

                $created++;
                $results[] = [
                    'source_url' => $sourceUrl,
                    'status' => 'created',
                    'message' => 'Berhasil dibuat sebagai draft.',
                    'title' => $data['judul'],
                ];
            } catch (Throwable $throwable) {
                $failed++;
                $results[] = [
                    'source_url' => $sourceUrl,
                    'status' => 'failed',
                    'message' => $throwable->getMessage(),
                ];
                report($throwable);
            }
        }

        $summary = [
            'status' => 'finished',
            'created' => $created,
            'skipped' => $skipped,
            'failed' => $failed,
            'started_at' => Cache::get($this->summaryKey(), [])['started_at'] ?? now()->toDateTimeString(),
            'finished_at' => now()->toDateTimeString(),
            'source_count' => count($sourceUrls),
        ];

        Cache::put($this->statusKey(), 'finished', now()->addDays(2));
        Cache::put($this->summaryKey(), $summary, now()->addDays(2));
        Cache::put($this->resultsKey(), array_slice(array_reverse($results), 0, 10), now()->addDays(2));

        LogAktifitas::create([
            'admin_id' => $adminId,
            'aksi' => 'crawl lowongan',
            'detail' => 'Crawler selesai. Sumber: ' . count($sourceUrls) . ', dibuat: ' . $created . ', dilewati: ' . $skipped . ', gagal: ' . $failed,
        ]);

        return $summary;
    }

    private function detectBlockedContent(string $sourceUrl, string $html): ?string
    {
        $host = $this->canonicalHost(parse_url($sourceUrl, PHP_URL_HOST) ?: '');
        $normalizedHtml = Str::lower($html);

        if ($host === 'linkedin.com') {
            if (Str::contains($normalizedHtml, ['<title>linkedin: log in or sign up</title>', '<title>sign in | linkedin</title>', 'authwall', '/checkpoint/'])) {
                return 'LinkedIn sering menampilkan halaman login/anti-bot, jadi halaman ini tidak bisa diproses dengan crawler publik.';
            }

            if (Str::contains($normalizedHtml, ['our mission is to connect', 'session expired'])) {
                return 'LinkedIn menolak akses publik untuk halaman ini.';
            }
        }

        return null;
    }

    private function extractLowonganData(string $sourceUrl, string $html): array
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        $title = $this->firstNonEmpty([
            $this->evaluateString($xpath, '//meta[@property="og:title"]/@content'),
            $this->evaluateString($xpath, '//title'),
            $this->evaluateString($xpath, '//h1'),
        ]);

        // Try to extract full rich text description from known DOM classes first (e.g. LinkedIn guest detail markup)
        $descriptionNode = $xpath->query('//div[contains(@class, "show-more-less-html__markup")]')->item(0)
            ?? $xpath->query('//div[contains(@class, "description__text")]')->item(0)
            ?? $xpath->query('//div[contains(@class, "job-description")]')->item(0);

        $description = null;
        if ($descriptionNode) {
            $description = $this->getInnerHtml($descriptionNode);
        }

        if (empty($description)) {
            $description = $this->firstNonEmpty([
                $this->evaluateString($xpath, '//meta[@name="description"]/@content'),
                $this->evaluateString($xpath, '//meta[@property="og:description"]/@content'),
                $this->shortenText($this->evaluateString($xpath, '//body')),
            ]);
        }

        // Clean up company name and title if it has typical LinkedIn guest format: "Company hiring Title in Location | LinkedIn"
        $companyName = null;
        $location = null;
        if (Str::contains($sourceUrl, 'linkedin.com') && $title) {
            // "Kalbe Nutritionals (PT Sanghiang Perkasa) hiring IT Support in Bogor, West Java, Indonesia | LinkedIn"
            if (preg_match('/^(.*?)\s+hiring\s+(.*?)\s+in\s+(.*?)\s*\|/i', $title, $matches)) {
                $companyName = trim($matches[1]);
                $location = trim($matches[3]);
                // We can also extract the clean job title from here to avoid the cluttered page title
                $title = trim($matches[2]);
            }
        }

        if (! $companyName) {
            $companyName = $this->firstNonEmpty([
                $this->evaluateString($xpath, '//meta[@property="og:site_name"]/@content'),
                $this->hostToCompanyName(parse_url($sourceUrl, PHP_URL_HOST) ?: 'Sumber Crawl'),
            ]);
        }

        $linkApply = $this->firstNonEmpty([
            $this->findApplyLink($xpath),
            $sourceUrl,
        ]);

        // Ensure apply link is a valid external URL, not an internal relative auth link
        if ($linkApply && (Str::startsWith($linkApply, '/') || Str::contains($linkApply, 'login') || Str::contains($linkApply, 'signup'))) {
            $linkApply = $sourceUrl;
        }

        if (! $location) {
            $location = $this->firstNonEmpty([
                $this->evaluateString($xpath, '//meta[@name="jobLocation"]/@content'),
                $this->evaluateString($xpath, '//meta[@property="og:location"]/@content'),
                $this->hostToLocation(parse_url($sourceUrl, PHP_URL_HOST) ?: ''),
            ]);
        }

        // Apply a title prefix if configured
        if ($title && ($prefix = config('crawl.job_title_prefix'))) {
            if (! Str::startsWith($title, $prefix)) {
                $title = $prefix . $title;
            }
        }

        return [
            'judul' => $title ? trim($title) : null,
            'deskripsi' => $description ? trim($description) : null,
            'link_apply' => $linkApply ? trim($linkApply) : null,
            'nama_perusahaan' => trim($companyName),
            'perusahaan_deskripsi' => 'Perusahaan hasil crawl dari sumber publik.',
            'lokasi' => $location ? trim($location) : 'Indonesia',
            'tipe_pekerjaan' => $this->inferJobType($title . ' ' . $description),
        ];
    }

    private function findApplyLink(DOMXPath $xpath): ?string
    {
        $nodes = $xpath->query('//a[@href]');

        if (! $nodes) {
            return null;
        }

        foreach ($nodes as $node) {
            $href = trim((string) $node->attributes?->getNamedItem('href')?->nodeValue);
            $label = Str::lower(trim($node->textContent ?? ''));

            if ($href === '') {
                continue;
            }

            if (Str::contains($label, ['apply', 'lamar', 'daftar', 'submit']) || Str::contains(Str::lower($href), ['apply', 'career', 'job', 'vacancy'])) {
                return $href;
            }
        }

        return null;
    }

    private function inferJobType(string $text): ?string
    {
        $normalized = Str::lower($text);

        if (Str::contains($normalized, ['intern', 'magang', 'prakerin'])) {
            return 'Internship';
        }

        if (Str::contains($normalized, ['part time', 'part-time', 'freelance'])) {
            return 'Part-time';
        }

        if (Str::contains($normalized, ['contract', 'kontrak', 'project based'])) {
            return 'Contract';
        }

        return 'Full-time';
    }

    private function normalizeSourceUrls(string $sourceUrls): array
    {
        $rawUrls = preg_split('/[\r\n,;]+/', $sourceUrls) ?: [];
        $allowedHosts = $this->allowedHosts();
        $normalizedUrls = [];

        foreach ($rawUrls as $rawUrl) {
            $url = trim($rawUrl);

            if ($url === '' || ! filter_var($url, FILTER_VALIDATE_URL)) {
                continue;
            }

            // Auto-convert query-parameter based LinkedIn job details to path-based to avoid 404/login wall
            if (Str::contains($url, 'linkedin.com/jobs/view') && Str::contains($url, 'currentJobId=')) {
                $parsed = parse_url($url);
                parse_str($parsed['query'] ?? '', $query);
                if (isset($query['currentJobId'])) {
                    $url = 'https://www.linkedin.com/jobs/view/' . trim($query['currentJobId']);
                }
            }

            $host = $this->canonicalHost(parse_url($url, PHP_URL_HOST) ?: '');

            if ($host === '' || ! $this->isAllowedHost($host, $allowedHosts)) {
                continue;
            }

            $normalizedUrls[] = $url;
        }

        return array_values(array_unique($normalizedUrls));
    }

    private function allowedHosts(): array
    {
        $allowedHosts = config('crawl.allowed_hosts', []) ?? [];

        return array_values(array_unique(array_filter(array_map(function ($host) {
            return $this->canonicalHost((string) $host);
        }, $allowedHosts))));
    }

    private function isAllowedHost(string $host, array $allowedHosts): bool
    {
        foreach ($allowedHosts as $allowedHost) {
            if ($host === $allowedHost || Str::endsWith($host, '.' . $allowedHost)) {
                return true;
            }
        }

        return false;
    }

    private function canonicalHost(string $host): string
    {
        $host = Str::lower(trim($host));

        if (Str::startsWith($host, 'www.')) {
            $host = Str::after($host, 'www.');
        }

        return $host;
    }

    private function evaluateString(DOMXPath $xpath, string $query): string
    {
        return trim((string) $xpath->evaluate('string(' . $query . ')'));
    }

    private function firstNonEmpty(array $values): ?string
    {
        foreach ($values as $value) {
            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
        }

        return null;
    }

    private function shortenText(string $text): string
    {
        return trim(Str::limit(preg_replace('/\s+/', ' ', strip_tags($text)), 2000, ''));
    }

    private function hostToCompanyName(string $host): string
    {
        $name = Str::title(str_replace(['-', '_', '.'], ' ', $this->canonicalHost($host)));

        return $name !== '' ? $name : 'Sumber Crawl';
    }

    private function hostToLocation(string $host): ?string
    {
        $canonical = $this->canonicalHost($host);

        if ($canonical === '') {
            return null;
        }

        return Str::title(str_replace(['-', '_', '.'], ' ', $canonical));
    }

    private function getInnerHtml(\DOMNode $node): string
    {
        $innerHTML = "";
        $children  = $node->childNodes;

        foreach ($children as $child) {
            $innerHTML .= $node->ownerDocument->saveHTML($child);
        }

        return trim($innerHTML);
    }

    private function isCoolingDown(): bool
    {
        $lastRunAt = Cache::get($this->lastRunKey());

        if (! $lastRunAt) {
            return false;
        }

        $cooldownMinutes = (int) config('crawl.cooldown_minutes', 240);
        $cooldownEndsAt = \Carbon\Carbon::parse($lastRunAt)->addMinutes($cooldownMinutes);

        return now()->lt($cooldownEndsAt);
    }

    private function dailyCountKey(): string
    {
        return 'crawl:daily_count:' . now()->toDateString();
    }

    private function lastRunKey(): string
    {
        return 'crawl:last_run_at';
    }

    private function statusKey(): string
    {
        return 'crawl:status';
    }

    private function summaryKey(): string
    {
        return 'crawl:summary';
    }

    private function resultsKey(): string
    {
        return 'crawl:results';
    }
}

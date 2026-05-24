<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\CrawlController;
use Illuminate\Console\Command;

class RunCrawlCommand extends Command
{
    protected $signature = 'crawl:run {--source-urls=} {--admin-id=}';

    protected $description = 'Run crawl jobs and persist valid results to the database';

    public function handle(CrawlController $crawlController): int
    {
        $sourceUrlsInput = (string) $this->option('source-urls');
        $sourceUrls = array_values(array_filter(array_map('trim', preg_split('/[\r\n,;]+/', $sourceUrlsInput) ?: [])));

        if (empty($sourceUrls)) {
            $sourceUrls = (array) config('crawl.default_source_urls', []);
        }

        if (empty($sourceUrls)) {
            $this->warn('No crawl source URLs configured.');

            return self::SUCCESS;
        }

        $sourceUrls = array_slice($sourceUrls, 0, (int) config('crawl.max_urls_per_run', 5));
        $adminId = (int) ($this->option('admin-id') ?: config('crawl.main_admin_id', 1));

        $summary = $crawlController->runCrawlSourceUrls($sourceUrls, $adminId);

        $this->info(sprintf(
            'Crawl finished. Created: %d, skipped: %d, failed: %d.',
            $summary['created'] ?? 0,
            $summary['skipped'] ?? 0,
            $summary['failed'] ?? 0
        ));

        return self::SUCCESS;
    }
}

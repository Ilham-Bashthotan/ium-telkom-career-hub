<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\User;
use App\Models\Perusahaan;
use App\Models\LogAktifitas;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLowongan = Lowongan::count();
        $activeLowongan = Lowongan::where('status', 'aktif')->count();
        $totalUsers = User::count();
        $totalMitra = Perusahaan::count();
        $pendingCrawl = Lowongan::where('sumber', 'crawl')->where('status', 'draft')->count();
        $crawlStatus = Cache::get('crawl:status', 'idle');
        $crawlSummary = Cache::get('crawl:summary', [
            'created' => 0,
            'skipped' => 0,
            'failed' => 0,
            'source_count' => 0,
            'started_at' => null,
            'finished_at' => null,
        ]);
        $crawlDailyRuns = (int) Cache::get('crawl:daily_count:' . now()->toDateString(), 0);
        $recentLowongans = Lowongan::with(['perusahaan', 'jurusan'])
            ->latest('updated_at')
            ->take(5)
            ->get();
        $recentActivities = LogAktifitas::with('admin')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalLowongan',
            'activeLowongan',
            'totalUsers',
            'totalMitra',
            'pendingCrawl',
            'crawlStatus',
            'crawlSummary',
            'crawlDailyRuns',
            'recentLowongans',
            'recentActivities'
        ));
    }
}

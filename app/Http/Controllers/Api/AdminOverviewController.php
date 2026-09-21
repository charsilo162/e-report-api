<?php

namespace App\Http\Controllers\Api;
//app/Http/Controllers/Api/AdminOverviewController.php

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Services\AdminStatsService;

class AdminOverviewController extends Controller
{
    public function __construct(protected AdminStatsService $stats)
    {
    }

    public function index()
    {
        $categoryOverview = $this->stats->categoryOverview();

        return response()->json([
            'reportMetrics' => $this->stats->reportMetrics(),
            'userMetrics' => $this->stats->userMetrics(),
            'topCategories' => $categoryOverview['top'],
            'categoryOverflow' => $categoryOverview['overflow'],
            'reportsPerDay' => $this->stats->reportsPerDay(),
            'categoryBreakdown' => $this->stats->categoryBreakdown(),
            'statusBreakdown' => $this->stats->statusBreakdown(),
            'activityLogs' => ActivityLog::latest()->take(10)->get()->map(fn ($log) => [
                'id' => $log->id,
                'title' => $log->title,
                'detail' => $log->detail.' · '.$log->created_at->diffForHumans(),
            ]),
        ]);
    }
}
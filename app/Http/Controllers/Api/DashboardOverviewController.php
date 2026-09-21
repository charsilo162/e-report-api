<?php

namespace App\Http\Controllers\Api;
//app/Http/Controllers/Api/DashboardOverviewController.php

use App\Http\Controllers\Controller;
use App\Services\DashboardStatsService;
use Illuminate\Http\Request;

class DashboardOverviewController extends Controller
{
    public function __construct(protected DashboardStatsService $stats)
    {
    }

    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'metrics' => $this->stats->metricsFor($user),
            'categories' => $this->stats->categoriesFor($user),
            'categoryBreakdown' => $this->stats->categoryBreakdownFor($user),
            'notifications' => $this->stats->recentActivityFor($user),
            'recentReports' => $this->stats->recentReportsFor($user),
        ]);
    }
}
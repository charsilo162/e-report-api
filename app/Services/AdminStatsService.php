<?php

namespace App\Services;

//app/Services/AdminStatsService.php
use App\Models\Category;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Carbon;

class AdminStatsService
{
    public function reportMetrics(): array
    {
        return [
            'total' => Report::count(),
            'underReview' => Report::where('status', 'Under Review')->count(),
            'resolved' => Report::where('status', 'Resolved')->count(),
            'rejected' => Report::where('status', 'Rejected')->count(),
            'anonymous' => Report::where('is_anonymous', true)->count(),
            'nonAnonymous' => Report::where('is_anonymous', false)->count(),
            'urgent' => Report::where('is_urgent', true)->count(),
        ];
    }

    public function userMetrics(): array
    {
        return [
            'total' => User::count(),
            'active' => User::whereNull('suspended_at')->count(),
            'suspended' => User::whereNotNull('suspended_at')->count(),
            'topReporters' => User::has('reports', '>=', 5)->count(),
        ];
    }

    public function categoryOverview(int $limit = 5): array
    {
        $counts = Category::withCount('reports')->orderByDesc('reports_count')->get();

        return [
            'top' => $counts->take($limit)->pluck('label')->values(),
            'overflow' => max(0, $counts->count() - $limit),
        ];
    }

    public function categoryBreakdown(): array
    {
        return Category::withCount('reports')
            ->having('reports_count', '>', 0)
            ->get()
            ->map(fn ($c) => ['label' => $c->label, 'value' => $c->reports_count])
            ->values()
            ->toArray();
    }

    public function statusBreakdown(): array
    {
        return Report::selectRaw('status, count(*) as value')
            ->groupBy('status')
            ->get()
            ->map(fn ($row) => ['label' => $row->status, 'value' => $row->value])
            ->values()
            ->toArray();
    }

    public function reportsPerDay(int $days = 11): array
    {
        $start = Carbon::now()->subDays($days - 1)->startOfDay();

        $counts = Report::selectRaw('DATE(created_at) as day, count(*) as value')
            ->where('created_at', '>=', $start)
            ->groupBy('day')
            ->pluck('value', 'day');

        $series = [];
        for ($i = 0; $i < $days; $i++) {
            $date = $start->copy()->addDays($i);
            $series[] = [
                'label' => $date->format('M d'),
                'value' => (int) ($counts[$date->format('Y-m-d')] ?? 0),
            ];
        }

        return $series;
    }
}
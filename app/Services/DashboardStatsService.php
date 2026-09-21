<?php

namespace App\Services;
//app/Services/DashboardStatsService.php

use App\Models\Category;
use App\Models\Report;
use App\Models\User;

class DashboardStatsService
{
    public function metricsFor(User $user): array
    {
        $reports = Report::where('user_id', $user->id);

        return [
            'total' => (clone $reports)->count(),
            'thisWeek' => (clone $reports)->where('created_at', '>=', now()->subDays(7))->count(),
            'pending' => (clone $reports)->whereIn('status', ['Submitted', 'Under Review', 'In Progress'])->count(),
            'resolved' => (clone $reports)->where('status', 'Resolved')->count(),
            'anonymous' => (clone $reports)->where('is_anonymous', true)->count(),
        ];
    }

    public function categoriesFor(User $user): array
    {
        return Category::whereHas('reports', fn ($q) => $q->where('user_id', $user->id))
            ->pluck('label')
            ->values()
            ->toArray();
    }

    public function categoryBreakdownFor(User $user): array
    {
        return Category::withCount(['reports' => fn ($q) => $q->where('user_id', $user->id)])
            ->having('reports_count', '>', 0)
            ->get()
            ->map(fn ($c) => ['label' => $c->label, 'value' => $c->reports_count])
            ->values()
            ->toArray();
    }

    public function recentActivityFor(User $user, int $limit = 6): array
    {
        return Report::where('user_id', $user->id)
            ->latest('updated_at')
            ->take($limit)
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'reportId' => 'REPT'.str_pad($r->id, 3, '0', STR_PAD_LEFT),
                'action' => 'Status changed to',
                'status' => $r->status,
            ])
            ->toArray();
    }

    public function recentReportsFor(User $user, int $limit = 5): array
    {
        return Report::where('user_id', $user->id)
            ->with('categories')
            ->latest()
            ->take($limit)
            ->get()
            ->map(fn ($r) => [
                'id' => '#REPT'.str_pad($r->id, 3, '0', STR_PAD_LEFT),
                'category' => $r->categories->pluck('label')->join(', '),
                'date' => $r->created_at->format('M d, Y - h:i A'),
                'status' => $r->status,
            ])
            ->toArray();
    }
}
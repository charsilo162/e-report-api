<?php

namespace App\Services;
//app/Services/PlatformWalletService.php

use App\Models\PlatformTopup;
use App\Models\Report;
use App\Models\WalletTransaction;

class PlatformWalletService
{
    public function balance(): float
    {
        $toppedUp = PlatformTopup::where('status', 'Completed')->sum('amount');

        $paidOut = WalletTransaction::where('type', 'Credit')
            ->whereNotNull('report_id')
            ->where('status', 'Completed')
            ->sum('amount');

        return (float) ($toppedUp - $paidOut);
    }

    public function metrics(): array
    {
        $payouts = WalletTransaction::where('type', 'Credit')->whereNotNull('report_id');
        $totalPayouts = (clone $payouts)->sum('amount');
        $paidReportsCount = (clone $payouts)->count();

        return [
            'reportsReviewed' => Report::whereIn('status', ['Approved', 'Rejected', 'Resolved', 'In Progress'])->count(),
            'approvedReports' => Report::where('status', 'Approved')->count(),
            'rejectedReports' => Report::where('status', 'Rejected')->count(),
            'totalPayouts' => $totalPayouts,
            'averagePayout' => $paidReportsCount > 0 ? round($totalPayouts / $paidReportsCount) : 0,
            'pendingWithdrawals' => WalletTransaction::where('type', 'Withdrawal')->where('status', 'Pending')->count(),
            'completedWithdrawals' => WalletTransaction::where('type', 'Withdrawal')->where('status', 'Completed')->count(),
        ];
    }

    public function paymentHistory(array $filters = [], int $perPage = 10)
    {
        return WalletTransaction::whereNotNull('report_id')
            ->where('type', 'Credit')
            ->with(['report', 'user'])
            ->when($filters['status'] ?? null, fn ($q, $status) =>
                $q->whereHas('report', fn ($q2) => $q2->where('status', $status))
            )
            ->when($filters['userType'] ?? null, function ($q, $type) {
                $q->whereHas('report', fn ($q2) => $q2->where('is_anonymous', $type === 'Anonymous'));
            })
            ->when($filters['from'] ?? null, fn ($q, $from) => $q->whereDate('created_at', '>=', $from))
            ->when($filters['to'] ?? null, fn ($q, $to) => $q->whereDate('created_at', '<=', $to))
            ->latest()
            ->paginate($perPage);
    }

    public function topupHistory(int $perPage = 10)
    {
        return PlatformTopup::latest()->paginate($perPage);
    }

    public function topUp(array $data): PlatformTopup
    {
        return PlatformTopup::create([
            'amount' => $data['amount'],
            'method' => $data['method'] ?? 'paystack',
            // No real Paystack verification wired up yet — this marks every
            // top-up Completed immediately. See note at the end.
            'status' => 'Completed',
        ]);
    }
}
<?php

namespace App\Services;

//app/Services/WalletService.php
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Validation\ValidationException;

class WalletService
{
    public function balanceFor(User $user): float
    {
        $credits = WalletTransaction::where('user_id', $user->id)
            ->where('type', 'Credit')
            ->where('status', 'Completed')
            ->sum('amount');

        $withdrawals = WalletTransaction::where('user_id', $user->id)
            ->where('type', 'Withdrawal')
            ->where('status', 'Completed')
            ->sum('amount');

        return (float) ($credits - $withdrawals);
    }

    public function transactionsFor(User $user, array $filters = [], int $perPage = 10)
    {
        return WalletTransaction::where('user_id', $user->id)
            ->when($filters['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate($perPage);
    }

    public function requestWithdrawal(User $user, array $data): WalletTransaction
    {
        if ($data['amount'] > $this->balanceFor($user)) {
            throw ValidationException::withMessages([
                'amount' => 'Withdrawal amount exceeds your available balance.',
            ]);
        }

        return WalletTransaction::create([
            'user_id' => $user->id,
            'type' => 'Withdrawal',
            'amount' => $data['amount'],
            'status' => 'Pending',
            'account_number' => $data['account_number'],
            'bank' => $data['bank'],
        ]);
    }
}
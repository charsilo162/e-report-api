<?php

namespace App\Http\Controllers\Api;
//app/Http/Controllers/Api/WalletController.php

use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawRequest;
use App\Http\Resources\WalletTransactionResource;
use App\Services\WalletService;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function __construct(protected WalletService $wallet)
    {
    }

    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'balance' => number_format($this->wallet->balanceFor($user), 2),
            'walletId' => $user->wallet_id,
        ]);
    }

    public function transactions(Request $request)
    {
        $paginated = $this->wallet->transactionsFor(
            $request->user(),
            $request->only('status'),
            (int) $request->input('per_page', 10)
        );

        return WalletTransactionResource::collection($paginated);
    }

    public function withdraw(WithdrawRequest $request)
    {
        return new WalletTransactionResource(
            $this->wallet->requestWithdrawal($request->user(), $request->validated())
        );
    }
}
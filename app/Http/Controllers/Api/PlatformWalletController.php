<?php

namespace App\Http\Controllers\Api;
//app/Http/Controllers/Api/PlatformWalletController.php

use App\Http\Controllers\Controller;
use App\Http\Requests\TopUpRequest;
use App\Http\Resources\PlatformPaymentResource;
use App\Http\Resources\PlatformTopupResource;
use App\Services\PlatformWalletService;
use Illuminate\Http\Request;

class PlatformWalletController extends Controller
{
    public function __construct(protected PlatformWalletService $wallet)
    {
    }

    public function show()
    {
        return response()->json([
            'balance' => number_format($this->wallet->balance(), 2),
            'metrics' => $this->wallet->metrics(),
        ]);
    }

    public function payments(Request $request)
    {
        $paginated = $this->wallet->paymentHistory(
            $request->only(['status', 'userType', 'from', 'to']),
            (int) $request->input('per_page', 10)
        );

        return PlatformPaymentResource::collection($paginated);
    }

    public function topups(Request $request)
    {
        return PlatformTopupResource::collection(
            $this->wallet->topupHistory((int) $request->input('per_page', 10))
        );
    }

    public function topUp(TopUpRequest $request)
    {
        return response()->json(new PlatformTopupResource($this->wallet->topUp($request->validated())));
    }
}
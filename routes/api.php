<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CaseStudyController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\MyReportController;
use App\Http\Controllers\Api\WalletController;
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/case-studies', [CaseStudyController::class, 'index']);
Route::get('/case-studies/{slug}', [CaseStudyController::class, 'show']);
Route::get('/faqs', [FaqController::class, 'index']);

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    Route::post('/case-studies', [CaseStudyController::class, 'store']);
    Route::put('/case-studies/{caseStudy}', [CaseStudyController::class, 'update']);
    Route::delete('/case-studies/{caseStudy}', [CaseStudyController::class, 'destroy']);

    Route::post('/faqs', [FaqController::class, 'store']);
    Route::put('/faqs/{faq}', [FaqController::class, 'update']);
    Route::delete('/faqs/{faq}', [FaqController::class, 'destroy']);


    Route::get('/reports', [ReportController::class, 'adminIndex']);
Route::patch('/reports/{report}/status', [ReportController::class, 'updateStatus']);
Route::delete('/reports/{report}', [ReportController::class, 'destroy']);
Route::post('/reports/{report}/credit-wallet', [ReportController::class, 'creditWallet']);
Route::get('/reports/{report}', [ReportController::class, 'adminShow']);
});


Route::middleware('auth:sanctum')->prefix('me/wallet')->group(function () {
    Route::get('/', [WalletController::class, 'show']);
    Route::get('/transactions', [WalletController::class, 'transactions']);
    Route::post('/withdraw', [WalletController::class, 'withdraw']);
});
//routes/api.php — ADD alongside your other public routes


Route::post('/reports', [ReportController::class, 'store']);
Route::get('/reports/track/{passcode}', [ReportController::class, 'track']);



Route::middleware('auth:sanctum')->prefix('me')->group(function () {
    Route::get('/reports', [MyReportController::class, 'index']);
    Route::get('/reports/{id}', [MyReportController::class, 'show']);
});
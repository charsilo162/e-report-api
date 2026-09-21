<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Session\Middleware\StartSession;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CaseStudyController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\MyReportController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\AdminUserController;
use App\Http\Controllers\Api\AdminOverviewController;
 use App\Http\Controllers\Api\DashboardOverviewController;
 use App\Http\Controllers\Api\PlatformWalletController;
/*
|--------------------------------------------------------------------------
| Public Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/
// Route::get('/overview', [AdminOverviewController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/case-studies', [CaseStudyController::class, 'index']);
Route::get('/case-studies/{slug}', [CaseStudyController::class, 'show']);
Route::get('/faqs', [FaqController::class, 'index']);

// Public report actions
Route::post('/reports', [ReportController::class, 'store']);
Route::get('/reports/track/{passcode}', [ReportController::class, 'track']);

/*
|--------------------------------------------------------------------------
| Stateful Auth Routes (Requires Session Middleware for SPA Login/Register)
|--------------------------------------------------------------------------
*/

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Requires Sanctum Token or Session Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // User's own reports
    Route::prefix('me/reports')->group(function () {
        Route::get('/', [MyReportController::class, 'index']);
        Route::get('/{id}', [MyReportController::class, 'show']);
    });

   

Route::get('/me/overview', [DashboardOverviewController::class, 'index']);
    // User wallet routes
    Route::prefix('me/wallet')->group(function () {
        Route::get('/', [WalletController::class, 'show']);
        Route::get('/transactions', [WalletController::class, 'transactions']);
        Route::post('/withdraw', [WalletController::class, 'withdraw']);


    });
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
     // Overview
    Route::get('/overview', [AdminOverviewController::class, 'index']);

    // Categories
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    // Case Studies
    Route::post('/case-studies', [CaseStudyController::class, 'store']);
    Route::put('/case-studies/{caseStudy}', [CaseStudyController::class, 'update']);
    Route::delete('/case-studies/{caseStudy}', [CaseStudyController::class, 'destroy']);

    // FAQs
    Route::post('/faqs', [FaqController::class, 'store']);
    Route::put('/faqs/{faq}', [FaqController::class, 'update']);
    Route::delete('/faqs/{faq}', [FaqController::class, 'destroy']);

    // Reports Management
    Route::get('/reports', [ReportController::class, 'adminIndex']);
    Route::get('/reports/{report}', [ReportController::class, 'adminShow']);
    Route::patch('/reports/{report}/status', [ReportController::class, 'updateStatus']);
    Route::delete('/reports/{report}', [ReportController::class, 'destroy']);
    Route::post('/reports/{report}/credit-wallet', [ReportController::class, 'creditWallet']);

    // User Management
    Route::get('/users', [AdminUserController::class, 'index']);
    Route::get('/users/{user}', [AdminUserController::class, 'show']);
    Route::patch('/users/{user}/suspend', [AdminUserController::class, 'suspend']);
    Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword']);
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy']);
        Route::patch('/users/{user}/reactivate', [AdminUserController::class, 'reactivate']);


        Route::prefix('wallet')->group(function () {
    Route::get('/', [PlatformWalletController::class, 'show']);
    Route::get('/payments', [PlatformWalletController::class, 'payments']);
    Route::get('/topups', [PlatformWalletController::class, 'topups']);
    Route::post('/top-up', [PlatformWalletController::class, 'topUp']);
});



});


<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiAuthController;
use App\Http\Resources\AuthUserResource;

// API Routes
Route::prefix('v1')->group(function () {
    Route::controller(ApiAuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    });

    //---------Admin Routing----------
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user', function (Request $request) {
            return new AuthUserResource($request->user());
        });
        Route::post('/logout', [ApiAuthController::class, 'logout']);
        Route::get('/dropdown/{model}', [\App\Http\Controllers\DropdownController::class, 'getDropDown']);

        Route::apiResources([
            'transactions' => TransactionController::class,
        ]);
        Route::controller(ReportController::class)->prefix('reports')->group(function () {
            Route::get('/total-amount-converted', 'totalAmountConverted');
            Route::get('/third-highest-amount', 'thirdHighestAmountReport');
            Route::get('/dashboard-data', 'dashboardData');
         });
    });
});

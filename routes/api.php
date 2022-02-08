<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiAuthController;
use App\Http\Resources\AuthUserResource;

// API Routes
Route::prefix('v1')->group(function () {
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/register', [ApiAuthController::class, 'register']);
    //---------Admin Routing----------
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user', function (Request $request) {
            return new AuthUserResource($request->user());
        });
        Route::post('/logout', [ApiAuthController::class, 'logout']);
    });
});

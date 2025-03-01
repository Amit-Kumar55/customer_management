<?php

use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;
use Laravel\Passport\Http\Controllers\ClientController;
use Laravel\Passport\Http\Controllers\ScopeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('oauth')->group(function () {
    Route::post('/token', [AccessTokenController::class, 'issueToken'])
        ->middleware(['throttle'])
        ->name('passport.token');

    Route::get('/authorize', [AuthorizationController::class, 'authorize']);
    Route::post('/token/refresh', [AccessTokenController::class, 'refresh']);
    Route::post('/token/revoke', [AccessTokenController::class, 'revoke']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::get('/scopes', [ScopeController::class, 'all']);
    Route::delete('/personal-access-tokens/{token_id}', [PersonalAccessTokenController::class, 'destroy']);
});

Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'apiLogin']);


Route::middleware('auth:api')->group(function () {
    Route::apiResource('customers', CustomerController::class);
});

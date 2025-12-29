<?php

use App\Http\Controllers\Api\v1\{AuthResponseController, GuestResponseController};
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->group(fn() => Route::post('/guest', GuestResponseController::class));

Route::prefix('v1')
    ->middleware('auth:sanctum')
    ->group(fn() => Route::post('/auth', AuthResponseController::class));

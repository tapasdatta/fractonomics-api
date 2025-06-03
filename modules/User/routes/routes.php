<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\CreateUserController;
use Modules\User\Http\Controllers\LoginController;
use Modules\User\Http\Controllers\LogoutController;

Route::middleware(["guest", "throttle:10,1"])->group(function () {
    Route::post("/register", [CreateUserController::class, "store"]);

    Route::post("/login", [LoginController::class, "authenticate"]);
});

Route::middleware(["auth:api", "throttle:10,1"])->group(function () {
    Route::post("/logout", [LogoutController::class, "logout"]);
});

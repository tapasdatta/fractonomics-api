<?php
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\AuthController;

Route::get("", function () {
    return "Hello World";
});

Route::middleware(["guest", "throttle:10,1"])->group(function () {
    Route::post("/register", [AuthController::class, "store"])->name(
        "register"
    );

    Route::post("/sanctum/token", [
        AuthController::class,
        "authenticate",
    ])->name("token");
});

Route::middleware(["auth:sanctum", "throttle:10,1"])->group(function () {
    Route::post("/logout", [AuthController::class, "logout"])->name("logout");
});

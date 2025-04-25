<?php
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

Route::get("", function () {
    return "Hello World";
});

Route::post("register", [UserController::class, "store"])->name("register");

// Route::group(function () {
//     Route::get("register", [UserController::class, "store"])->name("register");
//     // Route::get("auth", Auth::class)->name("auth");
// });

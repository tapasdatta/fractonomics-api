<?php

use Illuminate\Support\Facades\Route;
use Modules\Asset\Http\Controller\CreateAssetController;
use Modules\Asset\Http\Controller\UpdateAssetStateController;
use Modules\Asset\Http\Controller\ViewAssetController;

Route::middleware(["auth:api", "throttle:10,1"])->group(function () {
    Route::post("assets", [CreateAssetController::class, "store"]);

    Route::put("assets/{asset}", [UpdateAssetStateController::class, "update"]);

    Route::get("assets", [ViewAssetController::class, "index"]);
    Route::get("assets/{asset}", [ViewAssetController::class, "show"]);
});

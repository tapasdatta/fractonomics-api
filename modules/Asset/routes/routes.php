<?php

use Illuminate\Support\Facades\Route;
use Modules\Asset\Http\Controller\CreateAssetController;
use Modules\Asset\Http\Controller\UpdateAssetStatusController;

Route::middleware(["auth:api", "throttle:10,1"])->group(function () {
    Route::post("assets", [CreateAssetController::class, "store"]);

    Route::put("assets/{asset}", [
        UpdateAssetStatusController::class,
        "update",
    ]);
});

<?php

use Illuminate\Support\Facades\Route;
use Modules\Asset\Http\Controller\AssetController;

Route::middleware(["auth:api", "throttle:10,1"])->group(function () {
    Route::apiResource("assets", AssetController::class);
});

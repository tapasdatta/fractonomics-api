<?php

use Illuminate\Support\Facades\Route;
use Modules\Asset\Http\Controller\CreateAssetController;

Route::middleware(["auth:api", "throttle:10,1"])->group(function () {
    Route::post("assets", [CreateAssetController::class, "store"]);
});

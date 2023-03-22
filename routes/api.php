<?php

use Luchavez\ApiKeysVault\Http\Controllers\ApiKeyController;
use Illuminate\Support\Facades\Route;

Route::prefix('keys')->group(
    function () {
        Route::post('{vendor_name}/{package_name}/rollback', [ApiKeyController::class, 'rollback']);
    }
);

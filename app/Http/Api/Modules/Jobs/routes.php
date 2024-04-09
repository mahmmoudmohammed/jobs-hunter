<?php

use App\Http\Api\Modules\Jobs\Controllers\JobController;
use Illuminate\Support\Facades\Route;

/********************* Jobs Routes *********************/
Route::name('job.')->prefix('v1/job')->group(function () {
    Route::middleware(['auth:admin'])->group(function () {
        Route::post('/create', [JobController::class, 'create']);
    });
    Route::middleware(['auth:api'])->group(function () {
        Route::post('apply/{model}', [JobController::class, 'apply']);
    });
    Route::get('/{model}', [JobController::class, 'getById']);
    Route::get('/', [JobController::class, 'timeline']);
});


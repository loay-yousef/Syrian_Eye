<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeaponReportController;
use App\Http\Controllers\WarCrimeReportController;
use App\Http\Controllers\TunnelReportController;
use App\Http\Controllers\DrugReportController;
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('reports')->group(function () {

    Route::post('/weapons', [WeaponReportController::class, 'store']);
    Route::post('/war-crimes', [WarCrimeReportController::class, 'store']);
    Route::post('/tunnels', [TunnelReportController::class, 'store']);
    Route::post('/drugs', [DrugReportController::class, 'store']);

})->middleware('throttle:10,1');








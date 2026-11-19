<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminReportsController;
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->file(public_path('index.html'));
})->withoutMiddleware('web');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->middleware('auth')->name('logout');

    Route::get('/dashboard', AdminDashboardController::class)
        ->middleware(['auth', AdminOnly::class])
        ->name('dashboard');

    Route::middleware(['auth', AdminOnly::class])->group(function (): void {
        Route::get('/reports', [AdminReportsController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [AdminReportsController::class, 'export'])->name('reports.export');
        Route::get('/reports/{type}/{id}', [AdminReportsController::class, 'show'])->name('reports.show');
        Route::patch('/reports/{type}/{id}/status', [AdminReportsController::class, 'updateStatus'])->name('reports.status');
    });
});


<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeroeController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\WeaponController;
use App\Http\Controllers\PurchaseController;

Route::get('/', [DashboardController::class, 'index']);

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('heroes', HeroeController::class);
    Route::resource('quests', QuestController::class);
    Route::post('/weapons/{weapon}/buy', [WeaponController::class, 'buy'])->name('weapons.buy');
    Route::resource('weapons', WeaponController::class);
    Route::resource('purchases', PurchaseController::class);
});


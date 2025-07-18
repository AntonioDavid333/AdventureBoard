<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeroeController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\WeaponController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\SubmissionController;

Route::get('/', [DashboardController::class, 'index']);

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('heroes', HeroeController::class);
    Route::resource('quests', QuestController::class);
    Route::post('/weapons/{weapon}/buy', [WeaponController::class, 'buy'])->name('weapons.buy');
    Route::resource('weapons', WeaponController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::post('/heroes/attach', [HeroeController::class, 'attach'])->name('heroe.attach');
    Route::resource('equipments', EquipmentController::class);
    
    Route::put('/submissions/{submission}/accept', [SubmissionController::class, 'accept'])->name('submissions.accept');
    Route::put('/submissions/{submission}/deny', [SubmissionController::class, 'deny'])->name('submissions.deny');
    Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');

});


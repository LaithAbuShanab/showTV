<?php

use App\Http\Controllers\Frontend\EpisodeController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\RandomController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\ShowController;
use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomePageController::class, 'index'])->name('home');

Route::prefix('random')->name('random.')->group(function () {
    Route::get('/shows', [RandomController::class, 'randomly'])->name('shows');
    Route::get('/filter', [RandomController::class, 'filterByTag'])->name('filter');
});

Route::prefix('show')->name('show.')->group(function () {
    Route::get('/{show_id}', [ShowController::class, 'index'])->name('index');
});

Route::prefix('episode')->name('episode.')->group(function () {
    Route::get('/{episode}', [EpisodeController::class, 'index'])->name('index');
});

Route::prefix('search')->name('search.')->group(function () {
    Route::get('/', [SearchController::class, 'index'])->name('index');
});

Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
});

require __DIR__ . '/auth.php';

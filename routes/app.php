<?php

use App\Http\Controllers\Tracking\ToggleController;
use App\Http\Controllers\DashboardController;

Route::get('dashboard', DashboardController::class)->name('dashboard');

Route::post('track', ToggleController::class)->name('track.toggle');

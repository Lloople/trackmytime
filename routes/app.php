<?php

use App\Http\Controllers\Timesheets\CommentUpdateController;
use App\Http\Controllers\Tracking\ToggleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Tracking\TrackingStoreController;

Route::get('dashboard', DashboardController::class)->name('dashboard');

Route::post('track/toggle', ToggleController::class)->name('track.toggle');

Route::post('track', TrackingStoreController::class)->name('track.store');

Route::put('timesheets/{timesheet}/comment', CommentUpdateController::class)->name('timesheets.comment.update');

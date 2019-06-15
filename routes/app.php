<?php

use App\Http\Controllers\Timesheets\CommentUpdateController;
use App\Http\Controllers\Timesheets\TimesheetDestroyController;
use App\Http\Controllers\Tracking\ToggleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Tracking\TimesheetStoreController;

Route::get('dashboard', DashboardController::class)->name('dashboard');

Route::post('track/toggle', ToggleController::class)->name('track.toggle');

Route::post('timesheets', TimesheetStoreController::class)->name('timesheets.store');

Route::put('timesheets/{timesheet}/comment', CommentUpdateController::class)->name('timesheets.comment.update');
Route::delete('timesheets/{timesheet}', TimesheetDestroyController::class)->name('timesheets.destroy');

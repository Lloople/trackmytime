<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Timesheets\TimesheetDestroyController;
use App\Http\Controllers\Timesheets\TimesheetStoreController;
use App\Http\Controllers\Timesheets\TimesheetUpdateController;
use App\Http\Controllers\Tracking\ToggleController;

Route::get('dashboard', DashboardController::class)->name('dashboard');

Route::post('track/toggle', ToggleController::class)->name('track.toggle');

Route::post('timesheets', TimesheetStoreController::class)->name('timesheets.store');
Route::put('timesheets/{timesheet}', TimesheetUpdateController::class)->name('timesheets.update');

Route::delete('timesheets/{timesheet}', TimesheetDestroyController::class)->name('timesheets.destroy');

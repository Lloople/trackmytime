<?php

use App\Http\Controllers\Tracking\ToggleController;

Route::post('track', ToggleController::class)->name('track.toggle');

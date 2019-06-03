<?php

use App\Http\Controllers\TrackController;

Route::post('track', TrackController::class)->name('track.toggle');

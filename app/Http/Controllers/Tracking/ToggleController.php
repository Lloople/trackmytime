<?php

namespace App\Http\Controllers\Tracking;

use App\Http\Controllers\Controller;

class ToggleController extends Controller
{
    public function __invoke()
    {
        if (auth()->user()->tracking_since !== null) {
            auth()->user()->timesheets()->create([
                'end_at' => now(),
                'start_at' => auth()->user()->tracking_since,
                'duration' => now()->diffInMinutes(auth()->user()->tracking_since)
            ]);

            auth()->user()->stopTracking();
        } else {

            auth()->user()->startTracking();
        }

        return response(null, 201);
    }
}

<?php

namespace App\Http\Controllers\Tracking;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrackingStoreRequest;
use Illuminate\Http\Request;

class TrackingStoreController extends Controller
{
    public function __invoke(TrackingStoreRequest $request)
    {
        $timesheet = auth()->user()->timesheets()->create([
            'comment' => $request->input('comment', null),
            'start_at' => $request->input('start_at'),
            'end_at' => $request->input('end_at', null),
            'duration' => $request->getDuration()
        ]);

        return response($timesheet->id, 201);
    }
}

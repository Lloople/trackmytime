<?php

namespace App\Http\Controllers\Tracking;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimesheetStoreRequest;

class TimesheetStoreController extends Controller
{
    public function __invoke(TimesheetStoreRequest $request)
    {
        $timesheet = auth()->user()->timesheets()->create([
            'comment' => $request->input('comment', null),
            'start_at' => $request->input('start_at'),
            'end_at' => $request->input('end_at', null),
            'duration' => $request->getDuration(),
        ]);

        return response($timesheet->id, 201);
    }
}

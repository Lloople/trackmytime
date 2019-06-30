<?php

namespace App\Http\Controllers\Timesheets;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimesheetUpdateRequest;
use App\Models\Timesheet;

class TimesheetUpdateController extends Controller
{
    public function __invoke(TimesheetUpdateRequest $request, Timesheet $timesheet)
    {
        $timesheet->update([
            'comment' => $request->input('comment', null),
            'start_at' => $request->input('start_at'),
            'end_at' => $request->input('end_at', null),
            'duration' => $request->getDuration(),
        ]);

        return response($timesheet->id, 200);
    }
}

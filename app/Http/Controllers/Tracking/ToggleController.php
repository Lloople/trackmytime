<?php

namespace App\Http\Controllers\Tracking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToggleController extends Controller
{
    public function __invoke(Request $request)
    {
        $timesheet = auth()->user()->timesheets()->create([
            'comment' => $request->input('comment', null),
            'action' => auth()->user()->getNextTimesheetAction()
        ]);

        return response($timesheet->id, 201);
    }
}

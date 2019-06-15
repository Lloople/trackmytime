<?php

namespace App\Http\Controllers\Timesheets;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimesheetDestroyRequest;
use App\Models\Timesheet;

class TimesheetDestroyController extends Controller
{
    public function __invoke(TimesheetDestroyRequest $request, Timesheet $timesheet)
    {
        $timesheet->delete();

        return [];
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\TimesheetResource;

class DashboardController extends Controller
{

    public function __invoke()
    {
        $todayTimesheets = auth()->user()->timesheets()->whereDate('start_at', now()->format('Y-m-d'))->get();

        return view('dashboard', [
            'tracking' => auth()->user()->tracking_since !== null,
            'totalToday' => floor($todayTimesheets->sum('duration') / 60),
            'todayRegisters' => TimesheetResource::collection($todayTimesheets)
        ]);
    }
}

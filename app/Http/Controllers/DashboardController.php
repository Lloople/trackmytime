<?php

namespace App\Http\Controllers;

use App\Http\Resources\TimesheetResource;

class DashboardController extends Controller
{

    public function __invoke()
    {
        $todayTimesheets = auth()->user()->timesheets()
            ->whereDate('start_at', now()->format('Y-m-d'))
            ->orWhereDate('end_at', now()->format('Y-m-d'))
            ->orderBy('start_at')
            ->get();

        return view('dashboard', [
            'totalToday' => floor($todayTimesheets->sum('duration') / 60),
            'todayRegisters' => TimesheetResource::collection($todayTimesheets),
        ]);
    }
}

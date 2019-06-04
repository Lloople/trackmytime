<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{

    public function __invoke()
    {
        return view('dashboard', [
            'totalToday' => auth()->user()->totalHoursToday(),
            'todayRegisters' => auth()->user()->timesheets()->whereDate('start_at', now()->format('Y-m-d'))->get()
        ]);
    }
}

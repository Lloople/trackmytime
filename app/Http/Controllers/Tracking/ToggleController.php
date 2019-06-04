<?php

namespace App\Http\Controllers\Tracking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToggleController extends Controller
{
    public function __invoke(Request $request)
    {
        $timesheet = auth()->user()->timesheets()->where('end_at', null)->first();

        if ($timesheet) {
            $timesheet->update([
                'end_at' => now(),
                'comment' => $request->input('comment', $timesheet->comment),
                'duration' => now()->diffInMinutes($timesheet->start_at)
            ]);

            return response(null, 200);
        }

        $timesheet = auth()->user()->timesheets()->create([
            'comment' => $request->input('comment', null),
            'start_at' => now()
        ]);

        return response($timesheet->id, 201);
    }
}

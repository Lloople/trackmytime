<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrackController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $timesheet = auth()->user()->timesheets()->where('end_at', null)->first();

        if ($timesheet) {
            $timesheet->update([
                'end_at' => now(),
                'comment' => $request->input('comment', $timesheet->comment)
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

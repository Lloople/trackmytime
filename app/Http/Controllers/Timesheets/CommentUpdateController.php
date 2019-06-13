<?php

namespace App\Http\Controllers\Timesheets;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use Illuminate\Http\Request;

class CommentUpdateController extends Controller
{

    public function __invoke(Request $request, Timesheet $timesheet)
    {
        $timesheet->update(['comment' => $request->input('comment', '')]);

        return [];
    }
}

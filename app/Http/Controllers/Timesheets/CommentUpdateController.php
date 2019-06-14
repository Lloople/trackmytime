<?php

namespace App\Http\Controllers\Timesheets;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentUpdateRequest;
use App\Models\Timesheet;

class CommentUpdateController extends Controller
{

    public function __invoke(CommentUpdateRequest $request, Timesheet $timesheet)
    {
        $timesheet->update(['comment' => $request->input('comment', '')]);

        return [];
    }
}

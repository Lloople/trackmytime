<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TimesheetUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user() && auth()->user()->id === $this->route('timesheet')->user_id;
    }

    public function rules()
    {
        return [
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date'],
        ];
    }

    public function getDuration()
    {
        return Carbon::parse($this->input('end_at'))->diffInMinutes($this->input('start_at'));
    }
}

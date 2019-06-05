<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TrackingStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user();
    }

    public function rules()
    {
        return [
            'start_at' => ['required', 'date']
        ];
    }

    public function getDuration()
    {
        if (! $this->filled('end_at')) {
            return null;
        }

        return Carbon::parse($this->input('end_at'))->diffInMinutes($this->input('start_at'));
    }
}

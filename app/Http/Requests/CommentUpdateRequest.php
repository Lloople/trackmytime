<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->id() === $this->route('timesheet')->user_id;
    }

    public function rules()
    {
        return [
            'comment' => 'string',
        ];
    }
}

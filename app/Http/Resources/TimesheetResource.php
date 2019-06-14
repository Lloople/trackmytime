<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TimesheetResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id,
            'start_at' => $this->start_at->format('d/m/Y H:i'),
            'end_at' => $this->end_at->format('d/m/Y H:i'),
            'comment' => $this->comment,
            'duration' => $this->duration,
        ];
    }
}

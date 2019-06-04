<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $guarded = [];

    protected $dates = ['end_at', 'start_at'];

    const START = 'START';
    const END = 'END';

    public function getIsStartAttribute() { return $this->action === self::START; }

    public function getDurationForHumansAttribute()
    {
        return self::durationForHumans($this->duration);
    }

    public static function durationForHumans(int $minutes)
    {
        return sprintf('%02d:%02d', floor($minutes / 60), $minutes % 60);
    }
}

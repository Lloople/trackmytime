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
}

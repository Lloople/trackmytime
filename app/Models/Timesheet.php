<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $guarded = [];

    protected $dates = ['end_at', 'start_at'];
}
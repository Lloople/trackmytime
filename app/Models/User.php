<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Custom Methods
    |--------------------------------------------------------------------------
    */

    public function getNextTimesheetAction()
    {
        $timesheet = auth()->user()->timesheets()->orderBy('created_at', 'DESC')->first();

        return $timesheet === null || ! $timesheet->is_start
            ? Timesheet::START
            : Timesheet::END;
    }
}

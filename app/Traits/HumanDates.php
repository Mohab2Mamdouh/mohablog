<?php

namespace App\Traits;

use Carbon\Carbon;

trait HumanDates
{
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)
        ->timezone(config('app.timezone'))
        ->locale(app()->getLocale())
        ->translatedFormat('d M, Y, h:i A');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)
        ->timezone(config('app.timezone'))
        ->locale(app()->getLocale())
        ->translatedFormat('d M, Y, h:i A');
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return Carbon::parse($value)
        ->timezone(config('app.timezone'))
        ->locale(app()->getLocale())
        ->translatedFormat('d M, Y, h:i A');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\InvolvementLog;
use App\Commons\NotificationFunctions;

class Involvement extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($Involvement) {
            NotificationFunctions::alert('success', 'Created new involvement opprotunity!');
            return back();
        });
    }

    public function InvolvementLogs()
    {
        return $this->hasMany(InvolvementLog::Class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\InvolvementLog;
class Involvement extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($Involvement)
        {
            session()->put('success', 'Created new involvement opprotunity!');
            return back();
        });
    }

    public function InvolvementLogs(){
        return $this->hasMany(InvolvementLog::Class);
    }

}

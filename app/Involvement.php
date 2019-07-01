<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\InvolvementLog;
use App\Commons\NotificationFunctions;

class Involvement extends Model
{
    protected $guarded = [];

    public function InvolvementLogs()
    {
        return $this->hasMany(InvolvementLog::Class);
    }
}

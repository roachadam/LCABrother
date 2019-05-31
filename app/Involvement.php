<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\InvolvementLog;
class Involvement extends Model
{
    protected $guarded = [];

    public function InvolvementLogs(){
        return $this->hasMany(InvolvementLog::Class);
    }
}

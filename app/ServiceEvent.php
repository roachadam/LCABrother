<?php

namespace App;

use App\ServiceLog;
use Illuminate\Database\Eloquent\Model;

class ServiceEvent extends Model
{
    protected $guarded = [];

    public function ServiceLogs(){
        return $this->hasMany(Servicelog::class);
    }
}

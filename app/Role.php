<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Permission;
use App\Organization;

class Role extends Model
{
    protected $guarded =[];

    public function Permission(){
        $this->hasOne(Permission::class);
    }
    public function organization(){
        $this->belongsTo(Organization::class);
    }
}

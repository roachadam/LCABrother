<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Permission;

class Role extends Model
{
    protected $guarded =[];

    public function Permission(){
        $this->hasOne(Permission::class);
    }
}

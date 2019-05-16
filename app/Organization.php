<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Organization extends Model
{
    protected $fillable = [
        'name', 'owner_id'
    ];

    public function owner(){
        return $this->belongsTo(User::class);
    }
    public function roles(){
        $roles = DB::table('roles')->get();
        
    }
}

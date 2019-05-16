<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name', 'owner_id'
    ];
    
    public function owner(){
        return $this->hasOne(User::class);
    }

    public function members(){
        return $this->hasMany((User::class));
    }


}

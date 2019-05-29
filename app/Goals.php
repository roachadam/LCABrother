<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goals extends Model
{
    protected $guarded = [];

    public function organization()
    {
        return $this->belongsTo(Organization::Class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class InvolvementLog extends Model
{
    protected $guarded = [];

    public function involvement()
    {
        return $this->belongsTo(Involvement::class);
    }
}

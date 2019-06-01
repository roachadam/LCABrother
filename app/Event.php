<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Organization;
class Event extends Model
{
    protected $guarded = [];

    public function organization()
    {
        return $this->belongsTo(Organization::Class);
    }
}

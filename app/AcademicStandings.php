<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicStandings extends Model
{
    protected $guarded = [];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}

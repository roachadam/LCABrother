<?php

namespace App;

use App\Organization;
use Illuminate\Database\Eloquent\Model;

class CalendarItem extends Model
{
    protected $guarded = [];
    protected $table = 'calendar';

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}

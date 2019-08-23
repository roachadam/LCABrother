<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Organization;
class CalendarCatagory extends Model
{

    protected $guarded = [];

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}

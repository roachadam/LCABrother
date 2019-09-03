<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Organization;
use App\CalendarItem;
class CalendarCatagory extends Model
{

    protected $guarded = [];

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
    public function CalendarItem(){
        return $this->hasMany(CalendarItem::class);
    }
}

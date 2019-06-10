<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\NewsLetter;
class Subscribers extends Model
{
    protected $guarded = [];

    public function newsletter(){
        return $this->belongsTo(NewsLetter::class);
    }

    public function user(){
        return $this->belongsTo(user::class);
    }
}

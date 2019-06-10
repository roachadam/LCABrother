<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Subscribers;
class NewsLetter extends Model
{
    protected $guarded = [];
    protected $table = 'newsletter';

    public function subscribers(){
        return $this->hasMany(Subscribers::class);
    }
}

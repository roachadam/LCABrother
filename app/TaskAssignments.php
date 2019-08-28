<?php

namespace App;

use App\Tasks;
use Illuminate\Database\Eloquent\Model;

class TaskAssignments extends Model
{
    protected $guarded = [];

    public function tasks()
    {
        return $this->belongsTo(Tasks::class);
    }
}

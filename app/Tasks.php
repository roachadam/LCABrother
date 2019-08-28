<?php

namespace App;

use App\TaskAssignments;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $guarded = [];

    public function tasksAssignments()
    {
        return $this->hasMany(TaskAssignments::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

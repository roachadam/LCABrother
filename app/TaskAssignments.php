<?php

namespace App;

use App\User;
use App\Tasks;
use Illuminate\Database\Eloquent\Model;

class TaskAssignments extends Model
{
    protected $guarded = [];

    public function tasks()
    {
        return $this->belongsTo(Tasks::class);
    }
    public function getAssignedBy(){
        return User::where('id', '=', $this->assigner_id)->first();
    }
    public function getMemberAssigned(){
        return User::where('id', '=', $this->assignee_id)->first();
    }


}

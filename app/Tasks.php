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

    public function getAllUsersAssigned()
    {
        $assignedUsers  = collect();
        foreach ($this->tasksAssignments as $assignments) {
            $assignedUsers->push(User::where('id', '=', $assignments->assignee_id)->first());
        }

        return $assignedUsers;
    }

    public function getCompletionRate()
    {
        $numAssigned = count($this->tasksAssignments);
        $numCompleted = 0;
        foreach ($this->tasksAssignments as $assignments) {
            if ($assignments->completed == 1) {
                $numCompleted++;
            }
        }

        
        return (string) $numCompleted . "/" . (string) $numAssigned;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

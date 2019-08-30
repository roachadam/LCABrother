<?php

namespace App;

use App\TaskAssignments;
use App\Organization;
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
    public function assignUsersToTask($userArray){
        $attributes = [
            'organization_id' => $this->organization->id,
            'assigner_id' => $this->user_id,
        ];
        foreach($userArray as $user){
            $attributes['assignee_id'] = $user;
            $this->tasksAssignments()->create($attributes);
        }
    }

    public function unAssignUser($userID){
        $match = [
            'assignee_id' => $userID,
            'tasks_id' => $this->id
        ];
        $toDelete = TaskAssignments::where($match)->first();
        $toDelete->delete();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}

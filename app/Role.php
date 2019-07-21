<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Permission;
use App\Organization;

class Role extends Model
{
    protected $guarded = [];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function setPermissions($attributes): Permission
    {
        $permission = Permission::create($attributes);

        $this->permission()->associate($permission)->save();

        return $this->permission;
    }

    public function setAdminPermissions(): Permission
    {
        $attributes = [
            'view_member_details' => true,
            'manage_member_details' => true,
            'log_service_event' => true,
            'view_all_service' => true,
            'view_all_involvement' => true,
            'manage_all_service' => true,
            'manage_all_involvement' => true,
            'manage_events' => true,
            'manage_forum' => true,
            'manage_alumni' => true,
            'manage_surveys' => true,
            'view_all_study' => true,
            'manage_all_study' => true,
            'view_all_study' => true,
            'manage_calendar' => true,
            'take_attendance' => true,
            'manage_goals' => true,
        ];

        $permission = Permission::create($attributes);

        $this->permission()->associate($permission)->save();

        return $this->permission;
        //return $this->permission()->create($attributes);
    }

    public function setBasicPermissions(): Permission
    {
        $attributes = [
            'view_member_details' => false,
            'manage_member_details' => false,
            'log_service_event' => false,
            'view_all_service' => false,
            'view_all_involvement' => false,
            'manage_all_service' => false,
            'manage_all_involvement' => false,
            'manage_events' => false,
            'manage_forum' => false,
            'manage_alumni' => false,
            'manage_surveys' => false,
            'manage_all_study' => false,
            'view_all_study' => false,
            'manage_calendar' => false,
            'take_attendance' => false,
            'manage_goals' => false,
        ];

        $permission = Permission::create($attributes);

        $this->permission()->associate($permission)->save();

        return $this->permission;
        //return $this->permission()->create($attributes);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Permission;
use App\Organization;
use App\Commons\NotificationFunctions;

class Role extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($Role) {
            NotificationFunctions::alert('success', 'Added role!');
            return back();
        });
        // static::updated(function ($Role) {
        //     NotificationFunctions::alert('success', 'Updated role.');
        //     return back();
        // });
    }

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
            'manage_surveys' => true,
            'manage_all_study' => true,
            'view_all_study' => true,
            'manage_calendar' => true,
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
            'manage_surveys' => false,
            'manage_all_study' => false,
            'view_all_study' => false,
            'manage_calendar' => false,
        ];

        $permission = Permission::create($attributes);

        $this->permission()->associate($permission)->save();

        return $this->permission;
        //return $this->permission()->create($attributes);
    }
}

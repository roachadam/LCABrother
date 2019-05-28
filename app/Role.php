<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Permission;
use App\Organization;

class Role extends Model
{
    protected $guarded =[];

    public function permission(){
        return $this->belongsTo(Permission::class);
    }
    public function organization(){
        return $this->belongsTo(Organization::class);
    }
    public function user(){
        return $this->hasOne(User::class);
    }
    public function setPermissions($attributes)
    {
        $permission = Permission::create($attributes);

        $this->permission()->associate($permission)->save();
    }

    public function setAdminPermissions()
    {
        $attributes = [
            'view_member_details' => true,
            'manage_member_details'=> true,
            'log_service_event'=> true,
            'view_all_service'=> true,
            'view_all_involvement'=> true,
            'manage_all_service'=> true,
            'manage_all_involvement'=> true,
        ];

        $permission = Permission::create($attributes);

        $this->permission()->associate($permission)->save();

        //return $this->permission()->create($attributes);
    }
    public function setBasicPermissions()
    {
        $attributes = [
            'view_member_details' => false,
            'manage_member_details'=> false,
            'log_service_event'=> false,
            'view_all_service'=> false,
            'view_all_involvement'=> false,
            'manage_all_service'=> false,
            'manage_all_involvement'=> false,
        ];

        $permission = Permission::create($attributes);

        $this->permission()->associate($permission)->save();

        //return $this->permission()->create($attributes);
    }

}

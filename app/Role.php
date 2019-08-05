<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Permission;
use App\Organization;
use Illuminate\Support\Facades\Schema;

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
        $permission = Permission::create(
            collect(Schema::getColumnListing('permissions'))->filter(function ($permissionName) {
                return $permissionName !== 'id' && $permissionName !== 'created_at' && $permissionName !== 'updated_at';
            })->mapWithKeys(function ($permissionName) {
                return [$permissionName => true];
            })->toArray()
        );

        $this->permission()->associate($permission)->save();

        return $this->permission;
    }

    public function setBasicPermissions(): Permission
    {
        $attributes = [];

        $permission = Permission::create($attributes);

        $this->permission()->associate($permission)->save();

        return $this->permission;
    }
}

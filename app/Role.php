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
        $permissionNames = Schema::getColumnListing('permissions');

        foreach ($permissionNames as $key => $name) {
            if ($name == 'id' || $name == 'created_at' || $name == 'updated_at') {
                unset($permissionNames[$key]);
            } else {
                $attributes[$name] = true;
            }
        }

        $permission = Permission::create($attributes);

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

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use App\Commons\NotificationFunctions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageMembers');
    }

    public function index()
    {
        $permissionNames = Schema::getColumnListing('permissions');


        foreach ($permissionNames as $key => $value) {
            if ($value == 'id' || $value == 'created_at' || $value == 'updated_at') {
                unset($permissionNames[$key]);
            }
        }

        $organization = Auth::user()->organization;
        $roles = $organization->roles;

        return view('roles.index', compact('roles', 'organization', 'permissionNames'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->all();
        unset($attributes['_token']);

        $role = auth()->user()->organization->addRole($attributes['name']);

        unset($attributes['name']);

        foreach ($attributes as $key => $att) {
            if ($att == 'on') {
                $attributes[$key] = 1;
            }
        }
        $role->setPermissions($attributes);

        NotificationFunctions::alert('success', 'Added role!');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissionNames = Schema::getColumnListing('permissions');

        foreach ($permissionNames as $key => $value) {
            if ($value == 'id' || $value == 'created_at' || $value == 'updated_at') {
                unset($permissionNames[$key]);
            }
        }
        return view('roles.edit', compact('role', 'permissionNames'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $permissionNames = Schema::getColumnListing('permissions');
        $attributes = $request->all();

        $permission = $role->permission;
        foreach ($permissionNames as $key => $value) {
            if ($value == 'id' || $value == 'created_at' || $value == 'updated_at') {
                unset($permissionNames[$key]);
            } else {
                if (isset($attributes[$value])) {
                    $permission->$value = 1;
                } else {
                    $permission->$value = 0;
                }
            }
        }
        $permission->save();

        NotificationFunctions::alert('success', 'Updated role!');

        return redirect(route('role.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        abort_if(!auth()->user()->canManageMembers(), 403);
        $match = ['name' => 'Basic', 'organization_id' => auth()->user()->organization->id];

        $users = User::where('role_id', '=', $role->id)->get();
        $basicRole = Role::where(['name' => 'Basic', 'organization_id' => auth()->user()->organization->id])->first();

        foreach ($users as $user) {
            $user->setRole($basicRole);
        }

        $role->delete();
        NotificationFunctions::alert('primary', 'Successfully deleted role!');
        return redirect('/role');
    }

    public function usersInRole(Role $role)
    {
        $users = User::findAll(auth()->user()->organization->id);

        $usersWithRole = $users->where('role_id', $role->id);
        $usersWithoutRole = $users->where('role_id', '!=', $role->id);

        return view('roles.userRoles', compact('role', 'usersWithRole', 'usersWithoutRole'));
    }

    public function massSet(Request $request, $role)
    {
        $attributes = $request->all();
        if (isset($attributes['users'])) {
            foreach ($attributes['users'] as $user_id) {
                $user = User::findById($user_id);
                $user->setRole($role);
            }
        }

        NotificationFunctions::alert('success', 'Successfully Assigned New Roles!');
        return back();
    }

    public function removeRole(Request $request, User $user)
    {
        $user->setBasicUser();
        NotificationFunctions::alert('primary', 'Successfully removed user!');
        return back();
    }
}

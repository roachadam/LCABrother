<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use DB;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ManageMembers');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissionNames = Schema::getColumnListing('permissions');

        foreach ($permissionNames as $key => $value) {
            if($value == 'id' || $value == 'created_at' || $value == 'updated_at'){
                unset($permissionNames[$key]);
            }
        }
        $roles = Auth::user()->organization->roles;
        $org = Auth::user()->organization;
        return view('roles.index', compact('roles', 'org', 'permissionNames'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $org = Auth::user()->organization;
        return view('roles.create', compact('org'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {

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
            if($value == 'id' || $value == 'created_at' || $value == 'updated_at'){
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
            if($value == 'id' || $value == 'created_at' || $value == 'updated_at'){
                unset($permissionNames[$key]);
            }
            else{
                if(isset($attributes[$value])){
                    $permission->$value = 1;
                }
                else{
                    $permission->$value = 0;
                }
            }
        }
        $permission->save();
        return back();
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
        $match = ['name' => 'Basic', 'organization_id' =>auth()->user()->organization->id];
        $users = User::where('role_id', '=', $role->id)->get();
        $basicRole = Role::where(['name' => 'Basic','organization_id'=> auth()->user()->organization->id ])->first();
        foreach($users as $user){
            $user->setRole($basicRole);
        }

        $role->delete();
        return redirect('/role');
    }
    public function users(Role $role){
        $users = User::where(['role_id'=> $role->id, 'organization_id' => auth()->user()->organization->id])->get();
        $others = User::where([['role_id', '!=' , $role->id], ['organization_id','=', auth()->user()->organization->id]])->get();
        return view('roles.userRoles', compact('role', 'users','others'));
    }
    public function massSet(Request $request, $role){
        $attributes = $request->all();
        if(isset($attributes['users'])){
            foreach($attributes['users'] as $user_id){
                $user = User::find($user_id);
                if($user->role->name == 'Admin'){
                    if($user->id != auth()->user()->organization->owner->id){
                        $user->setRole($role);
                    }
                }
                else{
                    $user->setRole($role);
                }

            }
        }
        return back();
    }
}

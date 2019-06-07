<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

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
        $roles = Auth::user()->organization->roles;
        $org = Auth::user()->organization;
        return view('roles.index', compact('roles', 'org'));
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
        dump($attributes);
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
        dd($permission);
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
        //
    }
    public function users(Role $role){
        return view('roles.userRoles', compact($role));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organization;
use App\Task;

class OrganizationRolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('ManageMembers');
    }

    public function store(Request $request, Organization $organization)
    {

        $attributes = $request->all();
        unset($attributes['_token']);

        $role = $organization->addrole($attributes['name']);

        unset($attributes['name']);

        foreach($attributes as $key => $att){
            if($att == 'on'){
                $attributes[$key] = 1;
             }
        }
        $role->setPermissions($attributes);

        return back();
    }
}

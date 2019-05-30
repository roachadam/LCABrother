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

        //dd($request->all());
        $attributes = request()->validate([
            'name'=> ['required'],
        ]);

        $role = $organization->addrole($attributes);

        unset($attributes['name']);
        $role->setPermissions($attributes);

        return back();
    }
}

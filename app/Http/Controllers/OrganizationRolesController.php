<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organization;
use App\Task;
class OrganizationRolesController extends Controller
{
    public function store(Organization $organization)
    {
        $attributes = request()->validate([
            'name'=> ['required']
            ]);

        $organization->addrole($attributes);

        return back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForumController extends Controller
{

    public function create()
    {
        $category = auth()->user()->organization->category;
        return view('forums.categories.create', compact('category'));
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required']
        ]);
        $rand_color = '#' . substr(md5(mt_rand()), 0, 6);

        $attributes['color'] = $rand_color;
        $attributes['slug'] = strtolower($attributes['name']);
        $organization = auth()->user()->organization;
        $organization->category()->create($attributes);

        return redirect('/forum/create/categories');
    }
}

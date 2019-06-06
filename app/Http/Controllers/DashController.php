<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('orgverified');
    }

    public function index()
    {
        return view('home.dash');
    }
}

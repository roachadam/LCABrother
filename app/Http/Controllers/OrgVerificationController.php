<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class OrgVerificationController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    // hits from rout /orgpending
    public function index(){

        if(Auth::user()->organization_verified == 1){
            return redirect('/dash');
        }
        return view('main.orgpending');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsLetterController extends Controller
{
    public function create(){
        return view('newsletter.create');
    }
}

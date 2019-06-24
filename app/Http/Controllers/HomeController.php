<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\ContactUs;

class HomeController extends Controller
{
    public function contactUs(Request $request)
    {
        $attributes = $request->all();
        Mail::to('dawsonmjeane@gmail.com')
            ->send(
                new ContactUs($attributes)
            );

        return redirect('/contact/thanks');
    }
}

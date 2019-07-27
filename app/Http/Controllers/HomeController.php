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
        Mail::to('dawsonmjeane@gmail.com')  //TODO: Change this to an env variable that will point to a specified person's email
            ->send(
                new ContactUs($attributes)
            );

        return redirect('/contact/thanks');
    }
}

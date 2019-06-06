<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\ContactUs;
class HomeController extends Controller
{
    public function contactUs(Request $request)
    {
        $atrributes = $request->all();
        Mail::to('dawsonmjeane@gmail.com')
            ->send(
            new ContactUs($atrributes)
        );

        return redirect('/contact/thanks');
    }
}

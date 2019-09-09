<?php

namespace App\Http\Controllers;

use App\Mail\BugReport;
use Mail;
use Illuminate\Http\Request;
use App\Commons\NotificationFunctions;


class BugReportController extends Controller
{
    //

    public function sendReport(Request $request)
    {
        $attributes = $request->all();
        unset($attributes["_token"]);
        $devEmails = [
            'dawsonmjeane@gmail.com',
            'jacobdrury75@gmail.com',
            'adamroach504@gmail.com'
        ];
        // dd(env('MAIL_HOST'));
        foreach ($devEmails as $email) {
            Mail::to($email)->queue(new BugReport($attributes));
            if (env('MAIL_HOST') == 'smtp.mailtrap.io') {
                sleep(5); //use usleep(500000) for half a second or less
            }

        }

        NotificationFunctions::alert('success', 'Your bug report has been sent successfully! Thank you!');

        return back();
    }
}

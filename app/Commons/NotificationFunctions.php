<?php

namespace App\Commons;

use Illuminate\Support\Facades\Session;

class NotificationFunctions
{
    public static function alert($type, $newMsg)
    {
        if (Session::has($type)) {
            $msgs = Session($type);

            array_push($msgs, $newMsg);
            Session()->forget($type);
            Session()->put($type, $msgs);
        } else {
            Session()->put($type, array($newMsg));
        }
    }
}

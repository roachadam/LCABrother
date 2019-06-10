<?php

namespace App\Http\Controllers;

use App\Subscribers;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{
    public function destroy(Subscribers $subscribers)
    {
        dd($subscribers);
        $subscribers->delete();
        return back();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\Session;

class Academics extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($Academics) {
            $newMsg = 'Successfully overrode academic record!';
            if (Session::has('success')) {
                $msgs = Session('success');
                array_push($msgs, $newMsg);
                Session()->forget('success');
                Session()->put('success', $msgs);
            } else {
                Session()->put('success', array($newMsg));
            }
            return back();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::Class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class InvolvementLog extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($InvolvementLog)
        {
            $newMsg = 'Involvement points were logged!';
            if(Session::has('success')){
                $msgs = Session('success');

                $alreadyInSession = false;
                foreach($msgs as $msg){
                    if($msg === $newMsg);
                    $alreadyInSession = true;
                }

                if(!$alreadyInSession){
                    array_push($msgs, $newMsg);
                Session()->forget('success');
                Session()->put('success', $msgs);
                }

            }else{
                Session()->put('success', array($newMsg));
            }
            return back();
        });

        static::deleted(function ($InvolvementLog)
        {
            $newMsg = 'Involvement log(s) deleted!';

            if(Session::has('primary')){
                $msgs = Session('primary');

                $alreadyInSession = false;
                foreach($msgs as $msg){
                    if($msg === $newMsg);
                    $alreadyInSession = true;
                }

                if(!$alreadyInSession){
                    array_push($msgs, $newMsg);
                Session()->forget('primary');
                Session()->put('primary', $msgs);
                }

            }else{
                Session()->put('primary', array($newMsg));
            }
        });
    }

    public function involvement(){
        return $this->belongsTo(Involvement::class);
    }
}

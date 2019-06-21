<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;



class Academics extends Model
{
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();

        static::updated(function ($Academics) {
            $newMsg = 'Successfully overrode ' . self::name . '\'s academics!';
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

    public function updateStanding()
    {
        $academics = $this;

        $org = auth()->user()->organization;
        $standingsOuter = $org->getStandingsAsc();
        $standingsInner = $org->getStandingsDsc();

        $hitOuter = false;
        $readyToSet = false;
        $passedOuter = false;
        $prevTermIndex = 0;

        $standingsOuter = $standingsOuter->all();

        for ($i = 0; $i < count($standingsOuter); $i++) {
            $outer = $standingsOuter[$i];
            if ($outer->name == $academics->Previous_Academic_Standing) {
                $prevTermIndex = $i;
            }

            if ($this->check($outer)) {
                if ($academics->Previous_Academic_Standing === null) {
                    $this->setTo($outer->name, $academics);
                    break;
                }
                foreach ($standingsInner as $inner) {
                    if ($hitOuter) {
                        $passedOuter = true;
                    }

                    if ($outer->name == $inner->name) {   //Check if crossed middle
                        $hitOuter = true;
                    }

                    if ($hitOuter) {                    //Step down
                        if (!$passedOuter) {
                            $this->setTo($inner->name);
                            break;
                        } else {
                            $this->setTo($standingsOuter[$prevTermIndex + 1]->name);
                            break;
                        }
                    } else {                            //Step up
                        if ($readyToSet) {
                            $this->setTo($inner->name);
                            break;
                        }
                        if ($inner->name == $academics->Previous_Academic_Standing) {
                            $readyToSet = true;
                        }
                    }
                }
                break;
            }
        }
    }

    public function setTo($name)
    {
        $this->update([
            'Current_Academic_Standing' => $name
        ]);
    }

    public function check(AcademicStandings $standing): bool
    {
        return $this->Current_Term_GPA > $standing->Term_GPA_Min;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academics extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($Academics) {
            session()->put('success', 'Created new Academic!');
            return back();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::Class);
    }

    public function updateStanding(){
        if($this->Current_Term_GPA >2.5){
            if($this->Previous_Academic_Standing ==='Suspension'){
                $this->setToProbation();
            }
            else{            //elseif($this->Previous_Academic_Standing ==='Probation' || $this->Previous_Academic_Standing ==='Good'){
                $this->setToGood();
            }
        }
        elseif($this->Current_Term_GPA <2.5 && $this->Current_Term_GPA >1.0){
            if($this->Previous_Academic_Standing ==='Good'){
                $this->setToProbation();
            }
            else{
                $this->setToSuspension();
            }
        }
        else{
           $this->setToSuspension();
        }

    }
    public function setToSuspension(){
        $this->Current_Academic_Standing = 'Suspension';
        $this->save();
    }
    public function setToGood(){
        $this->Current_Academic_Standing = 'Good';
        $this->save();
    }
    public function setToProbation(){
        $this->Current_Academic_Standing = 'Probation';
        $this->save();
    }
}

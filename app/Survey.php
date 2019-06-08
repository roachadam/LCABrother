<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Organization;
use App\SurveyAnswers;
use Collective\Html\FormFacade;
class Survey extends Model
{
    protected $guarded = [];
    protected $casts = [
        'field_names' => 'array',
        'field_types' => 'array', // Will convarted to (Array)
    ];
    public function organization(){
        return $this->belongsTo(Organization::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function surveyAnswers(){
        return $this->hasMany(SurveyAnswers::class);
    }
    public function addResponse($attributes){
        return $this->surveyAnswers()->create($attributes);
    }

    public function generateForm(){

        $s = "";
        foreach($this->field_names as $index => $fieldName ) {
            $fieldType = $this->field_types[$index];
            $s .=   "<label>".$fieldName."</label>";
            $s .= "<br>";
            if($fieldType=='textarea'){
                $s.= "<textarea rows = \"5\" cols = \"50\" name = \"field_answers[]\" class=\"form-control\"></textarea>";
            }
            else{
                $s .="<input id=\"".$fieldName."\" type=\"".$fieldType."\" class=\"form-control\" name=\"field_answers[]\" required=\"\" autofocus=\"\">";
            }
            $s .= "<br>";
        }
        return $s;
    }

    public function getAllMembersWhoAnswered(){
        $answers = SurveyAnswers::where('survey_id', '=', $this->id)->get();
        $answers->load('user');

        $answered = collect();
        foreach($answers as $answer){
            $user = $answer->user;
            $answered->push($user);
        }

        return $answered;
    }

    public function getAllUnansweredMembers(){
        $users = auth()->user()->organization->users;
        $answered = $this->getAllMembersWhoAnswered();
        $unanswered = $users->diff($answered);
        return $unanswered;
    }
}

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
        'field_types' => 'array', // Will convert to (Array)
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function surveyAnswers()
    {
        return $this->hasMany(SurveyAnswers::class);
    }

    public function addResponse($attributes)
    {
        return $this->surveyAnswers()->create($attributes);
    }

    public function generateForm()
    {
        $survey = "";
        foreach ($this->field_names as $index => $fieldName) {
            $fieldType = $this->field_types[$index];
            $survey .=   "<label>" . $fieldName . "</label>";
            $survey .= "<br>";
            if ($fieldType === 'textarea') {
                $survey .= "<textarea rows = \"5\" cols = \"50\" name = \"field_answers[" . $fieldName . "]\" class=\"form-control\"></textarea>";
            } else if ($fieldType === 'text') {
                $survey .= "<input id=\"" . $fieldName . "\" type=\"" . $fieldType . "\" class=\"form-control\" name = \"field_answers[" . $fieldName . "]\" required=\"\" autofocus=\"\">";
            } else if ($fieldType === 'select') {
                $survey .= "<select rows = \"5\" cols = \"50\" class=\"form-control\" name = \"field_answers[" . $fieldName . "]\">";
                foreach ($this->field_names as $value) {                                                // ! I need an array of the options to loop over
                    $survey .=  "<option value=\"" . $value . "\">" . $value . "</option>";
                }
                $survey .= "</select>";
            } else if ($fieldType === 'checkbox') {                                                     // ! I need an array of the options to loop over
                $survey .= "<ul rows = \"5\" cols = \"50\" class=\"form-check\">";
                foreach ($this->field_names as $value) {
                    $survey .= "<li><input class=\"form-check-input\" type=\"checkbox\" name = \"field_answers[" . $fieldName . "][]\" value=\"" . $value . "\">" . $value . "</li>";
                }
                $survey .= "</ul>";
            }
            $survey .= "<br>";
        }
        return $survey;
    }

    public function getAllMembersWhoAnswered()
    {
        $answers = SurveyAnswers::where('survey_id', '=', $this->id)->get();
        $answers->load('user');

        $answered = collect();
        foreach ($answers as $answer) {
            $user = $answer->user;
            $answered->push($user);
        }

        return $answered;
    }

    public function getAllUnansweredMembers()
    {
        return auth()->user()->organization->users->diff($this->getAllMembersWhoAnswered());
    }
}

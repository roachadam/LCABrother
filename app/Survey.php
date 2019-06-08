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
            $s .="<input id=\"".$fieldName."\" type=\"".$fieldType."\" class=\"form-control\" name=\"field_answers[]\" required=\"\" autofocus=\"\">";
            $s .= "<br>";
        }
        return $s;
    }
}

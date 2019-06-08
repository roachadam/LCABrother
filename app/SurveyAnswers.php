<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Survey;
use App\User;
class SurveyAnswers extends Model
{
    protected $guarded = [];
    protected $casts = [
        'field_answers' => 'array', // Will convarted to (Array)
    ];
    public function survey(){
        return $this->belongsTo(Survey::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

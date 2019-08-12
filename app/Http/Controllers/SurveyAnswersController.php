<?php

namespace App\Http\Controllers;

use App\SurveyAnswers;
use Illuminate\Http\Request;
use App\Survey;
use App\Events\MemberAnsweredSurvey;

class SurveyAnswersController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Survey $survey)
    {
        $attributes = $request->all();
        unset($attributes['_token']);
        $attributes['user_id'] = auth()->id();
        $survey->addResponse($attributes);

        event(new MemberAnsweredSurvey($survey));
        return redirect(route('survey.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SurveyAnswers  $surveyAnswers
     * @return \Illuminate\Http\Response
     */
    public function destroy(SurveyAnswers $surveyAnswers)
    {
        $surveyAnswers->delete();
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Commons\NotificationFunctions;
use App\Events\MemberAnsweredSurvey;
use Illuminate\Http\Request;
use App\SurveyAnswers;
use App\Survey;

class SurveyAnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageSurvey')->only('destroy');
    }

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

        NotificationFunctions::alert('success', 'Successfully Saved Response!');
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
        NotificationFunctions::alert('success', 'Successfully Deleted Survey Entry!');
        return back();
    }
}

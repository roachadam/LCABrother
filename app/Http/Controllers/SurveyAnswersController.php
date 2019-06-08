<?php

namespace App\Http\Controllers;

use App\SurveyAnswers;
use Illuminate\Http\Request;
use App\Survey;
use App\Events\MemberAnsweredSurvey;

class SurveyAnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        event(new MemberAnsweredSurvey($survey));
        return redirect('/survey');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SurveyAnswers  $surveyAnswers
     * @return \Illuminate\Http\Response
     */
    public function show(SurveyAnswers $surveyAnswers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SurveyAnswers  $surveyAnswers
     * @return \Illuminate\Http\Response
     */
    public function edit(SurveyAnswers $surveyAnswers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SurveyAnswers  $surveyAnswers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SurveyAnswers $surveyAnswers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SurveyAnswers  $surveyAnswers
     * @return \Illuminate\Http\Response
     */
    public function destroy(SurveyAnswers $surveyAnswers)
    {
        dd($surveyAnswers->id);
        $surveyAnswers->delete();
        return back();
    }
}

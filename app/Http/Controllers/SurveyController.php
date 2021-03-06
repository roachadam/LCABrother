<?php

namespace App\Http\Controllers;

use App\Commons\NotificationFunctions;
use App\Mail\UserSurveyReminder;
use Illuminate\Http\Request;
use App\Survey;
use Mail;

class SurveyController extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageSurvey')->except('index', 'show');
    }

    public function index()
    {
        $user = auth()->user();
        $surveys = $user->organization->survey;

        return view('survey.index', compact('surveys', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('survey.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->all();
        unset($attributes['_token']);
        $serializedFieldNames = serialize($attributes['field_name']);
        $serializedFieldTypes = serialize($attributes['field_type']);

        //Strips out field if they just hit the add field button but don't insert a name
        foreach ($attributes['field_name'] as $key => $fieldName) {
            if ($fieldName == null) {
                unset($attributes['field_name'][$key]);
                unset($attributes['field_type'][$key]);
            }
        }

        $att['name'] = $attributes['name'];
        $att['field_names'] =   $attributes['field_name'];
        $att['field_types'] = $attributes['field_type'];
        $att['user_id'] = auth()->id();
        $att['desc'] = $attributes['desc'];

        auth()->user()->organization->addSurvey($att);
        return redirect('/survey');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        return view('survey.show', compact('survey'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();
        NotificationFunctions::alert('success', 'Successfully Deleted Survey!');
        return back();
    }

    public function viewResponses(Request $request, Survey $survey)
    {
        $survey->load('surveyAnswers');
        return view('survey.responses', compact('survey'));
    }

    public function notify(Request $request, Survey  $survey)
    {
        $users = $survey->getAllUnansweredMembers();
        foreach ($users as $user) {
            Mail::to($user->email)->send(
                new UserSurveyReminder($survey)
            );
        }
        return back();
    }
}

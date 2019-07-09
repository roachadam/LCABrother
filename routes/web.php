<?php

use App\Http\Controllers\AcademicsController;
use App\Http\Controllers\ServiceEventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home.home');
});

Route::get('/about', function () {
    return view('home.about');
});

Route::get('/contact', function () {
    return view('home.contact.contact');
});

Route::post('/home/contactUs', 'HomeController@contactUs');


Route::get('/contact/thanks', function () {
    return view('home.contact.thanks');
});

Auth::routes(['verify' => true]);

Route::resource('user', 'UserController')
    ->middleware('MemberView', ['only' => ['index']])
    ->middleware('orgverified', ['only' => ['index', 'contact']]);



Route::middleware('auth')->group(function () {

    //Registration Routes
    Route::resource('organization', 'OrganizationController')->only(['index', 'create', 'store']);

    Route::get('/goals/create', 'GoalsController@create');
    Route::post('/goals/store', 'GoalsController@store');
    Route::post('semester/initial', 'SemesterController@initial');

    Route::resource('academicStandings', 'AcademicStandingsController')->except(['update', 'destroy']);
    Route::patch('/academicStandings/{academicStandings}', 'AcademicStandingsController@update');
    Route::delete('/academicStandings/{academicStandings}', 'AcademicStandingsController@destroy');

    Route::post('/user/{user}/join', 'UserController@joinOrg');


    Route::middleware('verified')->group(function () {
        Route::get('/orgpending/waiting', 'OrgVerificationController@waiting');
        Route::get('/orgpending/rejected', 'OrgVerificationController@rejected');
        Route::get('/orgpending/alumni', 'OrgVerificationController@alumni');
        // Route::post('/organizations/{organization}/roles', 'OrganizationRolesController@store'); Don't think we use this


        Route::middleware('orgverified')->group(function () {
            Route::resource('role', 'RoleController')->middleware('ManageMembers');

            Route::resource('serviceEvent', 'ServiceEventController');
            Route::resource('serviceLog', 'ServiceLogController');
            Route::resource('event', 'EventController');
            Route::resource('survey', 'SurveyController');
            Route::resource('surveyAnswers', 'SurveyAnswersController');
            Route::resource('calendarItem', 'CalendarController');
            Route::resource('attendance', 'AttendanceController');
            Route::resource('attendanceEvent', 'AttendanceEventController');
            Route::resource('semester', 'SemesterController')->only('store');   //need to test
            Route::get('/dash', 'DashController@index');


            Route::get('/goals', 'GoalsController@index');
            Route::get('/goals/edit', 'GoalsController@edit');
            Route::post('/goals/{goals}/update', 'GoalsController@update');
            Route::get('/goals/{goals}/notify', 'NotifyController@index');
            Route::post('/goals/{goals}/notify/send', 'NotifyController@send');
            Route::post('/goals/{goals}/notify/sendAll', 'NotifyController@sendAll');

            Route::post('/users/update', 'UserController@update');
            Route::get('/users/{user}/adminView', 'UserController@adminView');
            Route::post('/user/{user}/organization/remove', 'UserController@orgRemove');
            Route::get('user/{user}/serviceBreakdown', 'UserController@serviceBreakdown');
            Route::get('/users/profile', 'UserController@profile');
            Route::get('/users/edit', 'UserController@edit');
            Route::get('/users/contact', 'UserController@contact');

            Route::get('/attendance/attendanceEvent/{attendanceEvent}', 'AttendanceController@index');
            Route::post('/attendanceEvent/calendarItem/{calendarItem}', 'AttendanceEventController@store');
            Route::post('/attendanceEvent/{attendanceEvent}/attendance', 'AttendanceController@store');
            Route::get('/attendanceEvent/{attendanceEvent}/attendance', 'AttendanceController@create');
            Route::get('/attendanceEvents', 'AttendanceEventController@index');

            Route::resource('newsletter', 'NewsLetterController')->except(['show', 'update']);
            Route::post('newsletter/send/preview', 'NewsLetterController@preview');
            Route::get('newsletter/send/show', 'NewsLetterController@showSend');
            Route::get('/newsletter/{newsletter}/subscribers', 'NewsLetterController@subscribers');
            Route::post('/newsletter/send', 'NewsLetterController@send');

            Route::post('/calendarItem/{calendarItem}/event/create', 'CalendarController@addEvent');


            Route::post('survey/{survey}/notify', 'SurveyController@notify');
            Route::get('survey/{survey}/responses', 'SurveyController@viewResponses');
            Route::post('/surveyAnswers/survey/{survey}', 'SurveyAnswersController@store');

            Route::get('/orgpending/{user}', 'OrgVerificationController@show');
            // Route::post('/orgpending/{user}/update', 'OrgVerificationController@update');    Don't Think we use this

            Route::get('/role/{role}/users', 'RoleController@users');
            Route::post('/role/{role}/massSet', 'RoleController@massSet');

            Route::get('/alumni', 'AlumniController@index');
            Route::post('/user/{user}/alumni', 'AlumniController@setAlum');
            Route::get('/alumni/contact', 'AlumniController@contact');
            Route::post('/alumni/contact/send', 'AlumniController@send');

            Route::get('/totals', 'TotalsController@index');

            Route::get('/event/{event}/invites', 'InviteController@index');
            Route::get('/event/{event}/invite', 'InviteController@create');
            Route::post('/event/{event}/invite', 'InviteController@store');
            Route::delete('/invite/{invite}', 'InviteController@destroy');


            Route::get('/forum/create/categories', 'ForumController@create');
            Route::post('/forum/create/categories', 'ForumController@store');

            Route::get('/serviceEvents/indexByUser', 'ServiceEventController@indexByUser');
            Route::get('/users/{user}/service', 'UserController@serviceBreakdown');

            Route::get('/user/{user}/involvementLogs', 'InvolvementLogController@breakdown');

            Route::resource('involvement', 'InvolvementController')->except(['destroy', 'update', 'show', 'edit']);
            Route::resource('involvementLog', 'InvolvementLogController')->only(['index', 'store', 'destroy']);

            Route::middleware('ManageInvolvement')->group(function () {
                Route::get('/involvement/edit', 'InvolvementController@edit');
                Route::post('/involvement/import', 'InvolvementController@import');
                Route::post('/involvement/setPoints', 'InvolvementController@setPoints');
            });

            Route::middleware('ManageAcademics')->group(function () {
                Route::resource('academics', 'AcademicsController')->only(['index', 'store']);
                Route::get('/academics/user_id/{academics}/edit', 'AcademicsController@edit');
                Route::patch('/user/{user}/academics/{academics}/update', 'AcademicsController@update');
                Route::get('/academics/manage', 'AcademicsController@manage');
                Route::get('/academics/downloadExampleFile', 'AcademicsController@getExampleFile');
                Route::post('/academics/notifyAll', 'NotifyController@academicsNotifyAll');
                Route::post('/academics/notify/selected', 'NotifyController@academicsNotifySelected');
                Route::post('/academics/notify/specificStanding', 'NotifyController@academicsNotifySpecificStanding');
            });
        });
    });
});

Route::resource('subscribers', 'SubscribersController');        //What is this for?

Route::get('/massInvite', 'MassInvite@index');
Route::post('/massInvite/send', 'MassInvite@inviteAll');
Route::get('/organizations/{organization}/join', 'InvitedRegisterController@showRegistrationForm');
Route::post('/organization/{organization}/register', 'InvitedRegisterController@register');

Route::get('/avatar/create', 'UserController@create_avatar');
Route::post('/avatar/create', 'UserController@update_avatar');
Route::post('/avatar/default', 'UserController@default_avatar');

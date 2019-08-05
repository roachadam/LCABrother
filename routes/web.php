<?php

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

//No middleware needed
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

Route::get('/organizations/{organization}/join', 'InvitedRegisterController@showRegistrationForm')->name('organization.join');
Route::post('/organization/{organization}/register', 'InvitedRegisterController@register')->name('organization.register');

Auth::routes(['verify' => true]);


//Can only access if user is logged in
Route::middleware('auth')->group(function () {
    //Registration Routes
    Route::resource('user', 'UserController')->only(['index', 'destroy']);
    Route::get('/avatar/create', 'ProfileController@create_avatar')->name('profile.createAvatar');
    Route::post('/avatar/create', 'ProfileController@update_avatar')->name('profile.updateAvatar');

    Route::get('/forum/create/categories', 'ForumController@create');
    Route::post('/forum/create/categories', 'ForumController@store');
    Route::get('/massInvite', 'MassInvite@index');
    Route::post('/massInvite/send', 'MassInvite@inviteAll');

    Route::resource('organization', 'OrganizationController')->only(['index', 'create', 'store']);

    Route::get('/goals/create', 'GoalsController@create');
    Route::post('/goals/store', 'GoalsController@store');
    Route::post('semester/initial', 'SemesterController@initial');

    Route::post('/user/{user}/join', 'UserController@joinOrg')->name('user.joinOrg');

    //Can only access if email is verified
    Route::middleware('verified')->group(function () {
        Route::get('/orgpending/waiting', 'OrgVerificationController@waiting');
        Route::get('/orgpending/rejected', 'OrgVerificationController@rejected');
        Route::get('/orgpending/alumni', 'OrgVerificationController@alumni')->name('OrgVerification.alumni');

        //Can only access if you're apart of the organization
        Route::middleware('orgverified')->group(function () {
            Route::resource('role', 'RoleController');

            Route::resource('serviceEvent', 'ServiceEventController')->except(['create', 'edit', 'up0date']);
            Route::resource('serviceLogs', 'ServiceLogController')->except(['show', 'create', 'store']);
            Route::resource('event', 'EventController');
            Route::resource('survey', 'SurveyController');
            Route::resource('surveyAnswers', 'SurveyAnswersController');
            Route::resource('calendarItem', 'CalendarController');
            Route::resource('attendance', 'AttendanceController')->only(['destroy']);
            Route::resource('attendanceEvents', 'AttendanceEventController')->only(['index', 'destroy']);
            Route::resource('semester', 'SemesterController')->only('store');   //need to test
            Route::get('/dash', 'DashController@index');


            Route::get('/goals', 'GoalsController@index');
            Route::get('/goals/edit', 'GoalsController@edit');
            Route::post('/goals/{goals}/update', 'GoalsController@update');
            Route::get('/goals/{goals}/notify', 'NotifyController@index');
            Route::post('/goals/{goals}/notify/send', 'NotifyController@send');
            Route::post('/goals/{goals}/notify/sendAll', 'NotifyController@sendAll');

            Route::get('/users/{user}/adminView', 'UserController@adminView');
            Route::post('/user/{user}/organization/remove', 'OrganizationController@removeUser')->name('organization.removeUser');

            Route::get('/users/contact', 'ContactController@userContacts')->name('contact.users');

            Route::get('/users/profile', 'ProfileController@index')->name('profile.index');
            Route::get('/users/edit', 'ProfileController@edit')->name('profile.edit');
            Route::post('/users/update', 'ProfileController@update')->name('profile.update');

            Route::post('/avatar/default', 'ProfileController@default_avatar')->name('profile.defaultAvatar');

            Route::get('/attendance/attendanceEvent/{attendanceEvent}', 'AttendanceController@index')->name('attendance.index');
            Route::get('/attendanceEvent/{attendanceEvent}/attendance', 'AttendanceController@create')->name('attendance.create');
            Route::post('/attendanceEvent/{attendanceEvent}/attendance', 'AttendanceController@store')->name('attendance.store');

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

            Route::get('/role/{role}/users', 'RoleController@usersInRole')->name('role.usersInRole');
            Route::post('/role/{role}/massSet', 'RoleController@massSet')->name('role.massSet');
            Route::patch('/users/{user}/removeRole', 'RoleController@removeRole')->name('user.removeRole');

            Route::get('/alumni', 'AlumniController@index')->name('alumni.index');
            Route::post('/user/{user}/alumni', 'AlumniController@setAlum')->name('alumni.setAlum');
            Route::get('/alumni/contact', 'AlumniController@contact')->name('alumni.contact');
            Route::post('/alumni/contact/send', 'AlumniController@send')->name('alumni.send');

            Route::get('/totals', 'TotalsController@index')->name('totals.index');

            Route::get('/user/{event}/invites', 'InviteController@index')->name('invites.index');
            Route::get('/user/{event}/invite', 'InviteController@create')->name('invite.create');
            Route::post('/user/{event}/invite', 'InviteController@store')->name('invite.store');
            Route::delete('/invite/{invite}', 'InviteController@destroy')->name('invite.destroy');

            Route::get('/users/{user}/service_breakdown', 'ServiceLogController@breakdown')->name('serviceLogs.breakdown');

            Route::resource('involvement', 'InvolvementController')->only(['index', 'store']); //except(['destroy', 'update', 'show', 'edit', 'create']);
            Route::resource('involvementLog', 'InvolvementLogController')->only(['store', 'destroy']);
            Route::get('/user/{user}/involvementLogs', 'InvolvementLogController@breakdown')->name('involvement.breakdown');

            Route::middleware('ManageInvolvement')->group(function () {
                Route::get('/involvement/adminView', 'InvolvementController@adminView')->name('involvement.adminView');
                Route::post('/involvement/import', 'InvolvementController@import')->name('involvement.import');
                Route::patch('/involvement/{involvement}/update', 'InvolvementController@update')->name('involvement.update');
                Route::post('/involvement/setPoints', 'InvolvementController@setPoints')->name('involvement.setPoints');
                Route::delete('involvement/{involvement}', 'InvolvementController@destroy')->name('involvement.delete');
            });

            Route::middleware('ManageAcademics')->group(function () {
                Route::resource('academics', 'AcademicsController')->only(['index', 'store']);
                Route::get('/academics/user_id/{academics}/edit', 'AcademicsController@edit')->name('academics.edit');
                Route::patch('/user/{user}/academics/{academics}/update', 'AcademicsController@update')->name('academics.update');
                Route::get('/academics/manage', 'AcademicsController@manage')->name('academics.manage');
                Route::get('/academics/downloadExampleFile', 'AcademicsController@getExampleFile')->name('academics.getExampleFile');
                Route::post('/academics/notifyAll', 'NotifyController@academicsNotifyAll')->name('academics.notifyAll');
                Route::post('/academics/notify/selected', 'NotifyController@academicsNotifySelected')->name('academics.notifySelected');
                Route::post('/academics/notify/specificStanding', 'NotifyController@academicsNotifySpecificStanding')->name('academics.notifySpecificStanding');

                Route::resource('academicStandings', 'AcademicStandingsController')->only(['index', 'store']);
                Route::patch('/academicStandings/{academicStandings}', 'AcademicStandingsController@update')->name('academicStandings.update');
                Route::delete('/academicStandings/{academicStandings}', 'AcademicStandingsController@destroy')->name('academicStandings.destroy');
                Route::get('academicStandings/{academicStandings}/edit', 'AcademicStandingsController@edit')->name('academicStandings.edit');
            });
        });
    });
});

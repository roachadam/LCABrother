<?php
use App\Http\Controllers\AcademicsController;

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
Route::get('/contact/thanks', function () {
    return view('home.contact.thanks');
});

Auth::routes();

Route::resource('organization', 'OrganizationController');
Route::resource('user', 'UserController');

Route::get('/users/profile', 'UserController@profile');
Route::get('/users/edit', 'UserController@edit');
Route::post('/user/{user}/join', 'UserController@joinOrg');
Route::post('/users/update', 'UserController@update');
Route::get('/users/{user}/adminView', 'UserController@adminView');
Route::post('/user/{user}/organization/remove', 'UserController@orgRemove');

Route::resource('role', 'RoleController');
Route::resource('serviceEvent', 'ServiceEventController');
Route::resource('serviceLog', 'ServiceLogController');
Route::resource('event', 'EventController');
Route::resource('involvement', 'InvolvementController');
Route::resource('involvementLog', 'InvolvementLogController');
Route::resource('survey', 'SurveyController');
Route::resource('surveyAnswers', 'SurveyAnswersController');
Route::resource('calendarItem', 'CalendarController');
Route::resource('subscribers', 'SubscribersController');
Route::resource('attendance', 'AttendanceController');
Route::resource('attendanceEvent', 'AttendanceEventController');

Route::get('/attendance/attendanceEvent/{attendanceEvent}', 'AttendanceController@index');
Route::post('/attendanceEvent/calendarItem/{calendarItem}', 'AttendanceEventController@store');
Route::post('/attendanceEvent/{attendanceEvent}/attendance', 'AttendanceController@store');
Route::get('/attendanceEvent/{attendanceEvent}/attendance', 'AttendanceController@create');
Route::get('/attendanceEvents', 'AttendanceEventController@index');

Route::post('newsletter/send/preview', 'NewsLetterController@preview');
Route::get('newsletter/send/show', 'NewsLetterController@showSend');

Route::resource('newsletter', 'NewsLetterController')->except(['show', 'update']);
// Route::get('newsletter/create', 'NewsLetterController@create');
// Route::post('/newsletter', 'NewsLetterController@store');
// Route::delete('/newsletter/{newsletter}', 'NewsLetterController@destroy');
// Route::get('newsletter', 'NewsLetterController@index');
// Route::get('newsletter/{newsletter}/edit', 'NewsLetterController@edit');
Route::get('/newsletter/{newsletter}/subscribers', 'NewsLetterController@subscribers');
Route::post('/newsletter/send', 'NewsLetterController@send');

Route::post('/calendarItem/{calendarItem}/event/create', 'CalendarController@addEvent');

Route::post('survey/{survey}/notify', 'SurveyController@notify');
Route::get('survey/{survey}/responses', 'SurveyController@viewResponses');
Route::post('/surveyAnswers/survey/{survey}', 'SurveyAnswersController@store');
Route::get('/user/{user}/involvementLogs', 'InvolvementLogController@breakdown');


Route::resource('academics', 'AcademicsController')->only(['index', 'store']);
Route::get('/academics/user_id/{academics}/edit', 'AcademicsController@edit');
Route::patch('/user/{user}/academics/{academics}/update', 'AcademicsController@update');
Route::get('/academics/manage', 'AcademicsController@manage');
Route::get('/academics/downloadExampleFile', 'AcademicsController@getExampleFile');


Route::resource('academicStandings', 'AcademicStandingsController')->except(['update', 'destroy']);
Route::patch('/academicStandings/{academicStandings}', 'AcademicStandingsController@update');
Route::delete('/academicStandings/{academicStandings}', 'AcademicStandingsController@destroy');

Route::post('/academics/notifyAll', 'NotifyController@academicsNotifyAll');
Route::post('/academics/notify/selected', 'NotifyController@academicsNotifySelected');
Route::post('/academics/notify/specificStanding', 'NotifyController@academicsNotifySpecificStanding');

Route::get('/dash', 'DashController@index');

Route::get('/orgpending/waiting', 'OrgVerificationController@waiting');
Route::get('/orgpending/rejected', 'OrgVerificationController@rejected');
Route::get('/orgpending/alumni', 'OrgVerificationController@alumni');

Route::get('/role/{role}/users', 'RoleController@users');
Route::post('/role/{role}/massSet', 'RoleController@massSet');


Route::get('/orgpending/{user}', 'OrgVerificationController@show');
Route::post('/orgpending/{user}/update', 'OrgVerificationController@update');
Route::post('/organizations/{organization}/roles', 'OrganizationRolesController@store');
Route::get('/users/contact', 'UserController@contact');

Route::get('/goals', 'GoalsController@index');
Route::get('/goals/create', 'GoalsController@create');
Route::post('/goals/store', 'GoalsController@store');
Route::post('/goals/{goals}/update', 'GoalsController@update');
Route::get('/goals/edit', 'GoalsController@edit');


Route::get('/massInvite', 'MassInvite@index');
Route::post('/massInvite/send', 'MassInvite@inviteAll');
Route::get('/organizations/{organization}/join', 'InvitedRegisterController@showRegistrationForm');
Route::post('/organization/{organization}/register', 'InvitedRegisterController@register');

Route::get('/event/{event}/invites', 'InviteController@index');
Route::get('/event/{event}/invite', 'InviteController@create');
Route::post('/event/{event}/invite', 'InviteController@store');
Route::delete('/invite/{invite}', 'InviteController@destroy');

Route::get('/goals/{goals}/notify', 'NotifyController@index');
Route::post('/goals/{goals}/notify/send', 'NotifyController@send');
Route::post('/goals/{goals}/notify/sendAll', 'NotifyController@sendAll');

Route::get('/forum/create/categories', 'ForumController@create');
Route::post('/forum/create/categories', 'ForumController@store');

Route::get('/avatar/create', 'UserController@create_avatar');
Route::post('/avatar/create', 'UserController@update_avatar');
Route::post('/avatar/default', 'UserController@default_avatar');

Route::post('/home/contactUs', 'HomeController@contactUs');

Route::get('/totals', 'TotalsController@index');

Route::get('/alumni', 'AlumniController@index');
Route::post('/user/{user}/alumni', 'AlumniController@setAlum');
Route::get('/alumni/contact', 'AlumniController@contact');
Route::post('/alumni/contact/send', 'AlumniController@send');

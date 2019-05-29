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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('organization/create', 'OrganizationController@create');
Route::resource('organization', 'OrganizationController');

Route::resource('user', 'UserController');
Route::post('/user/{user}/join', 'UserController@joinOrg');

Route::resource('role','RoleController');
Route::resource('serviceEvent', 'ServiceEventController');

Route::resource('involvement', 'InvolvementController');
Route::resource('involvementLog', 'InvolvementLogController');

Route::get('/dash', 'DashController@index');

Route::get('/orgpending/waiting', 'OrgVerificationController@waiting');
Route::get('/orgpending/rejected', 'OrgVerificationController@rejected');
Route::resource('role','RoleController');

Route::get('/orgpending/{user}', 'OrgVerificationController@show');
Route::post('/orgpending/{user}/update', 'OrgVerificationController@update');
Route::post('/organizations/{organization}/roles','OrganizationRolesController@store');
Route::post('/organizations/{organization}/roles/update','OrganizationRolesController@update');
Route::get('/users/contact', 'UserController@contact');

Route::get('/goals/create' , 'GoalsController@create');
Route::post('/goals/store', 'GoalsController@store');
// Route::group(['middleware' => ['ManageMembers']], function () {

// });

// Route::group(['middleware' => ['InvolvementView']], function () {
//     //
// });
// Route::group(['middleware' => ['ManageInvolvement']], function () {
//     //
// });
// Route::group(['middleware' => ['ManageService']], function () {
//     //
// });
// Route::group(['middleware' => ['MemberView']], function () {
//     Route::get('/users/contact', 'UserController@contact');
// });
// Route::group(['middleware' => ['ServiceLogger']], function () {
//     //
// });
// Route::group(['middleware' => ['ServiceView']], function () {
//     //
// });

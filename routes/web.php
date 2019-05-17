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
Route::resource('role','RoleController');
Route::get('/dash', 'DashController@index');
Route::get('/orgpending', 'OrgVerificationController@index');
//Route::post('/organizations/{organization}/roles','RolesController@store');
Route::post('/organizations/{organization}/roles','OrganizationRolesController@store');
Route::post('/organizations/{organization}/roles/update','OrganizationRolesController@update');


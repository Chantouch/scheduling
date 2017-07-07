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
Route::prefix('app')->name('app.')->group(function () {
    Route::resource('meetings', 'MeetingController');
    Route::resource('missions', 'MissionController');
});

Route::get('meetings', 'Front\MeetingController@index')->name('front.meetings.index');
Route::get('missions', 'Front\MissionController@index')->name('front.mission.index');
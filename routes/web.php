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
    Route::resource('gcalendars', 'gCalendarController');
    Route::get('gscalendars', 'gCalendarController@getDataG');
    Route::get('sync-google-calendars', 'TempDataController@syncGoogleCalendars')->name('sync.google.calendars');
    Route::get('sync-google-test-sync', 'TempDataController@testSync')->name('sync.google.test-sync');
    Route::get('sync-google-calendars-meetings', 'TempDataController@syncMeetingLocalData')->name('sync.google-calendars.local-meeting');
    Route::get('sync-google-calendars-missions', 'TempDataController@syncMissionLocalData')->name('sync.google-calendars.local-mission');
    Route::get('sync-google-calendars-local', 'TempDataController@syncGoogleCalendarsToLocal')->name('sync.google-calendars.local');
    Route::get('json-data/{id}', 'JsonDataController@show')->name('sync.json.data');
});

Route::get('meetings', 'Front\MeetingController@index')->name('front.meetings.index');
Route::get('missions', 'Front\MissionController@index')->name('front.missions.index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('oauth', ['as' => 'oauthCallback', 'uses' => 'gCalendarController@oauth']);
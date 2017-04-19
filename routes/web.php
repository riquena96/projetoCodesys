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
    return view('app');
});

Route::post('oauth/access_token', function () {
    return Response::json(Authorizer::issueAccessToken());
});

//OAuth verify
Route::group(['middleware' => 'oauth'], function() {

    //Client
    Route::resource('client', 'ClientController', ['exception' => 'create', 'edit']);

    //Project
    Route::resource('project', 'ProjectController', ['exception' => 'create', 'edit']);

    //Project Group
    Route::group(['prefix' => 'project'], function () {

        //ProjectNote
        Route::get('{id}/note', 'ProjectNoteController@index');
        Route::post('{id}/note/', 'ProjectNoteController@store');
        Route::put('note/{noteId}', 'ProjectNoteController@update');
        Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
        Route::delete('note/{id}', 'ProjectNoteController@destroy');

        //ProjectFile
        Route::get('{id}/file', 'ProjectFileController@index');
        Route::get('file/{fileId}', 'ProjectFileController@show');
        Route::get('file/{fileId}/download', 'ProjectFileController@showfile');
        Route::post('{id}/file', 'ProjectFileController@store');
        Route::put('file/{fileId}', 'ProjectFileController@update');
        Route::delete('file/{fileId}', 'ProjectFileController@destroy');
    });

    Route::get('user/authenticated', 'UserController@authenticated');
});

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
    Route::resource('client', 'ClientController', ['except' => 'create', 'edit']);

    //Project
    Route::resource('project', 'ProjectController', ['except' => 'create', 'edit']);

    //ProjectMember
    Route::resource('project.member', 'ProjectMemberController', ['except' => 'create', 'edit', 'update']);

    //Project Group
    Route::group(['middleware' => 'check.project.permission', 'prefix' => 'project'], function () {

        //ProjectNote
        Route::get('{id}/note', 'ProjectNoteController@index');
        Route::post('{id}/note/', 'ProjectNoteController@store');
        Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
        Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
        Route::delete('{id}/note/{noteId}', 'ProjectNoteController@destroy');

        //ProjectFile
        Route::get('{id}/file', 'ProjectFileController@index');
        Route::get('{id}/file/{fileId}', 'ProjectFileController@show');
        Route::get('{id}/file/{fileId}/download', 'ProjectFileController@showfile');
        Route::post('{id}/file', 'ProjectFileController@store');
        Route::put('{id}/file/{fileId}', 'ProjectFileController@update');
        Route::delete('{id}/file/{fileId}', 'ProjectFileController@destroy');

        //ProjectTask
        Route::get('{id}/task', 'ProjectTaskController@index');
        Route::get('{id}/task/{taskId}', 'ProjectTaskController@show');
        Route::post('{id}/task', 'ProjectTaskController@store');
        Route::put('{id}/task/{taskId}', 'ProjectTaskController@update');
        Route::delete('{id}/task/{taskId}', 'ProjectTaskController@destroy');
    });

    Route::get('user/authenticated', 'UserController@authenticated');
    Route::resource('user', 'UserController', ['except' => 'create', 'edit']);
});

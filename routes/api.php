<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('todo_list', 'ToDoVueController@index');
Route::get('todo/{id}', 'ToDoVueController@show');
Route::post('todo', 'ToDoVueController@store');
Route::put('todo', 'ToDoVueController@update');
Route::put('todo_mark', 'ToDoVueController@mark');
Route::delete('todo/{id}', 'ToDoVueController@destroy');
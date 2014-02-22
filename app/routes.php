<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function() {
	return View::make('singlepage');
});

Route::post('/auth/login', array('before' => 'csrf_json', 'uses' => 'AuthController@login'));
Route::post('/auth/register', array('before' => 'csrf_json', 'uses' => 'AuthController@register'));
Route::get('/auth/logout', 'AuthController@logout');
Route::get('/auth/status', 'AuthController@status');

Route::post('/services/collections', array('before' => 'csrf_json', 'uses' => 'CollectionsController@create'));
Route::delete('/services/collections/{id}', 'CollectionsController@delete')->where('id', '\d+');
Route::get('/services/collections', 'CollectionsController@getAll');
Route::get('/services/collections/{id}', 'CollectionsController@getOne')->where('id', '\d+');
Route::put('/services/collections/{id}', 'CollectionsController@update')->where('id', '\d+');


Route::post('/services/collections/{collection_id}/monuments', array('before' => 'csrf_json', 'uses' => 'MonumentsController@create'));
Route::delete('/services/collections/{collection_id}/monuments/{id}', 'MonumentsController@delete')->where('id', '\d+')->where('collection_id', '\d+');
Route::get('/services/collections/{collection_id}/monuments', 'MonumentsController@getAll');
Route::get('/services/collections/{collection_id}/monuments/{id}', 'MonumentsController@getOne')->where('id', '\d+')->where('collection_id', '\d+');
Route::put('/services/collections/{collection_id}/monuments/{id}', 'MonumentsController@update')->where('id', '\d+')->where('collection_id', '\d+');


Route::get('/{other}', function() {
    return View::make('singlepage');
})->where('other', '[^\.]+');
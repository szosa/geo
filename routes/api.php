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


Route::post('/add-location', 'LocationController@addLocations');
Route::post('/get-closest-point', 'LocationController@getClosestPoint');
Route::post('/get-point-in-range', 'LocationController@getPointInRange');
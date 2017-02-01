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

Route::get('leaderBoard','getLeaderBoard@getTop10');

Route::post('playerInfo','members@get')->middleware('memberExist','checkParams:memberID');

Route::post('addMember','members@add')->middleware('checkParams:name,adress1,adress2,postCode');

Route::post('editMember','members@edit')->middleware('checkParams:name,adress1,adress2,postCode,memberID');
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

Route::post('/','IndexController@Api');
Route::get('/','IndexController@Api');

Route::group(['prefix'=>'/key'],function (){
    Route::post('/IsTrue','KeysController@IsTrue');
    Route::post('/NewKey','KeysController@NewKey');
    Route::post('/DelKey','KeysController@DelKey');
    Route::post('/UpdateKey','KeysController@UpdateKey');
});

Route::group(['prefix'=>'/image'],function(){
   Route::post('/Upload','ImageController@Upload');
   Route::post('/NameFindImage','ImageController@NameFindImage');
});

Route::group(['prefix'=>'app'],function(){
    Route::post('FindKey','AppKeyController@FindKey');
});
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::get('product','ProductController@index');
Route::post('signin', 'api\Userdata@signin');
Route::post('signup', 'api\Userdata@signup');
Route::post('profile', 'api\Userdata@profile');
Route::post('update_profile', 'api\Userdata@update_profile');
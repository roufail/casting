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


Route::get('services/{search?}', 'API\ServiceController@index')->name('services');
Route::post('client/login', 'API\ClientController@login')->name('client.login');
Route::post('client/register', 'API\ClientController@register')->name('client.register');



Route::group(['middleware' => 'auth:api','prefix' => 'payer','as' => 'payer.'],function(){
    
    Route::get('myorders/update/{id}/{status}', 'API\OrderController@payer_updatemyorders')->name('updatemyorders');
    Route::get('myorders/{status?}', 'API\OrderController@myorders')->name('myorders');
    Route::post('profile', 'API\UserController@updatemyprofile')->name('updatemyprofile');

    Route::get('myservices', 'API\ServiceController@myservices')->name('myservice');
    Route::post('mainservice', 'API\ServiceController@create_main_service')->name('createmainservice');
    Route::resource('services', 'API\ServiceController');

});

Route::group(['middleware' => 'auth:client-api','prefix' => 'client','as' => 'client.'],function(){
    Route::post('place_order', 'API\OrderController@place_order')->name('place_order');
    Route::get('myorders/update/{id}/{status}', 'API\OrderController@client_updatemyorders')->name('updatemyorders');
    Route::post('rate/{order}', 'API\OrderController@rate_payer')->name('rate_payer');
});
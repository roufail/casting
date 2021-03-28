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


Route::get('services', 'API\ServiceController@index')->name('services');
Route::get('service/{UserService}', 'API\ServiceController@service')->name('service');
Route::get('service/{UserService}/reviews', 'API\ServiceController@service_reviews')->name('service_reviews');
Route::get('payer-images/{user}', 'API\ServiceController@payer_images')->name('payer_images');
Route::get('payer-video/{user}', 'API\ServiceController@payer_video')->name('payer_video');
Route::get('categories', 'API\ServiceController@categories')->name('categories');

Route::post('client/login', 'API\ClientController@login')->name('client.login');
Route::post('client/activate', 'API\ClientController@activate')->name('client.activate');
Route::post('client/register', 'API\ClientController@register')->name('client.register');
Route::post('client/password-recovery', 'API\ClientController@password_recovery')->name('client.password_recovery');


Route::post('payer/login', 'API\UserController@login')->name('payer.login');
Route::post('payer/activate', 'API\UserController@activate')->name('payer.activate');
Route::post('payer/register', 'API\UserController@register')->name('payer.register');
Route::post('payer/password-recovery', 'API\UserController@password_recovery')->name('payer.password_recovery');


Route::group(['middleware' => ['auth:payer-api','payer.activated'],'prefix' => 'payer','as' => 'payer.'],function(){
    
    Route::get('myorders/update/{id}/{status}', 'API\OrderController@payer_updatemyorders')->name('updatemyorders');
    Route::get('myorders/{status?}', 'API\OrderController@myorders')->name('myorders');
    Route::post('profile', 'API\UserController@updatemyprofile')->name('updatemyprofile');
    Route::post('update-my-data', 'API\UserController@update_my_data')->name('update_my_data');

    Route::get('myservices', 'API\ServiceController@myservices')->name('myservice');
    Route::post('mainservice', 'API\ServiceController@create_main_service')->name('createmainservice');
    Route::resource('services', 'API\ServiceController');
    // chat routes
    Route::post('chat/message/{client}', 'API\ChatController@message_to_client')->name('messagetoclient');
    Route::get('chat/load-chat/{order}', 'API\ChatController@load_chat')->name('load_chat');


});

Route::group(['middleware' => ['auth:client-api','client.activated'],'prefix' => 'client','as' => 'client.'],function(){
    Route::post('place_order', 'API\OrderController@place_order')->name('place_order');
    Route::get('myorders/update/{id}/{status}', 'API\OrderController@client_updatemyorders')->name('updatemyorders');
    Route::post('rate/{order}', 'API\OrderController@rate_payer')->name('rate_payer');
    // chat routes
    Route::post('chat/message/{payer}', 'API\ChatController@message_to_payer')->name('messagetopayer');
    Route::get('chat/load-chat/{order}', 'API\ChatController@load_chat')->name('load_chat');
});
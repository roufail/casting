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


Route::get('main-services', 'API\ServiceController@main_services')->name('main_services');
Route::get('services', 'API\ServiceController@index')->name('services');
Route::get('service/{UserService}', 'API\ServiceController@service')->name('service');
Route::get('service/{UserService}/reviews', 'API\ServiceController@service_reviews')->name('service_reviews');
Route::get('categories', 'API\ServiceController@categories')->name('categories');
Route::get('category/{category}', 'API\ServiceController@category')->name('category');

Route::get('payer/work-durations','API\UserController@work_duration')->name('work_duration');

Route::post('client/login', 'API\ClientController@login')->name('client.login');
Route::post('client/activate', 'API\ClientController@activate')->name('client.activate');
Route::post('client/register', 'API\ClientController@register')->name('client.register');
Route::post('client/password-recovery', 'API\ClientController@password_recovery')->name('client.password_recovery');
Route::post('client/reset-password', 'API\ClientController@reset_password')->name('client.reset_password');


Route::post('payer/login', 'API\UserController@login')->name('payer.login');
Route::post('payer/activate', 'API\UserController@activate')->name('payer.activate');
Route::post('payer/register', 'API\UserController@register')->name('payer.register');
Route::post('payer/password-recovery', 'API\UserController@password_recovery')->name('payer.password_recovery');
Route::post('payer/reset-password', 'API\UserController@reset_password')->name('payer.reset_password');


Route::get('payer-images/{user}', 'API\UserController@payer_images')->name('payer_images');
Route::get('payer-video/{user}', 'API\UserController@payer_video')->name('payer_video');



Route::get('/inital','API\InitialController@initial');
Route::get('/settings','API\InitialController@settings');


Route::group(['middleware' => ['auth:payer-api'],'prefix' => 'payer','as' => 'payer.'],function(){
    
    Route::get('/', 'API\UserController@payer')->name('payer');
    Route::post('logout', 'API\UserController@logout')->name('payer.logout');
    Route::post('/update-firebase-token', 'API\UserController@update_firebase_token')->name('update_firebase_token');

    Route::get('myorders/update/{id}/{status}', 'API\OrderController@payer_updatemyorders')->name('updatemyorders');
    Route::get('myorders/{order}', 'API\OrderController@payer_order')->name('payer_order')->where(['order' => '[0-9]+']);
    Route::get('myorders/{status?}', 'API\OrderController@myorders')->name('myorders');
    Route::post('profile', 'API\UserController@updatemyprofile')->name('updatemyprofile');
    Route::post('update-my-data', 'API\UserController@update_my_data')->name('update_my_data');
    Route::get('fees', 'API\ServiceController@fees')->name('fees');
    Route::post('update-data', 'API\UserController@update_data')->name('update_data');


    Route::get('myservices', 'API\ServiceController@myservices')->name('myservice');
    Route::post('mainservice', 'API\ServiceController@create_main_service')->name('createmainservice');
    Route::resource('services', 'API\ServiceController');
    // chat routes
    Route::post('chat/message/{client}', 'API\ChatController@message_to_client')->name('messagetoclient');
    Route::get('chat/load-chat/{order}', 'API\ChatController@load_chat')->name('load_chat');
    Route::get('notifications', 'API\UserController@notifications')->name('notifications');
    Route::post('read-notifications', 'API\UserController@read_notifications')->name('read_notifications');
    




});

Route::group(['middleware' => ['auth:client-api'],'prefix' => 'client','as' => 'client.'],function(){
    
    Route::get('/', 'API\ClientController@client')->name('client');
    Route::post('logout', 'API\ClientController@logout')->name('client.logout');
    Route::post('/update-firebase-token', 'API\ClientController@update_firebase_token')->name('update_firebase_token');

    Route::post('place-order', 'API\OrderController@place_order')->name('place_order');
    Route::get('myorders/{order}', 'API\OrderController@client_order')->name('myorder')->where(['order' => '[0-9]+']);
    Route::get('myorders/{status?}', 'API\OrderController@client_orders')->name('myorders');
    Route::get('myorders/update/{id}/{status}', 'API\OrderController@client_updatemyorders')->name('updatemyorders');
    Route::post('rate/{order}', 'API\OrderController@rate_payer')->name('rate_payer');
    // chat routes
    Route::post('chat/message/{payer}', 'API\ChatController@message_to_payer')->name('messagetopayer');
    Route::get('chat/load-chat/{order}', 'API\ChatController@load_chat')->name('load_chat');
    Route::post('update-profile', 'API\ClientController@update_profile')->name('update_profile');
    Route::post('update-password', 'API\ClientController@update_password')->name('update_password');
    Route::get('notifications', 'API\ClientController@notifications')->name('notifications');
    Route::post('read-notifications', 'API\ClientController@read_notifications')->name('read_notifications');

});
// Route::group(['middleware' => ['auth.api']],function(){
//     Route::get('notifications', 'API\NotificationController@notifications')->name('notifications');
//     Route::post('read-notifications', 'API\NotificationController@read_notifications')->name('read_notifications');
// });
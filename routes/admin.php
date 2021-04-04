<?php
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return 'admin';
// });


Route::group(['namespace' => 'Admin','as'=>'admin.'],function(){
    // Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    // Route::post('register', 'Auth\RegisterController@register')->name('register.post');
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@Login')->name('login.post');

    Route::group(['middleware' => ['auth:admin']],function(){
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('home', 'DashboardController@index')->name('dashboard'); 
        Route::get('dashboard', 'DashboardController@index')->name('dashboard'); 
        Route::get('logout', 'Auth\LoginController@logout')->name('logout');

        Route::get('users/ajax_data', 'UserController@ajaxData')->name('users.ajax_data');
        Route::get('users/delete_image', 'UserController@delete_image')->name('users.delete_image');
        Route::post('users/upload_images', 'UserController@upload_images')->name('users.upload_images');
        Route::post('users/remove_dropzone_image', 'UserController@remove_dropzone_image')->name('users.remove_dropzone_image');
        Route::resource('users', 'UserController');
        


        Route::get('categories/ajax_data', 'CategoryController@ajaxData')->name('categories.ajax_data');
        Route::get('categories/delete_image', 'CategoryController@delete_image')->name('categories.delete_image');
        Route::resource('categories', 'CategoryController');



        Route::get('services/ajax_data', 'ServiceController@ajaxData')->name('services.ajax_data');
        Route::get('services/delete_image', 'ServiceController@delete_image')->name('services.delete_image');
        Route::resource('services', 'ServiceController');


        Route::get('userservices/ajax_data', 'UserServiceController@ajaxData')->name('userservices.ajax_data');
        Route::get('userservices/delete_image', 'UserServiceController@delete_image')->name('userservices.delete_image');
        Route::resource('userservices', 'UserServiceController');



        Route::get('clients/ajax_data', 'ClientController@ajaxData')->name('clients.ajax_data');
        Route::get('clients/delete_image', 'ClientController@delete_image')->name('clients.delete_image');
        Route::resource('clients', 'ClientController');


        Route::get('orders/ajax_data', 'OrderController@ajaxData')->name('orders.ajax_data');
        Route::get('orders/{order}/chat', 'OrderController@chat')->name('orders.chat');
        Route::resource('orders', 'OrderController')->only('index');



        Route::get('incomings/ajax_data', 'IncomingController@ajaxData')->name('incomings.ajax_data');
        Route::resource('incomings', 'IncomingController');
        
        Route::get('outgoings/ajax_data', 'OutgoingController@ajaxData')->name('outgoings.ajax_data');
        Route::get('outgoings/pay/{order}', 'OutgoingController@pay')->name('outgoings.pay');
        Route::resource('outgoings', 'OutgoingController');

        Route::get('ratings/ajax_data', 'RatingController@ajaxData')->name('ratings.ajax_data');
        Route::resource('ratings', 'RatingController');
        
        
        Route::get('settings/delete_image', 'SettingController@delete_image')->name('settings.delete_image');
        Route::resource('settings', 'SettingController');
        
        
        Route::get('admins/ajax_data', 'AdminController@ajaxData')->name('admins.ajax_data');
        Route::resource('admins', 'AdminController');


    });
});







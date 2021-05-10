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
        Route::get('users/delete_video', 'UserController@delete_video')->name('users.delete_video');
        Route::post('users/upload_images', 'UserController@upload_images')->name('users.upload_images');
        Route::post('users/remove_dropzone_image', 'UserController@remove_dropzone_image')->name('users.remove_dropzone_image');
        Route::post('users/upload_video', 'UserController@upload_video')->name('users.video.upload');
        
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
        Route::get('outgoings/response', 'OutgoingController@response')->name('outgoings.response');
        Route::resource('outgoings', 'OutgoingController');

        
        
        Route::get('wallets/download-payment-requests/{ids?}', 'WalletController@download_payment_requests')->name('wallets.download_payment_requests');
        Route::get('wallets/ajax_data', 'WalletController@ajaxData')->name('wallets.ajax_data');
        Route::get('wallets/{wallet}/items_ajax_data', 'WalletController@itemsAjaxData')->name('wallets.items_ajax_data');
        Route::get('wallets/payment_requets_ajax_data/{status?}', 'WalletController@paymentRequetsAjaxData')->name('wallets.payment_requets_ajax_data');
        Route::get('wallet/pay/{wallet}', 'WalletController@pay')->name('wallets.pay');
        Route::get('wallet/{payment_request}/pay', 'WalletController@payment_request_pay')->name('wallets.payment_request_pay');
        Route::post('wallet/bank-account-details', 'WalletController@bank_account_details')->name('wallets.bank_account_details');
        Route::get('wallet/{wallet}/get-items', 'WalletController@get_items')->name('wallets.get_items');
        Route::get('wallet/payment-requests', 'WalletController@payment_requests')->name('wallets.payment_requests');
        Route::get('wallets/payment-requests/paid', 'WalletController@paid_payment_requests')->name('wallets.paid_payment_requests');
        Route::get('wallets/payment-requests/pending', 'WalletController@pending_payment_requests')->name('wallets.pending_payment_requests');
        
        Route::resource('wallets', 'WalletController');


        Route::get('ratings/ajax_data', 'RatingController@ajaxData')->name('ratings.ajax_data');
        Route::resource('ratings', 'RatingController');
        
        
        Route::get('settings/delete_image', 'SettingController@delete_image')->name('settings.delete_image');
        Route::resource('settings', 'SettingController');
        
        
        Route::get('admins/ajax_data', 'AdminController@ajaxData')->name('admins.ajax_data');
        Route::resource('admins', 'AdminController');


    });
});







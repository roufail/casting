<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


app()->setlocale("ar");
// Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/privacy-policy', [App\Http\Controllers\HomeController::class, 'privacy_policy'])->name('privacy_policy');
Route::get('/terms-and-conditions', [App\Http\Controllers\HomeController::class, 'terms_and_conditions'])->name('terms_and_conditions');

Route::get("/test-socket",[App\Http\Controllers\API\ChatController::class,'test_socket']);


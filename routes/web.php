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

Route::get('/', function () {
    return view('welcome');
});
//page dang nhap
Route::get('/login', 'App\Http\Controllers\Login_CTL@index');
//xu ly dang nhap
Route::post('/checkV', 'App\Http\Controllers\Login_CTL@login1');
Route::get('/logout', 'App\Http\Controllers\Login_CTL@logout');

//trang gaslist
Route::get('/gaslist', 'App\Http\Controllers\Gas_List@getgaslist');
//add del edit gas
Route::post('/gasadd', 'App\Http\Controllers\Gas_List@gasadd');
Route::post('/loadedit', 'App\Http\Controllers\Gas_List@load_edit');
Route::post('/delete', 'App\Http\Controllers\Gas_List@deletegas');


//search list gas
Route::get('/tim123', 'App\Http\Controllers\Gas_List@searchGas');
Route::get('/test', 'App\Http\Controllers\Gas_List@test');

//feedback page
Route::get('/feedback', 'App\Http\Controllers\Feedback_CTL@feedbackview');



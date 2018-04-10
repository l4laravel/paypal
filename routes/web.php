<?php

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

Route::post('pay','PaymentController@payWithPaypal')->name('pay');
Route::get('status','PaymentController@status')->name('status');
Route::get('canceled','PaymentController@canceled')->name('canceled');


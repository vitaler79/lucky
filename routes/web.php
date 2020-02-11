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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home/getprize', 'HomeController@getPrize')->name('home.getPrize');
Route::post('/home/refuse', 'HomeController@refuse')->name('home.refuse');
Route::post('/home/moneytoaccount', 'HomeController@moneyToAccount')->name('home.moneyToAccount');
Route::post('/home/bonustoaccount', 'HomeController@bonusToAccount')->name('home.bonusToAccount');
Route::get('/bank/{id}', 'BankController@index')->where('id', '[0-9]+')->name('bank');
Route::post('/bank/query', 'BankController@query')->name('bank.query');
Route::get('/shipping/{id}', 'ShippingController@index')->where('id', '[0-9]+')->name('shipping');
Route::post('/shipping/query', 'ShippingController@query')->name('shipping.query');

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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::group([
    'middleware'    => ['auth'],
    'prefix'        => 'money',
], function () {
    Route::get('/', 'MoneyController@index');
    Route::post('/transfer', 'MoneyController@transfer');
    Route::get('/deposit', 'MoneyController@deposit');
    Route::get('/withdraw', 'MoneyController@withdraw');
});

Route::get('/home', 'HomeController@index')->name('home');

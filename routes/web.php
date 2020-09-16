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

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::get('/home2', 'App\Http\Controllers\HomeController@demo')->name('demo');

Route::get('/clients', 'App\Http\Controllers\ClientController@index')->name('clients');
Route::get('/clients/create', '\App\Http\Controllers\ClientController@create')->name('clients.create');
Route::post('clients/create','\App\Http\Controllers\ClientController@store');

Route::delete('/clients/{client}', '\App\Http\Controllers\ClientController@destroy');

Route::get('clients/{client}/edit','\App\Http\Controllers\ClientController@edit');
Route::put('clients/{client}','\App\Http\Controllers\ClientController@update');

Route::get('/transactions','\App\Http\Controllers\TransactionController@index')->name('transactions');




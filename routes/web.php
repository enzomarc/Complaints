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

use Illuminate\Support\Facades\Route;

// Authentication routes
Route::get('login', 'Auth\LoginController@login')->name('login');

Route::post('login', 'Auth\LoginController@auth')->name('login.auth');

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('register', 'Auth\RegisterController@register')->name('register');

Route::post('register', 'Auth\RegisterController@create')->name('register.create');

Route::get('complaint/create', 'ComplaintController@create')->name('create.complaint');

Route::get('users/{user}', 'UserController@show')->name('users.show');

Route::resource('complaints', 'ComplaintController');


// Common routes
Route::group(['middleware' => 'auth'], function () {
	
	Route::get('/', 'UserController@dashboard')->name('dashboard');
	
	// Admin routes
	Route::group(['middleware' => 'admin'], function () {
		
		Route::resource('investigators', 'InvestigatorController');
		
		Route::resource('unities', 'UnityController');
		
	});
	
	Route::resource('investigations', 'InvestigationController');
	
	Route::resource('messages', 'MessageController');
	
});
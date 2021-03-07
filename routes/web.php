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

Route::prefix('app')->middleware('admin')->group(function(){
    Route::post('/create-tag','TagController@store');
    Route::get('/get-tag','TagController@index');
    Route::post('/edit-tag','TagController@update');
    Route::post('/delete-tag','TagController@destroy');
    Route::post('/upload','TagController@upload');
    Route::post('/create-category','CategoryController@store');
    Route::get('/category-lists','CategoryController@index');
    Route::post('/edit-category','CategoryController@update');
    Route::post('/delete-category','CategoryController@destroy');
    Route::post('/create-user','UserController@store');
    Route::get('/user-lists','UserController@index');
    Route::post('/edit-user','UserController@update');
    Route::post('/delete-user','UserController@destroy');
    Route::post('/create-role','RoleController@store');
    Route::get('/role-lists','RoleController@index');
    Route::post('/edit-role','RoleController@update');
    Route::post('/delete-role','RoleController@destroy');
    Route::post('/assignRoles','AssignController@store');
});






Route::post('app/user-login','Auth\LoginController@login');
Route::get('/logout','Auth\LoginController@logout');




Route::get('/','HomeController@index');
Route::any('{slug}', 'HomeController@index');





// Route::get('/home', 'HomeController@index')->name('home');

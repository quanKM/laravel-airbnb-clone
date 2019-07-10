<?php

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/user/edit', 'UsersController@edit')->name('user.edit');
Route::patch('/user', 'UsersController@update')->name('user.update');
<?php

Route::get('/', 'PagesController@home')->name('home');

Auth::routes();
Route::get('/user/edit', 'UsersController@edit')->name('user.edit');
Route::patch('/user', 'UsersController@update')->name('user.update');
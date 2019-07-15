<?php

Route::get('/', 'PagesController@home')->name('home');

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'verified', 'as' => 'user.'], function() {
    Route::get('/user/edit', 'UsersController@edit')->name('edit');
    Route::patch('/user', 'UsersController@update')->name('update');
});

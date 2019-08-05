<?php

Route::get('/', 'PagesController@home')->name('home');

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'verified', 'as' => 'user.'], function() {
    Route::get('/user/edit', 'UsersController@edit')->name('edit');
    Route::patch('/user', 'UsersController@update')->name('update');
});

Route::get('/auth/redirect/{provider}', 'SocialAuthController@redirect')->name('redirect');
Route::get('/callback/{provider}', 'SocialAuthController@callback')->name('callback');

Route::resource('users', 'UsersController')->only(['show']);

Route::group(['middleware' => 'verified', 'as' => 'user.'], function() {
    Route::get('/user/edit', 'UsersController@edit')->name('edit');
    Route::patch('/user', 'UsersController@update')->name('update');
});

Route::resource('rooms', 'RoomController')->except(['edit']);

Route::group(['prefix' => 'rooms', 'as' => 'rooms.'], function() {
    Route::resource('{room}/photos', 'PhotoController')->only(['store', 'destroy']);
    Route::get('/{room}/listing', 'RoomController@listing')->name('listing');
    Route::get('/{room}/pricing', 'RoomController@pricing')->name('pricing');
    Route::get('/{room}/description', 'RoomController@description')->name('description');
    Route::get('/{room}/photos', 'RoomController@photos')->name('photos');
    Route::get('/{room}/amenities', 'RoomController@amenities')->name('amenities');
    Route::get('/{room}/location', 'RoomController@location')->name('location');
    Route::patch('/{room}/publish', 'RoomController@publish')->name('publish');
});

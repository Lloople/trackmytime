<?php

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::auth();

Route::get('/home', 'HomeController@index')->name('home');

<?php

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::auth();

<?php


Route::get('/', function () {
    return view('welcome');
});

Route::resource('post','PostController');
Route::get('all/post','PostController@allPost')->name('all.post');
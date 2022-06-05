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


Route::get('/', 'App\Http\Controllers\Forum\Topic@list')->name('topic.list');

Route::view('/profile', 'profile')->name('profile');

Route::view('/login', 'authentication.login')->name('login');

Route::view('/register', 'authentication.register')->name('register');

Route::group([
    'namespace' => 'App\Http\Controllers\Forum',
    'prefix' => 'topic'
], function() {
    Route::get('{id}/get', 'Topic@get')->name('topic.get');

    Route::get('{id}/edit', 'Topic@edit')->name('topic.edit');

    Route::post('update', 'Topic@update')->name('topic.update');

    Route::get('create', 'Topic@create')->name('topic.create');

    Route::post('create', 'Topic@store')->name('topic.store');

});

Route::group([
    'namespace' => 'App\Http\Controllers\Forum',
    'prefix' => 'topic-comment'
], function() {

    Route::post('create', 'TopicComment@store')->name('topic-comment.store');

});



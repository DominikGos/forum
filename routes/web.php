<?php

use App\Http\Middleware\RedirectIfAuthenticated;
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

//
Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'auth'
], function() {

    Route::post('/logout', 'Authentication\LoginController@logout')->name('logout');

    Route::get('/', 'Forum\Topic@list')->name('topic.list');

    Route::get('/user/{id}', 'UserController@get')->name('profile');

    Route::group([
        'namespace' => 'Forum',
        'prefix' => 'topic'
    ], function() {
        Route::get('{id}/get', 'Topic@get')->name('topic.get');

        Route::get('{id}/edit', 'Topic@edit')->name('topic.edit');

        Route::post('update', 'Topic@update')->name('topic.update');

        Route::get('create', 'Topic@create')->name('topic.create');

        Route::post('create', 'Topic@store')->name('topic.store');

    });

    Route::group([
        'namespace' => 'Forum',
        'prefix' => 'topic-comment'
    ], function() {

        Route::post('create', 'TopicComment@store')->name('topic-comment.store');

    });

});

Route::group([
    'namespace' => 'App\Http\Controllers\Authentication',
    'middleware' => RedirectIfAuthenticated::class
], function() {
    Route::get('/login', 'LoginController@showForm')->name('show.login.form');

    Route::post('/login', 'LoginController@authenticate')->name('login');

    Route::get('/register', 'RegisterController@showForm')->name('show.register.form');

    Route::post('/register', 'RegisterController@register')->name('register');
});


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

Route::get('topic/{id}', 'App\Http\Controllers\Topic\Controller@get')->name('topic.get');

Route::get('/', 'App\Http\Controllers\Topic\Controller@list')->name('topic.list');

Route::get('/topic/search', 'App\Http\Controllers\Topic\Controller@search')->name('topic.search');

Route::get('/user/{id}', 'App\Http\Controllers\UserController@get')->name('user.get');

Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'auth'
], function() {
    Route::post('/logout', 'Authentication\LoginController@logout')->name('logout');

    Route::group([
        'prefix' => 'user',
    ], function() {
        Route::get('{id}/edit', 'UserController@edit')->name('user.edit');

        Route::put('{id}/update', 'UserController@update')->name('user.update');

        Route::get('list', 'UserController@list')
            ->name('user.list')
            ->middleware('check.role:'. App\Models\UserRole::ADMIN);

        /* Route::get('list', 'UserController@list')
            ->name('user.list')
            ->middleware('check.role:'. App\Models\UserRole::ADMIN); */
    });

    Route::group([
        'namespace' => 'Topic',
        'prefix' => 'topic'
    ], function() {
        Route::get('{id}/edit', 'Controller@edit')->name('topic.edit');

        Route::put('{id}/update', 'Controller@update')->name('topic.update');

        Route::get('create', 'Controller@create')->name('topic.create');

        Route::post('create', 'Controller@store')->name('topic.store');

        Route::delete('{id}/destroy', 'Controller@destroy')->name('topic.destroy');
    });

    Route::group([
        'namespace' => 'Topic',
        'prefix' => 'topic-comment'
    ], function() {
        Route::post('create', 'CommentController@store')->name('topic.comment.store');

        Route::delete('{id}/delete', 'CommentController@destroy')->name('topic.comment.destroy');
    });
});

Route::group([
    'namespace' => 'App\Http\Controllers\Authentication',
    'middleware' => RedirectIfAuthenticated::class
], function() {
    Route::get('/login', 'LoginController@showForm')->name('login.form');

    Route::post('/login', 'LoginController@authenticate')->name('login');

    Route::get('/register', 'RegisterController@showForm')->name('register.form');

    Route::post('/register', 'RegisterController@register')->name('register');
});


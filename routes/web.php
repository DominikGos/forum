<?php

use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;



use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;



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


Route::get('/user/{id}', 'App\Http\Controllers\UserController@get')->name('user.get');

Route::group([
    'namespace' => 'App\Http\Controllers\Topic',
    'prefix' => 'topic'
], function() {
    Route::get('list', 'Controller@list')->name('home');

    Route::get('{id}', 'Controller@get')->name('topic.get');

    Route::get('search', 'Controller@search')->name('topic.search');
});

Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'auth'
], function() {
    Route::post('/logout', 'Authentication\LoginController@logout')->name('logout');

    Route::group([
        'prefix' => 'user',
        'as' => 'user.'
    ], function() {
        Route::get('{id}/edit', 'UserController@edit')->name('edit');

        Route::put('{id}/update', 'UserController@update')->name('update');

        Route::get('list', 'UserController@list')->name('list');
    });

    Route::group([
        'namespace' => 'Topic',
        'prefix' => 'topic',
        'as' => 'topic.'
    ], function() {
        Route::get('{id}/edit', 'Controller@edit')->name('edit');

        Route::put('{id}/update', 'Controller@update')->name('update');

        Route::get('create', 'Controller@create')->name('create');

        Route::post('create', 'Controller@store')->name('store');

        Route::delete('{id}/destroy', 'Controller@destroy')->name('destroy');
    });

    Route::group([
        'namespace' => 'Topic',
        'prefix' => 'topic-comment',
        'as' => 'topic.comment.'
    ], function() {
        Route::post('create', 'CommentController@store')->name('store');

        Route::delete('{id}/delete', 'CommentController@destroy')->name('destroy');
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

    Route::get('/forgot-password', 'ResetPasswordController@forgotPasswordForm')->name('password.request');

    Route::post('/forgot-password', 'ResetPasswordController@resetLink')->name('password.reset.link');

    Route::get('/reset-password/{token}', 'ResetPasswordController@resetPasswordForm')->name('password.reset.form');

    Route::post('/reset-password', 'ResetPasswordController@updatePassword')->name('password.reset');
});

Route::fallback(function() {
    return redirect()->route('home');
});

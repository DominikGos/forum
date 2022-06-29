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


Route::get('/user/{id}', 'App\Http\Controllers\UserController@get')->name('user.get');

Route::group([
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'topic'
], function() {
    Route::get('list', 'TopicController@list')->name('home');

    Route::get('{id}', 'TopicController@get')->name('topic.get');

    Route::get('search', 'TopicController@search')->name('topic.search');
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
        'prefix' => 'topic',
        'as' => 'topic.'
    ], function() {
        Route::get('{id}/edit', 'TopicController@edit')->name('edit');

        Route::put('{id}/update', 'TopicController@update')->name('update');

        Route::view('create', 'topic.create')->name('create');

        Route::post('create', 'TopicController@store')->name('store');

        Route::delete('{id}/destroy', 'TopicController@destroy')->name('destroy');
    });

    Route::group([
        'prefix' => 'topic-comment',
        'as' => 'topic.comment.'
    ], function() {
        Route::post('create', 'TopicCommentController@store')->name('store');

        Route::delete('{id}/delete', 'TopicCommentController@destroy')->name('destroy');
    });
});

Route::group([
    'namespace' => 'App\Http\Controllers\Authentication',
    'middleware' => RedirectIfAuthenticated::class
], function() {
    Route::view('/login', 'authentication.login')->name('login.form');

    Route::post('/login', 'LoginController@authenticate')->name('login');

    Route::view('/register', 'authentication.register')->name('register.form');

    Route::post('/register', 'RegisterController@register')->name('register');

    Route::view('/forgot-password', 'authentication.forgot-password')->name('forgot.pasword.form');

    Route::post('/forgot-password', 'ResetPasswordController@resetLink')->name('forgot.pasword');

    Route::get('/reset-password/{token}', 'ResetPasswordController@resetPasswordForm')->name('password.reset.form');

    Route::post('/reset-password', 'ResetPasswordController@updatePassword')->name('password.reset');
});

Route::fallback(function() {
    return redirect()->route('home');
});

<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', 'Auth\UserController@current');

    Route::get('genres', 'GenreController@index');
    Route::group(['prefix' => 'genre'], function () {
        Route::post('add', 'GenreController@add');
        Route::get('edit/{id}', 'GenreController@edit');
        Route::post('update/{id}', 'GenreController@update');
        Route::delete('delete/{id}', 'GenreController@delete');
    });

    Route::get('languages', 'LanguageController@index');
    Route::group(['prefix' => 'language'], function () {
        Route::post('add', 'LanguageController@add');
        Route::get('edit/{id}', 'LanguageController@edit');
        Route::post('update/{id}', 'LanguageController@update');
        Route::delete('delete/{id}', 'LanguageController@delete');
    });

    Route::get('movies', 'MoviesController@index');
    Route::group(['prefix' => 'movie'], function () {
        Route::post('add', 'MoviesController@add');
        Route::get('edit/{id}', 'MoviesController@edit');
        Route::post('update/{id}', 'MoviesController@update');
        Route::delete('delete/{id}', 'MoviesController@delete');
    });

    Route::get('subtitles', 'SubtitleController@index');
    Route::group(['prefix' => 'subtitle'], function () {
        Route::post('add', 'SubtitleController@add');
        Route::get('edit/{id}', 'SubtitleController@edit');
        Route::post('update/{id}', 'SubtitleController@update');
        Route::delete('delete/{id}', 'SubtitleController@delete');
    });

    Route::get('genre_movies/{id}', 'MoviesController@genre_movies');

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

});



Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});


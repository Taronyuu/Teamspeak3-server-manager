<?php

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('index');

    Route::resource('servers', 'ServerController');
    Route::group(['as' => 'servers.'], function () {
        Route::get('servers/{server}/players', 'ServerController@players')->name('players');
        Route::post('servers/{server}/players/{player}/message', 'ServerController@sendPlayerMessage')->name('players.message');
        Route::get('servers/{server}/start', 'ServerController@start')->name('start');
        Route::get('servers/{server}/restart', 'ServerController@restart')->name('restart');
        Route::get('servers/{server}/stop', 'ServerController@stop')->name('stop');
        Route::get('servers/{server}/reset', 'ServerController@resetToken')->name('reset_token');
        Route::get('servers/{server}/tokens', 'ServerController@showTokens')->name('show_tokens');
        Route::get('servers/{server}/token/{token}/delete', 'ServerController@deleteToken')->name('delete_token');
        Route::get('servers/{server}/configure', 'ServerController@showConfigure')->name('configure');
        Route::post('servers/{server}/configure', 'ServerController@postConfigure')->name('configure');
    });
});

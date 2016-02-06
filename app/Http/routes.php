<?php

Route::get('/', 'DashboardController@index');

Route::resource('/servers', 'ServerController');
Route::get('/servers/{id}/start', 'ServerController@start');
Route::get('/servers/{id}/restart', 'ServerController@restart');
Route::get('/servers/{id}/stop', 'ServerController@stop');
Route::get('/servers/{id}/reset', 'ServerController@resetToken');
Route::get('/servers/{id}/tokens', 'ServerController@showTokens');
Route::get('/servers/{id}/token/{token_id}/delete', 'ServerController@deleteToken');
Route::get('/servers/{id}/configure', 'ServerController@showConfigure');
Route::post('/servers/{id}/configure', 'ServerController@postConfigure');
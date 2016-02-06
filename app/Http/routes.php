<?php

Route::get('/', 'DashboardController@index');

Route::resource('/servers', 'ServerController');
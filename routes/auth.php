<?php

use Illuminate\Support\Facades\Route;

//Confirmación de contraseña
Route::get('/password/confirm', 'Auth\ConfirmPasswordController@show')->name('password.confirm');
Route::post('/password/confirm', 'Auth\ConfirmPasswordController@store');

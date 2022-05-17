<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', 'IndexController@index');
//API Index Fedex
Route::get('/fedex', 'FedexController@index');
//API Get Token
Route::get('/fedex/auth', 'FedexController@auth');
Route::post('/fedex/authKey', 'FedexController@postToken');
//API Validation Address
Route::get('/fedex/addresValidationForm', 'FedexController@addresValidation');
Route::post('/fedex/addresValidationRequest', 'FedexController@validationFedexRequest');
//API Find Location
Route::get('/fedex/findLocationForm', 'FedexController@findLocationForm');
Route::post('/fedex/findLocationRequest', 'FedexController@findLocationRequest');
//API Global Trade
Route::get('/fedex/globalTradeForm', 'FedexController@globalTradeForm');
Route::post('/fedex/globalTradeRequest', 'FedexController@globalTradeRequest');
//API Ground End Day 
Route::get('/fedex/GroundDayCloseForm', 'FedexController@GroundDayCloseForm');
Route::post('/fedex/GroundDayCloseRequest', 'FedexController@GroundDayCloseRequest');
Route::post('/fedex/ReprintDayCloseRequest', 'FedexController@reprintDayCloseRequest');
//API Open Ship
// Service Availability API
Route::get('/fedex/ServiceAvailabilityForm', 'FedexController@serviceAvailabilityForm');
Route::post('/fedex/ServiceAvailabilityRequest', 'FedexController@serviceAvailabilityRequest');


//Route::post('/test', 'TestController@index');

//Login
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Login de admin
Route::get('/admin', [AdminController::class, 'index'])->middleware('auth.admin')->name('admin.index');

//Logout
Route::get('/logout', [App\Http\Controllers\Auth\VerificationController::class, 'destroy'])
    ->name('login.destroy');

Route::get('/register', [AdminController::class, 'createNew'])->name('register');

Route::get('/fedex/registerUser', 'AdminController@createPerron');

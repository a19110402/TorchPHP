<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FedexController;

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
Route::get('/fedex/options', [FedexController::class, 'fedexOptions'])->name('fedexOptions');
Route::get('/fedex/openShip', 'FedexController@openShip');
Route::post('/fedex/openShip', 'FedexController@createOpenShipmentRequest');
Route::post('/fedex/confirmOpenShipment', 'FedexController@confirmOpenShipmentRequest');
Route::post('/fedex/addOpenShipmentPackages', 'FedexController@addOpenShipmentPackagesRequest');
Route::post('/fedex/retrieveOpenShipmentPackage', 'FedexController@retriveOpenShipmentPackagesRequest');
Route::post('/fedex/retrieveOpenShipment', 'FedexController@retriveOpenShipmentRequest');
Route::post('/fedex/getOpenShipment', 'FedexController@getOpenShipmentResultsRequest');
Route::put('/fedex/modifyOpenShip', 'FedexController@modifyOpenShipmentRequest');
Route::put('/fedex/modifyOpenShipPackage', 'FedexController@modifyOpenShipmentPackagesRequest');
// Route::post('/fedex/createOpenShipmentRequest', 'FedexController@createOpenShipmentRequest');
//API RATE AND TRANSIT TIMES
Route::get('/fedex/rateAndTransitTimes', [FedexController::class, 'rateAndTransitTimes'])->name('rateAndTransitTimes')->middleware('auth');
Route::post('/fedex/rateAndTransitTimes', [FedexController::class, 'rateAndTransitTimesRequest']);
//API SHIPMENTS
Route::get('/fedex/shipments', [FedexController::class, 'shipments'])->name('shipments') -> middleware('auth');
Route::post('/fedex/shipments', 'FedexController@shipmentsRequest');
// Service Availability API
Route::get('/fedex/ServiceAvailabilityForm', 'FedexController@serviceAvailabilityForm');
Route::post('/fedex/ServiceAvailabilityRequest', 'FedexController@serviceAvailabilityRequest');


//Route::post('/test', 'TestController@index');

//Login
Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Login de admin
Route::get('/admin', [AdminController::class, 'index'])->middleware('auth.admin')->name('admin.index');

//Logout
Route::get('/logout', [App\Http\Controllers\Auth\VerificationController::class, 'destroy'])
    ->name('login.destroy');

Route::get('/adminRegister', [AdminController::class, 'createNew'])->name('createNew');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/register', [AdminController::class, 'createNew'])->name('register');

Route::get('/fedex/registerUser', 'AdminController@createPerron');

Route::get('/nosotros', [IndexController::class, 'nosotros'])->name('nosotros');

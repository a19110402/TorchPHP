<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\FedexController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ConfirmPasswordController;

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


Route::get('/rateAndTransitTimes', 'mainController@getRateView');
Route::post('/rateAndTransitTimes', 'mainController@rate');



Route::get('/', 'IndexController@index');
//API Index Fedex
Route::get('/fedex', 'FedexController@index');
//API Get Token
// Route::get('/fedex/auth', 'FedexController@auth');
Route::post('/fedex/authKey', 'FedexController@postToken');
//API Validation Address
// Route::get('/fedex/addresValidationForm', 'FedexController@addresValidation');
Route::post('/fedex/addresValidationRequest', 'FedexController@validationFedexRequest');
//API Find Location
// Route::get('/fedex/findLocationForm', 'FedexController@findLocationForm');
Route::post('/fedex/findLocationRequest', 'FedexController@findLocationRequest');
//API Global Trade
// Route::get('/fedex/globalTradeForm', 'FedexController@globalTradeForm');
Route::post('/fedex/globalTradeRequest', 'FedexController@globalTradeRequest');
//API Ground End Day 
// Route::get('/fedex/GroundDayCloseForm', 'FedexController@GroundDayCloseForm');
Route::post('/fedex/GroundDayCloseRequest', 'FedexController@GroundDayCloseRequest');
Route::post('/fedex/ReprintDayCloseRequest', 'FedexController@reprintDayCloseRequest');
//API Open Ship
// Route::get('/fedex/options', [FedexController::class, 'fedexOptions'])->name('fedexOptions');
// Route::get('/fedex/openShip', 'FedexController@openShip');
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
Route::get('/fedex/rateAndTransitTimes', 'FedexController@rateAndTransitTimes')->name('rateAndTransitTimes')->middleware('auth');
Route::post('/fedex/rateAndTransitTimes', 'FedexController@rateAndTransitTimesRequest');
//API Postal Code Validation
Route::post('/validatePostalCode','FedexController@validatePostalCodeRequest')->name('validatePostalCodeRequest');
//API SHIPMENTS
Route::get('/fedex/shipments', [FedexController::class, 'shipments'])->name('shipments') -> middleware('auth');
Route::post('/fedex/shipments', 'FedexController@shipmentsRequest');
//TRACKING API
// Route::get('fedex/tracking', 'FedexController@tracking')->name('tracking');
// Route::get('fedex/tracking', 'FedexController@trackingRequest');
// Service Availability API
Route::get('/fedex/ServiceAvailabilityForm', 'FedexController@serviceAvailabilityForm');
Route::post('/fedex/ServiceAvailabilityRequest', 'FedexController@serviceAvailabilityRequest');



//Route::post('/test', 'TestController@index');

//Login
Auth::routes(); //Conjunto de rutas,  ya no funcionaba
// Auth Routes...
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LogoutController@destroy')->name('login.destroy');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::get('/register', 'Auth\RegisterController@createNew')->name('register');
Route::post('/register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Verificación de correo electrónico
Route::get('/email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify')->middleware(['signed']);
Route::post('/email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

//Homepage
Route::get('/home', 'HomeController@index')->middleware('verified')->name('home');
Route::get('/home/admin', 'AdminController@index')->middleware('auth.admin','verified')->name('admin.index');

//Cambio a cuenta corporativa
Route::get('/upgrade-account', 'Auth\UpgradeController@index')->middleware('verified')->name('corpAccount');
// Route::get('/upgrade-account/{id}', 'UpgradeController@edit')->name('editAccount');
Route::post('/upgrade-account', 'Auth\UpgradeController@upgrade')->name('upgradeAccount');

//Confirmación de contraseña
Route::get('/password/confirm', 'Auth\ConfirmPasswordController@show')->middleware('auth')->name('password.confirm');
Route::post('/password/confirm', 'Auth\ConfirmPasswordController@store')->middleware('auth');

//Creación de cuenta para usuario normal
Route::get('/create-account', 'Auth\CreateAccountController@show')->middleware('auth')->name('create.account');
Route::post('/create-account', 'Auth\CreateAccountController@store')->middleware('auth');
//Visualización de cuenta para usuario normal
Route::get('/accounts', 'Auth\CreateAccountController@watchAccount')->middleware('auth')->name('watch.account');
//Edición de cuenta para usuario normal
Route::get('/accounts/{id}', 'Auth\CreateAccountController@editAccount')->middleware('auth')->name('edit.account');
//Actualizar cuenta para usuario normal
Route::patch('/accounts/{id}', 'Auth\CreateAccountController@updateAccount')->middleware('auth')->name('update.account');
//Eliminar una cuenta para usuario normal
Route::delete('/accounts/{id}', 'Auth\CreateAccountController@deleteAccount')->middleware('auth')->name('delete.account');


//Creación de usuario para corporativos
Route::get('/registerUser', 'Auth\RegisterByUserController@userCreation')->middleware('auth.admin', 'password.confirm')->name('registerUser');
Route::post('/registerUser', 'Auth\RegisterByUserController@register')->middleware('auth.admin', 'password.confirm');
//Visualización de usuarios para corporativos
Route::get('/users','AdminController@watchUsers')->middleware('password.confirm', 'auth.admin')->name('users');
//Editar un usuario para corporativos
Route::get('/users/{id}', 'AdminController@editUser')->name('editUser');
//Actualizar usuario para corporativos
Route::patch('/users/{id}', 'AdminController@updateUser')->name('updateUser');
//Eliminar un usuario para corporativos
Route::delete('/users/{id}', 'AdminController@deleteUser')->name('deleteUser');


//Página nosotros
Route::get('/nosotros', 'IndexController@nosotros')->name('nosotros');

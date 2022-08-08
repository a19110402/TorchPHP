<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Auth;
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
// Auth::routes(); //Conjunto de rutas,  ya no funcionaba
// Auth Routes...
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LogoutController@destroy')->name('login.destroy');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::get('/register', 'Auth\RegisterController@createNew')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

//Homepage
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/admin', 'AdminController@index')->middleware('auth.admin')->name('admin.index');

//Creación de usuario estando loggeado
Route::get('/registerUser', 'Auth\RegisterByUserController@userCreation')->name('registerUser');
Route::post('registerUser', 'Auth\RegisterByUserController@register');

//Visualización de usuarios creados
Route::get('/users','AdminController@watchUsers')->name('users');

//Editar un usuario
Route::get('/users/{id}', 'AdminController@editUser')->name('editUser');
Route::patch('/users/{id}', 'AdminController@updateUser')->name('updateUser');

//Eliminar un usuario
Route::delete('/users/{id}', 'AdminController@deleteUser')->name('deleteUser');

//Página nosotros
Route::get('/nosotros', 'IndexController@nosotros')->name('nosotros');


Route::get('/adminlte', function(){
    return view('adminlte'); 
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
/* Route::middleware(['auth:sanctum', 'verified'])->group(function(){     */
    Route::resource('products', ProductController::class);
    Route::get('/dashboard', function(){
        return view('dashboard');
    })->name('dashboard');
/* }); */

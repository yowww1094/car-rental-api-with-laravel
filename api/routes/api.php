<?php

use Illuminate\Http\Request;
use App\Models\VehicleManufacturer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\VehicleMileagesController;
use App\Http\Controllers\VehicleInsurancesController;
use App\Http\Controllers\VehicleMaintenancesController;
use App\Http\Controllers\VehicleManifacturersController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);

Route::post('/add_user', [AuthController::class, 'add_user']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('manufacturers', [VehicleManifacturersController::class, 'index']);

    // customers resources
    Route::resource('customers', CustomersController::class);

    // vehicle resources
    Route::resource('vehicles', VehiclesController::class);

    
    Route::resource('vehicles.insurances', VehicleInsurancesController::class)->except('index');
    Route::get('insurances', [VehicleInsurancesController::class, 'index']);

    Route::resource('vehicles.maintenances', VehicleMaintenancesController::class)->except('index');
    Route::get('maintenances', [VehicleMaintenancesController::class, 'index']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
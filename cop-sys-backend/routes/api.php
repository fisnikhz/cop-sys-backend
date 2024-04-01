<?php

use App\Http\Controllers\API\V1\EquipmentsController;
use App\Http\Controllers\API\V1\PersonnelController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\VehiclesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function (){


    //Personnel API
    Route::post('/addPersonnel', [PersonnelController::class, 'addPersonnel']);
    Route::put('/updatePersonnel', [PersonnelController::class, 'updatePersonnel']);
    Route::delete('/removePersonnel', [PersonnelController::class, 'removePersonnel']);


    //Equipments API
    Route::post('/addEquipment', [EquipmentsController::class, 'addEquipment']);
    Route::put('/updateEquipment', [EquipmentsController::class, 'updateEquipment']);
    Route::delete('/removeEquipment', [EquipmentsController::class, 'removeEquipment']);

    //Vehicles API
    Route::post('/addVehicle', [VehiclesController::class, 'addVehicle']);
    Route::put('/updateVehicle', [VehiclesController::class, 'updateVehicle']);
    Route::delete('/removeVehicle', [VehiclesController::class, 'removeVehicle']);

    Route::post('/addNewUser', [UserController::class, 'addUser']);

})->prefix('v1');

Route::post('/addUser', [UserController::class, 'addUser'])->prefix('v1');

Route::post('/login', [UserController::class, 'login'])->prefix('v1');


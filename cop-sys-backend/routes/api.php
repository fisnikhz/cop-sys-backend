<?php

use App\Http\Controllers\API\V1\EquipmentsController;
use App\Http\Controllers\API\V1\PersonnelController;
use App\Http\Controllers\API\V1\UserController;

use App\Http\Controllers\API\V1\DepartmentsController;
use App\Http\Controllers\API\V1\VehiclesController;
use App\Http\Controllers\API\V1\EmergencyCallController;

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

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => '/v1/', 'as' => 'api.'], function () {


    //Personnel API
    Route::post('/addPersonnel', [PersonnelController::class, 'addPersonnel']);
    Route::put('/updatePersonnel/{personnel}', [PersonnelController::class, 'updatePersonnel']);
    Route::delete('/removePersonnel/{personnel}', [PersonnelController::class, 'removePersonnel']);
    Route::get('/getPersonnel/{personnel}', [PersonnelController::class, 'getPersonnel']);
    Route::get('/getAllPersonnel', [PersonnelController::class, 'getAllPersonnel']);


    //Equipments API
    Route::post('/addEquipment', [EquipmentsController::class, 'addEquipment']);
    Route::put('/updateEquipment', [EquipmentsController::class, 'updateEquipment']);
    Route::delete('/removeEquipment', [EquipmentsController::class, 'removeEquipment']);
    Route::get('/getEquipment', [EquipmentsController::class, 'getEquipment']);
    Route::get('/getAllEquipment', [EquipmentsController::class, 'getAllEquipment']);

    //Departments API
    Route::post('/addDepartment', [DepartmentsController::class, 'addDepartment']);
    Route::put('/updateDepartment', [DepartmentsController::class, 'updateDepartment']);
    Route::delete('/removeDepartment', [DepartmentsController::class, 'removeDepartment']);
    Route::get('/getDepartment', [DepartmentsController::class, 'getDepartment']);
    Route::get('/getAllDepartments', [DepartmentsController::class, 'getAllDepartments']);


    //Vehicles API
    Route::post('/addVehicle', [VehiclesController::class, 'addVehicle']);
    Route::put('/updateVehicle', [VehiclesController::class, 'updateVehicle']);
    Route::delete('/removeVehicle', [VehiclesController::class, 'removeVehicle']);
    Route::get('/getVehicle',[VehiclesController::class, 'getVehicle']);
    Route::get('.getAllVehicles',[VehiclesController::class, 'getAllVehicles']);

    //EmergencyCall API
    Route::post('/addEmergencyCall', [EmergencyCallController::class, 'addEmergencyCall']);
    Route::put('/updateEmergencyCall', [EmergencyCallController::class, 'updateEmergencyCall']);
    Route::delete('/removeEmergencyCall', [EmergencyCallController::class, 'removeEmergencyCall']);
    Route::get('/getEmergencyCall',[EmergencyCallController::class, 'getEmergencyCall']);
    Route::get('.getAllEmergencyCalls',[EmergencyCallController::class, 'getAllEmergencyCalls']);


    Route::post('/addNewUser', [UserController::class, 'addUser']);



});

Route::group(['prefix' => '/v1/', 'as' => 'api.'], function () {

    Route::post('/register', [UserController::class, 'register']);

    Route::post('/login', [UserController::class, 'login']);

});


//Route::post('/login', [UserController::class, 'login'])->prefix('v1');

<?php

use App\Http\Controllers\API\V1\EquipmentsController;
use App\Http\Controllers\API\V1\PersonnelController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\CasesController;
use App\Http\Controllers\API\V1\DepartmentsController;
use App\Http\Controllers\API\V1\VehiclesController;
use App\Http\Controllers\API\V1\EmergencyCallController;
use App\Http\Controllers\API\V1\LocationController;

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
    Route::put('/updateEquipment/{equipment}', [EquipmentsController::class, 'updateEquipment']);
    Route::delete('/removeEquipment/{equipment}', [EquipmentsController::class, 'removeEquipment']);
    Route::get('/getEquipment/{equipment}', [EquipmentsController::class, 'getEquipment']);
    Route::get('/getAllEquipment', [EquipmentsController::class, 'getAllEquipment']);

    //Departments API
    Route::post('/addDepartment', [DepartmentsController::class, 'addDepartment']);
    Route::put('/updateDepartment/{department}', [DepartmentsController::class, 'updateDepartment']);
    Route::delete('/removeDepartment/{department}', [DepartmentsController::class, 'removeDepartment']);
    Route::get('/getDepartment/{department}', [DepartmentsController::class, 'getDepartment']);
    Route::get('/getAllDepartments', [DepartmentsController::class, 'getAllDepartments']);


    //Vehicles API
    Route::post('/addVehicle', [VehiclesController::class, 'addVehicle']);
    Route::put('/updateVehicle/{vehicle}', [VehiclesController::class, 'updateVehicle']);
    Route::delete('/removeVehicle{vehicle}', [VehiclesController::class, 'removeVehicle']);
    Route::get('/getVehicle/{vehicle}',[VehiclesController::class, 'getVehicle']);
    Route::get('/getAllVehicles',[VehiclesController::class, 'getAllVehicles']);


    //EmergencyCall API
    Route::post('/addEmergencyCall', [EmergencyCallController::class, 'addEmergencyCall']);
    Route::put('/updateEmergencyCall/{emergencyCall}', [EmergencyCallController::class, 'updateEmergencyCall']);
    Route::delete('/removeEmergencyCall/{emergencyCall}', [EmergencyCallController::class, 'removeEmergencyCall']);
    Route::get('/getEmergencyCall/{emergencyCall}',[EmergencyCallController::class, 'getEmergencyCall']);
    Route::get('/getAllEmergencyCalls',[EmergencyCallController::class, 'getAllEmergencyCalls']);


    //Location API
    Route::post('/addLocation', [LocationController::class, 'addLocation']);
    Route::put('/updateLocation', [LocationController::class, 'updateLocation']);
    Route::delete('/removeLocation', [LocationController::class, 'removeLocation']);
    Route::get('/getLocation',[LocationController::class, 'getLocation']);
    Route::get('/getAllLocations',[LocationController::class, 'getAllLocation']);


    //Cases API
    Route::post('/addCase', [CasesController::class, 'addCase']);
    Route::put('/updateCase/{case}', [CasesController::class, 'updateCase']);
    Route::delete('/removeCase/{case}', [CasesController::class, 'removeCase']);
    Route::get('/getCase/{case}',[CasesController::class, 'getCase']);
    Route::get('/getAllCases',[CasesController::class, 'getAllCases']);

    //User API
    Route::post('/addNewUser', [UserController::class, 'addUser']);
    Route::get('/getUserProfile/{user}', [UserController::class, 'getUserProfile']);
    Route::post('/changePassword', [UserController::class, 'changePassword']);



});

Route::group(['prefix' => '/v1/', 'as' => 'api.'], function () {

    Route::post('/register', [UserController::class, 'register']);

    Route::post('/login', [UserController::class, 'login']);

});


//Route::post('/login', [UserController::class, 'login'])->prefix('v1');

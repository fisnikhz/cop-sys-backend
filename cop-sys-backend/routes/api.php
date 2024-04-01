<?php

use App\Http\Controllers\EquipmentsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonnelController;

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


    // Equipments API
    Route::post('/addEquipment', [EquipmentsController::class, 'addEquipment']);


    Route::post('/addNewUser', [UserController::class, 'addUser']);



});

Route::post('/addUser', [UserController::class, 'addUser']);

Route::post('/login', [UserController::class, 'login']);


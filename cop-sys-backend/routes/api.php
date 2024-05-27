<?php

use App\Http\Controllers\API\V1\CampaignController;
use App\Http\Controllers\API\V1\ConversationController;
use App\Http\Controllers\API\V1\EquipmentsController;
use App\Http\Controllers\API\V1\MessageController;
use App\Http\Controllers\API\V1\NewsController;
use App\Http\Controllers\API\V1\IncidentsController;
use App\Http\Controllers\API\V1\PersonnelController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\CasesController;
use App\Http\Controllers\API\V1\DepartmentsController;
use App\Http\Controllers\API\V1\VehiclesController;
use App\Http\Controllers\API\V1\EmergencyCallController;
use App\Http\Controllers\API\V1\LocationController;
use App\Http\Controllers\API\V1\AttendanceController;
use App\Http\Controllers\API\V1\RolesController;
use App\Http\Controllers\API\V1\TicketsController;
use App\Http\Controllers\API\V1\PersonController;
use App\Http\Controllers\API\V1\DepartmentPersonnelController;


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


    //Attendance API
    Route::post('/addAttendance', [AttendanceController::class, 'addAttendance']);
    Route::put('/updateAttendance/{attendance}', [AttendanceController::class, 'updateAttendance']);
    Route::delete('/removeAttendance/{attendance}', [AttendanceController::class, 'removeAttendance']);
    Route::get('/getAttendance/{attendance}',[AttendanceController::class, 'getAttendance']);
    Route::get('.getAllAttendances',[AttendanceController::class, 'getAllAttendances']);


    //Cases API
    Route::post('/addCase', [CasesController::class, 'addCase']);
    Route::put('/updateCase/{case}', [CasesController::class, 'updateCase']);
    Route::delete('/removeCase/{case}', [CasesController::class, 'removeCase']);
    Route::get('/getCase/{case}',[CasesController::class, 'getCase']);
    Route::get('/getAllCases',[CasesController::class, 'getAllCases']);



    //Incidents API
    Route::post('/addIncident', [IncidentsController::class, 'addIncident']);
    Route::put('/updateIncident/{incident}', [IncidentsController::class, 'updateIncident']);
    Route::delete('/removeIncident/{incident}', [IncidentsController::class, 'removeIncident']);
    Route::get('/getIncident/{incident}',[IncidentsController::class, 'getIncident']);
    Route::get('/getAllIncidents',[IncidentsController::class, 'getAllIncidents']);


    //News API
    Route::post('news', [NewsController::class, 'addNews'])->name('news.add');
    Route::put('news/{news}', [NewsController::class, 'updateNews'])->name('news.update');
    Route::delete('news/{news}', [NewsController::class, 'removeNews'])->name('news.remove');

    //User API
    Route::post('/addNewUser', [UserController::class, 'addUser']);
    Route::get('/getUserProfile/{user}', [UserController::class, 'getUserProfile']);
    Route::post('/changePassword', [UserController::class, 'changePassword']);


    //Roles API
    Route::post('/addRole', [RolesController::class, 'addRole']);
    Route::put('/updateRole/{role}', [RolesController::class, 'updateRole']);
    Route::delete('/removeRole/{role}', [RolesController::class, 'removeRole']);
    Route::get('/getRole/{role}',[RolesController::class, 'getRole']);
    Route::get('/getAllRoles',[RolesController::class, 'getAllRoles']);


    //Campaign API
    Route::post('/addCampaigns', [CampaignController::class, 'addCampaign']);
    Route::put('campaigns/{campaign}', [CampaignController::class, 'updateCampaign']);
    Route::delete('campaigns/{campaign}', [CampaignController::class, 'removeCampaign']);
    Route::get('campaigns/{campaign}', [CampaignController::class, 'viewCampaign']);


    //Conversation API

    Route::get('/conversations/admin', [ConversationController::class, 'getAdminConversation']);
    Route::get('/conversations/{conversation}/messages', [MessageController::class, 'index']);
    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store']);


    //Tickets API
    Route::post('/addTicket', [TicketsController::class, 'addTicket']);
    Route::put('/updateTicket/{ticket}', [TicketsController::class, 'updateTicket']);
    Route::delete('/removeTicket/{ticket}', [TicketsController::class, 'removeTicket']);
    Route::get('/getTicket/{ticket}',[TicketsController::class, 'getTicket']);
    Route::get('/getAllTickets',[TicketsController::class, 'getAllTickets']);


    //Person API
    Route::post('/addPerson', [PersonController::class, 'addPerson']);
    Route::put('/updatePerson/{person}', [PersonController::class, 'updatePerson']);
    Route::delete('/removePerson/{person}', [PersonController::class, 'removePerson']);
    Route::get('/getPerson/{person}',[PersonController::class, 'getPerson']);
    Route::get('/getAllPersons',[PersonController::class, 'getAllPersons']);


    //DepartmentPersonnel API
    Route::get('departments/{department_id}/personnel', [DepartmentPersonnelController::class, 'getPersonnelByDepartment']);
    Route::get('personnel/{personnel_id}/departments', [DepartmentPersonnelController::class, 'getDepartmentByPersonnel']);

    //IncidentsReporter API
    Route::get('/incidents/{personnel_id}/reporters', [IncidentsController::class, 'getIncidentsByReporter']);

    //CasesReporter API
    Route::get('/cases/{personnel_id}/investigators', [CasesController::class, 'getCasesByInvestigator']);
    Route::get('departments/{department_id}/personnels', [DepartmentPersonnelController::class, 'getPersonnelsByDepartment']);
    Route::get('personnels/{personnel_id}/departments', [DepartmentPersonnelController::class, 'getDepartmentsByPersonnel']);

    //TicketsPersonnel API
    Route::get('/personnels/{personnel_id}/tickets', [TicketsController::class, 'getTicketsByPersonnel']);

});

Route::group(['prefix' => '/v1/', 'as' => 'api.'], function () {

    Route::post('/register', [UserController::class, 'register']);

    Route::post('/login', [UserController::class, 'login']);

    Route::get('/getNews', [NewsController::class, 'allNews'])->name('news.all');
    Route::get('/topViewedNews', [NewsController::class, 'getTopViewedNews']);
    Route::get('news/{news}', [NewsController::class, 'viewNews'])->name('news.view');
    Route::get('/getCampaigns', [CampaignController::class, 'allCampaigns']);
    Route::post('/addPersonnel', [PersonnelController::class, 'addPersonnel']);

});


//Route::post('/login', [UserController::class, 'login'])->prefix('v1');

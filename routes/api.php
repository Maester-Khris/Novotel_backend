<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) { return $request->user(); });
Route::Post('/testapi','App\Http\Controllers\Testcontroller@test2');


// ================ Manager New ================
Route::post('/company/new', 'App\Http\Controllers\ManagerController@newCompany');

// ================ Manager Start ================
Route::post('/company/{companyid}/getinfos', 'App\Http\Controllers\ManagerController@getCompanyInfos');
Route::post('/company/{companyid}/getreceptionist', 'App\Http\Controllers\ManagerController@getCompanyReceptionists');
Route::post('/company/{companyid}/getclient', 'App\Http\Controllers\ManagerController@getCompanyClients');
Route::post('/company/{companyid}/getvisit', 'App\Http\Controllers\ManagerController@getCompanyVisits');
Route::post('/company/{companyid}/addresource', 'App\Http\Controllers\ManagerController@addResource');
Route::post('/company/{companyid}/addreceptionist', 'App\Http\Controllers\ManagerController@addReceptionist');

Route::post('/company/resources-stats/{companyuuid}', 'App\Http\Controllers\ManagerController@getCompanyResourceInfo');


// =============== Reception Route ===========================
Route::get('/client/all', 'App\Http\Controllers\ReceptionController@allClient');
Route::post('/client/new', 'App\Http\Controllers\ReceptionController@newClient');
Route::post('/company/{companyid}/addvisit', 'App\Http\Controllers\ReceptionController@addVisit');
Route::post('/company/{companyuuid}', 'App\Http\Controllers\ManagerController@getCompany');
Route::post('/company/limited/{companyuuid}', 'App\Http\Controllers\ManagerController@getCompanyLimited');
Route::post('/company/{companyuuid}/getresources', 'App\Http\Controllers\ReceptionController@getResources');
Route::post('/company/{companyuuid}/getvisits', 'App\Http\Controllers\ReceptionController@getVisits');
Route::post('/company/{companyuuid}/getemployees', 'App\Http\Controllers\ManagerController@getEmployees');

// ============== Others Route =============================
Route::get('/country/all', 'App\Http\Controllers\UtilityController@getAllCountry');
Route::get('/localisation/all', 'App\Http\Controllers\UtilityController@getAllPlaces');
Route::post('/getEmployee','App\Http\Controllers\UtilityController@getEmployeeByName');
Route::post('/tech-support/message','App\Http\Controllers\UtilityController@newMessage');
Route::post('/company/user/{useruuid}/messages', 'App\Http\Controllers\ManagerController@getUserMessage');

// =============== DB Sync Routes =============================
Route::post('/sync/entity','App\Http\Controllers\SyncDataController@syncData');
Route::post('/sync/getEntity','App\Http\Controllers\SyncDataController@getDataForEmployee');
Route::get('/admin/data','App\Http\Controllers\SyncDataController@getDataForAdmin');
Route::get('/admin/stats','App\Http\Controllers\SyncDataController@getStatsForAdmin');
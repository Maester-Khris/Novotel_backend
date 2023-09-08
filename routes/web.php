<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\Http\Controllers\Dashboardcontroller@alldataUpdateSynceLastSync');
Route::get('/home-chart', 'App\Http\Controllers\Dashboardcontroller@getChartSatistic');
Route::get('/company-profile/{company_name}', 'App\Http\Controllers\Dashboardcontroller@companyInfos');
Route::get('/localisation', 'App\Http\Controllers\Dashboardcontroller@locationsWithInfos');
Route::get('/infos-updates/{commune}', 'App\Http\Controllers\Dashboardcontroller@communeInfos');

Route::post('/seach-autocomplete','App\Http\Controllers\Dashboardcontroller@autoComplete');
Route::get('/scrapping','App\Http\Controllers\Testcontroller@scrapper');
Route::get('/test','App\Http\Controllers\UtilityController@getplaceByCommune');
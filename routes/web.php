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

Route::get('/', 'App\Http\Controllers\DashboardController@alldataUpdateSynceLastSync');
Route::get('/home-chart', 'App\Http\Controllers\DashboardController@getChartSatistic');
Route::get('/company-profile/{company_name}', 'App\Http\Controllers\DashboardController@companyInfos');
Route::get('/localisation', 'App\Http\Controllers\DashboardController@locationsWithInfos');
Route::get('/infos-updates/{commune}', 'App\Http\Controllers\DashboardController@communeInfos');

Route::post('/seach-autocomplete','App\Http\Controllers\DashboardController@autoComplete');
Route::get('/scrapping','App\Http\Controllers\Testcontroller@scrapper');
Route::get('/test','App\Http\Controllers\UtilityController@getplaceByCommune');
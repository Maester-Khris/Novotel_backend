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

// Login route
Route::get('/', 'App\Http\Controllers\AuthController@welcome')->name('login');
Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::get('/logout', 'App\Http\Controllers\AuthController@logout');

// Dashboard route
Route::middleware('auth')->group(function(){
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@alldataUpdateSynceLastSync');
    Route::get('/home-chart', 'App\Http\Controllers\DashboardController@getChartSatistic');
    Route::get('/company-profile/{company_name}', 'App\Http\Controllers\DashboardController@companyInfos');
    Route::get('/localisation', 'App\Http\Controllers\DashboardController@locationsWithInfos');
    Route::get('/infos-updates/{commune}', 'App\Http\Controllers\DashboardController@communeInfos');
    Route::post('/suggestCompanies','App\Http\Controllers\DashboardController@companiesLike');
    Route::get('/logout', 'App\Http\Controllers\AuthController@logout');
});

Route::get('/scrapping','App\Http\Controllers\Testcontroller@scrapper');
// Route::get('/test/{companyid}','App\Http\Controllers\ReceptionController@getResources');
Route::get('/test/date','App\Http\Controllers\Testcontroller@get_datetime');
Route::get('/test/query','App\Http\Controllers\Testcontroller@other');
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use \stdClass;


class UtilityController extends Controller
{
    public function getAllCountry(){
        $countries = DB::table('country')->get();
        return response()->json($countries, 200);
    }
    public function getAllPlaces(){
        $places =DB::table('locations')->get();
        return response()->json($places, 200);
    }
    public function getplaceByCommune(){
        $places =DB::table('locations')
        ->whereJsonContains('place', ["commune"=>"Akoeman"])
        ->get();
        dd($places);
    }
}
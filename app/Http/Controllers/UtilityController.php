<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\User;
use App\Models\Chat;
use \stdClass;


class UtilityController extends Controller
{
    public function getAllCountry(){
        $countries = DB::table('countries')->get();
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
    public function getEmployeeByName(Request $request){
        $empl = User::where('full_name',$request->emp_name)->first();
        if(!$empl){
            return response()->json("No user found");
        }
        return response()->json($empl, 200);
    }
    public function newMessage(Request $request){
        $admin = User::find(1);
        $chat = Chat::create([
            'message'=>$request->message,
            'sender_uuid'=>$request->sender_uuid,
            'receiver_uuid'=>$admin->uuid
        ]);
        return response()->json($chat, 200);
    }
}
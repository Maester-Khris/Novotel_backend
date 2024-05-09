<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Company;
use App\Models\Resource;
use App\Models\Visit;
use App\Models\Client;
use App\Models\Chat;
use Hash;


class ManagerController extends Controller
{
    /**
     * Add new
     * Note: dont forget to hash passwordds at the end
     * newCompany: Create a new Company and add it data resource, employee
    */
    public function newCompany(Request $request){
        // return response()->json("hello", 200);
        $comp = $request[0];
        $mana = $request[1];  
        $res = $request[2];  
        $company = new Company;
        $company = $company->create($comp);
        $manager = $company->users()->create($mana);
        $resources = $company->resources()->createMany($res);
        $clients = Client::all();
        return response()->json(["comp"=>$company, "mana"=>$manager, "res"=>$resources, "clts"=>$clients], 200);
    }
    public function addResource(Request $request, $companyid){
        $company = Company::find($companyid);
        foreach($request[0] as $data){
            $data['uuid'] = Str::uuid();
            $company->resources()->create($data);
        }
        return response()->json(['confirm_message'=>"Successfull registration"], 200);
    }
    public function addReceptionist(Request $request, $companyid){
        $company = Company::find($companyid);
        foreach($request[0] as $data){
            $data['uuid'] = Str::uuid();
            $data['password'] = "456"; 
            $company->users()->create($data);
        }
        return response()->json(['confirm_message'=>"Successfull registration"], 200);
    }

    public function getUserMessage($useruuid){
        $messages = Chat::where('sender_uuid',$useruuid)
            ->orWhere('receiver_uuid',$useruuid)->get();
        return response()->json($messages, 200);
    }
    public function getCompany($companyuuid){
        $company = Company::where('uuid',$companyuuid)->first();
        return response()->json($company, 200);
    }
    public function getCompanyLimited($companyuuid){
        $company = Company::where('uuid',$companyuuid)->first();
        return response()->json([$company->uuid,$company->comp_name], 200);
    }
    public function getEmployees($companyuuid){
        $company = Company::where('uuid',$companyuuid)->first();
        $employees = $company->users;
        return response()->json($employees, 200);
    }
}
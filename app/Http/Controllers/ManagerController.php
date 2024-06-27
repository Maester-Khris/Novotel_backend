<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Company;
use App\Models\Commodity;
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
     * process have changed: now the resource created at hotel creation are only used for stats purpose
    */
    public function newCompany(Request $request){
        $comp = $request[0];
        $mana = $request[1];  
        $resources = $request[2];  

        $company = new Company;
        $company = $company->create($comp);
        $manager = $company->users()->create($mana);
        $bdcont = 0;
        $rmcont = 0;
        $apcont = 0;
        foreach($resources as $res){
            if($res["is_room"]==true){
                $rmcont++;
            }elseif($res["is_appartment"]==true){
                $apcont++;
            }else{
                $bdcont++;
            }
        }
        $utilities = Commodity::create([
            "rooms" => $rmcont,
            "apparts" => $apcont,
            "beds" => $bdcont
        ]);

        $company->commodities()->save($utilities);
        $clients = Client::all();
        return response()->json(["comp"=>$company, "mana"=>$manager, "clts"=>$clients, "stats"=>$utilities], 200);
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
    public function getCompanyResourceInfo($companyuuid){
        $company = Company::where('uuid',$companyuuid)->first();
        return response()->json($company->commodities, 200);
    }
}
// ================================================
// $resources = $company->resources()->createMany($res);
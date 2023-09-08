<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Company;
use App\Models\Resource;
use App\Models\Visit;
use App\Models\Client;
use Hash;


class ManagerController extends Controller
{
    /**
     * Add new
     * Note: dont forget to hash passwordds at the end
     * newCompany: Create a new Company and add it data resource, employee
    */
    public function newCompany(Request $request){
        $comp = $request[0];
        $comp['uuid'] = Str::uuid();
        $mana = $request[1];
        $mana['uuid'] = Str::uuid();
        $mana['password'] = "123"; 
        $company = new Company;
        $company = $company->create($comp);
        $manager = $company->users()->create($mana);
        return response()->json(["comp"=>$company, "mana"=>$manager], 200);
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

    /**
     * Get data related to a company
     * getCompanyInfos: return nbbed,appart,room,manager_name,telephone,company_name,standing,place,telephone
    */
    public function getCompanyInfos($companyid){

    }
    public function getCompanyReceptionists($companyid){

    }
    public function getCompanyResources($companyid){

    }
    public function getCompanyClients($companyid){

    }
    public function getCompanyVisits($companyid){

    }
}
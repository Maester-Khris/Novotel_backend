<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Company;
use App\Models\Resource;
use App\Models\Visit;
use App\Models\Client;

class ReceptionController extends Controller
{
    /**
     * Function to add more data
    */
    public function newClient(Request $request){
        $data = $request->all();
        $data['uuid'] = Str::uuid();
        $client = new Client;
        $client = $client->create($data);
        return response()->json(['confirm_message'=>"Successfull registration"], 200);
    }
    public function addVisit(Request $request, $companyid){
        $data = $request->all();
        $data['uuid'] = Str::uuid();
        $data['visit_start_date'] = Carbon::parse($data['visit_start_date']); 
        $company = Company::find($companyid);
        $client = Client::find($data['client_id']);
        $resource = Resource::find($data['resource_id']);
        $visit = new Visit;
        $visit = $visit->create($data);
        $company->visits()->save($visit);
        $client->visits()->save($visit);
        $resource->visit()->save($visit);
        $resource->resource_availability = false;
        $resource->save();
        return response()->json(['confirm_message'=>"Successfull registration"], 200);
    }

    /**
     * Function to retrieve data
    */
    public function allClient(){
        $clients =  Client::all();
        return response()->json($clients, 200);
    }
    public function getResources($companyuuid){
        $company = Company::where('uuid',$companyuuid)->first();
        $resources = $company->resources;
        return response()->json($resources, 200);
    }
    public function getVisits($companyuuid){
        $company = Company::where('uuid',$companyuuid)->first();
        $visits = $company->visits;
        return response()->json($visits, 200);
    }
    
}

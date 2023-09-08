<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visit;
use App\Models\Client;
use App\Models\Company;
use App\Models\Resource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;

class SyncDataController extends Controller
{
    public function syncData(Request $request){
        // can add a check for existing uuid before saving(new)
        switch ($request->name) {
            case 'company':
                Company::create($request->data);
                break;
            case 'clients':
                foreach($request->data as $entity){
                    Client::create($entity);
                }
                break;
            case 'resources':
                $comp = Company::where('uuid',$request->data[0]["company_uuid"])->first();
                foreach ($request->data as $entity) {
                    $res = Resource::create($entity);
                    $comp->resources()->save($res);
                }
                break;
            case 'employees':
                $comp = Company::where('uuid',$request->data[0]["company_uuid"])->first();
                foreach ($request->data as $entity) {
                    $emp = User::create($entity);
                    $comp->users()->save($emp);
                }
                break;
            case 'visits':
                $comp = Company::where('uuid',$request->data[0]["company_uuid"])->first();
                $newvisits = [];
                foreach($request->data as $entity){
                    $dat_st = new DateTime($entity['visit_start_date']);
                    $entity['visit_start_date'] = $dat_st->format('Y-m-d H:i:s');
                    if($entity['visit_end_date'] != null){
                        $dat_en = new DateTime($entity['visit_end_date']);
                        $entity['visit_end_date'] = $dat_en->format('Y-m-d H:i:s');
                    }
                    $visit = Visit::create($entity);
                    array_push($newvisits, $visit);
                    $clt = Client::where('uuid',$entity['client_uuid'])->first();
                    $clt->visits()->save($visit);
                    $res = Resource::where('uuid',$entity['resource_uuid'])->first();
                    $res->resource_availability = false;
                    $res->save();
                    $res->visit()->save($visit);
                }
                $comp->visits()->saveMany($newvisits);
                break;
            default:
                "nothing to-do";
                break;
        }
        return response()->json('received', 200);
    }

}

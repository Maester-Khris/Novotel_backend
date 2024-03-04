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
                    $existing_model = Visit::where('uuid',$entity['uuid'])->first();
                    if($existing_model != null){
                        $existing_model->visit_end_date = Carbon::parse($entity['visit_end_date'])->format('Y-m-d H:i:s');
                        $existing_model->save();
                    }else{
                        $entity['visit_start_date'] = Carbon::parse($entity['visit_start_date'])->format('Y-m-d H:i:s');
                        if($entity['visit_end_date'] != null){
                            $entity['visit_end_date'] = Carbon::parse($entity['visit_end_date'])->format('Y-m-d H:i:s');;
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
                }
                $comp->visits()->saveMany($newvisits);
                break;
            default:
                "nothing to-do";
                break;
        }
        return response()->json('received', 200);
    }
    public function getDataForEmployee(Request $request){
        $last_local_sync = Carbon::parse($request->lastsync)->format('Y-m-d H:i:s');
        $now = Carbon::now()->format('Y-m-d H:i:s');

        $clts = Client::whereBetween('created_at',[$last_local_sync, $now])->get();
        $res = Resource::whereBetween('created_at',[$last_local_sync, $now])
            ->orWhereBetween('updated_at',[$last_local_sync, $now])
            ->get();
        $vsts = Visit::whereBetween('created_at',[$last_local_sync, $now])
            ->orWhereBetween('updated_at',[$last_local_sync, $now])
            ->get();
        return response()->json([$clts, $vsts, $res], 200);
        // return response()->json([$clts, $vsts], 200);
        // $clt = Client::find(3);
        // return response()->json([$now, $last_local_sync], 200);
    }
    public function updateSyncDate(Request $request){
        DB::table('DBsync')
        ->where('id',1)
        ->update(['last_sync_date'=>$request->syncdate]);
        return response()->json('ok', 200);
    }

}

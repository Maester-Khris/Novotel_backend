<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Visit;
use App\Models\User;
use App\Models\Client;
use App\Models\Resource;

class DashboardController extends Controller
{
    /** Method with correponding pages
     * locationsWithInfos - view localisation 
     * communeInfos - view info update (after we have clicked on a particular location)
     * companyinfo - view company profile
     * Home dashboard
     * searchbar autocomplete
    */
    public function locationsWithInfos(Request $request){
        $places =DB::table('locations')->get();
        $allplaces = $places->map(function($item){
            $arr = json_decode($item->place);
            $arr->companies = Company::where("comp_location_id",$item->id)->count();
            return $arr;
        });
        $groupedbyregion = collect($allplaces)->groupBy('region')->sortBy(function($value, $key) {
            return $key;
        });
        $regions = $groupedbyregion->keys();
        return view('localisation')->with(compact('regions'))->with(compact('groupedbyregion'));
    }

    /**
     * 2 types of information:
     * commune statis sync last sync: nb visit, nb client
     * commune overall data: visit with company and client infos
     */
    public function communeInfos($commune){
        $location = DB::table('locations')->whereJsonContains('place', ["commune"=> $commune])->first();
        $location_id = $location->id;
        $syncTable = DB::table('dbsync')->where('id',1)->first();
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $visits_cnt = Visit::whereBetween('created_at', [$syncTable->last_sync_date, $today])->count();
        $client_cnt = Client::whereBetween('created_at', [$syncTable->last_sync_date, $today])->count();
        $all_visits = Visit::whereHas('company',function($query) use ($location_id){
            $query->where('comp_location_id',$location_id);
        })->with(['client','company'])->get();
        return view('insightupdate')->with(compact('visits_cnt'))->with(compact('client_cnt'))->with(compact('all_visits'));
    }

    public function companyInfos($company_name){
        $company = Company::withCount(['resources','visits'])->where("comp_name",$company_name)->firs();
        $comp_clients = Visit::where('company_id',$company_id)->distinct('client_id')->count();
        $location = $places = DB::table('locations')->where('id',$company->comp_location_id)->first();
        $location_string = implode(', ',json_decode($location->place,true));
        $mana = User::where('company_id',$company_id)->where('is_manager',true)->first();
        return view('companyprofile')
            ->with(compact('company'))
            ->with(compact('comp_clients'))
            ->with(compact('location_string'))
            ->with(compact('mana'));
    }

    /** ======================== Home Dabshobard ==========================
     * 1:return statistic for home dasbhobard cards
     * 2: return statistic data for home dabshbard charts 
     * 1st chart:  entree visiteur
     * 2snd chart: total occupation per month
     * last x month are the x-1 past month plus actual month 
    */
    public function alldataUpdateSynceLastSync(){
        $syncTable = DB::table('dbsync')->where('id',1)->first();
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $companies_cnt = Company::whereBetween('created_at', [$syncTable->last_sync_date, $today])->count();
        $visits_cnt = Visit::whereBetween('created_at', [$syncTable->last_sync_date, $today])->count();
        $client_cnt = Client::whereBetween('created_at', [$syncTable->last_sync_date, $today])->count();
        $all_res = Resource::count();
        $occ_res = Resource::where('resource_availability',false)->count();
        $occupation = ($occ_res / $all_res) * 100;
        return view('dashboard')->with(compact('companies_cnt'))->with(compact('visits_cnt'))
        ->with(compact('client_cnt'))->with(compact('occ_res'));
    }
    public function getChartSatistic(){
        $eightMonthsAgo = Carbon::now()->subMonths(7);
        $dates = [];
        $visit_per_month = [];
        for ($i = 0; $i <= 7; $i++) {
            $dates[] = $eightMonthsAgo->copy();
            $date_mont = $eightMonthsAgo->copy();
            $month_visit_cnt = Visit::whereBetween('created_at',[$date_mont->firstOfMonth(), $date_mont->lastOfMonth()])->count();
            $visit_per_month[] = ['month'=>$date_mont->month, 'total_visit'=>$month_visit_cnt];
            $eightMonthsAgo->addMonth();
        }

        $sixMonthsAgo = Carbon::now()->subMonths(5);
        $dates1 = [];
        $resoccu_per_month = [];
        for ($i = 0; $i <= 5; $i++) {
            $dates1[] = $sixMonthsAgo->copy();
            $date_mont1 = $sixMonthsAgo->copy();
            $month_occ_res = Resource::whereBetween('created_at',[$date_mont1->firstOfMonth(), $date_mont1->lastOfMonth()])
            ->where('resource_availability',false)
            ->count();
            $resoccu_per_month[] = ['month'=>$date_mont1->month, 'total_visit'=>$month_occ_res];
            $sixMonthsAgo->addMonth();
        }
        return response()->json(["chart1"=> $visit_per_month, "chart2"=>$resoccu_per_month], 200);
    }

    public function autoComplete(Request $request){
        $query = $request->maquery;
        $company = Company::where('comp_name', 'like', '%'.$query.'%')->get();
        $res = $company->toArray();
        usort($res, function ($a, $b) use ($query) {
            similar_text($a['comp_name'], $query, $similarityA);
            similar_text($b['comp_name'], $query, $similarityB);
            return $similarityB <=> $similarityA;
        });      
        return response()->json($all_ents, 200);
    }
}


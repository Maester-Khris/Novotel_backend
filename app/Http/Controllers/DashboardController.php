<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Visit;
use App\Models\User;
use App\Models\Client;
use App\Models\Resource;

class DashboardController extends Controller
{

    private $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }


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
     * a pb can arise because of date_entree and created_at
     */
    public function communeInfos($commune){
        $location = DB::table('locations')->whereJsonContains('place', ["commune"=> $commune])->first();
        $location_id = $location->id;
        $location_string = implode(', ',json_decode($location->place,true));
        $today = Carbon::now()->format('Y-m-d');
        
        // all commune visit and client since last sync date
        $visits_since_sync = Visit::whereBetween('created_at', [$this->user->last_visit, $today])
            ->whereHas('company',function($query) use ($location_id){
                $query->where('comp_location_id',$location_id);
            })
            ->get();
        $visits_ss_count = $visits_since_sync->count();
        $unique_client_visit_ss = $visits_since_sync->groupBy('client_id')->count();
        // overall commune visits
        $all_visits = Visit::whereHas('company',function($query) use ($location_id){
            $query->where('comp_location_id',$location_id);
        })->with(['client','company'])->paginate(5);  
        
        // update to not let the interface empty
        $companies_from_location = Company::where('comp_location_id',$location_id)->select('comp_name')->get();
        return view('insightupdate')
            ->with(compact('visits_ss_count'))
            ->with(compact('unique_client_visit_ss'))
            ->with(compact('location_string'))
            ->with(compact('all_visits'))
            ->with(compact('companies_from_location'));
    }

    public function companyInfos($company_name){
        $company = Company::withCount(['resources','visits'])->where("comp_name",$company_name)->first();
        $comp_clients = Visit::where('company_id',$company->id)->distinct('client_id')->count();
        $location = $places = DB::table('locations')->where('id',$company->comp_location_id)->first();
        $location_string = implode(', ',json_decode($location->place,true));
        $mana = User::where('company_id',$company->id)->where('is_manager',true)->first();
        
        
        $company_id = $company->id;
        $visits = Visit::whereHas('company',function($query) use ($company_id){
                $query->where('id',$company_id);
            })->with(['client','resource'])->paginate(10);
                
        return view('companyprofile')
            ->with(compact('company'))
            ->with(compact('comp_clients'))
            ->with(compact('location_string'))
            ->with(compact('mana'))
            ->with(compact('visits'));
    }

    /** ======================== Home Dabshobard ==========================
     * 1:return statistic for home dasbhobard cards
     * 2: return statistic data for home dabshbard charts 
     * 1st chart:  entree visiteur
     * 2snd chart: total occupation per month
     * last x month are the x-1 past month plus actual month 
    */
    public function alldataUpdateSynceLastSync(){
        $today =Carbon::today()->format('Y-m-d');
        $companies_cnt = Company::count();
        $visits_cnt = Visit::count();
        $client_cnt = Client::count();
        $newcomp = Company::whereBetween('created_at', [$this->user->last_visit, $today])->count();
        $newclt = Client::whereBetween('created_at', [$this->user->last_visit, $today])->count();
        $newvst = Visit::whereBetween('created_at', [$this->user->last_visit, $today])->count();
        $data_since_visit = ['comp'=>$newcomp,'client'=>$newclt,'visit'=>$newvst]; 
        $all_res = Resource::count();
        $occ_res = Resource::where('resource_availability',false)->count();
        $occupation = round($all_res == 0 ? 0 : (($occ_res / $all_res) * 100), 2);
        return view('dashboard')->with(compact('companies_cnt'))->with(compact('visits_cnt'))
        ->with(compact('client_cnt'))->with(compact('occupation'))->with(compact('data_since_visit'));
    }
    public function getChartSatistic(){
        $eightMonthsAgo = Carbon::now()->subMonths(7);
        $visit_per_month = [];
        for ($i = 0; $i <= 7; $i++) {
            $date_1 = $eightMonthsAgo->copy();
            $date_2 = $eightMonthsAgo->copy();
            $month_visit_cnt = Visit::whereBetween('created_at',[$date_1->firstOfMonth(), $date_2->lastOfMonth()])->count();
            $visit_per_month[] = ['month'=> $this->numberToMonth($date_1->month), 'total_visit'=>$month_visit_cnt];
            $eightMonthsAgo->addMonth();
        }

        $sixMonthsAgo = Carbon::now()->subMonths(5);
        $resoccu_per_month = [];
        for ($i = 0; $i <= 5; $i++) {
            $date_1 = $sixMonthsAgo->copy();
            $date_2 = $sixMonthsAgo->copy();
            $month_occ_res = Resource::whereBetween('created_at',[$date_1->firstOfMonth(), $date_2->lastOfMonth()])
                ->where('resource_availability',false)
                ->count();
            $resoccu_per_month[] = ['month'=>$this->numberToMonth($date_1->month), 'total_visit'=>$month_occ_res];
            $sixMonthsAgo->addMonth();
        }
        return response()->json(["chart1"=> $visit_per_month, "chart2"=>$resoccu_per_month], 200);
    }

    public function companiesLike(Request $request){
        $query = $request->comp_query;
        $company = Company::where('comp_name', 'like', '%'.$query.'%')->limit(5)->get();
        $res = $company->toArray();
        usort($res, function ($a, $b) use ($query) {
            similar_text($a['comp_name'], $query, $similarityA);
            similar_text($b['comp_name'], $query, $similarityB);
            return $similarityB <=> $similarityA;
        });      
        return response()->json($res, 200);
    }

    // ========= Helper Function ==================
    // translate monthNumber to word 
    public function numberToMonth($num){
        switch($num){
            case 1:
                return "Janvier";
            case 2:
                return "Février";
            case 3:
                return "Mars";
            case 4:
                return "Avril";
            case 5:
                return "Mai";
            case 6:
                return "Juin";
            case 7:
                return "Juillet";
            case 8:
                return "Aout";
            case 9:
                return "Septembre";
            case 10:
                return "Octobre";
            case 11:
                return "Novembre";
            case 12:
                return "Décembre";

        }
    }
}


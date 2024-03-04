<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\User;
use Carbon\Carbon;
use Goutte\Client;
use App\Models\Resource;
use App\Models\Company;
use Hash;

class Testcontroller extends Controller
{
    public function other(){
        // list companies that doesnt have a list one manager
        $comps = Company::whereDoesntHave("users",function($query){
            $query->where('is_manager', true);
        })->get();

        // $comps->each(function($comp, $key){
        //     $users = User::where('company_id', $comp->id)->get();
        //     $mana = $users->random();
        //     $mana->is_manager = true;
        //     $mana->save();
        // });
        dd($comps);
    }
    public function get_datetime(){
        // $da = Carbon::now();
        // $da = Carbon::parse("Sun, 11 Feb 2024 01:22:10 GMT")->format('Y-m-d H:i:s');
        // $da = Carbon::now()->setTimezone("Africa/Douala");
        // dd($da->format('Y-m-d H:i:s'));

        $faker = Faker::create();
        // $dates = [];
        // for($i=0; $i<5; $i++){
        //     $dates[] = $faker->dateTimeBetween('-2 year', 'now');
        // }

        // $location = DB::table('locations')->first(); 
        // $place = [];
        // array_push($place, ['id'=>$location->id,'place'=>$location->place]);

        // $eightMonthsAgo = Carbon::now()->subMonths(7);
        // $visit_per_month = [];
        // for ($i = 0; $i <= 7; $i++) {
        //     $date_1 = $eightMonthsAgo->copy();
        //     $date_2 = $eightMonthsAgo->copy();
        //     $month_visit_cnt = Visit::whereBetween('created_at',[$date_1->firstOfMonth(), $date_2->lastOfMonth()])->count();
        //     $visit_per_month[] = ['month'=> $this->numberToMonth($date_1->month), 'total_visit'=>$month_visit_cnt];
        //     $eightMonthsAgo->addMonth();
        // }

        dd(Carbon::parse($faker->dateTimeBetween('-1 year', 'now'))->format('Y-m-d H:i:s'));
        dd($faker->dateTimeBetween('-1 year', 'now'));

        // $all_res = Resource::count();
        // $occ_res = Resource::where('resource_availability',false)->count();
        // dd([$all_res, $occ_res]);
        // dd(($occ_res/$all_res)*100);
        // dd($eightMonthsAgo->lastOfMonth()); 2023-07-31 00:00:00.0 UTC (+00:00)
        // dd($eightMonthsAgo,$eightMonthsAgo->startOfMonth(),$date_mont->lastOfMonth());
        // dd(implode(', ',json_decode($location->place,true)));
    }
    public function test(Request $request){
        $test = Http::get('https://api.first.org/data/v1/countries');
        $countries=[];
        foreach($test["data"] as $d){
            array_push($countries, $d['country']);
        }
        dd($countries);
    }

    public function scrapper(Request $request){
        $client = new Client();
        $website1 = $client->request('GET', 'https://www.osidimbea.cm/collectivites/liste-communes/');
        $website2 = $client->request('GET','https://fr.wikipedia.org/wiki/Commune_(Cameroun)');
        $locations = [];
        $locations= $website2->filter('table.centre > tbody > tr')->each(function ($node) {
            $line = $node->children()->each(function ($child) {
                return $child->text();
            });
            return ["region"=>$line[2],"departement"=>$line[1],"commune"=>$line[0]];
        });
        array_shift($locations);
        dd($locations);
    }

    public function test2(Request $request){
        $data = $request->all();
        $data['uuid'] = Str::uuid();
        $data['password']= Hash::make(Str::random(5));
        $user = new User;
        $user = $user->create($data);
        return response()->json(["data"=>$user, "message"=>"created record"]);
    }

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


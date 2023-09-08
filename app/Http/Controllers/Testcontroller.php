<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\User;
use Goutte\Client;
use Hash;

class Testcontroller extends Controller
{
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
}

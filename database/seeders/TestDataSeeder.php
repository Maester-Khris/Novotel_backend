<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;


class TestDataSeeder extends Seeder
{
    
    public function run()
    {
        /**
         * ============ Data seeding logic ============================
         * create overall 100 clients
         * for each place create between 2 to 4 companies
         * for each componanies
         *    - one manager and one recep
         *    - random number of ressource (4 - 10)
         *    - random number of visit (3 - 5) with random client id
         * 
        */

        /** new ==== did ^===================
         * turn res availability after affecting to visit
         * generate a date between the last 12 month $faker->dateTimeBetween('-1 week', '+1 week');
         * get world place from locétion
        */
        
        $faker = Faker::create();
        $compnames = [];
        $stars = [1,2,3,4,5];
        $hotels = ['Inn','Lodge','Motel','Resort','Hostel','Guesthouse','Bed and Breakfast (B&B)','Boardinghouse','Pension','Retreat','Spa','Campground','Hostelry','Caravansary','Cabins','Accommodation','Shelter','Resthouse','Rooming house','Wayside inn',
        'Roadhouse','Stopover','Holiday home','Manor','Palatial resort','Coastal retreat','Country house','Spa resort','Tourist lodge','Boutique hotel'];
        for($n=0; $n<20; $n++){
            $compnames[] = $faker->name() .' '. $faker->randomElement($hotels);
        }

        $places=[];
        $locations = DB::table('locations')->get();
        foreach($locations as $location){
            array_push($places, ['id'=>$location->id, 'place'=>implode(', ',json_decode($location->place,true))]);
        }
       
        // ======================================
        // ======= generating clients =============
        $clients = \App\Models\Client::factory()->count(20)->create();

        // ======================================
        // ======= generating companies =============
        foreach($places as $place){
            $rand_comp = rand(2,4);
            $placecomps = [];
            for($i=0;$i<$rand_comp; $i++){
                $comp = \App\Models\Company::create([
                    'uuid' => Str::random(5),
                    'comp_name' => $faker->randomElement($compnames),
                    'comp_telephone' => '+237 6'.$faker->randomNumber(8),
                    'comp_location_id' => $place['id'],
                    'comp_mail_address' => $faker->unique()->safeEmail(),
                    'comp_web_site' => 'www'.Str::random(6).'.docs.cmr',
                    'comp_standing_stars' => $faker->randomElement($stars),
                    'created_at' => Carbon::parse( $faker->dateTime() )->format('Y-m-d H:i:s')
                ]);
                $placecomps[] = $comp;
                // =====================================
                // ======= generating companies user ===
                \App\Models\User::factory()->count(2)->create(['company_id'=>  $comp->id ]);
                // =====================================
                // === generating companies resources ==
                $rand_res = rand(4,10);
                $resources = \App\Models\Resource::factory()->count($rand_res)->create(['company_id'=> $comp->id ]);
            }
            // =========================================
            // === genereating visits ==================
            $rand_visit = rand(3,5);
            for($i=0;$i<$rand_comp; $i++){
                $vis = \App\Models\Visit::create([ 
                    'uuid' => Str::random(5),
                    'visit_start_date' =>  Carbon::parse( $faker->dateTimeBetween('-1 year', 'now') )->format('Y-m-d H:i:s'),
                    'visit_end_date' =>  Carbon::parse( $faker->dateTimeBetween('-1 year', 'now') )->format('Y-m-d H:i:s'),
                    'client_coming_from' =>$faker->randomElement($places)['place'],
                    'client_going_to' =>$faker->randomElement($places)['place'],
                    'created_at' =>  Carbon::parse( $faker->dateTimeBetween('-1 year', 'now') )->format('Y-m-d H:i:s')
                ]);
                $comp = $faker->randomElement($placecomps);
                $res = $faker->randomElement($comp->resources);
                $comp->visits()->save($vis);
                $clients->random()->visits()->save($vis);
                $res->visit()->save($vis);
                $res->resource_availability = false;
                $res->save();
            }
        }
    }
}

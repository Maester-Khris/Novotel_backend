<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Goutte\Client;

class Location extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->json('place');
        });

        foreach(self::camerLocations() as $p){
            DB::table('locations')->insert(
                array(
                    'place' => json_encode($p)
                )
            );
        }
    }

    public function camerLocations(){
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
        return $locations;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

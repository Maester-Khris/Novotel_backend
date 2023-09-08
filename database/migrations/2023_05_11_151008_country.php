<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Http;

class Country extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        foreach(self::getAll() as $c){
            DB::table('countries')->insert(
                array(
                    'name' => $c
                )
            );
        }
       
    }


    public function getAll(){
        $test = Http::get('https://api.first.org/data/v1/countries');
        $countries=[];
        foreach($test["data"] as $d){
            array_push($countries, $d['country']);
        }
        return $countries;
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

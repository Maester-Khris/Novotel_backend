<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('full_name');
            $table->date('birth_date');
            $table->string('telephone');
            $table->integer('nationality_country_id');
            $table->integer('living_country_id');
            $table->integer('address_location_id');
            $table->string('nic_card_id');
            $table->date('nic_card_delivery');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}

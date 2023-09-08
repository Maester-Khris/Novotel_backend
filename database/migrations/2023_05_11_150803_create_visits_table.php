<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            // foregin key on company
            $table->bigInteger('company_id')->nullable()->unsigned();
            // foregin key on client
            $table->bigInteger('client_id')->nullable()->unsigned();
            // foregin key on resource
            $table->bigInteger('resource_id')->nullable()->unsigned();
            $table->dateTime('visit_start_date');
            $table->dateTime('visit_end_date')->nullable();
            $table->string('client_coming_from');
            $table->string('client_going_to');
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('resource_id')->references('id')->on('resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
}

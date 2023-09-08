<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            // foregin key on company
            $table->bigInteger('company_id')->nullable()->unsigned();
            $table->string('resource_name');
            $table->boolean('resource_availability')->default(true);
            $table->boolean('is_room');
            $table->boolean('is_bed');
            $table->boolean('is_appartment');
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}

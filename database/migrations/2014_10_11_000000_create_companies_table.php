<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('comp_name');
            $table->string('comp_telephone');
            $table->integer('comp_location_id');
            // mail
            $table->string('comp_mail_address')->default('xyz@gmail.com');
            // url
            $table->string('comp_web_site')->default('xyz-myhotel.com');
            $table->integer('comp_standing_stars')->default(0);
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
        Schema::dropIfExists('companies');
    }
}

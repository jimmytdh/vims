<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vas', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('category_id')->nullable();
            $table->string('category_id_number')->nullable();
            $table->string('philhealth_id')->nullable();
            $table->string('pwd_id')->nullable();
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('suffix')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('street_name')->nullable();
            $table->string('region')->nullable();
            $table->string('province')->nullable();
            $table->string('muncity')->nullable();
            $table->string('brgy')->nullable();
            $table->string('sex')->nullable();
            $table->date('birthdate')->nullable();
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
        Schema::dropIfExists('vas');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_info', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('category')->nullable();
            $table->string('category_id')->nullable();
            $table->string('category_id_number')->nullable();
            $table->string('pwd_id')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('direct_interaction')->nullable();
            $table->string('profession')->nullable();
            $table->string('employer')->nullable();
            $table->string('employer_province')->nullable();
            $table->string('employer_address')->nullable();
            $table->string('employer_contact')->nullable();
            $table->string('pregnancy_status')->nullable();
            $table->string('was_diagnosed')->nullable();
            $table->date('date_result')->nullable();
            $table->string('classification')->nullable();
            $table->string('willing_to_vaccinated')->nullable();
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
        Schema::dropIfExists('user_info');
    }
}

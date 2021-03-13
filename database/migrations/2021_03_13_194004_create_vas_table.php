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
            $table->string('consent')->nullable();
            $table->string('refusal_reason')->nullable();
            $table->string('question_01')->nullable();
            $table->string('question_02')->nullable();
            $table->string('question_03')->nullable();
            $table->string('question_04')->nullable();
            $table->string('question_05')->nullable();
            $table->string('question_06')->nullable();
            $table->string('question_07')->nullable();
            $table->string('question_08')->nullable();
            $table->string('question_09')->nullable();
            $table->string('question_10')->nullable();
            $table->string('question_11')->nullable();
            $table->string('question_12')->nullable();
            $table->string('question_13')->nullable();
            $table->string('question_14')->nullable();
            $table->string('question_15')->nullable();
            $table->string('question_16')->nullable();
            $table->string('question_17')->nullable();
            $table->string('question_18')->nullable();
            $table->string('deferral')->nullable();
            $table->date('vaccination_date')->nullable();
            $table->string('vaccine_manufacturer')->nullable();
            $table->string('batch_no')->nullable();
            $table->string('lot_no')->nullable();
            $table->string('vaccinator_name')->nullable();
            $table->string('vaccinator_profession')->nullable();
            $table->date('date_dose1')->nullable();
            $table->date('date_dose2')->nullable();
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

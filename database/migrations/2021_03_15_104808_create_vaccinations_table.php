<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->integer('vac_id');
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
            $table->string('dose1')->nullable();
            $table->string('dose2')->nullable();
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
        Schema::dropIfExists('vaccinations');
    }
}

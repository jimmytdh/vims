<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuickCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quick_counts', function (Blueprint $table) {
            $table->id();
            $table->date('report_date')->nullable();
            $table->string('question_02a')->nullable();
            $table->string('question_02b')->nullable();
            $table->string('question_03')->nullable();
            $table->string('question_05')->nullable();
            $table->string('question_06')->nullable();
            $table->string('question_07')->nullable();
            $table->string('question_08')->nullable();
            $table->string('question_09')->nullable();
            $table->string('question_10')->nullable();
            $table->string('question_13')->nullable();
            $table->string('question_14')->nullable();
            $table->string('question_15')->nullable();
            $table->string('question_16')->nullable();
            $table->string('question_17')->nullable();
            $table->string('question_18')->nullable();
            $table->string('question_19')->nullable();
            $table->string('question_20')->nullable();
            $table->string('question_21')->nullable();
            $table->string('question_22')->nullable();
            $table->string('question_23')->nullable();
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
        Schema::dropIfExists('quick_counts');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllergiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allergies', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('drug')->nullable();
            $table->string('food')->nullable();
            $table->string('insect')->nullable();
            $table->string('latex')->nullable();
            $table->string('mold')->nullable();
            $table->string('pet')->nullable();
            $table->string('pollen')->nullable();
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
        Schema::dropIfExists('allergies');
    }
}

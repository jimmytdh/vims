<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComorbiditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comorbidities', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('with_comorbidity')->nullable();
            $table->string('hypertension')->nullable();
            $table->string('heart_disease')->nullable();
            $table->string('diabetes')->nullable();
            $table->string('asthma')->nullable();
            $table->string('immunodeficiency')->nullable();
            $table->string('cancer')->nullable();
            $table->string('others')->nullable();
            $table->string('others_info')->nullable();
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
        Schema::dropIfExists('comorbidities');
    }
}

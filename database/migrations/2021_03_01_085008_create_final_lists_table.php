<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_lists', function (Blueprint $table) {
            $table->id();
            $table->string("category")->nullable();
            $table->string("categoryid")->nullable();
            $table->string("categoryidnumber")->nullable();
            $table->string("philhealthid")->nullable();
            $table->string("pwd_id")->nullable();
            $table->string("lastname")->nullable();
            $table->string("firstname")->nullable();
            $table->string("middlename")->nullable();
            $table->string("suffix")->nullable();
            $table->string("contact_no")->nullable();
            $table->string("full_address")->nullable();
            $table->string("region")->nullable();
            $table->string("province")->nullable();
            $table->string("muncity")->nullable();
            $table->string("barangay")->nullable();
            $table->string("sex")->nullable();
            $table->date("birthdate")->nullable();
            $table->string("civilstatus")->nullable();
            $table->string("employed")->nullable();
            $table->string("direct_covid")->nullable();
            $table->string("profession")->nullable();
            $table->string("employer_name")->nullable();
            $table->string("employer_lgu")->nullable();
            $table->string("employer_address")->nullable();
            $table->string("employer_contact_no")->nullable();
            $table->string("preg_status")->nullable();
            $table->string("allergy_01")->nullable();
            $table->string("allergy_02")->nullable();
            $table->string("allergy_03")->nullable();
            $table->string("allergy_04")->nullable();
            $table->string("allergy_05")->nullable();
            $table->string("allergy_06")->nullable();
            $table->string("allergy_07")->nullable();
            $table->string("w_comorbidities")->nullable();
            $table->string("comorbidity_01")->nullable();
            $table->string("comorbidity_02")->nullable();
            $table->string("comorbidity_03")->nullable();
            $table->string("comorbidity_04")->nullable();
            $table->string("comorbidity_05")->nullable();
            $table->string("comorbidity_06")->nullable();
            $table->string("comorbidity_07")->nullable();
            $table->string("comorbidity_08")->nullable();
            $table->string("covid_history")->nullable();
            $table->string("covid_date")->nullable();
            $table->string("covid_classification")->nullable();
            $table->string("consent")->nullable();
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
        Schema::dropIfExists('final_lists');
    }
}

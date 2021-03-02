<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalList extends Model
{
    use HasFactory;
    protected $fillable = [
        'category',
        'categoryid',
        'categoryidnumber',
        'philhealthid',
        'pwd_id',
        'lastname',
        'firstname',
        'middlename',
        'suffix',
        'contact_no',
        'full_address',
        'region',
        'province',
        'muncity',
        'barangay',
        'sex',
        'birthdate',
        'civilstatus',
        'employed',
        'direct_covid',
        'profession',
        'employer_name',
        'employer_lgu',
        'employer_address',
        'employer_contact_no',
        'preg_status',
        'allergy_01',
        'allergy_02',
        'allergy_03',
        'allergy_04',
        'allergy_05',
        'allergy_06',
        'allergy_07',
        'w_comorbidities',
        'comorbidity_01',
        'comorbidity_02',
        'comorbidity_03',
        'comorbidity_04',
        'comorbidity_05',
        'comorbidity_06',
        'comorbidity_07',
        'comorbidity_08',
        'covid_history',
        'covid_date',
        'covid_classification',
        'consent',
    ];
}

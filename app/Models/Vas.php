<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vas extends Model
{
    use HasFactory;
    protected $table = 'vas';
    protected $fillable = [
        'category',
        'category_id',
        'category_id_number',
        'philhealth_id',
        'pwd_id',
        'lastname',
        'firstname',
        'middlename',
        'suffix',
        'contact_no',
        'street_name',
        'region',
        'province',
        'muncity',
        'brgy',
        'sex',
        'birthdate',
        'consent',
        'refusal_reason',
        'question_01',
        'question_02',
        'question_03',
        'question_04',
        'question_05',
        'question_06',
        'question_07',
        'question_08',
        'question_09',
        'question_10',
        'question_11',
        'question_12',
        'question_13',
        'question_14',
        'question_15',
        'question_16',
        'question_17',
        'question_18',
        'deferral',
        'vaccination_date',
        'vaccine_manufacturer',
        'batch_no',
        'lot_no',
        'vaccinator_name',
        'vaccinator_profession',
        'date_dose1',
        'date_dose2',
    ];
}

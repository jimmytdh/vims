<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;
    protected $fillable = [
        'vac_id',
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
        'dose1',
        'dose2',
    ];
}

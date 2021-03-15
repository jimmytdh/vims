<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickCount extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_date',
        'question_02a',
        'question_02b',
        'question_03',
        'question_05',
        'question_06',
        'question_07',
        'question_08',
        'question_09',
        'question_10',
        'question_13',
        'question_14',
        'question_15',
        'question_16',
        'question_17',
        'question_18',
        'question_19',
        'question_20',
        'question_21',
        'question_22',
        'question_23',
    ];
}

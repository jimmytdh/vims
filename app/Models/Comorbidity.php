<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comorbidity extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'with_comorbidity',
        'hypertension',
        'heart_disease',
        'kidney_disease',
        'diabetes',
        'asthma',
        'immunodeficiency',
        'cancer',
        'others',
        'others_info',
    ];
}

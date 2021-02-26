<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    protected $table = 'user_info';
    protected $fillable = [
        'user_id',
        'category',
        'category_id',
        'category_id_number',
        'pwd_id',
        'employment_status',
        'direct_interaction',
        'profession',
        'employer',
        'employer_province',
        'employer_address',
        'employer_contact',
        'pregnancy_status',
        'was_diagnosed',
        'date_result',
        'classification',
        'willing_to_vaccinated',
    ];
}

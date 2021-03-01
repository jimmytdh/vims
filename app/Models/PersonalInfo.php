<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    use HasFactory;
    protected $connection = 'users';
    protected $table = 'personal_info';
    protected $fillable = [
        'user_id',
        'philhealth_id',
        'suffix',
        'contact_no',
        'sex',
        'dob',
        'civil_status',
        'address_street',
        'address_brgy',
        'address_muncity',
        'address_province',
        'address_region',
    ];
}

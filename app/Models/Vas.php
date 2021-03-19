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
        'facility',
    ];
}

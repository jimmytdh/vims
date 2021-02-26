<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergy extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'drug',
        'food',
        'insect',
        'latex',
        'mold',
        'pet',
        'pollen',
    ];
}

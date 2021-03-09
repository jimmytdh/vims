<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;
    protected $fillable = [
        'emp_id',
        'list',
        'schedule',
        'type',
        'date_1',
        'lot_1',
        'vaccinator_1',
        'date_2',
        'lot_2',
        'vaccinator_2',
    ];
}

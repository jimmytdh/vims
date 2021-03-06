<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $connection = 'philippines';
    protected $table = 'refprovince';
    protected $fillable = ['vimsCode'];
    public $timestamps = false;
}

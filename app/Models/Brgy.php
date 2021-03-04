<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brgy extends Model
{
    use HasFactory;
    protected $connection = 'philippines';
    protected $table = 'refbrgy';
    protected $fillable = ['vimsCode'];
    public $timestamps = false;
}

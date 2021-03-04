<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muncity extends Model
{
    use HasFactory;
    protected $connection = 'philippines';
    protected $table = 'refcitymun';
    protected $fillable = ['vimsCode'];
    public $timestamps = false;
}

<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    static function createLog($description)
    {
        Logs::create([
            'description' => $description
        ]);
    }
}

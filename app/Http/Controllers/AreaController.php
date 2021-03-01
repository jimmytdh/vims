<?php

namespace App\Http\Controllers;

use App\Models\Brgy;
use App\Models\Muncity;
use App\Models\Province;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public static function getProvinces($regCode)
    {
        $provinces = Province::where('regCode',$regCode)
                        ->orderBy('provDesc','asc')
                        ->get();
        return $provinces;
    }

    public static function getMuncity($provCode)
    {
        return Muncity::where('provCode',$provCode)
            ->orderBy('citymunDesc','asc')
            ->get();
    }

    public static function getBrgy($citymunCode)
    {
        return Brgy::where('citymunCode',$citymunCode)
            ->orderBy('brgyDesc','asc')
            ->get();
    }
}

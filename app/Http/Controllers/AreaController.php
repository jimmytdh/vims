<?php

namespace App\Http\Controllers;

use App\Models\Brgy;
use App\Models\Muncity;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public static function getProvinces($code)
    {
        $regCode = Region::where('vimsCode',$code)->first()->regCode;
        $provinces = Province::where('regCode',$regCode)
                        ->orderBy('provDesc','asc')
                        ->get();
        return $provinces;
    }

    public static function getMuncity($code)
    {
        $provCode = Province::where('vimsCode',$code)->first()->provCode;
        return Muncity::where('provCode',$provCode)
            ->orderBy('citymunDesc','asc')
            ->get();
    }

    public static function getBrgy($code)
    {
        $citymunCode = optional(Muncity::where('vimsCode',$code)->first())->citymunCode;
        return Brgy::where('citymunCode',$citymunCode)
            ->orderBy('brgyDesc','asc')
            ->get();
    }

    function fix()
    {
        $list = Brgy::all();
        foreach($list as $row)
        {
            $desc = str_replace("-", "_", $row->brgyDesc);
            $str = "_$row->brgyCode $desc";
            $value = str_replace(" ", "_", $str);
            Brgy::find($row->id)
                ->update([
                    'vimsCode' => strtoupper($value)
                ]);
        }
        echo 'Done!';
    }
}

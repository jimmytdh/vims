<?php

namespace App\Http\Controllers;

use App\Models\Vaccination;
use App\Models\Vas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class FacilityController extends Controller
{
    public function index()
    {
        $facility = Session::get('facility');
        if(!$facility)
            $facility = null;
        if(request()->ajax()) {
            $data = Vas::where('facility',$facility)
                ->orderBy('lastname','asc')
                ->get();

            return DataTables::of($data)
                ->addColumn('age', function($data){
                    return Carbon::parse($data->birthdate)->diff(Carbon::now())->format('%y');
                })
                ->addColumn('vaccine_manufacturer', function($data){
                    $r = optional(Vaccination::where('vac_id',$data->id)
                            ->where('dose1','01_Yes')
                            ->first());
                    return $r->vaccine_manufacturer;
                })
                ->addColumn('dose1', function($data){
                    $r = Vaccination::where('vac_id',$data->id)
                        ->where('dose1','01_Yes')
                        ->first();
                    if($r)
                        return date("M d, Y",strtotime($r->vaccination_date));
                    return "-";
                })
                ->addColumn('dose2', function($data){
                    $r = Vaccination::where('vac_id',$data->id)
                        ->where('dose2','01_Yes')
                        ->first();
                    if($r)
                        return date("M d, Y",strtotime($r->vaccination_date));
                    return "-";
                })

                ->rawColumns(['dose1','dose2'])
                ->make(true);
        }
        return view('report.facility',compact('facility'));
    }

    public function searchFacility(Request $request)
    {
        Session::put('facility',$request->facility);
        return redirect()->back();
    }
}

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

    public function exportData()
    {
        $data = Vas::orderBy('lastname','asc')
            ->get();
        $fileName = date('Y-m-d')."_Report.csv";
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = array(
            'Last Name',
            'First Name',
            'Middle Name',
            'Suffix',
            'Age',
            'Facility',
            'Vaccine',
            '1st Dose',
            '2nd Dose'
        );

        $callback = function() use ($data, $columns){
            $file = fopen('php://output','w');
            fputcsv($file,$columns);
            foreach($data as $row){
                $dose1 = optional(Vaccination::where('vac_id',$row->id)->where('dose1','01_Yes')->first());
                $dose2 = optional(Vaccination::where('vac_id',$row->id)->where('dose2','01_Yes')->first());
                $info = array(
                    utf8_decode($row->lastname),
                    utf8_decode($row->firstname),
                    utf8_decode($row->middlename),
                    $row->suffix,
                    Carbon::parse($row->birthdate)->diff(Carbon::now())->format('%y'),
                    $row->facility,
                    $dose1->vaccine_manufacturer,
                    $dose1->vaccination_date,
                    $dose2->vaccination_date,
                );
                fputcsv($file,$info);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}

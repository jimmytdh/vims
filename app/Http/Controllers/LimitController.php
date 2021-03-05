<?php

namespace App\Http\Controllers;

use App\Models\FinalList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LimitController extends Controller
{
    public function showList()
    {
        if(request()->ajax()){
            $data = FinalList::orderBy('lastname','asc')->get();

            return DataTables::of($data)
                ->addColumn('lastname',function ($data){
                    return "<span class='text-success edit' data-pk='$data->id' data-name='lastname' data-title='Last Name'>$data->lastname</span>";
                })
                ->addColumn('firstname',function ($data){
                    return "<span class='text-success edit' data-pk='$data->id' data-name='firstname' data-title='First Name'>$data->firstname</span>";
                })
                ->addColumn('middlename',function ($data){
                    return "<span class='text-success edit' data-pk='$data->id' data-name='middlename' data-title='Middle Name'>$data->middlename</span>";
                })
                ->addColumn('suffix',function ($data){
                    return "<span class='text-success edit' data-pk='$data->id' data-name='suffix' data-title='Suffix'>$data->suffix</span>";
                })
                ->addColumn('gender',function ($data){
                    return ($data->sex=='02_Male') ? 'Male' : 'Female';
                })
                ->addColumn('history',function ($data){
                    return ($data->covid_history=='02_No') ? 'No' : '<span class="text-danger">Yes</span>';
                })
                ->addColumn('consent',function ($data){
                    $consent = 'Unknown';
                    $class = 'muted';
                    if($data->consent=='01_Yes'){
                        $consent = 'Yes';
                        $class = 'success';
                    }elseif($data->consent=='02_No'){
                        $consent = 'No';
                        $class = 'danger';
                    }
                    return "<span class='text-$class consent' id='consent' data-type='select' data-value='$data->consent' data-title='Confirmation' data-pk='$data->id'>$consent</span>";
                })
                ->addColumn('age', function($data){
                    return Carbon::parse($data->birthdate)->diff(Carbon::now())->format('%y');
                })
                ->addColumn('action', function($data){
                    $urlCard = route('list.card',$data->id);
                    $btn = "<a href='$urlCard' target='_blank' class='btn btn-sm btn-info'><i class='fa fa-id-card'></i></a>";
                    return "$btn";
                })


                ->rawColumns(['lastname','firstname','middlename','suffix','history','consent','action'])
                ->make(true);
        }

        return view('user.list');
    }

    public function exportList()
    {

        $fileName = 'ConfirmedList_'.date('(M d)').'.csv';
        $finalList = FinalList::where('consent','01_Yes')
            ->orderBy('lastname','asc')
            ->get();
        //whereRaw('LENGTH(philhealthid) > 3')
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array(
            'No',
            'Last Name',
            'First Name',
            'Middle Name',
            'Suffix',
            'Age',
            'Contact',
            'Date Updated'
        );

        $callback = function() use ($finalList,$columns){
            $file = fopen('php://output','w');
            $row = array();
            fputcsv($file,$columns);
            $c = 1;
            foreach($finalList as $list){
                $row = array(
                    'no' => $c++,
                    'lastname' => utf8_decode($list->lastname),
                    'firstname' => utf8_decode($list->firstname),
                    'middlename' => utf8_decode($list->middlename),
                    'suffix' => $list->suffix,
                    'age' => Carbon::parse($list->birthdate)->diff(Carbon::now())->format('%y'),
                    'contact' => $list->contact_no,
                    'date' => date('M d, Y h:i a',strtotime($list->updated_at)),
                );
                fputcsv($file,$row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}

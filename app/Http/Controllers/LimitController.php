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
                ->addColumn('fullname',function ($data){
                    $middlename = substr($data->middlename,0,1);
                    $suffix = ($data->suffix!='NA') ? $data->suffix: '';
                    $name = "$data->lastname, $data->firstname $middlename. $suffix";
                    return "<span class='text-success'>$name</span>";
                })
                ->addColumn('gender',function ($data){
                    return ($data->sex=='02_Male') ? 'Male' : 'Female';
                })
                ->addColumn('history',function ($data){
                    return ($data->covid_history=='02_No') ? 'No' : '<span class="text-danger">Yes</span>';
                })
                ->addColumn('consent',function ($data){
                    $consent = '';
                    if($data->consent=='01_Yes'){
                        return '<span class="text-success">Yes</span>';
                    }elseif($data->consent=='02_No'){
                        return '<span class="text-danger">No</span>';
                    }elseif($data->consent=='03_Unknown'){
                        return '<span class="text-muted">Unknown</span>';
                    }
                })
                ->addColumn('age', function($data){
                    return Carbon::parse($data->birthdate)->diff(Carbon::now())->format('%y');
                })
                ->addColumn('action', function($data){
                    $urlCard = route('list.card',$data->id);
                    $btn = "<a href='$urlCard' target='_blank' class='btn btn-sm btn-info'><i class='fa fa-id-card'></i></a>";
                    return "$btn";
                })


                ->rawColumns(['fullname','history','consent','action'])
                ->make(true);
        }

        return view('user.list');
    }
}

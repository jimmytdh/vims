<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\FinalList;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LimitController extends Controller
{
    public function showList()
    {
        if(request()->ajax()){
            $data = FinalList::select('final_lists.*','vaccines.id as vac_id','vaccines.date_1','vaccines.date_2','vaccines.schedule','vaccines.list')
                        ->leftJoin('vaccines','vaccines.emp_id','=','final_lists.id')
                        ->orderBy('lastname','asc')->get();

            return DataTables::of($data)
                ->addColumn('fullname',function ($data){
                    $class = ($data->consent=='01_Yes') ? 'success' : 'danger';

                    $lname = "<span class='text-$class edit' data-pk='$data->id' data-name='lastname' data-title='Last Name'>$data->lastname</span>";
                    $fname = "<span class='text-$class edit' data-pk='$data->id' data-name='firstname' data-title='First Name'>$data->firstname</span>";
                    $mname = "<span class='text-$class edit' data-pk='$data->id' data-name='middlename' data-title='Middle Name'>$data->middlename</span>";
                    $suffix = ($data->suffix=='NA' || $data->suffix=='N/A') ? '' : $data->suffix;
                    return "$lname, $fname $mname $suffix";
                })
                ->addColumn('w_comorbidity',function ($data){
                    $w_commorbidty = false;
                    $header = array(
                        'comorbidity_01',
                        'comorbidity_02',
                        'comorbidity_03',
                        'comorbidity_04',
                        'comorbidity_05',
                        'comorbidity_06',
                        'comorbidity_07',
                        'comorbidity_08',
                    );
                    foreach($header as $row){
                        if($data->$row=='01_Yes')
                            $w_commorbidty = true;
                    }
                    return ($w_commorbidty) ? "<span class='text-danger'>Yes</span>" : '';

                })
                ->addColumn('division',function ($data){
                    $check = optional(User::select('division.code','division.id')
                                ->leftJoin('division','division.id','=','users.division')
                                ->where('fname',$data->firstname)
                                ->where('lname',$data->lastname)
                                ->first());
                    $class = ($check->code) ? 'success' : 'danger text-italic';
                    $code = ($check->code) ? $check->code : 'Empty';
                    $id = ($check->id) ? $check->id : 0;
                    return "<span class='editUser text-$class' data-type='select' data-value='$id' data-pk='$data->id' data-name='user_id' data-title='Select Division'>$code</span>";
                })
                ->addColumn('list',function ($data){

                    $class = ($data->list) ? 'success' : 'danger text-italic';
                    $code = ($data->list) ? strtoupper($data->list) : 'Empty';

                    return "<span class='editList text-$class' data-type='select' data-value='$data->list' data-pk='$data->id' data-name='list' data-title='Select Group List'>$code</span>";
                })
                ->addColumn('gender',function ($data){
                    return ($data->sex=='02_Male') ? 'Male' : 'Female';
                })
                ->addColumn('willing',function ($data){
                    return ($data->consent == '01_Yes') ? 'Yes' : 'No';
                })
                ->addColumn('schedule',function ($data){
                    $date = '-';
                    if($data->schedule){
                        $date = ($data->schedule) ? date('m/d/y',strtotime($data->schedule)): '';
                        //$date .= "<br><small class='text-danger'>(Scheduled)</small>";
                    }

                    return "<small class='text-info font-weight-bold'>$date</small>";
                })

                ->addColumn('dosage1',function ($data){
                    $date = '-';
                    if($data->date_1){
                        $date = ($data->date_1) ? date('m/d/y',strtotime($data->date_1)): '';
                    }

                    return "<small class='text-info font-weight-bold'>$date</small>";
                })
                ->addColumn('dosage2',function ($data){
                    $date = '-';
                    if($data->date_2){
                        $date = ($data->date_2) ? date('m/d/y',strtotime($data->date_2)): '';
                    }

                    return "<small class='text-info font-weight-bold'>$date</small>";
                })
                ->addColumn('history',function ($data){
                    return ($data->covid_history=='02_No') ? 'No' : '<span class="text-danger">Yes</span>';
                })
                ->addColumn('created_at',function ($data){
                    return date('m/d/Y h:i A',strtotime($data->created_at));
                })
                ->addColumn('consent_update',function ($data){
                    return date('m/d/Y h:i A',strtotime($data->consent_update));
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
                    $btn = '';
                    $btn2 = '';
                    $btn3 = '';
                    if($data->consent=='01_Yes'){
                        $btn = "<a href='$urlCard' target='_blank' class='btn btn-sm btn-info'><i class='fa fa-id-card'></i></a>";
                        $btn2 = "<a href='#vaccineModal' data-id='$data->id' data-toggle='modal' class='btn btn-sm btn-warning'><i class='fa fa-eyedropper'></i></a>";
                        $btn3 = "<a href='#scheduleModal' data-id='$data->id' data-toggle='modal' class='btn btn-sm btn-primary'><i class='fa fa-calendar'></i></a>";
                        $btn4 = "<a href='#scheduleModal' data-id='$data->id' data-toggle='modal' class='btn btn-sm btn-primary'><i class='fa fa-calendar'></i></a>";
                    }
                    return "$btn $btn2 $btn3";
                })


                ->rawColumns(['fullname','list','w_comorbidity','division','suffix','schedule','dosage1','dosage2','history','status','consent','action'])
                ->make(true);
        }
        $divisions = Division::get();
        return view('user.list',compact('divisions'));
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

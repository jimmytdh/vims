<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\CategoryID;
use App\Models\CivilStatus;
use App\Models\Deferral;
use App\Models\FinalList;
use App\Models\Refusal;
use App\Models\Region;
use App\Models\Vaccination;
use App\Models\Vaccinator;
use App\Models\Vaccine;
use App\Models\Vas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class VasController extends Controller
{
    public function header()
    {
        return array(
            'category',
            'category_id',
            'category_id_number',
            'philhealth_id',
            'pwd_id',
            'lastname',
            'firstname',
            'middlename',
            'suffix',
            'contact_no',
            'street_name',
            'region',
            'province',
            'muncity',
            'brgy',
            'sex',
            'birthdate',
            'consent',
            'refusal_reason',
            'question_01',
            'question_02',
            'question_03',
            'question_04',
            'question_05',
            'question_06',
            'question_07',
            'question_08',
            'question_09',
            'question_10',
            'question_11',
            'question_12',
            'question_13',
            'question_14',
            'question_15',
            'question_16',
            'question_17',
            'question_18',
            'deferral',
            'vaccination_date',
            'vaccine_manufacturer',
            'batch_no',
            'lot_no',
            'vaccinator_name',
            'vaccinator_profession',
            'dose1',
            'dose2',
        );
    }

    public function changeDate(Request $request)
    {
        Session::put('vaccination_date',$request->vaccination_date);
        return redirect()->back();
    }

    public function changeStatus(Request $request)
    {
        Vaccination::find($request->id)
            ->update([
                'status' => $request->status
            ]);
        return 1;
    }

    public function index()
    {
        $date = Session::get('vaccination_date');
        $date = ($date) ? $date: date('Y-m-d');
        if(request()->ajax()) {
            $data = Vas::leftJoin('vaccinations','vaccinations.vac_id','=','vas.id')
                    ->where('vaccination_date',$date)
                    ->orderBy('lastname','asc')
                    ->get();

            return DataTables::of($data)
                ->addColumn('fullname',function ($data){
                    $suffix = ($data->suffix!='NA') ? $data->suffix: '';
                    $name = "$data->lastname, $data->firstname $data->middlename $suffix";
                    $class = 'success';
                    if($data->defferal) {
                        $class = 'danger';
                    }
                    return "<span class='text-$class'>$name</span>";
                })
                ->addColumn('gender',function ($data){
                    return ($data->sex=='02_Male') ? 'Male' : 'Female';
                })

                ->addColumn('deferral',function ($data){
                    $deferral = ($data->deferral) ? $data->deferral : null;

                    return "<span class='text-danger'>$deferral</span>";
                })
                ->addColumn('age', function($data){
                    return Carbon::parse($data->birthdate)->diff(Carbon::now())->format('%y');
                })
                ->addColumn('dose', function($data){
                    $dose = '-';
                    if($data->dose1=='01_Yes')
                        $dose = '1st';
                    elseif($data->dose2=='01_Yes')
                        $dose = '2nd';

                    return $dose;
                })
                ->addColumn('vaccination_date', function($data){
                    $date = Carbon::parse($data->vaccination_date)->format('M d, Y');

                    return "<span class='vaccination_date' data-name='vaccination_date' data-pk='$data->id' data-value='$date' data-type='date' data-title='Change Vaccination Date'>$date</span>";
                })
                ->addColumn('consent', function($data){
                    return ($data->consent=='01_Yes') ? 'Yes' : 'No';
                })
                ->addColumn('action', function($data){
                    $editUrl = url('list/vas/edit',$data->vac_id);
                    $deleteUrl = url('list/vas/delete/'.$data->vac_id);
                    $btn1 = "<a href='$editUrl' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></a>";
                    $btn2 = null;
                    if(Auth::user()->isAdmin()):
                    $btn2 = "<a href='#deleteModal' data-toggle='modal' data-backdrop='static' data-url='$deleteUrl' data-title='Delete Record?' data-id='$data->vac_id' class='btnDelete btn btn-sm btn-danger'><i class='fa fa-trash'></i></a>";
                    endif;
                    $btn4 = null;
                    $btn3 = "<a href='#healthModal' data-toggle='modal' data-backdrop='static' data-id='$data->vac_id' class='btn btn-sm btn-info'><i class='fa fa-stethoscope'></i></a>";
                    if(!$data->deferral){
                        $btn4 = "<a href='#vaccinationModal' data-toggle='modal' data-backdrop='static' data-id='$data->vac_id' class='btn btn-sm btn-warning'><i class='fa fa-eyedropper'></i></a>";
                    }
                    $nextDose = Vaccination::where('vac_id',$data->vac_id)
                                ->where('id','>',$data->id)
                                ->first();
                    $date = Carbon::parse($data->vaccination_date)->addWeek(4)->format('Y-m-d');
                    if($data->vaccine_manufacturer=='Astrazeneca'){
                        $date = Carbon::parse($data->vaccination_date)->addWeek(8)->format('Y-m-d');
                    }
                    $btn5 = "<a href='#nextVisitModal' data-toggle='modal' data-backdrop='static' data-date='$date' data-id='$data->vac_id' class='btn btn-sm btn-warning'><i class='fa fa-calendar'></i></a>";
                    if($nextDose)
                        $btn5 = null;
                    if($data->dose1!='01_Yes')
                        $btn5 = null;
                    if($data->deferral && !$nextDose){
                        $date = Carbon::now()->format('Y-m-d');
                        $btn5 = "<a href='#nextVisitModal' data-toggle='modal' data-backdrop='static' data-date='$date' data-id='$data->vac_id' class='btn btn-sm btn-warning'><i class='fa fa-calendar'></i></a>";
                    }
                    $btn6 = "<a href='#statusModal' data-toggle='modal' data-backdrop='static' data-id='$data->id' class='btn btn-sm btn-primary'><i class='fa fa-exclamation-circle'></i></a>";
                    return "$btn1 $btn2 $btn3 $btn4 $btn5 $btn6";
                })
                ->rawColumns(['fullname','deferral','action','vaccination_date'])
                ->make(true);
        }
        return view('vas.index',compact('date'));
    }

    public function allData()
    {
        $date = date("Y-m-d");
        if(request()->ajax()) {
            $data = Vas::leftJoin('vaccinations','vaccinations.vac_id','=','vas.id')
                ->orderBy('lastname','asc')
                ->get();

            return DataTables::of($data)
                ->addColumn('fullname',function ($data){
                    $suffix = ($data->suffix!='NA') ? $data->suffix: '';
                    $name = "$data->lastname, $data->firstname $data->middlename $suffix";
                    $class = 'success';
                    if($data->defferal) {
                        $class = 'danger';
                    }
                    return "<span class='text-$class'>$name</span>";
                })
                ->addColumn('gender',function ($data){
                    return ($data->sex=='02_Male') ? 'Male' : 'Female';
                })

                ->addColumn('deferral',function ($data){
                    $deferral = ($data->deferral) ? $data->deferral : null;

                    return "<span class='text-danger'>$deferral</span>";
                })
                ->addColumn('age', function($data){
                    return Carbon::parse($data->birthdate)->diff(Carbon::now())->format('%y');
                })
                ->addColumn('dose', function($data){
                    $dose = '-';
                    if($data->dose1=='01_Yes')
                        $dose = '1st';
                    elseif($data->dose2=='01_Yes')
                        $dose = '2nd';

                    return $dose;
                })
                ->addColumn('vaccination_date', function($data){
                    $date = Carbon::parse($data->vaccination_date)->format('M d, Y');

                    return "<span class='vaccination_date' data-name='vaccination_date' data-pk='$data->id' data-value='$date' data-type='date' data-title='Change Vaccination Date'>$date</span>";
                })
                ->addColumn('consent', function($data){
                    return ($data->consent=='01_Yes') ? 'Yes' : 'No';
                })
                ->addColumn('action', function($data){
                    $editUrl = url('list/vas/edit',$data->vac_id);
                    $deleteUrl = url('/vas/schedule/delete/'.$data->id);
                    $btn1 = "<a href='$editUrl' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></a>";
                    $btn2 = null;
                    if(Auth::user()->isAdmin()):
                        $btn2 = "<a href='#deleteModal' data-toggle='modal' data-backdrop='static' data-url='$deleteUrl' data-title='Delete Record?' data-id='$data->vac_id' class='btnDelete btn btn-sm btn-danger'><i class='fa fa-trash'></i></a>";
                    endif;

                    $btn4 = null;
                    $btn3 = "<a href='#healthModal' data-toggle='modal' data-backdrop='static' data-id='$data->vac_id' class='btn btn-sm btn-info'><i class='fa fa-stethoscope'></i></a>";
                    if(!$data->deferral){
                        $btn4 = "<a href='#vaccinationModal' data-toggle='modal' data-backdrop='static' data-id='$data->vac_id' class='btn btn-sm btn-warning'><i class='fa fa-eyedropper'></i></a>";
                    }
                    $nextDose = Vaccination::where('vac_id',$data->vac_id)
                        ->where('id','>',$data->id)
                        ->first();
                    $date = Carbon::parse($data->vaccination_date)->addWeek(4)->format('Y-m-d');
                    if($data->vaccine_manufacturer=='Astrazeneca'){
                        $date = Carbon::parse($data->vaccination_date)->addWeek(8)->format('Y-m-d');
                    }
                    $btn5 = "<a href='#nextVisitModal' data-toggle='modal' data-backdrop='static' data-date='$date' data-id='$data->vac_id' class='btn btn-sm btn-warning'><i class='fa fa-calendar'></i></a>";
                    if($nextDose)
                        $btn5 = null;
                    if($data->dose1!='01_Yes')
                        $btn5 = null;
                    if($data->deferral && !$nextDose){
                        $date = Carbon::now()->format('Y-m-d');
                        $btn5 = "<a href='#nextVisitModal' data-toggle='modal' data-backdrop='static' data-date='$date' data-id='$data->vac_id' class='btn btn-sm btn-warning'><i class='fa fa-calendar'></i></a>";
                    }
                    $btn6 = "<a href='#statusModal' data-toggle='modal' data-backdrop='static' data-id='$data->id' class='btn btn-sm btn-primary'><i class='fa fa-exclamation-circle'></i></a>";
                    return "$btn2";
                })
                ->rawColumns(['fullname','deferral','action','vaccination_date'])
                ->make(true);
        }
        return view('vas.all',compact('date'));
    }

    public function allData2()
    {

        if(request()->ajax()) {
            $data = Vaccination::select('vas.*','vaccinations.*')
                ->leftJoin('vas','vas.id','=','vaccinations.vac_id')
                ->orderBy('lastname','asc')
                ->orderBy('vaccination_date','asc')
                ->get();

            return DataTables::of($data)
                ->addColumn('fullname',function ($data){
                    $suffix = ($data->suffix!='NA') ? $data->suffix: '';
                    $name = "$data->lastname, $data->firstname $data->middlename $suffix";
                    $class = 'success';
                    if($data->defferal) {
                        $class = 'danger';
                    }
                    return "<span class='text-$class'>$name</span>";
                })
                ->addColumn('gender',function ($data){
                    return ($data->sex=='02_Male') ? 'Male' : 'Female';
                })

                ->addColumn('deferral',function ($data){
                    $deferral = ($data->deferral) ? $data->deferral : null;

                    return "<span class='text-danger'>$deferral</span>";
                })
                ->addColumn('age', function($data){
                    return Carbon::parse($data->birthdate)->diff(Carbon::now())->format('%y');
                })
                ->addColumn('dose', function($data){
                    $dose = '-';
                    if($data->dose1=='01_Yes')
                        $dose = '1st';
                    elseif($data->dose2=='01_Yes')
                        $dose = '2nd';

                    return $dose;
                })
                ->addColumn('vaccination_date', function($data){
                    return Carbon::parse($data->vaccination_date)->format('M d, Y');
                })
                ->addColumn('consent', function($data){
                    return ($data->consent=='01_Yes') ? 'Yes' : 'No';
                })
                ->addColumn('action', function($data){
                    $editUrl = url('list/vas/edit',$data->vac_id);
                    $deleteUrl = url('/vas/schedule/delete/'.$data->id);
                    $btn1 = "<a href='$editUrl' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></a>";
                    $btn2 = null;
                    if(Auth::user()->isAdmin()):
                        $btn2 = "<a href='#deleteModal' data-toggle='modal' data-backdrop='static' data-url='$deleteUrl' data-title='Delete Record?' data-id='$data->vac_id' class='btnDelete btn btn-sm btn-danger'><i class='fa fa-trash'></i></a>";
                    endif;

                    return "$btn1 $btn2";
                })
                ->rawColumns(['fullname','deferral','action'])
                ->make(true);
        }
        return view('vas.all');
    }

    public function edit($id)
    {
        $data = Vas::find($id);
        $category = Categories::get();
        $categoryID = CategoryID::get();

        $region = Region::get();
        $provinces = AreaController::getProvinces('CentralVisayas');
        $muncity = AreaController::getMuncity('_0722_CEBU');
        $brgy = AreaController::getBrgy($data->muncity);
        return view('vas.edit',compact(
            'category',
            'categoryID',
            'region',
            'provinces',
            'muncity',
            'brgy',
            'id',
            'data'
        ));
    }

    public function update(Request $req,$id)
    {
        $row = $_POST;
        $row['firstname'] = mb_strtoupper($row['firstname']);
        $row['lastname'] = mb_strtoupper($row['lastname']);
        $row['middlename'] =mb_strtoupper($row['middlename']);

        Vas::find($id)->update($row);
        return redirect()->back()->with('success',true);
    }

    public function delete($id)
    {
        Vas::find($id)->delete();
        Vaccination::where('vac_id',$id)->delete();
        return redirect()->back()->with('deleted',true);
    }

    public function deleteVaccination($id)
    {
        Vaccination::find($id)->delete();
        return redirect()->back()->with('deleted',true);
    }

    public function editable(Request $request)
    {
        Vaccination::find($request->pk)
            ->update([
                $request->name => $request->value
            ]);
        return 1;
    }

    public function register()
    {
        $category = Categories::get();
        $categoryID = CategoryID::get();

        $region = Region::get();
        $provinces = AreaController::getProvinces('CentralVisayas');
        $muncity = AreaController::getMuncity('_0722_CEBU');
        $brgy = array();
        return view('vas.register',compact(
            'category',
            'categoryID',
            'region',
            'provinces',
            'muncity',
            'brgy',
        ));
    }

    public function saveRegistration(Request $request)
    {
        $row = $_POST;
        $row['birthdate'] = Carbon::parse($row['birthdate'])->format('Y-m-d');
        $row['firstname'] = mb_strtoupper($row['firstname']);
        $row['lastname'] = mb_strtoupper($row['lastname']);
        $row['middlename'] =mb_strtoupper($row['middlename']);

        $match = array(
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'middlename' => $row['middlename'],
        );
        $status = 'saved';
        $check = Vas::where($match)->first();
        if($check){
            $status = 'duplicate';
        }
        $vac = Vas::updateOrCreate($match,$row);
        if($vac->wasRecentlyCreated){
            $this->generateVaccinationDate($vac->id,$request->vaccination_date);
        }

        return redirect()->back()->with($status,true);
    }

    public static function generateVaccinationDate($id,$date)
    {
        $check = Vaccination::where('vac_id',$id)
                    ->where('vaccination_date',$date)
                    ->first();
        if($check)
            return 0;

        $data = Vas::find($id);
        $row['consent'] = '01_Yes';
        $age = Carbon::parse($data->birthdate)->diff(Carbon::now())->format('%y');
        $row['question_01'] = ($age > 16) ? '01_Yes' : '02_No';
        for($i=2; $i<=18;$i++)
        {
            $question = "question_".str_pad($i,2,0,STR_PAD_LEFT);
            if( $i==9 || $i==17 || $i==5 || $i==7 || $i==15 || $i==18){
                continue;
            }
            $row[$question] = '01_Yes';
        }
        $row['vac_id'] = $data->id;
        $row['vaccination_date'] = $date;
        Vaccination::create($row);

        return 1;
    }

    public function healthCondition($id)
    {
        $date = Session::get('vaccination_date');
        $date = ($date) ? $date: date('Y-m-d');

        $data = Vaccination::where('vac_id',$id)->where('vaccination_date',$date)->first();
        $info = Vas::find($id);
        $deferral = Deferral::get();
        $questions = $this->questions();
        $id = $data->id;
        return view('load.health',compact(
            'data',
            'deferral',
            'questions',
            'id',
            'info'
        ));
    }

    static function questions()
    {
        $data[0] = "Age more than 16 years old?";
        $data[1] = "Allergic to PEG or polysorbate?";
        $data[2] = "Severe allergic reaction after the 1st dose of the vaccine?";
        $data[3] = "Allergic to food, egg, medicines, and no asthma?";
        $data[4] = "If with allergy or asthma, will the vaccinator able to monitor the patient for 30 minutes?";
        $data[5] = "History of bleeding disorders or currently taking anti-coagulants?";
        $data[6] = "If with bleeding history, is a gauge 23 - 25 syringe available for injection?";
        $data[7] = "Manifest any of the following symptoms: Fever/chills, Headache, Cough, Colds, Sore throat,  Myalgia, Fatigue, Weakness, Loss of smell/taste, Diarrhea, Shortness of breath/ difficulty in breathing";
        $data[8] = "If manifesting any of the mentioned symptom/s, specify all that apply";
        $data[9] = "History of exposure to a confirmed or suspected COVID-19 case in the past 2 weeks?";
        $data[10] = "Previously treated for COVID-19 in the past 90 days?";
        $data[11] = "Received any vaccine in the past 2 weeks?";
        $data[12] = "Received convalescent plasma or monoclonal antibodies for COVID-19 in the past 90 days?";
        $data[13] = "Pregnant?";
        $data[14] = "If pregnant, 2nd or 3rd Trimester?";
        $data[15] = "Have any of the following: HIV, Cancer/ Malignancy, Underwent Transplant, Under Steroid Medication/ Treatment, Bed Ridden, terminal illness, less than 6 months prognosis";
        $data[16] = "If with mentioned condition/s, specify.";
        $data[17] = "If with mentioned condition, has presented medical clearance prior to vaccination day?";

        return $data;
    }

    static function facilities()
    {
        return array(
            'Cebu South Medical Center',
            'Vicente Sotto Memorial Medical Center',
            'LGU - Talisay City',
            'DPWH',
            'Private Health Facility',
            'BFP',
        );
    }

    public function saveHealthCondition(Request $request,$id)
    {
        $row = $_POST;

        if($request->deferral){
            $data = $this->emptyVaccination();
            $row = array_merge($row,$data);
        }
        Vaccination::find($id)->update($row);
    }

    public function vaccination($id)
    {
        $date = Session::get('vaccination_date');
        $date = ($date) ? $date: date('Y-m-d');

        $data = Vaccination::where('vac_id',$id)->where('vaccination_date',$date)->first();
        $vaccinator = Vaccinator::orderBy('name','asc')->get();
        $refusal = Refusal::get();
        $dose = Vaccination::where('vac_id',$id)->where('dose1','01_Yes')->count();
        $id = $data->id;

        return view('load.vaccination',compact('data','vaccinator','id','refusal','dose'));
    }

    public function saveVaccination(Request $request,$id)
    {

        $vac = optional(Vaccinator::find($request->vaccinator));
        $row = $_POST;
        $row['dose1'] = null;
        $row['dose2'] = null;
        $row[$request->dose] = '01_Yes';
        $row['vaccinator_name'] = $vac->name;
        $row['vaccinator_profession'] = $vac->profession;
        if($request->consent=='02_No'){
            $row = $this->emptyVaccination();
            $row['consent'] = $request->consent;
            $row['refusal_reason'] = $request->refusal_reason;
        }else{
            $row['refusal_reason'] = null;
        }
        Vaccination::find($id)->update($row);
        return $row;
    }

    function emptyVaccination()
    {
        $row['dose1'] = null;
        $row['dose2'] = null;
        $row['vaccinator_name'] = null;
        $row['vaccinator_profession'] = null;
        $row['vaccine_manufacturer'] = null;
        $row['batch_no'] = null;
        $row['lot_no'] = null;

        return $row;
    }

    public function exportData($all = false)
    {
        $fileName = date('(m-d-Y)').'_CBC05596_CebuSouthMedicalCenter'.'.csv';
        $date = Session::get('vaccination_date');
        $date = ($date) ? $date: date('Y-m-d');
        $data = Vas::leftJoin('vaccinations','vaccinations.vac_id','=','vas.id');

        if(!$all){
            $data = $data->where(function($q) {
                        $q->where('dose1','01_Yes')
                            ->orwhere('dose2','01_Yes');
            })
            ->where('vaccination_date',$date);
        }
        $data = $data->orderBy('lastname','asc')->get();

        //whereRaw('LENGTH(philhealthid) > 3')
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = $this->header();
        $columns['facility'] = 'facility';
        $columns['age'] = 'age';
        $callback = function() use ($data, $columns){
            $file = fopen('php://output','w');
            $row = array();
            fputcsv($file,$columns);
            foreach($data as $list){
                foreach($columns as $col){
                    if($col=='age')
                    {
                        $age = Carbon::parse($list->birthdate)->diff(Carbon::now())->format('%y');
                        $row[$col] = $age;
                        continue;
                    }
                    $row[$col] = utf8_decode($list->$col);
                }
                fputcsv($file,$row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function schedule(Request $request)
    {
        $date = $request->nextDate;
        $id = $request->vac_id;
        $this->generateVaccinationDate($id,$date);

        return 1;
    }

    public function uploadList(Request $request)
    {
        $date = date('Y-m-d',strtotime($request->vaccination_date));
        if($request->hasFile('file'))
        {
            $file_name = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('upload',$file_name);
        }
        $path = storage_path()."/app/upload/".$file_name;
        $data = $this->csvToArray($path);
        foreach($data as $row)
        {
            $row['firstname'] = $row['firstname'];
            $row['lastname'] = $row['lastname'];
            $row['middlename'] =$row['middlename'];
            $row['philhealth_id'] =utf8_encode($row['philhealth_id']);
            $row['street_name'] =utf8_encode($row['street_name']);

            $row['facility'] = $request->facility;
            $match = array(
                'lastname' => $row['lastname'],
                'firstname' => $row['firstname'],
                'middlename' => $row['middlename'],
            );
            $row['birthdate'] = date('Y-m-d',strtotime($row['birthdate']));
            $vas = Vas::updateOrCreate($match,$row);
            if($vas->wasRecentlyCreated){
                $this->generateVaccinationDate($vas->id,$request->vaccination_date);
            }
        }
        unlink($path);
        return redirect()->back();
    }

    public function updateList(Request $request)
    {
        if($request->hasFile('file'))
        {
            $file_name = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('upload',$file_name);
        }
        $path = storage_path()."/app/upload/".$file_name;
        $data = $this->csvToArray($path);
        foreach($data as $val){
            $match = array(
                'firstname' => $val['firstname'],
                'lastname' => $val['lastname']
            );
            $val['facility'] = $request->facility;
            if($val['birthdate']){
                $val['birthdate'] = date('Y-m-d',strtotime($val['birthdate']));
            }
            $vas = Vas::updateOrCreate($match,$val);
            if($vas->wasRecentlyCreated){
                $check = Vaccination::where('vac_id',$vas->id)->first();
                if(!$check)
                    $this->generateVaccinationDate($vas->id,date('Y-m-d'));
            }
        }
        unlink($path);
        return redirect()->back();
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if(!$row[0])
                    break;
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);

            }
            fclose($handle);
        }

        return $data;
    }

    public function transferVas()
    {
        $date = Session::get('vaccination_date');
        $date = ($date) ? $date: date('Y-m-d');

        $data = Vas::leftJoin('vaccinations','vaccinations.vac_id','=','vas.id')
            ->where('vaccination_date',$date)
            ->where('facility','Cebu South Medical Center')
            ->get();
        foreach($data as $row)
        {
            $where = array(
                'firstname' => $row->firstname,
                'lastname' => $row->lastname,
                'middlename' => $row->middlename,
            );
            $dose = 'date_1';
            $vaccinator = 'vaccinator_1';
            if($row->dose2 == '01_Yes'){
                $dose = 'date_2';
                $vaccinator = 'vaccinator_2';
            }

            $vims = FinalList::where($where)->first();
            if($vims){
                $match = array(
                    'emp_id' => $vims->id
                );
                $update = array(
                    $dose => $row->vaccination_date,
                    'type' => $row->vaccine_manufacturer,
                    $vaccinator => $row->vaccinator
                );
                Vaccine::updateOrCreate($match,$update);
            }
        }
        return redirect()->back();
    }
}

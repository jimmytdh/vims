<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\CategoryID;
use App\Models\CivilStatus;
use App\Models\Deferral;
use App\Models\Refusal;
use App\Models\Region;
use App\Models\Vaccination;
use App\Models\Vaccinator;
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
                    return Carbon::parse($data->vaccination_date)->format('M d, Y');
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
                    $btn5 = null;
                    $dose = Vaccination::where('vac_id',$data->vac_id)->count();
                    if($dose == 1 && $data->dose1=='01_Yes'){
                        $date = Carbon::parse($data->vaccination_date)->addDay(30)->format('Y-m-d');
                        $btn5 = "<a href='#nextVisitModal' data-toggle='modal' data-backdrop='static' data-date='$date' data-id='$data->vac_id' class='btn btn-sm btn-warning'><i class='fa fa-calendar'></i></a>";
                    }
                    return "$btn1 $btn2 $btn3 $btn4 $btn5";
                })
                ->rawColumns(['fullname','deferral','action'])
                ->make(true);
        }
        return view('vas.index',compact('date'));
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
        Vaccination::where('vac_id',$id)->first()->delete();
        return redirect()->back()->with('deleted',true);
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
        $this->generateVaccinationDate($vac->id,$request->vaccination_date);
        return redirect()->back()->with($status,true);
    }

    public function generateVaccinationDate($id,$date)
    {
        $data = Vas::find($id);
        $row['consent'] = '01_Yes';
        $age = Carbon::parse($data->birthdate)->diff(Carbon::now())->format('%y');
        $row['question_01'] = ($age > 16) ? '01_Yes' : '02_No';
        for($i=2; $i<=18;$i++)
        {
            $question = "question_".str_pad($i,2,0,STR_PAD_LEFT);
            if( $i==9 || $i==17){
                continue;
            }
            $row[$question] = '02_No';
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
        $deferral = Deferral::get();
        $questions = $this->questions();
        $id = $data->id;
        return view('load.health',compact(
            'data',
            'deferral',
            'questions',
            'id'
        ));
    }

    static function questions()
    {
        $data[] = "Age more than 16 years old?";
        $data[] = "Has no allergies to PEG or polysorbate?";
        $data[] = "Has no severe allergic reaction after the 1st dose of the vaccine?";
        $data[] = "Has no allergy to food, egg, medicines, and no asthma?";
        $data[] = "If with allergy or asthma, will the vaccinator able to monitor the patient for 30 minutes?";
        $data[] = "Has no history of bleeding disorders or currently taking anti-coagulants?";
        $data[] = "If with bleeding history, is a gauge 23 - 25 syringe available for injection?";
        $data[] = "Does not manifest any of the following symptoms: Fever/chills, Headache, Cough, Colds, Sore throat,  Myalgia, Fatigue, Weakness, Loss of smell/taste, Diarrhea, Shortness of breath/ difficulty in breathing";
        $data[] = "If manifesting any of the mentioned symptom/s, specify all that apply";
        $data[] = "Has no history of exposure to a confirmed or suspected COVID-19 case in the past 2 weeks?";
        $data[] = "Has not been previously treated for COVID-19 in the past 90 days?";
        $data[] = "Has not received any vaccine in the past 2 weeks?";
        $data[] = "Has not received convalescent plasma or monoclonal antibodies for COVID-19 in the past 90 days?";
        $data[] = "Not Pregnant?";
        $data[] = "If pregnant, 2nd or 3rd Trimester?";
        $data[] = "Does not have any of the following: HIV, Cancer/ Malignancy, Underwent Transplant, Under Steroid Medication/ Treatment, Bed Ridden, terminal illness, less than 6 months prognosis";
        $data[] = "If with mentioned condition/s, specify.";
        $data[] = "If with mentioned condition, has presented medical clearance prior to vaccination day?";

        return $data;
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

    public function exportData()
    {
        $fileName = date('(m-d-Y)').'_CBC05596_CebuSouthMedicalCenter'.'.csv';
        $date = Session::get('vaccination_date');
        $date = ($date) ? $date: date('Y-m-d');
        $data = Vas::leftJoin('vaccinations','vaccinations.vac_id','=','vas.id')->where('vaccination_date',$date)->orderBy('lastname','asc')->get();

        //whereRaw('LENGTH(philhealthid) > 3')
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = $this->header();
        $callback = function() use ($data, $columns){
            $file = fopen('php://output','w');
            $row = array();
            fputcsv($file,$columns);
            foreach($data as $list){
                foreach($columns as $col){
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
}

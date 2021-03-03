<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\CategoryID;
use App\Models\CivilStatus;
use App\Models\Classification;
use App\Models\EmploymentStatus;
use App\Models\FinalList;
use App\Models\Profession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class ListController extends Controller
{
    public function index()
    {
        $countRecords = count($this->readFiles());
        return view('admin.list',compact(
            'countRecords'
        ));
    }

    public function data()
    {
        $data = FinalList::select(
                                'firstname',
                                'middlename',
                                'lastname',
                                'suffix',
                                'birthdate',
                                'covid_history',
                                'consent',
                                'id',
                                'sex',
                                'updated_at',
                            )
                            ->orderBy('lastname','asc')->get();
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
            ->addColumn('date_updated',function ($data){
                $date = Carbon::parse($data->updated_at)->format('m/d h:ia');
                return "<span class='text-danger'>$date</span>";
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
            ->addColumn('with_allergy', function($data){
                $header = array(
                    'allergy_01',
                    'allergy_02',
                    'allergy_03',
                    'allergy_04',
                    'allergy_05',
                    'allergy_06',
                    'allergy_07',
                );
                foreach($header as $row){
                    $allergy = FinalList::where('id',$data->id)
                            ->where($row,'01_Yes')
                            ->first();
                    if($allergy)
                        return '<span class="text-danger">With Allergy</span>';
                }
                return 'No';
            })
            ->addColumn('with_comorbidity', function($data){
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
                    $comorbidity = FinalList::where('id',$data->id)
                        ->where($row,'01_Yes')
                        ->first();
                    if($comorbidity)
                        return '<span class="text-danger">With Comorbidity</span>';
                }
                return 'No';
            })
            ->addColumn('action', function($data){
                $url = route('list.edit',$data->id);
                $urlCard = route('list.card',$data->id);
                $deleteUrl = url('/list/delete/'.$data->id);
                $btn1 = "<a href='$url' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></a>";
                $btn2 = "<a href='#deleteModal' data-toggle='modal' data-backdrop='static' data-url='$deleteUrl' data-title='Delete Record?' data-id='$data->id' class='btnDelete btn btn-sm btn-danger'><i class='fa fa-trash'></i></a>";
                $btn3 = "<a href='$urlCard' target='_blank' class='btn btn-sm btn-info'><i class='fa fa-id-card'></i></a>";
                return "$btn1 $btn2 $btn3";
            })
            ->rawColumns(['date_updated','fullname','with_allergy','with_comorbidity','history','consent','action'])
            ->toJson();
    }

    public function fix()
    {
        if(request()->ajax()) {
            $data = FinalList::select(
                            'id',
                            'firstname',
                            'middlename',
                            'lastname',
                            'suffix',
                            'philhealthid',
                            'region',
                            'province',
                            'muncity',
                            'barangay',
                        )
//                        ->where('philhealthid','LIKE',"%+%")
//                        ->orwhereRaw('LENGTH(philhealthid) < 5')
                        ->orwhere('muncity','NOT LIKE',"%7%")
                        ->orwhere('barangay','NOT LIKE',"%7%")
                        ->orderBy('lastname','asc')->get();
            return DataTables::of($data)
                ->addColumn('fullname',function ($data){
                    $middlename = substr($data->middlename,0,1);
                    $suffix = ($data->suffix!='NA') ? $data->suffix: '';
                    $url = url('list/edit/'.$data->id);
                    return "<a href='$url' target='_blank' class='text-success'>$data->lastname, $data->firstname $middlename. $suffix</a>";
                })
                ->addColumn('philhealthid',function ($data){
                    return "<span class='edit' data-pk='$data->id' id='philhealthid' data-title='PhilHealth ID'>$data->philhealthid</span>";
                })
                ->addColumn('muncity',function ($data){
                    return "<span class='edit' data-pk='$data->id' id='muncity' data-title='Municipality/City'>$data->muncity</span>";
                })
                ->addColumn('barangay',function ($data){
                    return "<span class='edit' data-pk='$data->id' id='barangay' data-title='Barangay'>$data->barangay</span>";
                })
                ->rawColumns(['fullname','philhealthid','muncity','barangay'])
                ->toJson();
        }
        return view('admin.fix');
    }

    public function fixUpdate(Request $req)
    {
        FinalList::find($req->pk)
            ->update([
                $req->name => $req->value
            ]);
        return 'success';
    }

    public function upload()
    {
        $data = $this->readFiles();
        $countDuplicate = 0;
        foreach($data as $row)
        {
            $row['birthdate'] = Carbon::parse($row['birthdate'])->format('Y-m-d');
            $row['firstname'] = strtoupper(utf8_encode($row['firstname']));
            $row['lastname'] = strtoupper(utf8_encode($row['lastname']));
            $row['middlename'] =strtoupper(utf8_encode($row['middlename']));

            $row['employer_name'] = "Cebu South Medical Center";
            $row['employer_address'] = "San Isidro, Talisay City, Cebu";
            $row['employer_lgu'] = "722 - CEBU";
            $row['employer_contact_no'] = "(032) 273-3226";

            $row['suffix'] = ($row['suffix']) ? $row['suffix']: 'NA';

            $match = array(
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'middlename' => $row['middlename'],
            );
            $check = FinalList::where($match)->count();
            $countDuplicate += $check;
//            if(!$check)
//                FinalList::create($row);
            FinalList::updateOrCreate($match,$row);
        }
        $this->deleteFiles();
        $status = ($countDuplicate>0) ? 'duplicate': 'saved';
        return redirect('/list/master')->with($status,$countDuplicate);
    }

    public function edit($id)
    {

        $data = FinalList::find($id);
        $with_allergy = false;
        $header = array(
            'allergy_01',
            'allergy_02',
            'allergy_03',
            'allergy_04',
            'allergy_05',
            'allergy_06',
            'allergy_07',
        );
        foreach($header as $row){
            $allergy = FinalList::where('id',$data->id)
                ->where($row,'01_Yes')
                ->first();
            if($allergy){
                $with_allergy = true;
                break;
            }
        }

        $category = Categories::get();
        $categoryID = CategoryID::get();
        $civil_status = CivilStatus::get();
        $employment_status = EmploymentStatus::get();
        $profession = Profession::get();
        $classification = Classification::get();

        return view('admin.update',compact(
            'id',
            'data',
            'with_allergy',
            'category',
            'categoryID',
            'civil_status',
            'employment_status',
            'profession',
            'classification',
        ));
    }

    public function update(Request $request, $id)
    {
        $header = $this->headerKey();
        $data = array();
        foreach($header as $row)
        {
            $post = array(
                $row => $request->$row
            );
            $data = array_merge($data,$post);
        }
        FinalList::where('id',$id)
            ->update($data);
        return redirect()->back()->with('success',true);
    }

    function readFiles()
    {
        $path = storage_path()."/app/upload/";
        $files = File::allFiles($path);
        $data = array();
        foreach($files as $file)
        {
            $d = $this->csvToArray($file);
            $data = array_merge($data,$d);
        }
        return $data;
    }

    function deleteFiles()
    {
        $path = storage_path()."/app/upload/";
        $files = File::allFiles($path);
        foreach($files as $file)
        {
            unlink($file);
        }
        return redirect()->back();
    }

    public function deleteRecord($id)
    {
        FinalList::find($id)->delete();
        return redirect()->back()->with('delete',true);
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        $headerKey = $this->headerKey();
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            fgetcsv($handle);
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if(!$row[0])
                    break;
                if (!$header)
                    $header = $row;
                else
//                    $data[] = array_combine($header, $row);
                    $data[] = array_combine($headerKey, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function uploadCSV(Request $request)
    {
        if($request->hasFile('file'))
        {
            $file_name = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('upload',$file_name);
        }

        return redirect('/list/master')->with('upload',true);
    }

    function headerKey()
    {
        return array(
            'category',
            'categoryid',
            'categoryidnumber',
            'philhealthid',
            'pwd_id',
            'lastname',
            'firstname',
            'middlename',
            'suffix',
            'contact_no',
            'full_address',
            'region',
            'province',
            'muncity',
            'barangay',
            'sex',
            'birthdate',
            'civilstatus',
            'employed',
            'direct_covid',
            'profession',
            'employer_name',
            'employer_lgu',
            'employer_address',
            'employer_contact_no',
            'preg_status',
            'allergy_01',
            'allergy_02',
            'allergy_03',
            'allergy_04',
            'allergy_05',
            'allergy_06',
            'allergy_07',
            'w_comorbidities',
            'comorbidity_01',
            'comorbidity_02',
            'comorbidity_03',
            'comorbidity_04',
            'comorbidity_05',
            'comorbidity_06',
            'comorbidity_07',
            'comorbidity_08',
            'covid_history',
            'covid_date',
            'covid_classification',
            'consent',
        );
        $data = array(
            "Category",
            "CategoryID",
            "CategoryIDnumber",
            "PhilHealthID",
            "PWD_ID",
            "Lastname",
            "Firstname",
            "Middlename",
            "Suffix",
            "Contact_no",
            "Full_address",
            "Region",
            "Province",
            "MunCity",
            "Barangay",
            "Sex",
            "Birthdate_",
            "Civilstatus",
            "Employed",
            "Direct_covid",
            "Profession",
            "Employer_name",
            "Employer_LGU",
            "Employer_address",
            "Employer_contact_no",
            "Preg_status",
            "Allergy_01",
            "Allergy_02",
            "Allergy_03",
            "Allergy_04",
            "Allergy_05",
            "Allergy_06",
            "Allergy_07",
            "W_comorbidities",
            "Comorbidity_01",
            "Comorbidity_02",
            "Comorbidity_03",
            "Comorbidity_04",
            "Comorbidity_05",
            "Comorbidity_06",
            "Comorbidity_07",
            "Comorbidity_08",
            "covid_history",
            "covid_date",
            "covid_classification",
            "Consent",
        );
        foreach($data as $row)
        {
            $str = strtolower($row);
            echo "'$str',<br>";
        }
    }

    public function export()
    {
        $fileName = 'CentralVisayas-CebuSouthMedicalCenter_'.date('(M d)').'.csv';
        $finalList = FinalList::where('muncity','LIKE',"%7%")
            ->where('barangay','LIKE',"%7%")
            ->get();

        //whereRaw('LENGTH(philhealthid) > 3')
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = $this->headerKey();
        $callback = function() use ($finalList, $columns){
            $file = fopen('php://output','w');
            $row = array();
            fputcsv($file,$columns);
            foreach($finalList as $list){
                foreach($columns as $col){
                    $row[$col] = utf8_decode($list->$col);
                }
                $row['employer_name'] = "Cebu South Medical Center";
                $row['employer_address'] = "San Isidro, Talisay City, Cebu";
                $row['employer_lgu'] = "722 - CEBU";
                $row['employer_contact_no'] = "(032) 273-3226";
                $row['suffix'] = ($row['suffix']) ? $row['suffix']: 'NA';

                fputcsv($file,$row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function generateCard($id)
    {
        $data = FinalList::find($id);
        return view('admin.card',compact('data'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\CategoryID;
use App\Models\CivilStatus;
use App\Models\Classification;
use App\Models\EmploymentStatus;
use App\Models\FinalList;
use App\Models\Profession;
use App\Models\Region;
use App\Models\Vaccine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
use PDF;

class ListController extends Controller
{
    public function index1()
    {
        $countRecords = count($this->readFiles());
        $data = FinalList::orderBy('lastname','asc')
                    ->paginate(25);

        return view('admin.list2',compact(
            'countRecords',
            'data'
        ));
    }

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
                    'id',
                    'firstname',
                    'middlename',
                    'lastname',
                    'employer_name',
                    'birthdate',
                    'sex',
                    'updated_at',
                )
                ->orderBy('lastname','asc')
                ->get();

        return DataTables::of($data)
            ->addColumn('fullname',function ($data){
                $middlename = substr($data->middlename,0,1);
                $suffix = ($data->suffix!='NA') ? $data->suffix: '';
                $name = "$data->lastname, $data->firstname $middlename. $suffix";
                return "<label class='text-success' data-id='$data->lastname'><input type='checkbox' data-id='$data->id'> $name</label>";
            })
            ->addColumn('gender',function ($data){
                return ($data->sex=='02_Male') ? 'Male' : 'Female';
            })
            ->addColumn('date_updated',function ($data){
                $date = Carbon::parse($data->updated_at)->format('m/d H:i');
                return "<span class='text-danger'>$date</span>";
            })

            ->addColumn('age', function($data){
                return Carbon::parse($data->birthdate)->diff(Carbon::now())->format('%y');
            })

            ->addColumn('action', function($data){
                $url = route('list.edit',$data->id);
                $urlCard = route('list.card',$data->id);
                $deleteUrl = url('/list/delete/'.$data->id);
                $btn1 = "<a href='$url' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></a>";
                $btn2 = "<a href='#deleteModal' data-toggle='modal' data-backdrop='static' data-url='$deleteUrl' data-title='Delete Record?' data-id='$data->id' class='btnDelete btn btn-sm btn-danger'><i class='fa fa-trash'></i></a>";
                return "$btn1 $btn2";
            })
            ->rawColumns(['date_updated','fullname','action','radio'])
            ->make(true);
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
        $update[$req->name] = $req->value;
        if($req->name=='consent'){
            $update['consent_update'] = Carbon::now();
        }
        FinalList::find($req->pk)
            ->update($update);
        return $update;
    }

    public function upload()
    {
        $data = $this->readFiles();
        $countDuplicate = 0;
        foreach($data as $row)
        {
            $row['birthdate'] = Carbon::parse($row['birthdate'])->format('Y-m-d');
            $row['firstname'] = utf8_encode(strtoupper($row['firstname']));
            $row['lastname'] = utf8_encode(strtoupper($row['lastname']));
            $row['middlename'] = utf8_encode(strtoupper($row['middlename']));
            $row['full_address'] =utf8_encode($row['full_address']);

            $row['suffix'] = ($row['suffix']) ? $row['suffix']: 'NA';
            $row['consent_update'] = Carbon::now();

            $match = array(
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'middlename' => $row['middlename'],
            );
            $check = FinalList::where($match)->first();

            if($check->consent != $row['consent']){
                $row['consent_update'] = Carbon::now();
            }
            $count = FinalList::where($match)->count();
            $countDuplicate += $count;
//            if(!$check)
//                FinalList::create($row);
            $list = FinalList::updateOrCreate($match,$row);
            VaccineController::transferToVas($list->id);
        }
        $this->deleteFiles();
        $status = ($countDuplicate>0) ? 'duplicate': 'saved';
        return redirect('/list/master')->with($status,$countDuplicate);
    }

    public function compareCSV(Request $request)
    {
        $path = null;
        $id_list = [];
        if($request->hasFile('file'))
        {

            $file_name = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('upload',$file_name);
            $path = storage_path('app/upload/'.$file_name);
        }
        $data = $this->csvToArray($path);
        foreach($data as $row)
        {
            $where['birthdate'] = Carbon::parse($row['birthdate'])->format('Y-m-d');
            $where['firstname'] = utf8_encode(strtoupper($row['firstname']));
            $where['lastname'] = utf8_encode(strtoupper($row['lastname']));
            $where['middlename'] = utf8_encode(strtoupper($row['middlename']));
            $where['consent'] =utf8_encode($row['consent']);

            $check = FinalList::where($where)->first();
            if($check){
                array_push($id_list, $check->id);
            }

        }
        $this->deleteFiles();
        Session::put('id_list',$id_list);
        return redirect()->back();
    }

    public function exportLacking()
    {
        $id_list = Session::get('id_list');
        return $this->export($id_list);
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

        $region = Region::get();
        $provinces = AreaController::getProvinces($data->region);
        $muncity = AreaController::getMuncity($data->province);
        $brgy = AreaController::getBrgy($data->muncity);

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
            'region',
            'provinces',
            'muncity',
            'brgy',
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
            $data['facility'] = $request->facility;
            $data = array_merge($data,$post);
        }
        $consent = FinalList::find($id)->consent;
        if($consent != $request->consent){
            $data['consent_update'] = Carbon::now();
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
    }

    public function export($id_list=null)
    {
        $fileName = 'CentralVisayas-CebuSouthMedicalCenter_'.date('(M d)').'.csv';
        $finalList = FinalList::select('*');
        if($id_list){
            $finalList = $finalList->whereNotIn('id',$id_list);
        }

        $finalList = $finalList->get();

        //whereRaw('LENGTH(philhealthid) > 3')
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = $this->headerKey();
        $columns['dose1'] = "dose1";
        $columns['dose2'] = "dose2";
        $columns['vaccine'] = "vaccine";
        $callback = function() use ($finalList, $columns){
            $file = fopen('php://output','w');
            $row = array();
            fputcsv($file,$columns);
            foreach($finalList as $list){
                foreach($columns as $col){
                    $row[$col] = utf8_decode($list->$col);
                }
                $dose = optional(Vaccine::where('emp_id',$list->id)->first());
                $row['suffix'] = ($row['suffix']) ? $row['suffix']: 'NA';
                $row['dose1'] = $dose->date_1;
                $row['dose2'] = $dose->date_2;
                $row['vaccine'] = $dose->type;
                fputcsv($file,$row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function generateCard($id)
    {
        $data = FinalList::where('final_lists.id',$id)
                    ->leftJoin('vaccines','vaccines.emp_id','=','final_lists.id')
                    ->first();

        $date_registered = date('M d, Y h:i a',strtotime($data->created_at));
        $barcode = "$data->firstname $data->middlename $data->lastname $data->suffix; Registered on $date_registered";
        //return view('admin.card',compact('data','barcode'));

        $title = $data->fname." ".$data->lname;
        $pdf = PDF::loadView('admin.card',compact(
            'title',
            'data',
            'barcode',
        ));
        return $pdf->setPaper('a4','landscape')
                    ->stream($title.'.pdf');
    }

    public function generateAllCard($offset,$limit)
    {
        $list = FinalList::select(
                        'category',
                        'philhealthid',
                        'lastname',
                        'middlename',
                        'firstname',
                        'suffix',
                        'contact_no',
                        'full_address',
                        'province',
                        'muncity',
                        'barangay',
                        'birthdate',
                        'sex',
                    )
                    ->where('consent','01_Yes')
                    ->offset($offset)
                    ->limit($limit)
                    ->get();
        $records = array();
        foreach($list as $row)
        {
            $records[] = $row;
        }
        $count = count($records);
//        return view('admin.cardAll',compact('records','count'));

        $pdf = PDF::loadView('admin.cardAll',compact(
            'records',
            'count'
        ));
        return $pdf->setPaper('a4','landscape')
            ->stream('VaccineCards.pdf');
    }
}

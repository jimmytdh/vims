<?php

namespace App\Http\Controllers;

use App\Models\FinalList;
use App\Models\Vaccine;
use App\Models\Vas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VaccineController extends Controller
{
    public function show($id = 0)
    {
        $data = optional(Vaccine::where('emp_id',$id)->first());
        return view('load.vaccine',compact(
            'data','id'
        ));
    }

    public function fixUpdate(Request $req)
    {
        $match = array(
            'emp_id' => $req->pk
        );
        $data = array(
            $req->name => $req->value
        );
        Vaccine::updateOrCreate($match,$data);
    }

    public function update(Request $request)
    {
        $id_list = explode(',',$request->id_list);

        foreach($id_list as $id)
        {
            if($id == null)
                return 'Empty';
            $match = array(
                'emp_id' => $id
            );
            $data = array(
                'type' => $request->type,
                'date_1' => $request->date_1,
                'lot_1' => $request->lot_1,
                'vaccinator_1' => $request->vaccinator_1,
                'date_2' => $request->date_2,
                'lot_2' => $request->lot_2,
                'vaccinator_2' => $request->vaccinator_2,
            );
            Vaccine::updateOrCreate($match,$data);
        }
    }

    public function updateSchedule(Request $request)
    {
        $id_list = explode(',',$request->id_list);

        foreach($id_list as $id)
        {
            if($id == null)
                return 'Empty';
            $match = array(
                'emp_id' => $id
            );
            $update = array(
                'schedule' => $request->date
            );
            Vaccine::updateOrCreate($match,$update);
        }
        if($request->emp_id){
            $match['emp_id'] = $request->emp_id;
            $update['schedule'] = $request->date;
            Vaccine::updateOrCreate($match,$update);
        }
    }

    public static function transfer(Request $request)
    {
        $id_list = explode(',',$request->id_list);
        $date = $request->date;

        foreach($id_list as $id)
        {
            if($id == null)
                return 'Empty';

            $list = FinalList::find($id);
            $match = array(
                'firstname' => $list->firstname,
                'middlename' => $list->middlename,
                'lastname' => $list->lastname,
                'suffix' => $list->suffix,
            );
            $data = array(
                'category' => $list->category,
                'category_id' => $list->categoryid,
                'category_id_number' => $list->categoryidnumber,
                'philhealth_id' => $list->philhealthid,
                'pwd_id' => $list->pwd_id,
                'contact_no' => $list->contact_no,
                'street_name' => $list->full_address,
                'region' => $list->region,
                'province' => $list->province,
                'muncity' => $list->muncity,
                'brgy' => $list->barangay,
                'sex' => $list->sex,
                'birthdate' => $list->birthdate,
                'facility' => 'Cebu South Medical Center',
            );
            $vac = Vas::updateOrCreate($match,$data);
            VasController::generateVaccinationDate($vac->id,$date);
        }
    }

    public static function transferToVas($id)
    {
        $date = date('Y-m-d');
        $list = FinalList::find($id);
        $match = array(
            'firstname' => utf8_decode($list->firstname),
            'middlename' => utf8_decode($list->middlename),
            'lastname' => utf8_decode($list->lastname),
            'suffix' => utf8_decode($list->suffix),
        );
        $data = array(
            'category' => $list->category,
            'category_id' => $list->categoryid,
            'category_id_number' => $list->categoryidnumber,
            'philhealth_id' => $list->philhealthid,
            'pwd_id' => $list->pwd_id,
            'contact_no' => $list->contact_no,
            'street_name' => $list->full_address,
            'region' => $list->region,
            'province' => $list->province,
            'muncity' => $list->muncity,
            'brgy' => $list->barangay,
            'sex' => $list->sex,
            'birthdate' => $list->birthdate,
            'facility' => $list->employer_name,
        );
        $vas = Vas::updateOrCreate($match,$data);
        if($vas->wasRecentlyCreated){
            VasController::generateVaccinationDate($vas->id,$date, true);
        }
    }

    public function updateGroupList(Request $request)
    {
        $id_list = explode(',',$request->id_list);

        foreach($id_list as $id)
        {
            if($id == null)
                return 'Empty';
            $match = array(
                'emp_id' => $id
            );
            $update = array(
                'list' => $request->list
            );
            Vaccine::updateOrCreate($match,$update);
        }
    }

    public function exportDosage1()
    {
        $fileName = 'List_1st_Dosage_'.date('(M d)').'.csv';
        $finalList = FinalList::select('final_lists.*','vaccines.*')
            ->leftJoin('vaccines','vaccines.emp_id','=','final_lists.id')
            ->where('date_1','!=',null)
            ->where('date_2',null)
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
            'Vaccine',
            '1st Dosage',
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
                    'type' => $list->type,
                    'date' => date('M d, Y',strtotime($list->date_1)),
                );
                fputcsv($file,$row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportDosage2()
    {
        $fileName = 'List_2nd_Dosage_'.date('(M d)').'.csv';
        $finalList = FinalList::select('final_lists.*','vaccines.*')
            ->leftJoin('vaccines','vaccines.emp_id','=','final_lists.id')
            ->where('date_1','!=',null)
            ->where('date_2','!=',null)
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
            'Vaccine',
            '1st Dosage',
            '2nd Dosage',
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
                    'type' => $list->type,
                    'date' => date('M d, Y',strtotime($list->date_1)),
                    'date2' => date('M d, Y',strtotime($list->date_2)),
                );
                fputcsv($file,$row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\FinalList;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        $search = Session::get('division');
        if(request()->ajax()) {
            $data = User::select('fname','mname','lname','suffix','designation.description as designation','division.description as division')
                ->leftJoin('designation','designation.id','=','users.designation')
                ->leftJoin('division','division.id','=','users.division');
            if($search){
                $data = $data->where('division',$search);
            }
             $data = $data
                        ->orderBy('lname','asc')
                        ->get();
            return DataTables::of($data)
                ->addColumn('fullname',function ($data){
                    $mname = substr($data->mname,0,1);
                    $suffix = ($data->suffix!='NA') ? $data->suffix: '';
                    return "<span class='text-success font-weight-bold'>$data->lname, $data->fname $mname. $suffix</span>";
                })
                ->addColumn('status',function ($data){
                    $status = $this->checkStatus($data->lname, $data->fname);
                    if($status)
                        return "<span class='text-success'>Registered</span>";
                    return "<span class='text-danger'>Not Registered</span>";
                })
                ->rawColumns(['fullname','status'])
                ->make(true);
        }
        $division = Division::orderBy('description','asc')->get();
        return view('admin.employee',compact('division'));
    }

    public function search(Request $req)
    {
        Session::put('division',$req->search);
        return redirect()->back();
    }

    public function checkStatus($lname, $fname)
    {
        $check = FinalList::where('lastname',$lname)
                    ->where('firstname',$fname)
                    ->first();
        return $check;
    }

    public function update(Request $request)
    {
        $emp = FinalList::find($request->pk);
        $division = $request->value;
        $match = array(
            'fname' => $emp->firstname,
            'lname' => $emp->lastname
        );
        $update = array(
            'division' => $division
        );
        $check = User::where($match)->first();
        if($check){
            User::where($match)->update($update);
        }else{
            $this->createNewUser($emp,$division);
        }
        return $request;
    }

    public function createNewUser($data,$division)
    {
        $data = array(
            'lname' => ucfirst(strtolower($data->lastname)),
            'fname' => ucfirst(strtolower($data->firstname)),
            'mname' => ucfirst(strtolower($data->middlename)),
            'suffix' => $data->suffix,
            'username' => strtolower($data->firstname).".".strtolower($data->lastname),
            'password' => bcrypt(strtolower($data->lname)."@csmc"),
            'designation' => 0,
            'division' => $division,
            'section' => 0,
            'user_priv' => 0,
            'status' => 0,
        );
        User::create($data);
    }

    public function importUser()
    {
        $path = storage_path('app/import/guard.csv');
        $data = array();
        $delimiter = ',';
        $header = null;
        if (($handle = fopen($path, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if(!$row[0])
                    break;

                if (!$header){
                    $header = $row;
                }else{
                    $match = array(
                        'lname' => ucfirst(strtolower(utf8_encode($row[2]))),
                        'fname' => ucfirst(strtolower(utf8_encode($row[0]))),
                        'mname' => ucfirst(strtolower(utf8_encode($row[1]))),
                    );
                    $data = array(

                        'suffix' => $row[3],
                        'username' => strtolower(utf8_encode($row[4])),
                        'password' => bcrypt(strtolower(utf8_encode($row[5])),),
                        'designation' => $row[6],
                        'division' => $row[7],
                        'section' => 0,
                        'user_priv' => 0,
                        'status' => 0,
                    );
                    User::updateOrCreate($match,$data);
                }
            }
            fclose($handle);
        }
        return 'Done!';
    }
}

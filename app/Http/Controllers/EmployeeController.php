<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\FinalList;
use App\Models\User;
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
}

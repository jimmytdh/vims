<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $data = User::select('fname','mname','lname','suffx','designation.description','division.description')
            ->leftJoin('designation','designation.id','=','users.designation')
            ->leftJoin('division','division.id','=','users.division')
            ->orderBy('lname','asc')
            ->get();
        if(request()->ajax()) {

        }
        return view('admin.employee');
    }
}

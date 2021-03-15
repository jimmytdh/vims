<?php

namespace App\Http\Controllers;

use App\Models\Vaccinator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VaccinatorController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            $doctors = Vaccinator::select('*')->get();
            return datatables()->of($doctors)
                ->addColumn('name', function($row){
                    $r = "<span class='edit' data-name='name' data-pk='$row->id' data-title='Full Name'>$row->name</span>";
                    return $r;
                })
                ->addColumn('profession', function($row){
                    $r = "<span id='profession' data-type='select' data-pk='$row->id' data-title='Profession' data-value='$row->profession'>$row->profession</span>";
                    return $r;
                })
                ->addColumn('updated_at', function($row){
                    $action = Carbon::parse($row->updated_at)->format('m/d/Y h:i a');
                    $action .= "<a href='javascript:void(0)' data-id='$row->id' class='btn btn-danger btn-cirlce btn-sm pull-right btn-delete'><i class='fa fa-trash'></i></a>";
                    return $action;
                })
                ->rawColumns(['updated_at','name','profession'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('vas.vaccinator');
    }

    public function store(Request $req)
    {
        $data = array(
            'name' => $req->name,
            'profession' => $req->profession,
        );
        Vaccinator::create($data);
    }

    public function update(Request $req)
    {
        $doc = Vaccinator::find($req->pk);
        $doc->update([
            $req->name => $req->value
        ]);
    }

    public function destroy(Request $req)
    {
        Vaccinator::find($req->id)->delete();
        return $req;
    }
}

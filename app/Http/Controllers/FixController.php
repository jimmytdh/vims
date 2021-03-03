<?php

namespace App\Http\Controllers;

use App\Models\FinalList;
use Illuminate\Http\Request;

class FixController extends Controller
{
    public function muncity()
    {
        $data = FinalList::select(
                'muncity',
                'province'
            )
            ->where('muncity','NOT LIKE',"%7%")
            ->orderBy('muncity','asc')
            ->get();
        return view('fix.muncity',compact('data'));
    }

    public function updateMuncity(Request $request)
    {
        FinalList::where('muncity','LIKE',"%$request->search%")
            ->update([
                'muncity' => $request->value
            ]);
        return redirect()->back();
    }

    public function brgy()
    {
        $data = FinalList::select(
            'muncity',
            'province',
            'barangay',
        )
            ->where('barangay','NOT LIKE',"%7%")
            ->orderBy('muncity','asc')
            ->orderBy('barangay','asc')
            ->get();
        return view('fix.brgy',compact('data'));
    }

    public function updateBrgy(Request $request)
    {
        FinalList::where('barangay','LIKE',"%$request->search%")
            ->update([
                'barangay' => $request->value
            ]);
        return redirect()->back();
    }
}

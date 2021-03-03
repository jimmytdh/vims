<?php

namespace App\Http\Controllers;

use App\Models\Allergy;
use App\Models\Categories;
use App\Models\CategoryID;
use App\Models\CivilStatus;
use App\Models\Classification;
use App\Models\Comorbidity;
use App\Models\Confirmation;
use App\Models\EmploymentStatus;
use App\Models\FinalList;
use App\Models\PersonalInfo;
use App\Models\Profession;
use App\Models\Region;
use App\Models\User;
use App\Models\UserInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegistrationController extends Controller
{
    public function index()
    {
        $personal = optional(PersonalInfo::where('user_id',Auth::id())->first());
        $confirmation = Confirmation::get();
        $category = Categories::get();
        $categoryID = CategoryID::get();
        $civil_status = CivilStatus::get();
        $employment_status = EmploymentStatus::get();
        $profession = Profession::get();
        $classification = Classification::get();

        $region = Region::get();
        $provinces = AreaController::getProvinces('07');
        $muncity = AreaController::getMuncity('0722');
        $brgy = array();

        if($personal->address_muncity)
            $brgy = AreaController::getBrgy($personal->address_muncity);
        return view('page.register',compact(
            'confirmation',
            'category',
            'categoryID',
            'civil_status',
            'employment_status',
            'profession',
            'classification',
            'region',
            'provinces',
            'muncity',
            'brgy'
        ));
    }

    public function register()
    {
        $row = $_POST;
        $row['birthdate'] = Carbon::parse($row['birthdate'])->format('Y-m-d');
        $row['firstname'] = strtoupper(utf8_encode($row['firstname']));
        $row['lastname'] = strtoupper(utf8_encode($row['lastname']));
        $row['middlename'] =strtoupper(utf8_encode($row['middlename']));

        $match = array(
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'middlename' => $row['middlename'],
        );
        $check = FinalList::where($match)->first();

        FinalList::updateOrCreate($match,$row);
        $status = ($check) ? 'duplicate': 'saved';
        return redirect()->back()->with($status,true);
    }

    public function verify(Request $req)
    {
        $data = array();
        $search = '';
        if(request()->method()=='POST')
        {

            if(strlen($req->search) > 3){
                $data = FinalList::where('firstname','like',"%$req->search%")
                    ->orwhere('lastname','like',"%$req->search%")
                    ->get();
            }

            $search = $req->search;
        }
        return view('page.verify',compact('data','search'));
    }

    public function verifyKey(Request $req)
    {
        $key = $req->key;
        if($key == '!VIMS@CSMC_'){
            Session::put('key',true);
            return 'success';
        }else{
            return 'failed';
        }
    }
}

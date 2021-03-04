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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $allergy = array(
            'allergy_01',
            'allergy_02',
            'allergy_03',
            'allergy_04',
            'allergy_05',
            'allergy_06',
            'allergy_07',
        );

        $countAllergy = FinalList::select("*");
        foreach($allergy as $a){
            $countAllergy = $countAllergy->orwhere($a,'01_Yes');
        }
        $countAllergy = $countAllergy->count();

        $comorbidity = array(
            'comorbidity_01',
            'comorbidity_02',
            'comorbidity_03',
            'comorbidity_04',
            'comorbidity_05',
            'comorbidity_06',
            'comorbidity_07',
            'comorbidity_08',
        );
        $countComorbidity = FinalList::select("*");
        foreach($comorbidity as $c){
            $countComorbidity = $countComorbidity->orwhere($c,'01_Yes');
        }
        $countComorbidity = $countComorbidity->count();
        $countHistory = FinalList::where('covid_history','01_Yes')->count();
        $countDirect = FinalList::where('direct_covid','01_Yes')->count();
        $consent = FinalList::where('consent','01_Yes')->count();
        $total = FinalList::count();
        $target = 911;
        $per = 0;
        $male = number_format(FinalList::where('sex','02_Male')->count());
        $female = number_format(FinalList::where('sex','01_Female')->count());
        if($total > 0){
            $per = number_format(($total / $target) * 100,1);
        }

        return view('page.home',compact(
            'countAllergy',
            'countComorbidity',
            'countHistory',
            'countDirect',
            'total',
            'target',
            'per',
            'consent',
            'male',
            'female'
        ));
    }

    public function myData(Request $request)
    {
        if ($request->isMethod('post'))
        {
            return self::createDefaultValue();
        }
        $data = UserInfo::where('user_id',Auth::id())->first();
        $personal = optional(PersonalInfo::where('user_id',Auth::id())->first());
        $allergy = Allergy::where('user_id',Auth::id())->first();
        $com = Comorbidity::where('user_id',Auth::id())->first();
        $user = Auth::user();

        $confirmation = Confirmation::get();
        $category = Categories::get();
        $categoryID = CategoryID::get();
        $civil_status = CivilStatus::get();
        $employment_status = EmploymentStatus::get();
        $profession = Profession::get();
        $classification = Classification::get();

        $region = Region::get();
        $provinces = array();
        $muncity = array();
        $brgy = array();
        if($personal->address_region)
            $provinces = AreaController::getProvinces($personal->address_region);
        if($personal->address_province)
            $muncity = AreaController::getMuncity($personal->address_province);
        if($personal->address_muncity)
            $brgy = AreaController::getBrgy($personal->address_muncity);

        return view('page.data',compact(
            'data',
            'personal',
            'allergy',
            'com',
            'user',
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

    public function createDefaultValue()
    {
        $personal = new PersonalInfo();
        $personal->user_id = Auth::id();
        $personal->philhealth_id = null;
        $personal->suffix = null;
        $personal->contact_no = null;
        $personal->sex = 'Male';
        $personal->dob = null;
        $personal->civil_status = 'Single';
        $personal->address_street = null;
        $personal->address_brgy = null;
        $personal->address_muncity = null;
        $personal->address_province = null;
        $personal->address_region = null;
        $personal->save();

        $user = new UserInfo();
        $user->user_id = Auth::id();
        $user->category = 'Health Care Worker';
        $user->category_id = 'Facility ID Number';
        $user->category_id_number = null;
        $user->pwd_id = null;
        $user->employment_status = 'Government Employed';
        $user->direct_interaction = 'No';
        $user->profession = null;
        $user->employer = 'Cebu South Medical Center';
        $user->employer_province = 'City of Talisay';
        $user->employer_address = 'San Isidro, Talisay City, Cebu';
        $user->employer_contact = '(032) 273-3226';
        $user->pregnancy_status = 'Not Pregnant';
        $user->was_diagnosed = 'No';
        $user->date_result = null;
        $user->classification = null;
        $user->willing_to_vaccinated = null;
        $user->save();

        $allergy = new Allergy();
        $allergy->user_id = Auth::id();
        $allergy->drug = 'No';
        $allergy->food = 'No';
        $allergy->insect = 'No';
        $allergy->latex = 'No';
        $allergy->mold = 'No';
        $allergy->pet = 'No';
        $allergy->pollen = 'No';
        $allergy->save();

        $com = new Comorbidity();
        $com->user_id = Auth::id();
        $com->with_comorbidity = 'No';
        $com->hypertension = 'No';
        $com->heart_disease = 'No';
        $com->kidney_disease = 'No';
        $com->diabetes = 'No';
        $com->asthma = 'No';
        $com->immunodeficiency = 'No';
        $com->cancer = 'No';
        $com->others = 'No';
        $com->others_info = '';
        $com->save();

        return redirect('/mydata');

    }

    public function userUpdate(Request $req)
    {
        User::find($req->pk)
            ->update([
                $req->name => $req->value
            ]);
        return 'success';
    }

    public function personalUpdate(Request $req)
    {
        PersonalInfo::where('id',$req->pk)
            ->update([
                $req->name => $req->value
            ]);

        if($req->name=='address_region' || $req->name=='address_province' || $req->name=='address_muncity'){
            return $req->value;
        }
        return 'success';
    }

    public function dataUpdate(Request $req)
    {
        UserInfo::find($req->pk)
            ->update([
                $req->name => $req->value
            ]);
        return $req;
    }

    public function tableUpdate(Request $req, $table)
    {
        $user_id = Auth::id();
        DB::table($table)
            ->where('user_id',$user_id)
            ->update([
                $req->name => $req->value
            ]);
        return 'success';
    }

    public function dataComorbidity(Request $req)
    {
        Comorbidity::find($req->pk)
            ->update([
                $req->name => $req->value
            ]);
        return 'success';
    }
}

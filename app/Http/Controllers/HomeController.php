<?php

namespace App\Http\Controllers;

use App\Models\Allergy;
use App\Models\Categories;
use App\Models\CategoryID;
use App\Models\CivilStatus;
use App\Models\Comorbidity;
use App\Models\Confirmation;
use App\Models\EmploymentStatus;
use App\Models\PersonalInfo;
use App\Models\Profession;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('page.home');
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
            'profession'
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
        $user->pregnancy_status = 'No';
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
        $com->diabetes = 'No';
        $com->asthma = 'No';
        $com->immunodeficiency = 'No';
        $com->cancer = 'No';
        $com->others = 'No';
        $com->others_info = 'No';
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
        PersonalInfo::find($req->pk)
            ->update([
                $req->name => $req->value
            ]);
        return 'success';
    }

    public function dataUpdate(Request $req)
    {
        UserInfo::find($req->pk)
            ->update([
                $req->name => $req->value
            ]);
        return 'success';
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
}

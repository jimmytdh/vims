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
use App\Models\PersonalInfo;
use App\Models\Profession;
use App\Models\Region;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function register(Request $req)
    {
        $username = strtolower($req->lname).".".strtolower($req->fname);
        $check = User::where('username',$username)
            ->first();
        if($check)
            return redirect()->back()->with('duplicate',true);

        $dataUser = array(
            'fname' => ucwords(strtolower($req->fname)),
            'lname' => ucwords(strtolower($req->lname)),
            'mname' => ucwords(strtolower($req->mname)),
            'username' => strtolower($req->lname).".".strtolower($req->fname),
            'password' => bcrypt('user1234'),
            'designation' => 0,
            'division' => 0,
            'section' => 0,
            'user_priv' => 0,
            'status' => 0,
        );

        $user = User::create($dataUser);

        $dataPersonalInfo = array(
            'user_id' => $user->id,
            'philhealth_id' => $req->philhealth_no,
            'suffix' => strtoupper($req->suffix),
            'contact_no' => $req->contact_no,
            'sex' => $req->sex,
            'dob' => $req->dob,
            'civil_status' => $req->civil_status,
            'address_street' => $req->address_street,
            'address_brgy' => $req->address_brgy,
            'address_muncity' => $req->address_muncity,
            'address_province' => $req->address_province,
            'address_region' => $req->address_region,
        );
        PersonalInfo::create($dataPersonalInfo);

        $dataUserInfo = array(
            'user_id' => $user->id,
            'category' => $req->category,
            'category_id' => $req->category_id,
            'category_id_number' => $req->category_id_number,
            'pwd_id' => $req->pwd_id,
            'employment_status' => $req->employment_status,
            'direct_interaction' => $req->direct_interaction,
            'profession' => $req->profession,
            'employer' => $req->employer,
            'employer_province' => $req->employer_province,
            'employer_address' => $req->employer_address,
            'employer_contact' => $req->employer_contact,
            'pregnancy_status' => $req->pregnant_status,
            'was_diagnosed' => $req->was_diagnosed,
            'date_result' => $req->date_result,
            'classification' => $req->classification,
            'willing_to_vaccinated' => $req->willing_to_vaccinated,
        );
        UserInfo::create($dataUserInfo);

        $dataAllergies = array(
            'user_id' => $user->id,
            'drug' => $req->drug,
            'food' => $req->food,
            'insect' => $req->insect,
            'latex' => $req->latex,
            'mold' => $req->mold,
            'pet' => $req->pet,
            'pollen' => $req->pollen,
        );
        Allergy::create($dataAllergies);

        $dataComorbidities = array(
            'user_id' => $user->id,
            'with_comorbidity' => $req->with_comorbidity,
            'hypertension' => $req->hypertension,
            'heart_disease' => $req->heart_disease,
            'kidney_disease' => $req->kidney_disease,
            'diabetes' => $req->diabetes,
            'asthma' => $req->asthma,
            'immunodeficiency' => $req->immunodeficiency,
            'cancer' => $req->cancer,
            'others' => $req->others,
            'others_info' => "",
        );
        Comorbidity::create($dataComorbidities);

        return redirect()->back()->with('success',true);
    }
}

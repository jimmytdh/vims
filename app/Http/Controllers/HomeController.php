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
use App\Models\Facility;
use App\Models\FinalList;
use App\Models\PersonalInfo;
use App\Models\Profession;
use App\Models\Region;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Vaccine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $facilities = Facility::orderBy('name','asc')->get();
        $vaccinated = Vaccine::where('date_1','<>',null)
                            ->orwhere('date_2','<>',null)
                            ->count();
        $target = 911;
        $per = number_format(($vaccinated / $target) * 100,1);
        return view('page.index',compact('facilities','vaccinated','target','per'));
    }
    public function index2()
    {

        $consent = FinalList::where('consent','01_Yes')->count();
        $total = FinalList::count();
        $target = 911;
        $per = 0;
        $male = number_format(FinalList::where('sex','02_Male')->count());
        $female = number_format(FinalList::where('sex','01_Female')->count());
        $yesPer = 0;
        if($total > 0){
            $per = number_format(($total / $target) * 100,1);
            $yesPer = number_format(($consent / $total) * 100,1);
        }

        return view('page.home',compact(
            'total',
            'target',
            'per',
            'consent',
            'male',
            'female',
            'yesPer'
        ));
    }

    public function chart(){
        return array(
            'today' => Vaccine::where('schedule',Carbon::today())->count(),
            'tomorrow' => Vaccine::where('schedule',Carbon::tomorrow())->count(),
            'v_today' => Vaccine::where('date_1',Carbon::today())->count(),
            'v_dosage1' => Vaccine::where('date_1','<>',null)->count(),
            'area' => $this->transactionChart(),
            'donut' => $this->categoricalChart(),
        );
    }

    public function transactionChart()
    {
        $data['label'] = array();
        $data['nsd'] = array();
        $data['mpsd'] = array();
        $data['mcc'] = array();
        $data['hopss'] = array();
        $data['fms'] = array();
        $data['qmd'] = array();

        for($i=0; $i<=6; $i++)
        {
            $date = Carbon::now()->addDay(-6)->addDay($i);
            $start = Carbon::parse($date)->startOfDay();
            $end = Carbon::parse($date)->endOfDay();
            $data['label'][] = $date->format("M d");
            $data['mcc'][] = $this->countVaccinated($start,$end,1);
            $data['hopss'][] = $this->countVaccinated($start,$end,2);
            $data['mpsd'][] = $this->countVaccinated($start,$end,3);
            $data['nsd'][] = $this->countVaccinated($start,$end,4);
            $data['fms'][] = $this->countVaccinated($start,$end,5);
            $data['qmd'][] = $this->countVaccinated($start,$end,6);
        }
        return $data;
    }

    public function countVaccinated($start,$end,$division)
    {
        $list = Vaccine::leftJoin('final_lists','final_lists.id','=','vaccines.emp_id')
                    ->whereBetween('date_1',[$start,$end])
                    ->get();
        $count = 0;
        foreach($list as $row){
            $c = User::where('fname',$row->firstname)
                    ->where('lname',$row->lastname)
                    ->where('division',$division)
                    ->count();
            $count += $c;
        }
        return $count;
    }

    public function categoricalChart(){
        $data['vaccinated'] = Vaccine::where('date_1','<>',null)
                                ->orwhere('date_2','<>',null)
                                ->count();
        $data['waiting'] = FinalList::leftJoin('vaccines','vaccines.emp_id','=','final_lists.id')
                                ->where('consent','01_Yes')
                                ->where('date_1',null)
                                ->count();
        return $data;
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

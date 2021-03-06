<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\QuickCount;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuickCountController extends Controller
{
    static function countReport($col,$date = false)
    {
        if(!$date){
            $date = Session::get('report_date');
        }
        $date = ($date) ? $date: date('Y-m-d');
        if($col=='02a')
            return Vaccination::where('vaccine_manufacturer','Astrazeneca')->where('vaccination_date',$date)->count();
        else if($col=='02a_all')
            return Vaccination::where('vaccine_manufacturer','Astrazeneca')->count();
        else if($col=='02b')
            return Vaccination::where('vaccine_manufacturer','Sinovac')->where('vaccination_date',$date)->count();
        else if($col=='02b_all')
            return Vaccination::where('vaccine_manufacturer','Sinovac')->count();
        else if($col=='05')
            return Vaccination::where('deferral','!=',"")->where('vaccination_date',$date)->count();
        else if($col=='06')
            return Vaccination::where('status','Previous deferral')->where('vaccination_date',$date)->count();
        else if($col=='07')
            return Vaccination::where('consent','02_No')->where('vaccination_date',$date)->count();
        else if($col=='08')
            return Vaccination::where('status','Previous refusal')->where('vaccination_date',$date)->count();
        else if($col=='09')
            return Vaccination::leftJoin('vas','vas.id','=','vaccinations.vac_id')->where('category','01_Health_Care_Worker')->where('dose1','01_Yes')->where('vaccination_date',$date)->count();
        else if($col=='10')
            return Vaccination::leftJoin('vas','vas.id','=','vaccinations.vac_id')->where('category','01_Health_Care_Worker')->where('dose2','01_Yes')->where('vaccination_date',$date)->count();
        else if($col=='13')
            return Vaccination::leftJoin('vas','vas.id','=','vaccinations.vac_id')->where('category','04_Uniformed_Personnel')->where('dose1','01_Yes')->where('vaccination_date',$date)->count();
        else if($col=='14')
            return Vaccination::leftJoin('vas','vas.id','=','vaccinations.vac_id')->where('category','04_Uniformed_Personnel')->where('dose2','01_Yes')->where('vaccination_date',$date)->count();
        else if($col=='15')
            return Vaccination::leftJoin('vas','vas.id','=','vaccinations.vac_id')->where('category','!=','01_Health_Care_Worker')->where('category','!=','04_Uniformed_Personnel')->where('dose1','01_Yes')->where('vaccination_date',$date)->count();
        else if($col=='16')
            return Vaccination::leftJoin('vas','vas.id','=','vaccinations.vac_id')->where('category','!=','01_Health_Care_Worker')->where('category','!=','04_Uniformed_Personnel')->where('dose2','01_Yes')->where('vaccination_date',$date)->count();
        else if($col=='17')
            return Vaccination::where('status','AEFI reported')->where('vaccination_date',$date)->count();
        else if($col=='18')
            return Vaccination::where('status','Serious AEFI')->where('vaccination_date',$date)->count();
        else if($col=='19')
            return Vaccination::where('status','Death related to AEFI')->where('vaccination_date',$date)->count();
        else if($col=='today')
            return Vaccination::whereNotNull('vaccine_manufacturer')->where('vaccination_date',$date)->count();
        else if($col=='total')
            return Vaccination::whereNotNull('vaccine_manufacturer')->count();
        return 0;
    }
    public function header()
    {
        return array(
            '02a' => 'Astrazeneca',
            '02b' => 'Sinovac',
            '03' => 'Vaccines(vials) delivered',
            '05' => 'Deferrals',
            '06' => 'Previous deferrals vaccinated today',
            '07' => 'Refusals',
            '08' => 'Previous refusals vaccinated today',
            '09' => 'Priority A1: 1st Dose',
            '10' => 'Priority A1: 2nd Dose',
            '13' => 'Priority A4: 1st Dose',
            '14' => 'Priority A4: 2nd Dose',
            '15' => 'Other Priority: 1st Dose',
            '16' => 'Other Priority: 2nd Dose',
            '17' => 'AEFI reported',
            '18' => 'Serious AEFI',
            '19' => 'Deaths related to AEFI',
            '20' => 'Problem with vaccination site logistics',
            '21' => 'Problem with vaccination team',
            '22' => 'Problem with vaccine recipeints',
            '23' => 'Problem with vaccination site',
        );
    }

    public function index()
    {
        $header = $this->header();
        $date = Session::get('report_date');
        $date = ($date) ? $date: date('Y-m-d');
        $data = optional(QuickCount::where('report_date',$date)->first());
        $facilities = Facility::orderBy('name','asc')->get();
        return view('cbcr.index',compact('header','date','data','facilities'));
    }

    public function changeDate(Request $req)
    {
        Session::put('report_date',$req->report_date);
        return redirect()->back();
    }

    public function update()
    {
        $row = $_POST;
        $date = Session::get('report_date');
        $date = ($date) ? $date: date('Y-m-d');
        $match = array(
            'report_date' => $date
        );
        QuickCount::updateOrCreate($match,$row);
        return redirect()->back();
    }

    public static function countPerFacility($facility)
    {
        $date = Session::get('report_date');
        $date = ($date) ? $date: date('Y-m-d');
        $count = Vaccination::leftJoin('vas','vas.id','=','vaccinations.vac_id')
                    ->where('vaccination_date',$date)
                    ->where(function($q) {
                        $q->where('dose1','01_Yes')
                            ->orwhere('dose2','01_Yes');
                    })
                    ->where('facility',$facility)
                    ->count();
        return $count;
    }

    public static function countVaccinated($facility = null ,$vaccine = null,$date = null)
    {
        $data = Vaccination::select('vac_id')
            ->leftJoin('vas','vas.id','=','vaccinations.vac_id');
        if($facility){
            $data = $data->where('facility',$facility);
        }
        if($vaccine){
            $data = $data->where('vaccine_manufacturer',$vaccine);
        }

        if($date){
            $data = $data->where('vaccination_date',$date);
        }

        $data = $data->where(function($q) {
                            $q->where('dose1','01_Yes')
                                ->orwhere('dose2','01_Yes');
                        })
                    ->groupBy('vac_id')
                    ->get();
        return count($data);
    }
}

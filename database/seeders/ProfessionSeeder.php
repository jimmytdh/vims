<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            'Dental_Hygienist',
            'Dental_Technologist',
            'Dentist',
            'Medical_Technologist',
            'Midwife',
            'Nurse',
            'Nutritionist_Dietician',
            'Occupational_Therapist',
            'Optometrist',
            'Pharmacist',
            'Physical_Therapist',
            'Physician',
            'Radiologic_Technologist',
            'Respiratory_Therapist',
            'X_ray_Technologist',
            'Barangay_Health_Worker',
            'Maintenance_Staff',
            'Administrative_Staff',
            'Others',
        );
        foreach($data as $d){
            $str = str_replace("_"," ",$d);
            Profession::create([
                'name' => $str
            ]);
        }
    }
}

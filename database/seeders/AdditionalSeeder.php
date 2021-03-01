<?php

namespace Database\Seeders;

use App\Models\CategoryID;
use App\Models\CivilStatus;
use App\Models\Confirmation;
use App\Models\EmploymentStatus;
use Illuminate\Database\Seeder;

class AdditionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            'PRC_number',
            'OSCA_number',
            'Facility_ID_number',
            'Other_ID',

        );
        foreach($data as $d){
            $str = str_replace("_"," ",$d);
            CategoryID::create([
                'name' => $str
            ]);
        }

        $data = array(
            'Single',
            'Married',
            'Widow/Widower',
            'Separated/Annulled',
            'Living_with_Partner',
        );
        foreach($data as $d){
            $str = str_replace("_"," ",$d);
            CivilStatus::create([
                'name' => $str
            ]);
        }

        $data = array(
            'Government_Employed',
            'Private_Employed',
            'Self_employed',
            'Private_practitioner',
            'Others',
        );
        foreach($data as $d){
            $str = str_replace("_"," ",$d);
            EmploymentStatus::create([
                'name' => $str
            ]);
        }

        $data = array(
            'Yes',
            'No'
        );
        foreach($data as $d){
            $str = str_replace("_"," ",$d);
            Confirmation::create([
                'name' => $str
            ]);
        }

    }
}

<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;

class AdditionalCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            'Comorbidities',
            'Teachers_Social_Workers',
            'Other_Govt_Wokers',
            'Other_High_Risk',
            'OFW',
            'Remaining_Workforce'
        );

        foreach($data as $d){
            $str = str_replace("_"," ",$d);
            Categories::create([
                'name' => $str
            ]);
        }
    }
}

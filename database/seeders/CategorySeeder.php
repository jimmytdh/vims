<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            'Health_Care_Worker',
            'Senior_Citizen',
            'Indigent',
            'Uniformed_Personnel',
            'Essential_Worker',
            'Other',

        );
        foreach($data as $d){
            $str = str_replace("_"," ",$d);
            Categories::create([
                'name' => $str
            ]);
        }
    }
}

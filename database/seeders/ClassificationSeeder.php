<?php

namespace Database\Seeders;

use App\Models\Classification;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            'Asymptomatic',
            'Mild',
            'Moderate',
            'Severe',
            'Critical',

        );
        foreach($data as $d){
            $str = str_replace("_"," ",$d);
            Classification::create([
                'name' => $str
            ]);
        }
    }
}

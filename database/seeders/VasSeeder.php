<?php

namespace Database\Seeders;

use App\Models\Deferral;
use App\Models\Refusal;
use Illuminate\Database\Seeder;

class VasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            'Fever',
            'Headache',
            'Cough',
            'Colds',
            'Sore Throat',
            'Shortness of Breath or Difficulty in Breathing',
            'Chest Pain',
            'Abdominal Pain',
            'Changes in Bowel Movement',
            'Loss of taste/smell',
            'Fatigue/weakness',
            'COVID-19 in the past 90 days?',
            'Bleeding disorder or blood thinner',
            'Autoimmune disorder, HIV, AIDS, Cancer',
            'Received any vaccine 4 weeks ago',
            'Reaction from any previous vaccine?',
            'Pregnant, Breastfeeding, Planning Pregnancy',
            'Multiple conditions',
            'Hypertension',
        );
        foreach($data as $d){
            Deferral::create([
                'name' => $d
            ]);
        }

        $data = array(
            'I do not think this vaccine is safe',
            'I do not think this vaccine is effective',
            'I do not trust a vaccine that has come from another country',
            'I have religious beliefs that do not allow me to be vaccinated',
            'Others'
        );

        foreach($data as $d){
            Refusal::create([
                'name' => $d
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = \App\PersonalInformation::all();
        foreach ($employees as $employee) {
            $benefit = new \App\BenefitSchedule();
            $benefit->personal_information_id = $employee->id;
            $benefit->nosi = $employee->getlatestplantillacontent() ? ($employee->getlatestplantillacontent()->last_promotion ? $employee->getlatestplantillacontent()->last_promotion : $employee->getlatestplantillacontent()->original_appointment) : null;
            $benefit->save();
        }
    }
}

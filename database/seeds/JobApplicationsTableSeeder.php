<?php

use Illuminate\Database\Seeder;
// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class JobApplicationsTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();
        $employee = \App\Models\Employee::all();
        foreach (range(1, 10) as $index) {
            \App\Models\JobApplication::create([
                'job_id' => rand(1, 3),
                'name' => $faker->firstName,
                'email' => $faker->email,
                'company_id' => rand(1, 2),
                'phone' => $faker->phoneNumber,
                'cover_letter' => $faker->paragraph,
                'submitted_by' => $employee[rand(0, count($employee) - 1)]->employeeID
            ]);
        }
    }

}

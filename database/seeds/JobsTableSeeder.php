<?php

use Illuminate\Database\Seeder;
// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class JobsTableSeeder extends Seeder
{

    public function run()
    {
        \DB::table('jobs')->delete(); // deleting old records.
        $faker = Faker::create();
        $designation = \App\Models\Designation::all();
        $companies = \App\Models\Company::all();

        foreach ($companies as $company) {

            foreach (range(1, 3) as $index) {
                \App\Models\Job::create([
                    'position' => $designation[rand(0, count($designation) - 1)]->designation,
                    'description' => $faker->paragraph,
                    'company_id' => $company->id,
                    'posted_date' => \Carbon\Carbon::now(),
                    'last_date' => \Carbon\Carbon::now()->addDays(rand(1, 30)),
                    'close_date' => \Carbon\Carbon::now()->addDays(rand(30, 31)),
                    'status' => 'active'
                ]);
            }
        }

    }

}

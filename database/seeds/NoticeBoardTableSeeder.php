<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class NoticeBoardTableSeeder extends Seeder
{

    public function run()
    {

        DB::table('noticeboards')->truncate(); // deleting old records.
        $faker = Faker::create();

        $companies = \App\Models\Company::all();

        foreach ($companies as $company) {

            for ($i = 0; $i < 10; $i++) {
                \App\Models\Noticeboard::create([
                    'title' => $faker->realText(50),
                    'company_id' => $company->id,
                    'description' => $faker->realText(100),
                    'status' => 'active'
                ]);
            }
        }

    }

}

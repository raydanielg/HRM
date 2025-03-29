<?php

use Illuminate\Database\Seeder;
// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class PayrollsTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            \App\Models\Payroll::create([

            ]);
        }
    }

}

<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\Leavetype;

class LeaveTypeTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('leavetypes')->truncate(); // deleting old records.
        $companies = \App\Models\Company::all();

        foreach ($companies as $company) {

            Leavetype::create([

                'leaveType' => 'sick',
                'num_of_leave' => 5,
                'company_id' => $company->id
            ]);

            Leavetype::create([
                'leaveType' => 'casual',
                'num_of_leave' => 5,
                'company_id' => $company->id
            ]);
            
            Leavetype::create([

                'leaveType' => 'maternity',
                'num_of_leave' => 0,
                'company_id' => $company->id
            ]);
            Leavetype::create([

                'leaveType' => 'annual',
                'num_of_leave' => 0,
                'company_id' => $company->id
            ]);
            Leavetype::create([
                'leaveType' => 'unpaid',
                'num_of_leave' => 0,
                'company_id' => $company->id
            ]);
            Leavetype::create([
                'leaveType' => 'others',
                'num_of_leave' => 0,
                'company_id' => $company->id
            ]);
        }

    }

}

<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\Designation;

class DepartmentTableSeeder extends Seeder
{

    public function run()
    {

        DB::table('department')->truncate(); // deleting old records.

        DB::table('designation')->truncate(); // deleting old records.

        $departments = ['PHP Developer', 'Android Developer', 'Laravel Developer', 'Human Resource'];
        $designations = ['Fresher', 'Senior'];

        $companies = \App\Models\Company::all();
        foreach ($companies as $company) {

            foreach ($departments as $department) {
                $dept = Department::create([
                    'name' => $department,
                    'company_id' => $company->id

                ]);

                foreach ($designations as $designation) {
                    Designation::create([
                        'department_id' => $dept->id,
                        'designation' => $designation . ' '.$department
                    ]);
                }
            }
        }

    }

}

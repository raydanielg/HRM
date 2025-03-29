<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employeePerDesignationCount = 1;
        \Illuminate\Support\Facades\DB::table('employees')->truncate(); // deleting old records.
        DB::table('awards')->truncate(); // deleting old records.

        $faker = Faker\Factory::create();

        \App\Models\Employee::create([
            'employeeID' => '123456',
            'full_name' => $faker->firstName . ' ' . $faker->lastName,
            'email' => 'employee@example.com',
            'password' => '123456',
            'gender' => $faker->randomElement(['male', 'female']),
            'father_name' => $faker->name,
            'mobile_number' => $faker->e164PhoneNumber,
            'designation' => rand(1, 4),
            'joining_date' => $faker->dateTimeBetween('-2 years')->format('Y-m-d'),
            'local_address' => $faker->address, 'permanent_address' => $faker->address,
            'status' => 'active',
            'company_id' => 1,
            'last_login' => $faker->dateTime,
        ]);

        $companies = \App\Models\Company::all();
        $companiesCount = count($companies);

        foreach ($companies as $company) {

            $this->command->info('Seeding company employees:' . $company->id . ' out of ' . $companiesCount);
            $departments = $company->departments;

            foreach ($departments as $department) {

                foreach ($department->designations as $designation) {

                    for ($i = 0; $i < $employeePerDesignationCount; $i++) {

                        $employeeID = $faker->randomNumber(9);

                        $employee = \App\Models\Employee::create([
                            'employeeID' => $employeeID,
                            'full_name' => $faker->firstName . ' ' . $faker->lastName,
                            'email' => $faker->email,
                            'password' => '123456',
                            'gender' => $faker->randomElement(['male', 'female']),
                            'father_name' => $faker->name,
                            'mobile_number' => $faker->e164PhoneNumber,
                            'designation' => $designation->id,
                            'joining_date' => $faker->dateTimeBetween('-2 years')->format('Y-m-d'),
                            'local_address' => $faker->address,
                            'permanent_address' => $faker->address,
                            'status' => 'active',
                            'company_id' => $company->id,
                            'last_login' => $faker->dateTime,
                        ]);

                        \App\Models\Award::create([
                            'employee_id' => $employee->id,
                            'award_name' => 'Employee of the Month',
                            'gift' => 'pen',
                            'company_id' => $company->id,
                            'cash_price' => rand(100, 4000),
                            'month' => strtolower($faker->monthName),
                            'year' => '2019'

                        ]);
                    }

                }

            }

        }

    }
}

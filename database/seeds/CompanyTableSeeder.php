<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class CompanyTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('companies')->delete(); // deleting old records.
        DB::table('companies')->truncate(); // Truncating old records.

        $faker = Faker::create();
        Company::create([
            'company_name' => 'Froiden Technologies Private Ltd',
            'email' => 'admin@hrm.com',
            'name' => 'HRM ADMIN',
            'currency' => 'INR',
            'contact' => $faker->e164PhoneNumber,
            'address' => $faker->address,
            'billing_address' => $faker->address,
            'currency_symbol' => '₹',
            'admin_theme' => 'light',
            'front_theme' => 'dark-blue',
            'active' => 1,
            'office_start_time' => '09:30:00',
            'office_end_time' => '18:36:00',
            'attendance_setting_set' => 1,
            'status' => 'active'
        ]);


        Company::create([
            'company_name' => 'HRM SAAS',
            'email' => 'ajay@huntplex.com',
            'name' => 'Administrator',
            'currency' => 'INR',
            'contact' => $faker->e164PhoneNumber,
            'address' => $faker->address,
            'billing_address' => $faker->address,
            'currency_symbol' => '₹',
            'admin_theme' => 'light',
            'front_theme' => 'dark-blue',
            'office_start_time' => '09:30:00',
            'office_end_time' => '18:36:00',
            'attendance_setting_set' => 1,
            'active' => 0,
            'status' => 'active'
        ]);

        foreach (range(1, 4) as $index) {

            Company::create([
                'company_name' => $faker->company,
                'email' => $faker->companyEmail,
                'name' => $faker->name,
                'currency' => 'INR',
                'contact' => $faker->e164PhoneNumber,
                'address' => $faker->address,
                'billing_address' => $faker->address,
                'currency_symbol' => '₹',
                'office_start_time' => '09:30:00',
                'office_end_time' => '18:36:00',
                'admin_theme' => 'light',
                'front_theme' => 'dark-blue',
                'active' => 0,
                'status' => 'active'
            ]);
        }

    }

}

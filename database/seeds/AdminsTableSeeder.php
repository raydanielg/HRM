<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('admins')->truncate(); // deleting old records.
        $faker = Faker::create();
        Admin::create(
            [
                'name' => 'SuperAdmin',
                'email' => 'superadmin@example.com',
                'type' => 'superadmin',
                'email_verified' => 'yes',
                'password' => Hash::make('123456')

            ]
        );

        // This is basically for the demo data
        if (env('APP_ENV') != 'codecanyon') {
            Admin::create(
                [
                    'name' => 'Company 1 Admin',
                    'email' => 'admin@example.com',
                    'company_id' => '1',
                    'type' => 'admin',
                    'email_verified' => 'yes',
                    'password' => Hash::make('123456')

                ]
            );
            Admin::create(
                [
                    'name' => 'Company 2 Admin ',
                    'email' => 'admin2@example.com',
                    'company_id' => '2',
                    'type' => 'admin',
                    'email_verified' => 'yes',
                    'password' => Hash::make('123456')

                ]
            );

            $companies = \App\Models\Company::all();
            foreach ($companies as $company) {

                Admin::create(
                    [
                        'name' => $faker->name,
                        'email' => $faker->email,
                        'company_id' => $company->id,
                        'type' => 'admin',
                        'email_verified' => 'yes',
                        'password' => Hash::make('123456')

                    ]
                );
            }
        }

    }
}

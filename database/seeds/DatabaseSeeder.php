<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \Eloquent::unguard();

        $this->call('SubscriptionPlanSeeder');
        $this->command->info('SubscriptionPlanSeeder table seeded!');

        $this->call('CountriesTableSeeder');
        $this->command->info('Countries table seeded!');


        $this->call('SettingTableSeeder');
        $this->command->info('Setting table seeded!');

        $this->call('LanguageTableSeeder');
        $this->command->info('LanguageTableSeeder Table seeded');

        $this->call('EmailTemplatesTableSeeder');
        $this->command->info('EmailTemplatesTableSeeder Table seeded');

        if (env('APP_ENV') != 'codecanyon') {

            $this->call('CompanyTableSeeder');
            $this->command->info('Setting table seeded!');

            $this->call('DepartmentTableSeeder');
            $this->command->info('Department table seeded!');
            $this->command->info('Designation also table seeded!');

            $this->call('EmployeesTableSeeder');
            $this->command->info('Employees table seeded!');


            $this->call('LeaveTypeTableSeeder');
            $this->command->info('LeaveType table seeded!');

            $this->call('NoticeBoardTableSeeder');
            $this->command->info('Notice Board seeded');

            $this->call('HolidayTableSeeder');
            $this->command->info('HolidayTableSeeder  seeded');

            $this->call('JobsTableSeeder');
            $this->command->info('Jobs Table seeded');


            $this->call('JobApplicationsTableSeeder');
            $this->command->info('JobApplications Table seeded');

        }

        $this->call('AdminsTableSeeder');
        $this->command->info('Admin table seeded!');


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

}

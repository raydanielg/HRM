<?php

use Illuminate\Database\Seeder;

class HolidayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('holidays')->truncate(); // deleting old records.
        DB::table('holidays')->truncate(); // deleting old records.


        $companies = \App\Models\Company::all();

        foreach ($companies as $company) {
            $sundays = $this->getSundays();

            foreach ($sundays as $sunday) {
                \App\Models\Holiday::create([
                    'date' => $sunday,
                    'company_id' => $company->id,
                    'occassion' => 'Sunday'
                ]);
            }

        }

    }

    function getSundays()
    {
        $days = array();
        for ($month = 1; $month <= 12; $month++) {

            $y = \Carbon\Carbon::now()->format('Y');
            $date = "$y-$month-01";
            $first_day = date('N', strtotime($date));
            $first_day = 7 - $first_day + 1;
            $last_day = date('t', strtotime($date));

            for ($i = $first_day; $i <= $last_day; $i = $i + 7) {
                $days[] = $y . '-' . $month . '-' . $i;
            }
        }

        return $days;
    }
}

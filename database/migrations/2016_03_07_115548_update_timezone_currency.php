<?php

    use App\Models\Company;
    use Carbon\Carbon;
    use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTimezoneCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $faker = \Faker\Factory::create();

        \DB::beginTransaction();

        $companies = Company::join("browse_history", "browse_history.company_id", "=", "companies.id")
                ->groupBy("companies.id")->get();

        echo "This is slow migration, will take few minutes to complete\n";

        foreach($companies as $company) {
            $country = \App\Models\Country::where("name", $company->country)->first();
            if (!$country) {
                continue;
            }

            $info = \App\Http\Controllers\Controller::getIpInfo($company->ip);

            $timezone = $info["timezone"];
            $offset = Carbon::now($timezone)->format("P");

            $timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);

            $position = array_search($timezone, $timezones);

            if ($position == "") {
                $position = 0;
            }

            $company->timezone = $offset."=".$position;
            $company->currency = $country->currency_code;
            $company->currency_symbol = $country->currency_symbol;

            $company->save();
            sleep(1);
        }

        \DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

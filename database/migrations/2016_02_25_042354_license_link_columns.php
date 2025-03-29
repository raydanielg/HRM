<?php

    use App\Models\Company;
    use App\Models\License;
    use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LicenseLinkColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update company id links of existing companies
        Schema::table("licenses", function(Blueprint $table) {
            $table->unsignedInteger("company_id")->nullable()->after("license_type_id");
            $table->foreign("company_id")->references("id")->on("companies")->onUpdate("set null")->onDelete("set null");
        });

        $licenses = License::where("license_type_id", 1)->get();

        foreach($licenses as $license) {
            $company = Company::where("email", $license->email)->first();

            if ($company) {
                $license->company_id = $company->id;
                $license->save();
            }
        }

        Schema::table("transactions", function(Blueprint $table) {
            $table->char("license_number", 36)->nullable()->after("id");
            $table->foreign("license_number")->references("license_number")->on("licenses")->onUpdate("set null")->onDelete("set null");
        });
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

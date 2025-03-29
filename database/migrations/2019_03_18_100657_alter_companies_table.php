<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('plan_type');
            $table->enum('package_type', ['monthly', 'annual'])->after('subscription_plan_id')->default('monthly');
            $table->date('licence_expire_on')->after('trial_ends_at')->nullable();
        });

        \DB::statement("ALTER TABLE `companies` CHANGE `status` `status` ENUM('active','inactive','license_expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active'");
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

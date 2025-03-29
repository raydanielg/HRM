<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetDefaultCompaniesOfficeTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("UPDATE companies  SET office_start_time = '00:00:00' where companies.office_start_time is NULL");
        DB::statement("UPDATE companies  SET office_end_time = '00:00:00' where companies.office_end_time is NULL");
        DB::statement("ALTER TABLE companies CHANGE COLUMN office_start_time office_start_time TIME NULL DEFAULT '00:00:00' AFTER mark_attendance");
        DB::statement("ALTER TABLE companies CHANGE COLUMN office_end_time office_end_time TIME NULL DEFAULT '00:00:00' AFTER office_start_time");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE companies CHANGE COLUMN office_start_time office_start_time TIME NULL DEFAULT NULL AFTER mark_attendance");
        DB::statement("ALTER TABLE companies CHANGE COLUMN office_end_time office_end_time TIME NULL DEFAULT NULL AFTER office_start_time");
    }
}

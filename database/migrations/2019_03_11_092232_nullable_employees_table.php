<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `employees` MODIFY `father_name` VARCHAR(255) NULL;');
        DB::statement('ALTER TABLE `employees` MODIFY `mobile_number` VARCHAR(255) NULL;');
        DB::statement('ALTER TABLE `employees` MODIFY `local_address` VARCHAR(255) NULL;');
        DB::statement('ALTER TABLE `employees` MODIFY `permanent_address` VARCHAR(255) NULL;');
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

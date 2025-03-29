<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmployeesAdminGdprColumnsExtend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE admins MODIFY COLUMN name VARCHAR(255)');
        #\Illuminate\Support\Facades\DB::statement('ALTER TABLE admins MODIFY COLUMN email VARCHAR(255)');


        \Illuminate\Support\Facades\DB::statement('ALTER TABLE employees MODIFY COLUMN full_name VARCHAR(255)');
       # \Illuminate\Support\Facades\DB::statement('ALTER TABLE employees MODIFY COLUMN email VARCHAR(255)');

        \Illuminate\Support\Facades\DB::statement('ALTER TABLE employees MODIFY COLUMN local_address LONGTEXT');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE employees MODIFY COLUMN permanent_address LONGTEXT');

        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('gdpr')->default(0);
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

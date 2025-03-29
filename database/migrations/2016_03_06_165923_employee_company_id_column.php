<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmployeeCompanyIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table("employees", function(Blueprint $table) {
            $table->unsignedInteger("company_id")->after("employeeID");
            $table->foreign("company_id")->references("id")->on("companies")->onUpdate("cascade")->onDelete("cascade");
        });

        $employees = \App\Models\Employee::all();

        foreach($employees as $employee) {
            $employeeID = $employee->employeeID;
            $parts = explode("-", $employeeID);
            $company_id = $parts[0];
            $employee->company_id = $company_id;
            $employee->save();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::beginTransaction();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::table("employees", function(Blueprint $table) {
            $table->dropForeign("employees_company_id_foreign");
            $table->dropIndex("employees_company_id_foreign");
           $table->dropColumn("company_id");
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::commit();
    }
}

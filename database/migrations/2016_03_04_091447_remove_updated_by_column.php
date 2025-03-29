<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUpdatedByColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::beginTransaction();

        Schema::table("attendance", function(Blueprint $table) {
            $table->unsignedInteger("last_updated_by")->nullable()->after("halfDayType");
            $table->foreign("last_updated_by")
                  ->references("id")
                  ->on("admins")
                  ->onUpdate("cascade")
                  ->onDelete("cascade");
        });

        $attendances = \App\Models\Attendance::join("admins", "admins.email", "=", "attendance.updated_by")
            ->select(["admins.id as admin_id", DB::raw("attendance.*")])
            ->get();

        foreach($attendances as $attendance) {
            $attendance->last_updated_by = $attendance->admin_id;
            $attendance->save();
        }


        Schema::table("attendance", function(Blueprint $table) {
            $table->dropForeign("attendance_updated_by_foreign");
            $table->dropIndex("attendance_updated_by_index");
        });

        Schema::table("attendance", function(Blueprint $table) {
            $table->dropColumn("updated_by");
        });

        Schema::table("leave_applications", function(Blueprint $table) {
            $table->unsignedInteger("last_updated_by")->nullable()->after("halfDayType");
            $table->foreign("last_updated_by")
                  ->references("id")
                  ->on("admins")
                  ->onUpdate("cascade")
                  ->onDelete("cascade");
        });

        $leave_applications = \App\Models\LeaveApplication::join("admins", "admins.email", "=", "leave_applications.updated_by")
            ->select(["admins.id as admin_id", DB::raw("leave_applications.*")])
            ->get();

        foreach($leave_applications as $leave_application) {
            $leave_application->last_updated_by = $leave_application->admin_id;
            $leave_application->save();
        }


        Schema::table("leave_applications", function(Blueprint $table) {
            $table->dropForeign("leave_applications_updated_by_foreign");
            $table->dropIndex("leave_applications_updated_by_index");
        });

        Schema::table("leave_applications", function(Blueprint $table) {
            $table->dropColumn("updated_by");
        });

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

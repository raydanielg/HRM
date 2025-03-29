<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClockAttendenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->time('clock_in')->nullable();
            $table->time('clock_out')->nullable();
            $table->string('clock_in_ip_address',16)->nullable();
            $table->string('clock_out_ip_address',16)->nullable();
            $table->string('working_from',100)->default('Office')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropColumn('clock_in');
            $table->dropColumn('clock_out');
            $table->dropColumn('clock_in_ip_address');
            $table->dropColumn('clock_out_ip_address');
            $table->dropColumn('working_from');
            $table->dropColumn('notes');
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGdprToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dateTime('last_activity')->nullable()->default(null);
            $table->boolean('accepted_gdpr')->nullable()->default(null);
            $table->boolean('isAnonymized')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function ($table) {
            $table->dropColumn('last_activity');
            $table->dropColumn('accepted_gdpr');
            $table->dropColumn('isAnonymized');
        });
    }
}

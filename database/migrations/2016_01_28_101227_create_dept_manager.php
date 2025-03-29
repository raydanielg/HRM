<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeptManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_manager', function (Blueprint $table) {
           $table->increments('id');

            $table->unsignedInteger('department_id');
            $table->foreign('department_id')
                  ->references('id')->on('department')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->unsignedInteger('manager_id');
            $table->foreign('manager_id')
                  ->references('id')->on('admins')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('department_manager', function (Blueprint $table) {
            Schema::drop('department_manager');
        });
    }
}

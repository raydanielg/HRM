<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatesRead extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("updates_read", function(Blueprint $table) {
            $table->unsignedInteger("admin_id");
            $table->foreign("admin_id")->references("id")->on("admins")->onUpdate("cascade")->onDelete("cascade");
            $table->unsignedInteger("update_id");
            $table->foreign("update_id")->references("id")->on("updates")->onUpdate("cascade")->onDelete("cascade");
            $table->unique(["admin_id", "update_id"]);
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

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BrowseHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("browse_history", function(Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("company_id");
            $table->foreign("company_id")->references("id")->on("companies")->onUpdate("cascade")->onDelete("cascade");
            $table->unsignedInteger("admin_id");
            $table->foreign("admin_id")->references("id")->on("admins")->onUpdate("cascade")->onDelete("cascade");
            $table->string("ip");
            $table->string("route");
            $table->string("url");
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
        Schema::dropIfExists("browse_history");
    }
}

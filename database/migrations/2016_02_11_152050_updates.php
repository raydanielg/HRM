<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Updates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("updates", function(Blueprint $table) {
            $table->increments("id");
            $table->string("title", 100);
            $table->text("excerpt");
            $table->text("description");
            $table->enum("status", ["Unpublished", "Published"]);
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
        Schema::dropIfExists("updates");
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReferralMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_member', function ($table) {
            $table->increments('id');
            $table->string('referral_code');
            $table->index('referral_code');
            $table->string('email');
            $table->string('password');
            $table->string('name');
            $table->string('company_name');
            $table->text('company_address');
            $table->string('position');
            $table->string('phone',20);
            $table->string('country');
            $table->string('agreement');
            $table->dateTime('date_of_agreement');
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
        Schema::dropIfExists('referral_member');
    }
}

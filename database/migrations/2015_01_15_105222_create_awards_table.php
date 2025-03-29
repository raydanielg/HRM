<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAwardsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('awards', function(Blueprint $table)
		{
			$table->increments('id');

            $table->unsignedInteger("company_id");
            $table->foreign("company_id")->references("id")->on("companies")->onUpdate("cascade")->onDelete("cascade");

			$table->unsignedInteger("employee_id");
			
			$table->foreign('employee_id')
      			  ->references('id')->on('employees')
      			  ->onUpdate('cascade')
      			  ->onDelete('cascade');
      		$table->string('award_name');
      		$table->string('gift');
      		$table->string('cash_price');
      		$table->string('month',15);
      		$table->string('year',4);
      			  
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
		Schema::drop('awards');
	}

}

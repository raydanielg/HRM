<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeavetypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('leavetypes', function(Blueprint $table)
		{
			$table->increments('id');

			$table->unsignedInteger('company_id')->nullable();
			$table->foreign('company_id')
			      ->references('id')->on('companies')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');

			$table->string('leaveType',100);
            $table->unsignedInteger('num_of_leave');
			$table->index('leaveType');

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
		Schema::drop('leavetypes');
	}

}

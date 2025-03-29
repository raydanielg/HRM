<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jobs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('company_id')->nullable();

			$table->foreign('company_id')
			      ->references('id')->on('companies')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');
			$table->string('position');
			$table->text('description');
			$table->date('posted_date');
			$table->date('last_date');
			$table->date('close_date');
			$table->enum('status',['active','inactive'])->default('active');
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
		Schema::drop('jobs');
	}

}

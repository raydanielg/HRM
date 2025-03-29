<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobApplicationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('job_applications', function(Blueprint $table)
		{
			$table->increments('id');


			$table->unsignedInteger("company_id");
            $table->foreign("company_id")->references("id")->on("companies")->onUpdate("cascade")->onDelete("cascade");

            $table->unsignedInteger('job_id');
			$table->foreign('job_id')
			      ->references('id')->on('jobs')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');

			$table->string('name',50);
			$table->string('email',100);
			$table->string('phone',20);
			$table->string('resume',50);
			$table->text('cover_letter');
			$table->enum('status',['selected','rejected','pending'])->default('pending');

            $table->unsignedInteger("submitted_by");;
			$table->foreign('submitted_by')
			      ->references('id')->on('employees')
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
		Schema::drop('job_applications');
	}

}

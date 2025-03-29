<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeaveApplications extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */

	public function up()
	{
		Schema::create('leave_applications', function(Blueprint $table)
		{
			$table->increments('id');
            $table->unsignedInteger("company_id");
            $table->foreign("company_id")->references("id")->on("companies")->onUpdate("cascade")->onDelete("cascade");

			$table->unsignedInteger("employee_id");
			$table->string('leaveType',100)->nullable();
			$table->string('halfDayType',100)->nullable();

			
			$table->foreign('employee_id')
			      ->references('id')->on('employees')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');

			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->integer('days');
			$table->date('applied_on')->nullable();
			$table->string('updated_by',100)->nullable();
			$table->text('reason');
			$table->enum('application_status',array('approved','rejected','pending'))->nullable();

			$table->index('leaveType');
			$table->foreign('leaveType')
			      ->references('leaveType')->on('leavetypes')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');

			$table->index('updated_by');
			$table->foreign('updated_by')
			      ->references('email')->on('admins')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');

			$table->index('halfDayType');
			$table->foreign('halfDayType')
			      ->references('leaveType')->on('leavetypes')
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
		Schema::drop('leave_applications');
	}

}

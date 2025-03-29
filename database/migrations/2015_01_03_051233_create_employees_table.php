<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('employeeID', 20);

			$table->string('full_name', 100);
			$table->string('email', 150)->unique();
			$table->string('password', 100);
			$table->enum('gender',['male','female']);
			$table->string('father_name', 100);
			$table->string('mobile_number', 20);
			$table->date('date_of_birth')->nullable();
			$table->integer('designation')->unsigned()->nullable();
			$table->date('joining_date')->nullable();
			$table->string('profile_image')->default('default.jpg')->nullable();
			$table->text('local_address');
			$table->text('permanent_address');
			$table->integer('annual_leave')->default(0);
			$table->enum('status',['active','inactive']);
			$table->dateTime('last_login');
			$table->string('remember_token', 100)->nullable();
			$table->date('exit_date')->nullable();

			$table->foreign('designation')
			      ->references('id')->on('designation')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');
			$table->string('reset_code')->nullable();
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
		Schema::drop('employees');
	}

}

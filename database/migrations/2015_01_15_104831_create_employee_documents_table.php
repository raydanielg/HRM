<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeDocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employee_documents', function(Blueprint $table)
		{
			$table->increments('id');


			$table->unsignedInteger("employee_id");
			
			$table->foreign('employee_id')
      			  ->references('id')->on('employees')
      			  ->onUpdate('cascade')
      			  ->onDelete('cascade');
      		$table->string('type',100);
      		$table->string('filename',100);


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
		Schema::drop('employee_documents');
	}

}

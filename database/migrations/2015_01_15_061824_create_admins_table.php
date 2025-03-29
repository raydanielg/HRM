<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admins', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('company_id')->nullable();
			$table->foreign('company_id')
			      ->references('id')->on('companies')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');
			$table->string('name',100);
			$table->string('email',100)->unique();
			$table->string('password',100);
			$table->string('reset_code')->nullable();
			$table->dateTime('last_login')->nullable();
			$table->enum('email_verified',['yes','no'])->default('no');
			$table->string('email_token')->nullable();
			$table->rememberToken();
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
		Schema::drop('admins');
	}

}

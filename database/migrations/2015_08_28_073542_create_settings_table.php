<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('main_name',100);
			$table->string('email',100);
			$table->string('name',100);
			$table->string('logo',100)->nullable();
			$table->string('address');
			$table->string('contact',20);
			$table->string('admin_theme');
			$table->string('locale',10)->default('en');
			$table->enum('status', ['active', 'inactive']);
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
		Schema::drop('settings');
	}

}

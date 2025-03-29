<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('company_name',100);

            $table->unsignedInteger("subscription_plan_id")->nullable();
            $table->foreign("subscription_plan_id")->references("id")->on("subscription_plans")->onUpdate("cascade")->onDelete("set null");

			$table->string('email',100);
			$table->string('name',100);
			$table->string('logo',100)->default('default.png');
			$table->string('address');
			$table->string('contact',20);
			$table->string('currency',20)->default('USD');
			$table->string('currency_symbol',10)->default('$');

			$table->boolean('award_notification')->default(1);
			$table->boolean('attendance_notification')->default(1);
			$table->boolean('leave_notification')->default(1);
			$table->boolean('notice_notification')->default(1);
			$table->boolean('payroll_notification')->default(1);
			$table->boolean('expense_notification')->default(1);
			$table->boolean('employee_add')->default(1);
			$table->boolean('job_notification')->default(1);
			$table->boolean('admin_add')->default(1);
			$table->string('admin_theme')->default('darkblue');
			$table->string('front_theme')->default('dark-blue');
			$table->string('locale',10)->default('en');
			$table->boolean('active');

			// Features
			$table->boolean('award_feature')->default('1');
			$table->boolean('attendance_feature')->default('1');
			$table->boolean('leave_feature')->default('1');
			$table->boolean('notice_feature')->default('1');
			$table->boolean('payroll_feature')->default('1');
			$table->boolean('expense_feature')->default('1');
			$table->boolean('holidays_feature')->default('1');
			$table->boolean('jobs_feature')->default('1');

			$table->enum('status', ['active', 'inactive'])->default('active');;

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
		Schema::drop('companies');
	}
}

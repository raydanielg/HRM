<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePayrollsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payrolls', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger("employee_id");
			
			$table->foreign('employee_id')
			      ->references('id')->on('employees')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');
			$table->string('month');
			$table->string('year');
			$table->enum('payment_mode',['cash','paypal','bank_transfer','cheque']);
			$table->string('basic');
			$table->string('overtime_hours');
			$table->string('overtime_pay');

			$table->string('allowances');
			$table->string('total_allowance');

			$table->string('deductions');
			$table->string('total_deduction');

			$table->string('additionals');
			$table->string('total_additional');
			$table->string('net_salary');
			$table->date('pay_date');
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
		Schema::drop('payrolls');
	}

}

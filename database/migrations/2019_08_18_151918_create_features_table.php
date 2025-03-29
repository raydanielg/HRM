<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        $data = [
            [
                'title' => 'Comprehensive Employee Dashboard',
                'description' => 'Employee Dashboard has been designed to give easy access to the relevant information on a single page.The Dashboard also makes doing common tasks very easy. An Employee can track his attendance on the calendar, view his leaves, check latest notices on the Notice Board, see upcoming holidays and birthdays, and even download salary slip of every month.',
                'image' => 'employee_dashboard.png'
            ],
            [
                'title' => 'Expense Claim',
                'description' => 'HRM makes it very easy to manage expenses made by employees and reimburse them. Be it online bill, mobile recharge, field expenses, etc. employees can add expenses they have made with all details including the bill. Approved expenses are automatically added to salary in payroll.',
                'image' => 'expense.png'
            ],
            [
                'title' => 'Leave Management',
                'description' => 'Applying for leaves is a cake walk with HRM. An Employee can apply for leaves on
                                specific days or by using a date range when he wants to apply for a long leave -
                                for example, sick or maternity leaves.
                                Leave request is sent to the HR Manager for the approval. After approval or rejection,
                                the employee is notified by an email.',
                'image' => 'apply_leaves.png'
            ],
            [
                'title' => 'Job Application',
                'description' => 'Job Application section allows employees to refer people to open job applications in
                                the organization. This promotes their involvement in referring good candidates for open
                                jobs
                                and makes it easy for the manager to manage the referrals.',
                'image' => 'job_vacency.png'
            ],
            [
                'title' => 'Admin Dashboard',
                'description' => 'HRM focuses on providing easy access to information. Admin dashboard has common stats to give a good overview of what\'s going on in the organization. Stats like total employees, total departments, awards, attendance, company expenses, current month birthdays, awards list, etc. are available at hand on the dashboard itself.',
                'image' => 'admin_dash.png'
            ],
            [
                'title' => 'Employee Management',
                'description' => 'You can easily manage all the employees in the organization and their data with HRM. Tasks like adding new employees, updating employee information, deleting any existing employee, and others can now be done without much hassle. You can also assign Credit Leaves (Annual Leaves) to an employee based on his experience and performance.',
                'image' => 'employee_admin.png'
            ],
            [
                'title' => 'Pay Slip Generator',
                'description' => 'Why to use a separate payroll software for generating pay slips when it can be done in HRM itself. HRM provides a simple interface to make generating pay slip both easy and fun. Now add hourly payments, allowances, and deductions, and generate, edit and email payslips to employees, all using HRM.',
                'image' => 'payroll.png'
            ],
            [
                'title' => 'Awards Management',
                'description' => 'Being a good HR Manager, you frequently give awards and appreciation to employees. But, as a number of employees increase, keeping the track of them becomes difficult. No worries, with HRM you can comfortably manage all the awards, achievements, and appreciations given in your organization.',
                'image' => 'awards.png'
            ],
            [
                'title' => 'Notice Board',
                'description' => 'With HRM\'s notice board feature, you can make company-wide announcements. Notices are visible on employee dashboard and employees are also notified by email.',
                'image' => 'notice.png'
            ],
            [
                'title' => 'Company Expense Management',
                'description' => 'Now keep track of all the company expenses conveniently. Any expense, from a small pencil to big purchases like laptops, bills, party expenditure, etc. can be added the to the expense management. HRM shows monthly expense stats to help you know if you are overspending and take measures on time.',
                'image' => 'expense_admin.png'
            ],
            [
                'title' => 'Attendance Management',
                'description' => 'You can mark attendance of all the employees with just one click. All you need to do is specify which employees are absent and then mark attendance.

You can also see the attendance of employees month wise.',
                'image' => 'attendance.png'
            ],
            [
                'title' => 'Holidays List',
                'description' => 'Company Holidays are also now very easy to manage. Any holidays for the current year can be pre-planned and added. Employees can see all the upcoming holidays on their dashboard and make plans accordingly.',
                'image' => 'holidays.png'
            ],
            [
                'title' => 'Admin Job Application',
                'description' => 'You can easily review the resumes submitted by employees and accept the best candidates. He can also preview the submitted resume without downloading them.',
                'image' => 'job_admin.png'
            ],
            [
                'title' => 'Customize to Your Needs',
                'description' => 'HRM provides many options to customize HRM according to your needs. You can change details like the logo, company address, contact number, email and currency to use on Settings Page.',
                'image' => 'settings.png'
            ],
            [
                'title' => 'Multiple Admins',
                'description' => 'HRM supports multiple admins. Add admins without any restrictions to minimize your headache. You just need to create a new admin and email them the details of the new account.',
                'image' => 'admins.png'
            ],
            [
                'title' => 'Multiple Themes',
                'description' => 'HRM has 11 front end themes. Choose a theme that everyone likes, or the one that blends well with your company logo.',
                'image' => 'themes.png'
            ],
        ];

        foreach ($data as $item) {
            \App\Models\Feature::create($item);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('features');
    }
}

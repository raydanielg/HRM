<?php

use Illuminate\Database\Seeder;
// Composer: "fzaninotto/faker": "v1.3.0"
use App\Models\EmailTemplate;

class EmailTemplatesTableSeeder extends Seeder
{

    public function run()
    {

       $this->insertEmailTemplate();

    }


    public function insertEmailTemplate()
    {
        # 	Admin Add
        $email = new \App\Models\EmailTemplate();
        $email->email_id = 'NEW_ADMIN';
        $email->subject = 'New admin added';
        $email->body = '
		 	Hi!

		    <b>##NAME## </b><br> Your account is created successfully on ##COMPANY_NAME##<br /><br/>
		    <p>Login Details are Below</p>

		    <p><strong>Email</strong>:  ##EMAIL##</p>
		    <p><strong>Password</strong>: ##PASSWORD##</p>
		    <br />
		    <br />
   		 <hr>';
        $email->save();

        $email = new EmailTemplate();
        $email->email_id = 'NEW_ADMIN_EMAIL_VERIFICATION';
        $email->subject = 'Email Verification - hrm.com';
        $email->body = '
		 	Hi!
		   <b>##NAME## </b><br><br>
		      Please Verify your Email.Click the below link or copy paste on browser to verify your email<br>
		    ##VERIFY_LINK##<br/>
		    <br />
   		 <hr>';
        $email->save();

        # 	Attendance Marked
        $email = new EmailTemplate();
        $email->email_id = 'ATTENDANCE_MARKED';
        $email->subject = 'Attendance Marked';
        $email->body = 'Hi

		<b>##NAME##</b><br /><br/>
    Your attendance dated <strong>##DATE##</strong>  has been marked.
    <br /><br />
		';
        $email->save();


        # Award
        $email = new EmailTemplate();
        $email->email_id = 'AWARD';
        $email->subject = 'Award';
        $email->body = 'Hi
		<b>##NAME##</b><br /><br/>
   You have been awarded with <strong>##AWARD##</strong>.
    <br /><br />
		';
        $email->save();


        //	Employee Add

        $email = new EmailTemplate();
        $email->email_id = 'EMPLOYEE_ADD';
        $email->subject = 'Login Credentials';
        $email->body = 'Hi
		<b>##NAME## </b><br> You account is created successfully on ##COMPANY_NAME##<br /><br/>
		    <p>Login Details are Below</p>
		    <strong>Email</strong>:  ##EMAIL##
		    <strong>Password</strong>: ##PASSWORD##

		';
        $email->save();


        //	Expense

        $email = new EmailTemplate();
        $email->email_id = 'EXPENSE_APPROVAL';
        $email->subject = 'Expense Status';
        $email->body = 'Hi
		<br /><br/>
        Your expense is ##STATUS## ON ##DATE##
    	<br /><br />
		';
        $email->save();

        // LEAVE REQUEST
        $email = new EmailTemplate();
        $email->email_id = 'LEAVE_APPROVAL';
        $email->subject = 'Leave Status';
        $email->body = 'Hi
		<br /><br/>
        	Your leave request of date <strong>##DATE##</strong> has been <strong>##STATUS##</strong>
    	<br /><br />
		';
        $email->save();


        // NEW COMPANY ADMIN REQUEST

        $email = new EmailTemplate();

        $email->email_id = 'NEW_COMPANY_REQUEST_TO_ADMIN';
        $email->subject = 'Company Request';
        $email->body = 'Hi
			    <br>
			    <br>
			    Your company  <b>##COMPANY_NAME##</b> is registered with ##STATUS## status.Please wait for the Administator approval before you login
			    <br>
				';
        $email->save();


        // NEW COMPANY SUPERADMIN NOTIFICATION
        $email = new EmailTemplate();

        $email->email_id = 'NEW_COMPANY_NOTIFICATION_SUPERADMIN';
        $email->subject = 'New company request';
        $email->body = 'Hi
		    <br>
		    <br>
		       <b>##COMPANY_NAME##</b> is registered with ##STATUS## status.Go Admin panel see the details and approve it
		    <br>
			';
        $email->save();

        // NEW NOTICE ADDED
        $email = new EmailTemplate();

        $email->email_id = 'NEW_NOTICE';
        $email->subject = 'New Notice published';
        $email->body = 'Hi!

    <b> ##NAME## </b>
    	<br /><br/>
		    New Notice Published.Click ##LINK## to Visit the dashboard
	    <br /><br />
		';
        $email->save();


        // NEW PAYSLIP ADDED
        $email = new EmailTemplate();
        $email->email_id = 'NEW_PAYSLIP';
        $email->subject = 'Payslip generated';
        $email->body = 'Hi!

		    <b>##NAME## </b><br /><br/>
		    Your payslip generated for the month <strong>##MONTH_YEAR## <strong>

		    <br /><br />
		';
        $email->save();


        // RESET PASSWORD
        $email = new EmailTemplate();
        $email->email_id = 'ADMIN_RESET_PASSWORD';
        $email->subject = 'Reset Password';
        $email->body = 'Hi!

		 <b>##NAME## </b>
    	<br /><br/>
	   			 To reset your password, complete this form: ##CODE_LINK##<br/>

	    <br /><br />
		';
        $email->save();

        // RESET PASSWORD
        $email = new EmailTemplate();
        $email->email_id = 'FRONT_RESET_PASSWORD';
        $email->subject = 'Reset Password';
        $email->body = 'Hi!

		 <b>##NAME## </b>
    	<br /><br/>
	   			 To reset your password, complete this form: ##CODE_LINK##.<br/>

	    <br /><br />
		';
        $email->save();

        // RESET PASSWORD
        $email = new EmailTemplate();
        $email->email_id = 'RESET_PASSWORD_SUCCESS';
        $email->subject = 'Reset Password Success';
        $email->body = 'Hi!

		 <b>##NAME## </b>
    	<br /><br/>
	   			Your password is successfully reset.

	    <br /><br />
		';
        $email->save();


        // CHANGE PASSWORD EMPLOYEE
        $email = new EmailTemplate();
        $email->email_id = 'CHANGE_PASSWORD_EMPLOYEE';
        $email->subject = 'Password Reset';
        $email->body = 'Hi!

		 <b>##NAME## </b>
    	<br /><br/>
	   			Your password is successfully reset.

	    <br /><br />
		';
        $email->save();


        // EXPENSE CLAIM
        $email = new EmailTemplate();
        $email->email_id = 'EXPENSE_CLAIM';
        $email->subject = 'Expense Claim request';
        $email->body = 'Hi!

		<b>##NAME##</b> your expense claim is submitted<br /><br/>

		    <p><b>Item Name:</b>##ITEM_NAME##</p>
		    <p><b>Purchase From:</b>##PURCHASE_FROM##</p>
		    <p><b>Purchase Date:</b>##PURCHASE_DATE##</p>
		    <p><b>Purchase Price:</b>  ##PRICE##</p>
		    <br />
		    <br />
		';
        $email->save();


        // JOB APPLICATION REQUEST
        $email = new EmailTemplate();
        $email->email_id = 'JOB_APPLICATION_REQUEST';
        $email->subject = 'New job application submitted';
        $email->body = 'Hi!

		  <b>##NAME##</b> has submitted the job application<br /><br/>

    <p><b>Position:</b>##POSITION##</p>
    <p><b>Name:</b>    ##NAME##</p>
    <p><b>Email:</b>   ##EMAIL##</p>
    <p><b>Phone:</b>  ##PHONE##</p>
    <p><b>Cover Letter:</b> ##COVER_LETTER##</p>

    <br />
    	Click resume  to view resume: ##LINK##</a>
    <br />
    <br />

		';
        $email->save();
    }

}

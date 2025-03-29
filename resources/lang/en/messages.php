<?php

return [
    /*
   |--------------------------------------------------------------------------
   | Messages Language Lines
   |--------------------------------------------------------------------------
   |
   | The following language lines are used by the message shown on webiste.
   | You are free to change them to anything
   | you want to customize your views to better match your application.
   |
   */
    // Dashboard
    'verifyEmail' => 'Please verify your email address. <a href=":link">Click here</a> to resend verification email',
    'noBirthdays' => 'No birthdays this month',
    'noAwards' => 'No awards have been given',

    // Employees
    "employeeDelete" => "Employee <strong>:name</strong> deleted successfully",
    "deleteConfirm" => "Are you sure you want to delete following employee: <strong>:name</strong>? This action cannot be undone.",
    "deleteSalaryConfirm" => "Are you sure you want to delete this salary: <strong>:type</strong>?",
    'noDepartment' => '<strong>Note:</strong> Please add a <strong><a href="' . route("admin.departments.index") . '">department</a></strong> before creating an employee.',
    'imageSizeLimit' => "<span class=\"label label-danger\">NOTE!</span> Image must be of size :size",
    'basicSalaryInfo' => 'This salary will be used for calculation in payroll',
    'hourlyRateMessage' => 'Hourly Rate (:symbol per hour)',
    'statusRemoveWarning' => '<strong>Note:</strong> Setting status to Active will remove the Exit Date',
    'bankUpdateSuccess' => 'Bank details updated successfully',
    'companyUpdateSuccess' => 'Company details updated successfully',
    'personalUpdateSuccess' => 'Personal details updated successfully',
    'documentsUpdateSuccess' => 'Documents updated successfully',
    'employeeIDUsed' => 'This Employee ID has already been used',
    "deleteConfirmCompany" => "Are you sure .You want to delete this company",
    "matchColumnMessage" => "Please sort the data you have uploaded by matching the columns in the CSV to the fields in the associated employee fields.",
    "columnMatchSuccess" => "<strong>Well done!</strong> You have successfully matched all the columns. Please click on submit to save.",
    "unmatchedColumns" => "<span id=\"unmatchedCount\">:unmatchCount</span> unmatched columns.",
    "pleaseSelectAColumn" => "Please select a column or click on skip",
    "columnRequired" => "This column is required and must be matched: <strong>:column</strong>",
    "requiredColumnsUnmatched" => "Following fields are required and must be matched: <strong>:columns</strong>",
    "importFail" => "<div class=\"alert alert-danger\"><strong>Oh snap!</strong> Error occurred while importing. Please go back to <a href=\"" . URL::route("admin.employees.import") . "\">Import Employee</a> page and try again. If problem persists, please contact support.",
    "uploadMessage" => 'Upload a CSV containing employee data. If you have excel file, please export it as a CSV first. If you want to add employees manually, you can do so by <a href="javascript:;" onclick="loadView(\'' . route("admin.employees.create") . '\')">clicking here</a>.',

    // Employees
    'employeeDeleteMessage' => "Employee <strong>:employee</strong> deleted successfully",
    'employeeAddMessage' => "Employee <strong>:employee</strong> added successfully",
    'employeeUpdateMessage' => "Employee <strong>:employee</strong> updated successfully",
    'employeeImportNote' => "<strong>Note:</strong> You do not need to worry about column order, we will help you match them in next step.",
    'employeeImportError' => "There was an error uploading selected file. Please check your internet connection and try again.",
    'failedRecordsMessage' => "We could not import following employee records. Fail reason is indicated against each.",

    // Departments
    'departmentDeleteMessage' => "Department <strong>:department</strong> deleted successfully",
    'departmentAddMessage' => "Department <strong>:department</strong> added successfully",
    'departmentUpdateMessage' => "Department <strong>:department</strong> updated successfully",

    // Awards
    'awardDeleteMessage' => "Award deleted successfully",
    'awardAddMessage' => "Award <strong>:award</strong> added successfully",
    'awardUpdateMessage' => "Award <strong>:award</strong> updated successfully",
    'awardDeleteConfirm' => "Are you sure you want to delete following award: <strong>:award</strong>?",

    // Expenses
    'expenseDeleteMessage' => "Expense deleted successfully",
    'expenseAddMessage' => "Expense added successfully",
    'expenseUpdateMessage' => "Expense updated successfully",
    'expenseDeleteConfirm' => "Are you sure you want to delete following ?",
    'expenseStatusChangeMessage' => "Status changed successfully",


    // Holidays
    'holidayDeleteMessage' => "Holiday on <strong>:holiday</strong> removed successfully",
    'holidayAddMessage' => "Holidays added successfully",
    'holidayDayMessage' => "All :day marked holiday successfully",
    'holidayUpdateMessage' => "Holiday on <strong>:holiday</strong> updated successfully",
    'holidayDeleteConfirm' => "Are you sure you want to remove holiday on following date: <strong>:holiday</strong>?",
    'holidayStatusChangeMessage' => "Status of holiday <strong>:holiday</strong> changed successfully",
    'noHolidays' => 'No Holidays',

    // Attendance
    'attendanceAlreadyMarked' => "<strong>Attendance already marked</strong>",
    'attendanceDeleteMessage' => "Attendance for day <strong>:attendance</strong> removed successfully",
    'attendanceAddMessage' => "Attendance for day <strong>:attendance</strong> added successfully",
    'attendanceUpdateMessage' => "Attendance for day <strong>:attendance</strong> updated successfully",
    'attendanceDeleteConfirm' => "Are you sure you want to remove attendance for following day: <strong>:attendance</strong>?",
    'todayIsHoliday' => 'Today is holiday on the occasion of: <strong>:date</strong>',
    'attendanceSettings' => '<strong> You need to set Attendance settings first. <a href="' . route("admin.attendance_settings.edit") . '">Click Here</a></strong> to configure your settings',

    'leaveTypeDeleteConfirm' => 'Are you sure you want to delete this leave type: <strong>:leaveType</strong>?',
    'leaveTypeAddMessage' => "Leave Type <strong>:leaveType</strong> added successfully",
    'leaveTypeUpdateMessage' => "Leave Type <strong>:leaveType</strong> updated successfully",
    'leaveTypeDeleteMessage' => "Leave Type  deleted successfully",
    "addLeaveTypes" => 'You have to configure leave type before marking attendance. <a href="' . route("admin.leavetypes.index") . '">Click Here</a> to configure leave types',

    'leaveApplicationDeleteConfirm' => 'Are you sure you want to delete this leave application?',
    'leaveApplicationAddMessage' => "Leave Application <strong>:leaveApplication</strong> added successfully",
    'leaveApplicationUpdateMessage' => "Leave Application status changed successfully",
    'leaveApplicationDeleteMessage' => "Leave Application deleted successfully",

    'payrollDeleteConfirm' => 'Are you sure you want to delete this salary slip?',
    'payrollAddMessage' => "Salary Slip added successfully",
    'payrollUpdateMessage' => "Salary Slip status changed successfully",
    'payrollDeleteMessage' => "Salary Slip deleted successfully",
    'salarySlipExistsMessage' => 'Salary Slip for the employee for selected month and year has already been created. Do you want modify it?',

    'noticeDeleteConfirm' => 'Are you sure you want to delete this notice?',
    'noticeAddMessage' => "Notice added successfully",
    'noticeUpdateMessage' => "Notice status changed successfully",
    'noticeDeleteMessage' => "Notice deleted successfully",

    'jobDeleteConfirm' => 'Are you sure you want to delete this job opening?',
    'jobAddMessage' => "Job opening added successfully",
    'jobUpdateMessage' => "Job opening status changed successfully",
    'jobDeleteMessage' => "Job opening deleted successfully",

    'jobApplicationsDeleteConfirm' => 'Are you sure you want to delete this job application?',
    'jobApplicationsAddMessage' => "Job application added successfully",
    'jobApplicationsUpdateMessage' => "Job application status changed successfully",
    'jobApplicationsDeleteMessage' => "Job application deleted successfully",

    'adminDeleteConfirm' => "Are you sure you want to delete this Admin?",
    'adminDeleteMessage' => "Admin was deleted successfully",
    'adminAddMessage' => "Admin created successfully",
    'adminUpdateMessage' => "Admin updated successfully",

    "updateCreateMessage" => "Update created successfully",
    "updateUpdateMessage" => "Update changed successfully",
    "updateDeleteConfirm" => "Are you sure you want to delete this update?",
    "updateDeleteMessage" => "Update removed successfully",

    // Billing
    "invoiceAddSuccess" => "Invoice was added successfully",
    "invoiceUpdateSuccess" => "Invoice was updated successfully",
    "invoicePaymentSuccess" => "Invoice was paid successfully",
    "invoicePaymentFail" => "Payment failed. Please try again or contact support!",
    "invoicePaymentCancel" => "Payment was cancelled. Please try again!",

    'loginPageMessage' => 'Login to your account',
    'submitting' => 'Submitting',
    'loginSuccess' => 'Logged in successfully.',
    'loginBlocked' => '<strong>Access Denied!</strong> Your account has been blocked',
    'loginInvalid' => 'Wrong login details',
    'wrongPassword' => 'Wrong Password',

    'noteLeaveTypes' => '<strong>Half Day</strong> leaves are not added to total leaves on <strong>Employee Dashboard Page</strong>',
    'deleteNoteDepartment' => '<strong>Note:</strong> All the <strong>employees</strong> associated with this department will also be deleted',
    'deleteNoteDesignation' => 'Deleting/Emptying a designation will delete all the <strong>employees</strong> associated with it',
    'noDept' => '<strong>Note:</strong> There is no <strong>department</strong> in the database. Please create a department first',
    'noDeptTable' => 'Department table is Empty',
    'noLeaveType' => 'LeaveType table is Empty',

    'notAuthorised' => 'Sorry! You are not authorised to do this action',
    'companyDisabled' => 'Your company has been disabled. Please contact HRM support for further assistance',
    'correctEmail' => 'Enter correct email address',
    'passwordReset' => 'Email sent! Please check your inbox for instructions to reset your password',
    'emailNotFound' => 'Email address not found in our database',
    'bothFieldsRequired' => 'Both fields are required',
    'passwordRequired' => 'Password is required',
    'passwordResetSuccess' => 'Password successfully reset.',
    'passwordChangeSuccess' => '<strong>Success!</strong> Password changed successfully',
    'createdSuccess' => '<strong>Success! </strong>Created successfully',
    'companyRegisterSuccess' => 'Thank you for registering. You will be notified once your company is approved by the administrator',

    'adminCreated' => 'New admin created successfully',
    'updateSuccess' => "Updated successfully",
    'companyChange' => "Company changed to ",
    'statusChange' => "Status changed to ",
    'objectAddSuccess' => "<strong>:object</strong> added successfully",
    'objectUpdateSuccess' => "<strong>:object</strong> updated successfully",
    'objectDeleteSuccess' => "<strong>:object</strong> deleted successfully",
    'designation0required' => "Designation field cannot be left blank",
    'nameRequired' => "Department field cannot be left blank",


    'leaveRequest' => '<strong>Success! </strong>Your leave request has been sent to the HR Team. You will be notified when it\'s status changes',
    'errorLeaveRequest' => '<strong>Error! </strong> You have already applied for a leave on this date', 'employeeSpecific' => 'Employee Specific',
    'halfDaySpecific' => 'Other leave Specific',
    'departmentDeleteConfirm' => 'Are you sure you want to this department: ',

    'successApplyJob' => 'Thank you for the submission. The applicant will be notified soon',
    'noJob' => 'No job openings',
    'dateRangeNote' => 'You can either apply for a single leave or multiple leaves at a time',
    'note' => 'Note',
    'noDataTable' => 'No data available in the table',

    // Toastr Messages
    'success' => 'Success',
    'successDelete' => 'Successfully deleted',
    'successUpdate' => "Updated successfully",
    'error' => 'Error',
    'errorTitle' => 'Please fix the error(s) below',
    'successAdd' => 'Added successfully',
    'statusChanged' => 'Status changed',
    'successExpenseAdd' => 'Expense successfully added',
    'designationEmptyNote' => ' (empty if you want to delete the designation)',
    'generalError' => "A server side error occurred. Please try again after sometime!",


    'approveLeave' => 'Are you sure you want to approve? You will not be able to disapprove the leave after this action.',
    'rejectLeave' => 'Are you sure you want to reject? You will not be able to approve the leave after this action.',

    //Referral Member
    'referralDeleteMessage' => "Referral Code <strong>:code</strong> deleted successfully",
    'referralDeleteConfirm' => "Are you sure you want to delete following Referral code: <strong>:code</strong>?",
    'backupDeleted' => 'BackUp Deleted',
    'atLeastOneDept' => 'Select at least one department',
    'warningInvoice' => 'You are required to pay the pending invoice to continue using HRM',
    'addNewEmployeeWarning' => 'Adding new employee will convert your license from Free license to Paid version. Are you sure you want to continue?',

    'upgradeYourPlan' => 'To perform this action please upgrade your plan',

    'categoryRequired' => 'Category is required',
    'faqCategoryDeleteConfirm' => 'Are you sure you want to this FAQ category: ',
    'deleteNotefaqCategory' => "<strong>Note:</strong> All the <strong>FAQ\'s</strong> associated with this category will also be deleted",
    'faqCategoryDeleteMessage' => "FAQ Category <strong>:category</strong> deleted successfully",
    'faqDeleteConfirm' => 'Are you sure you want to this FAQ.',
    'faqDeleteMessage' => "FAQ <strong>:faq</strong> deleted successfully",

    'addSuccess' => 'Successfully created',
    'deleteSuccess' => 'Successfully deleted',
    'updateAlert' => 'Do not click update now button if the application is customised. Your changes will be lost.',
    'updateBackupNotice' => 'Take backup of files and database before updating.',
    'smtpError' => 'Your SMTP details are not correct. Please update to correct one',
    'smtpSuccess' => 'Your SMTP details are correct',
    'smtpSecureEnabled' => 'Please check if you have enabled less secure app on your account from here ',
    'smtpNotSet' => 'You have not configured SMTP settings. You might get an error when adding info ',

];

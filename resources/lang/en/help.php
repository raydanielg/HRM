<?php

return [
    'employeeImageSize' => [
        "title" => "Image Size",
        "text" => "Recommended image size is <strong>872x724 pixels</strong>. Images of improper dimensions may get distorted."
    ],
    'exitDate' => [
        "title" => "Exit Date",
        "text" => "Date when this employee left the company. Leave blank for employees currently working in your company."
    ],
    'creditLeaves' => [
        "title" => "Credit Leaves",
        "text" => "Extra leaves given on per employee basis."
    ],
    'bankIdentificationCode' => [
        "title" => "Bank Identifier Code",
        "text" => "A unique code to identify a bank in your country. For example, IFSC code in India, SWIFT code in United Kingdom, etc."
    ],
    'taxPayerID' => [
        "title" => "Taxpayer ID",
        "text" => "Taxpayer Identification Number used in your country. For example, PAN Number in India, Taxpayer Identification Number in USA, etc."
    ],

    'award_name' => [
        "title" => "Award Name",
        "text" => "Name of award/appreciation given. For example, Employee of the Month."
    ],

    'awardGift' => [
        "title" => "Gift",
        "text" => "Any gift that was given along with the award. For example, a coffee mug, a bouquet, etc."
    ],

    'markAllHolidays' => [
        "title" => "Mark All Sundays",
        "text" => "Click on this button to mark all Sundays as holidays, if you do not have Sundays as working days."
    ],

    'importFileInfo' => [
        "title" => "Import CSV File",
        "text" => "Select a comma separated CSV file containing employee data. If you see some error while importing a CSV exported from Excel, please contact support for assistance."
    ],

    'markLateAfter' => [
        "title" => "Mark Late After",
        "text" => "Employees who clock in after this time will be marked as late"
    ],

    'allowMarkAttendance' => [
        "title" => "Allow Mark Attendance",
        "text" => "Allow employees to clock in/out from their self service portal. HRM records various stats like IP address, working location, etc. to help you moderate marked attendances."
    ],

    'billingAddress' => [
        "title" => "Billing Address",
        "text" => "Enter billing address for your company. All your invoices will be billed to this address."
    ],

    'emailNotificationDisabled' => [
        "title" => "Email Notification Disabled",
        "text" => "Email notification for this task is disabled because you have more than " . \App\Http\Controllers\Admin\EmployeesController::$MAX_EMPLOYEES . " employees"
    ],
    'stripeKey' => [
        "title" => "Publishable key",
        "text" => "Add Stripe publishable key. Generate from the link given below"
    ],
    'stripeSecretKey' => [
        "title" => "Secret key",
        "text" => "Add Stripe secret key. Generate from the link given below"
    ],
    'stripeWebhookKey' => [
        "title" => "Stripe Webhook Secret",
        "text" => "Create endpoint and generate webhook secret"
    ],
    'gdpr' => [
        "title" => "General Data Protection Regulation",
        "text" => "Enabling GDPR will encrypt employees data"
    ]
];

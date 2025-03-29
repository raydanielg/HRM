#hrm-saas
Create plans on stripe and set recurring payments and then put that plan id in packages table.

Create a webhook for eaxmple "www.hrm.com/save-invoices"
on stripe. Domain can be anything but "/save-invoices" is important.

Select event "invoice.payment_failed" and "invoice.payment_succeeded" while creating webhook.

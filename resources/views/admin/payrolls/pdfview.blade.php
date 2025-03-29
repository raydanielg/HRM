<head>
    <style type="text/css">

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            table.details tr th {
                background-color: #F2F2F2 !important;
            }

            .print_bg {
                background-color: #F2F2F2 !important;
            }

        }

        .print_bg {
            background-color: #F2F2F2 !important;
        }

        body {
            font-family: "Open Sans", helvetica, sans-serif;
            font-size: 13px;
            color: #000000;
        }

        table.logo {
            -webkit-print-color-adjust: exact;
            border-collapse: inherit;
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border-bottom: 2px solid #25221F;

        }

        table.emp {
            width: 100%;
            margin-bottom: 10px;
            padding: 40px;
        }

        table.details, table.payment_details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.payment_total {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 10px;
        }

        table.emp tr td {
            width: 30%;
            padding: 10px
        }

        table.details tr th {
            border: 1px solid #000000;
            background-color: #F2F2F2;
            font-size: 15px;
            padding: 10px
        }

        table.details tr td {
            vertical-align: top;
            width: 30%;
            padding: 3px
        }

        table.payment_details > tbody > tr > td {
            border: 1px solid #000000;
            padding: 5px;
        }

        table.payment_total > tbody > tr > td {
            padding: 5px;
            width: 60%
        }

        table.logo > tbody > tr > td {
            border: 1px solid transparent;
        }
    </style>
</head>
<body>
<table class="logo">
    <tr>
        <td>

        </td>
        <td><p style="text-align: right;">
                {!!  HTML::image($employee->company->logo_image_url,'Logo',['class'=>'logo-default','height'=>'40px']) !!}
            </p>

            <p style="text-align: right;">

                <b>{{$employee->company->company_name}}</b><br/>
                {{$employee->company->address}}<br/>
                <b>Contact</b>: {{$employee->company->contact}}
                {{$employee->company->email}}

            </p>
        </td>
    </tr>
</table>
<table class="emp">
    <tbody>
    <tr>
        <td colspan="3" style="text-align: center; font-size: 18px;"><strong>@lang("core.payslip") <br>
                @lang("core.salaryMonth"): {{ date('F', mktime(0, 0, 0, $payroll->month, 10))}}, {{$payroll->year}}
            </strong></td>
    </tr>
    <tr>
        <td><strong>@lang("core.employeeID"):</strong> {{ $payroll->employee->employeeID }} </td>
        <td><strong>@lang("core.name"):</strong> {{$payroll->employee->full_name}}</td>
        <td><strong>@lang("core.payslipNumber"):</strong> {{$payslip_num}}</td>
    </tr>

    <tr>
        <td><strong>@lang("core.department"):</strong> {{ $payroll->employee->getDesignation->department->name}}</td>
        <td><strong>@lang("core.designation"):</strong> {{ $payroll->employee->getDesignation->designation}}</td>
        <td><strong>@lang("core.joining_date")
                :</strong> {!! date('d-M,Y',strtotime($payroll->employee->joining_date)) !!}</td>
    </tr>
    </tbody>
</table>

<!-- Table for Details -->
<table class="details">

    <tr>
        <!-- Payment Info Slip Start-->
        <td>

            <table class="payment_details">
                <tr>
                    <th colspan="2">@lang("core.paymentInfo")</th>
                </tr>
                <tr>
                    <td><strong>@lang("core.payType")</strong></td>

                    <td><strong>@lang("core.amount")</strong></td>
                </tr>
                <tr>
                    <td>@lang("core.basic")</td>
                    <td> {{$employee->company->currency}} {{number_format($payroll->basic, 2)}}</td>
                </tr>
                <tr>
                    <td>@lang("core.hourlyPayment")</td>

                    <td> {{$employee->company->currency}} {{number_format($payroll->overtime_pay, 2)}} </td>
                </tr>
                <tr>
                    <td>@lang("core.expenseClaim")</td>
                    <td> {{$employee->company->currency}} {{number_format($payroll->expense, 2)}} </td>
                </tr>
                @foreach(json_decode($payroll->allowances) as $index=>$value)
                    <tr>
                        <td> {{ $index }}</td>

                        <td> {{$employee->company->currency}} {{number_format($value, 2)}} </td>
                    </tr>
                @endforeach
            </table>
            <!-- Table for Details -->
        </td>
        <!--  Payment Info Slip End-->

        <!--  Reimebursement Slip start-->

        <!--  Reimebursement Slip END-->

        <!-- Deduction start -->
        <td>
            <table class="payment_details">
                <tr>
                    <th colspan="2">@lang("core.deductions")</th>
                </tr>
                <tr>
                    <td><strong>@lang("core.payType")</strong></td>

                    <td><strong>@lang("core.amount")</strong></td>
                </tr>
                @foreach(json_decode($payroll->deductions) as $index=>$value)

                    <tr>
                        <td> {{ $index }}</td>

                        <td> {{$employee->company->currency}} {{number_format($value, 2)}} </td>
                    </tr>
                @endforeach

            </table>
        </td>
        <!--  Deductions End-->
    </tr>

</table>
<!-- Table for Details -->
<hr>
<!-- TotalTotal -->
<table class="payment_total">

    <tr>
        <td><strong>&nbsp;</strong></td>

        <td>
            <table class="payment_details">
                <tr>
                    <th colspan="2">@lang("core.total")</th>
                </tr>
                <tr>
                    <td>@lang("core.totalAllowances")</td>

                    <td> {{$employee->company->currency}} {{number_format($payroll->total_allowance, 2)}} </td>
                </tr>

                <tr>
                    <td>@lang("core.totalDeductions")</td>

                    <td> {{$employee->company->currency}} {{number_format($payroll->total_deduction, 2)}}</td>
                </tr>
                <tr class="print_bg">
                    <td><b>@lang("core.netSalary")</b></td>

                    <td>  {{$employee->company->currency}} {{number_format($payroll->net_salary, 2)}}</td>
                </tr>
            </table>

        </td>
    </tr>


</table>
<!-- TotalTotal -->
</body>





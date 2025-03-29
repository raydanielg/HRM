<table width="100%" border="1" style="border-collapse:collapse; border-color:white;">
    <tr>
        <td style="background-color:#FFFFFF;padding:10px;text-align: center">

            <img src="{{URL::asset('uploads/company_logo/'.$employee->company['logo'])}}" class="logo-default"
                 height="30px">
        </td>
    </tr>
    <tr>
        <td style="padding:10px;">
            @yield('email_content')
            <font color="#888888">
                <font color="#888888">
                    <b> {{$employee->company['company_name']}}</b>
                </font>
                <br/>
                <b> {{ config('app.name') }}</b><br/>
                <font size="1">
                    <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
                    <br/>
                </font>
            </font>
        </td>
    </tr>
</table>

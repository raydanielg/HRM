<table width="100%" border="1" style="border-collapse:collapse; border-color:white;">
    <tr>
        <td style="background-color:#FFFFFF;padding:10px; text-align: center">
            <img src="{{$logo_image_url}}" height="50px">
        </td>
    </tr>
    <tr>
        <td style="padding:10px;">
            @yield('email_content')

            <b> {{ config('app.name') }}</b><br/>
            <font size="1">
                <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
                <br/>
            </font>
        </td>
    </tr>
</table>

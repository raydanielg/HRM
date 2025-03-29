@extends("mail.layout")
@section("email_content")
    Hi {{ $name }},
    <br/><br/>
    <b>Congratulations!</b> Your HRM account has been created. Please use details below to login to your account:<br/><br/>
    <b>Email:</b> {{ $email }}<br/>
    <b>Password: </b> (One you entered at sign up)<br/><br/>
    <b>Login: </b><a href="{{ $login_url }}">Click here</a> to go to login page.<br/><br/>
    Your license number for HRM is: <b>{{ $license_number }}</b>. Please keep your license number safe for future references.<br/><br/>
    If you have any problems, please do not hesitate to reach us at support@hrm.com.
    <br/><br/>
@endsection

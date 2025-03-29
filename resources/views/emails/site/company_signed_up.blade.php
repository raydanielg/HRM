@extends("emails.site.layout")
@section("email_content")
    Hi {{ $name }},
    <br/><br/>
    <b>Congratulations!</b> Your HRM account has been created. Please use details below to login to your account:<br/><br/>
    <b>Email:</b> {{ $email }}<br/>
    <b>Password: </b> (One you entered at sign up)<br/><br/>
    <b>Login: </b><a href="{{ $login_url }}">Click here</a> to go to login page.<br/><br/>

    <br/><br/>
@endsection

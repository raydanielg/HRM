@extends("mail.layout")
@section("email_content")
    Hi {{ $name }},
    <br/><br/>
    <b>Congratulations!</b> Your HRM purchase was successful. Please download you copy from link below:<br/><br/>
    <b>Download Link:</b> https://www.hrm.com/download/{{ $license_number }} <br/><br/>
    Your license number for HRM is: <b>{{ $license_number }}</b>. Please keep your license number safe for future references.<br/><br/>
    If you have any problems, please do not hesitate to reach us at support@hrm.com.
    <br/><br/>
@endsection

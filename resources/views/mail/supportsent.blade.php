@extends("mail.layout")
@section("email_content")
    Hi,
    <br/><br/>
    A new support request has been received:
    <br/><br/>
    <b>Name:</b> {{ $name }}<br/>
    <b>Email:</b> {{ $email }}<br/>
    <b>Category:</b> {{ $category }}<br/>
    <b>Details:</b> {{ $details }}<br/>
    <br/><br/>
@endsection

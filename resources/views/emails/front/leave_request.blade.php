@extends('front.layouts.email_layout')

@section('email_content')
    <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;border-color:#aaa;margin:0px auto;}
        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#fff;}
        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#fff;background-color:#f38630;}
        .tg .tg-0ord{text-align:right}
        .tg .tg-s6z2{text-align:center}
        .tg .tg-z2zr{background-color:#FCFBE3}
        .tg .tg-gyqc{background-color:#FCFBE3;text-align:right}
    </style>
    <strong>{{$full_name}}</strong> {{trans('email.appliedLeave')}}

    <br /><br/>

    <table style="width:100%;border-collapse:collapse;border-spacing:0;border-color:#aaa;margin:0px auto">
        <tr>
            <th style="font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#fff;background-color:#f38630;text-align:center" colspan="6">{{trans('core.leaves')}}</th>

        </tr>
        @if($emailType == 'single')
            <tr>
                <td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#FCFBE3">{{trans('core.date')}}</td>
                <td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#FCFBE3">{{trans('core.leaveTypes')}}</td>
                <td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#FCFBE3">{{trans('core.reason')}}</td>
            </tr>

            @foreach ($dates as $index=>$value)
                <tr>
                    <td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#fff">{{$value}}</td>
                    <td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#fff;">{{ $leaveType[$index]}}</td>
                    <td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#fff;">{{$reason[$index]}}</td>
                </tr>
            @endforeach

        @elseif($emailType == 'date_range')
            <tr>
                <td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#FCFBE3">{{ trans('core.date') }}</td>
                <td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#FCFBE3">{{ trans('core.days') }}</td>
                <td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#FCFBE3">{{ trans('core.leaveTypes') }}</td>
                <td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#FCFBE3">{{ trans('core.reason') }}</td>
            </tr>
            <tr>
                <td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#fff">{{ $dates }}</td>
                <td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#fff;">{{ $days }}</td>
                <td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#fff;">{{ $leaveType }}</td>
                <td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#fff;">{{ $reason }}</td>
            </tr>
        @endif


    </table>



    <br /><br />


@stop





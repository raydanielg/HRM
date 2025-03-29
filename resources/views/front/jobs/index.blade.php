@extends('front.layouts.frontlayout')

@section('head')
    <style>
        a:hover{
            text-decoration: none !important;
        }
    </style>
@stop

@section('mainarea')
    <div class="col-md-9">

        <!--Profile Body-->
        <div class="profile-body">

            <h2>{{trans('core.jobVacancy')}}</h2>
            <hr>

            @if(Session::get('success'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            <span class="fa fa-check">{{Session::get('success')}}</span>
                        </div>
                    </div>
                </div>
            @endif
            @if(count($jobs)==0)
                <div class="col-md-12">

                    <div class="service-block rounded-2x service-block-u">
                        <i class="icon-2x color-light fa fa-thumbs-down"></i>
                        <h2 class="heading-md">{{trans('messages.noJob')}}</h2>

                    </div>

                </div>
            @endif
            <div class="row">
                @foreach($jobs as $job)
                    <div class="col-md-4 col-sm-6">
                        <a href="{{route('jobs.show',$job->id)}}">
                            <div class="service-block  service-block-{{$job_block_color[$job->id%count($job_block_color)]}}">
                                <i class="icon-2x color-light fa fa-{{$job_block_icon[$job->id%count($job_block_icon)]}}"></i>
                                <h2 class="heading-md">{{$job->position}}</h2>

                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>

    </div>


@stop

@section('footerjs')

@stop

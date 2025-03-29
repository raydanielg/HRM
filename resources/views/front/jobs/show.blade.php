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
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="headline"><h2>{{$job_detail->position}}</h2></div>
                </div>

                <div class="col-md-6">
                    {!! $job_detail->description !!}
                    <hr>
                    {{--<p><strong>Last Date to Apply:</strong> {{date('d M Y',strtotime($job_detail->last_date))}}</p>--}}
                </div>

                <div class="col-md-6">
                    <button type="submit" class="btn-u field btn-block" id="apply_button"
                            onclick="ShowApplyForm();return false;">{{trans('core.applyNow')}}</button>
                    <!-- Reg-Form -->


                    {!! Form::open(array('class'=>'sky-form ajax_form','id'=>'apply_job_form','style'=>'display: none','files'=>true)) !!}

                    <input type="hidden" name="job_id" value="{{$job_detail->id}}">
                    <header>{{trans('core.applicationForm')}}</header>

                    <fieldset>
                            <div class="form-group">

                                <label class="label col col-4">Name</label>
                                <div class="col col-8">
                                    <label class="input">

                                        <input type="text" name="name" placeholder="{{trans('core.name')}}">
                                    </label>
                                </div>
                            </div>


                            <div class="form-group">

                                <label class="label col col-4">Email</label>
                                <div class="col col-8">
                                    <label class="input">

                                        <input type="email" name="email" placeholder="{{trans('core.email')}}">
                                    </label>
                                </div>
                            </div>


                        <section>
                            <div class="form-group">

                                <label class="label col col-4">Contact</label>
                                <div class="col col-8">
                                    <label class="input">

                                        <input type="text" name="phone" placeholder="{{trans('core.phone')}}" id="phone"
                                               >
                                    </label>
                                </div>
                            </div>


                        </section>

                        <section>
                            <div class="form-group">

                                <label class="label col col-4">Cover</label>
                                <div class="col col-8">
                                    <label class="input">

                                        <textarea rows="3" name="cover_letter" class="form-control"
                                                  placeholder="{{trans('core.coverLetter')}}"></textarea>
                                    </label>
                                </div>
                            </div>


                        </section>

                        <section>
                            <div class="form-group">

                                <label class="label col col-4">{{trans('core.resume')}}</label>
                                <div class="col col-8">
                                    <label for="file" class="input input-file">
                                        <div class="button"><input type="file" name="resume"
                                                                   onchange="this.parentNode.nextSibling.value = this.value">{{trans('core.browse')}}
                                        </div>
                                        <input type="text" placeholder="{{trans('core.includeSomeFile')}}" readonly>
                                    </label>
                                </div>
                            </div>

                        </section>
                    </fieldset>


                    <footer>
                        <button type="button" onclick="submitForm();return false;" class="btn-u">{{trans('core.btnSubmit')}}</button>
                    </footer>
                {!! Form::close() !!}
                <!-- End Reg-Form -->
                </div>

            </div>
        </div>

    </div>


@stop

@section('footerjs')

    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <!-- END PAGE LEVEL PLUGINS -->
    <script>
        function ShowApplyForm() {
            $('#apply_button').hide();
            $('#apply_job_form').fadeIn();
        }

        @if(Session::get('success') || count( $errors ) > 0)
        ShowApplyForm();

        @endif

        function submitForm() {
            var url = "{{ route('jobs.store') }}";
            $.easyAjax({
                type: 'POST',
                url: url,
                container: '#apply_job_form',
                file: true,
            });
        }
    </script>

@stop

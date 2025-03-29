<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">@lang("pages.jobApplications.indexTitle")</h4>
</div>
<div class="modal-body" id="job_info">
    <div class="tabbable-custom ">
        <ul class="nav nav-tabs ">
            <li class="active">
                <a href="#details" data-toggle="tab" aria-expanded="true">
                    {{trans('core.applicantDetails')}} </a>
            </li>
            <li class="">
                <a href="#resume" data-toggle="tab" aria-expanded="false">
                    {{trans('core.resume')}} </a>
            </li>

        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="details">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">

                        <tbody>
                        <tr>
                            <td><strong>{{trans('core.position')}}:</strong></td>
                            <td>{{$job_application->job->position}}</td>

                        </tr>
                        <tr>
                            <td><strong>{{trans('core.name')}}:</strong></td>
                            <td>{{$job_application->name}}</td>

                        </tr>
                        <tr>
                            <td><strong>{{trans('core.email')}}:</strong></td>
                            <td> {{$job_application->email}}</td>
                        </tr>
                        <tr>
                            <td><strong>{{trans('core.phone')}}:</strong></td>
                            <td> {{$job_application->phone}}</td>
                        </tr>
                        <tr>
                            <td><strong>{{trans('core.submittedBy')}}:</strong></td>
                            <td> {{ $job_application->employee->full_name}}</td>
                        </tr>
                        <tr>
                            <td><strong>{{trans('core.appliedOn')}}:</strong></td>
                            <td> {{$job_application->created_at}}</td>
                        </tr>

                        <tr>
                            <td><strong>{{trans('core.status')}}</strong></td>
                            <td>
                                <span class='margin-bottom-10 label label-{{$color[$job_application->status]}}'>{{trans('core.'.$job_application->status)}}</span>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="resume">
                <p><strong>{{trans('core.coverLetter')}}:</strong></p>

                <p>
                    {{$job_application->cover_letter}}
                </p>

                <p>
                    @if($job_application->resume!='')
                        <a href="https://docs.google.com/viewer?url={{$job_application->resume_url}}"
                           target="_blank"
                           class="btn green btn-sm">{{trans('core.btnView')}} {{trans('core.resume')}}</a>
                        
                    @else
                        <span class="label label-info">@lang("core.noResumeUploaded")</span>
                    @endif
                </p>

            </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn default">{{trans('core.btnClose')}}</button>
</div>


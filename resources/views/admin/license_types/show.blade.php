<div class="tabbable-custom ">
    <ul class="nav nav-tabs ">
        <li class="active">
            <a href="#details" data-toggle="tab" aria-expanded="true">
                Contact Request </a>
        </li>
        <li class="">
            <a href="#resume" data-toggle="tab" aria-expanded="false">
                Reply </a>
        </li>

    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="details">
            <p>
                Contact Request Details
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover">

                    <tbody>
                    <tr>
                        <td><strong>{{trans('core.id')}}:</strong></td>
                        <td>{{$request->id}}</td>

                    </tr>
                    <tr>
                        <td><strong>{{trans('core.name')}}:</strong></td>
                        <td>{{$request->name}}</td>

                    </tr>
                    <tr>
                        <td><strong>{{trans('core.email')}}:</strong></td>
                        <td> {{$request->email}}</td>
                    </tr>

                    <tr>
                        <td><strong>Category:</strong></td>
                        <td> {{$request->category}}</td>
                    </tr>
                    <tr>
                        <td><strong>Details:</strong></td>
                        <td> {!! $request->details !!}</td>
                    </tr>
                    <tr>
                        <td><strong>{{trans('core.appliedOn')}}:</strong></td>
                        <td> {{$request->created_at}}</td>
                    </tr>

                    <tr>
                        <td><strong>{{trans('core.status')}}</strong></td>
                        <td> <span  class='margin-bottom-10 label label-{{$color[$request->status]}}'>{{$request->status}}</span></td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane" id="resume">
            <p><strong>{{trans('core.coverLetter')}}:</strong></p>
            <p>
                {{$job_application->cover_letter ?? ''}}
            </p>

            <p>
            {!! Form::open(array('url'=>"",'class'=>'form-horizontal ','method'=>'POST','id'=>'edit_form')) !!}

                <div id="error_edit"></div>
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('core.email')}}: <span class="required">
                        * </span>
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="email_id" name="email_id" placeholder="{{trans('core.email')}}" value="{{$request->email}}" readonly >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Body: <span class="required">
                        * </span>
                        </label>
                        <div class="col-md-8">
                            <textarea id="body" class="form-control" name="body"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" id="submitbutton_edit"  class=" btn green"><i class="fa fa-edit"></i> {{trans('core.btnSubmit')}}</button>
                        </div>
                    </div>
                </div>
            {!!  Form::close()  !!}
        </div>

    </div>
</div>

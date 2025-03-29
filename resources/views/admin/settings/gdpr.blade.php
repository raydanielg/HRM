@extends('admin.adminlayouts.adminlayout')

@section('mainarea')

    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                {{$pageTitle}}
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>

            <li>
                <span class="active"> {{trans('core.settings')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            <div id="load">

                {{--INLCUDE ERROR MESSAGE BOX--}}

                {{--END ERROR MESSAGE BOX--}}


            </div>
            <div class="portlet light bordered">

                <div class="portlet-body form">

                    <h3>General Data Protection Regulation</h3>
                    <hr>
                    <div class="note note-info">
                        <strong>Note:</strong> Enabling GPPR will <span class="label label-success">encrypt</span> all basic information of employees and admin into the database.
                        <p></p>
                        <br>
                        <p>1. Before clicking update make sure you really want to encrypt/decrypt the data</p>
                        <br>
                        <p>2. Data may get lost if not done properly</p>
                        <br>
                        <p><strong>Recommended:</strong> Do it when setting up the application when no company is registered </p>

                    </div>
                    <!------------------------ BEGIN FORM---------------------->
                    {!!  Form::model($setting, ['method' => 'PUT','class'=>'form-horizontal', 'id' => 'gdprSettings'])  !!}

                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-2 control-label">Enable GDPR: <span class="required">
                                        * {!! help_text("gdpr") !!} </span>
                            </label>
                            <div class="col-md-6">
                                <label class="radio-inline"><input type="radio" name="gdpr" value="1"
                                                                   @if($setting->gdpr) checked @endif >Yes</label>
                                <label class="radio-inline"><input type="radio" name="gdpr" value="0"
                                                                   @if(!$setting->gdpr) checked @endif>No</label>
                            </div>
                        </div>


                        <!------------------------- END FORM ----------------------->

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-9">
                                <button type="submit" onclick="updateModal();return false;"

                                        class="btn green">{{trans('core.btnUpdate')}}</button>

                            </div>
                        </div>
                    </div>
                    {!! Form::close()  !!}
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->

            </div>
        </div>
    </div>

    {{--DELETE Model--}}
    <div id="updateModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{trans('core.confirmation')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="note note-success" id="info">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal"
                            class="btn dark btn-outline">{{trans('core.btnCancel')}}</button>
                    <button type="button" data-dismiss="modal" class="btn green" id="delete"><i
                                class="fa fa-check"></i> {{trans('core.btnSubmit')}}</button>
                </div>
            </div>
        </div>
    </div>

    {{--END DELETE MODAL--}}


    <!-- END PAGE CONTENT-->
@stop

@section('footerjs')

    <script>

        function updateModal() {
            var status = $('[name=gdpr]:checked').val();
            var text = '';

            if (status == 1) {
                text = 'Enabling GPPR will <span class="label label-success">encrypt</span> all basic information of employees and admin into the database'
            } else {
                text = 'Disabling GPPR will <span class="label label-danger">decrypt</span> all basic information of employees and admin into the database'
            }

            $('#updateModal').modal('show');

            $("#updateModal").find('#info').html(text);

            $('#updateModal').find("#delete").off().click(function () {

                var url = "{{ route('admin.settings.update-gdpr') }}";
                $.easyAjax({
                    type: 'POST',
                    url: url,
                    container: '#gdprSettings',
                    data: $('#gdprSettings').serialize(),
                });

            });
        }

    </script>
    <!-- END PAGE LEVEL PLUGINS -->
@stop

@extends('admin.adminlayouts.adminlayout')


@section('mainarea')

    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                {{ trans('pages.superAdminDashboard.title') }}
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <span class="active">{{ trans('pages.superAdminDashboard.title') }}</span>
            </li>
        </ul>

    </div>
    <!-- END PAGE HEADER-->

    <div class="row">
        <div class="col-md-12">

            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            <div class="portlet light bordered">

                <div class="portlet-body">

                    @include('vendor.froiden-envato.update.update_blade')

                    <div class="row">
                        @include('vendor.froiden-envato.update.changelog')
                        <div class="col-md-6">
                            <h4 class="box-title" id="structure">@lang('core.systemDetails')</h4>
                            @include('vendor.froiden-envato.update.version_info')
                        </div>


                    </div>

                    <hr>
                    <div class="clearfix"></div>

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->

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
                <div class="modal-body" id="info">
                    <p>
                        Take backup of files and database before updating!
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal"
                            class="btn dark btn-outline">{{trans('core.btnCancel')}}</button>
                    <button type="button" data-dismiss="modal" id="success" class="btn green"><i
                                class="fa fa-check"></i> Yes, update it!
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{--END DELETE MODAL--}}



@stop

@section('footerjs')
    @include('vendor.froiden-envato.update.update_script')
@stop

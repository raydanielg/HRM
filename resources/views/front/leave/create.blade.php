<div class="modal-header">
    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
    <h4 id="myLargeModalLabel" class="modal-title">
        {{__('menu.applyLeave')}}
    </h4>
</div>
<div class="modal-body">
    <div class="portlet-body form">

        <div class="tab-v1 margin-bottom-40">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#button-1"
                                      data-toggle="tab">  {{__('core.singleDateLeave')}}</a></li>
                <li class=""><a href="#button-2"
                                data-toggle="tab">  {{__('core.multipleDateleave')}}</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="button-1">
                    <div class="clearfix margin-bottom-10"></div>
                    {{--<div id="alert"></div>--}}
                    <!------------------------------ BEGIN FORM ----------------------------------------->
                    {!! Form::open(array('class'=>'sky-form','id'=>'single_leaves_form','method'=>'POST')) !!}
                    <input type="hidden" name="days_single" id="days_single" value="1">
                    <input type="hidden" name="leaveformType" id="leaveformType" value="single_leaves">

                    <div class="row">
                        <div class="col-md-3 form-group">
                            <div>
                                <label class="input">
                                    <i class="icon-append fa fa-calendar"></i>
                                    <input type="text" class="margin-bottom-10 from-control" name="date[0]" id="leave"
                                           placeholder="{{trans('core.leaveDate')}}">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2 form-group">
                            <div>
                                {!!  Form::select('leaveType[0]', $leaveTypes,null,['class' => ' form-control leaveType margin-bottom-10','id'=>'leaveType[0]','onchange'=>'halfDayToggle(0,this.value)'] )  !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            {!!  Form::checkbox('halfleaveType[0]', 'yes',null,['class' => 'form-control margin-bottom-10 margin-bottom-10'] )  !!}
                            Half Day
                        </div>
                        <div class="col-md-5">
                            <input class="form-control form-control-inline margin-bottom-10" type="text"
                                   name="reason[0]" placeholder="{{trans('core.reason')}}"/>
                        </div>
                    </div>
                    <div id="insertBefore"></div>

                    <button type="button" id="plusButton" class="btn-u btn-u-green margin-bottom-10">
                        {{trans('core.addMore')}} <i class="fa fa-plus"></i>
                    </button>
                    <div class="row">
                        <div class="col-md-offset-4 col-md-8">
                            <button type="submit" class="btn-u btn-u-sea"
                                    onclick="submitLeaves('single_leaves');return false;"><i
                                        class="fa fa-check"></i> {{trans('core.btnSubmit')}}</button>

                        </div>

                    </div>
                {!!  Form::close()  !!}
                <!------------------------ END FORM ------------------------------------------>

                </div>
                <div class="tab-pane fade" id="button-2">
                    <div class="clearfix margin-bottom-10"></div>

                    <div id="error_date_range"></div>
                    <!------------------------------ Mutiple BEGIN FORM ----------------------------------------->
                    {!! Form::open(array('class'=>'form-horizontal sky-form','id'=>'date_range_form','method'=>'POST')) !!}

                    <input type="hidden" name="days" id="days" value="0">
                    <input type="hidden" name="leaveformType" id="leaveformType" value="date_range">

                    <div class="row">

                        <label for="inputEmail1"
                               class="col-lg-2 control-label">{{trans('core.dateRange')}}</label>
                        <div class="col col-4 form-group">
                            <div class="">
                                <label class="input">
                                    <i class="icon-append fa fa-calendar"></i>
                                    <input class="form-control" type="text" name="start_date" id="start_date"
                                           placeholder="{{trans('core.startDate')}}">
                                </label>
                            </div>
                        </div>
                        <div class="col col-4 form-group margin-left-25">
                            <div class="">
                                <label class="input">
                                    <i class="icon-append fa fa-calendar"></i>
                                    <input class="form-control" type="text" name="end_date" id="end_date"
                                           placeholder="{{trans('core.endDate')}}">
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="inputEmail1"
                               class="col-lg-2 control-label">{{trans('core.selectedDays')}} </label>
                        <div class="col-lg-2" style="margin-top: 6px;">
                            <span id="daysSelected" class="badge rounded-2x badge-red">0</span>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1"
                               class="col-lg-2 control-label">{{trans('core.leaveTypes')}}</label>
                        <div class="col-lg-6">
                            {!!  Form::select('leaveType', $leaveTypes,null,['class' => 'form-control','id'=>'date_range_leaveType'] )  !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword1"
                               class="col-lg-2 control-label">{{trans('core.reason')}}</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" name="reason"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn-u btn-u-green" id="submitbutton_date_range"
                                    onclick="submitLeaves('date_range');return false;">{{trans('core.btnSubmit')}}</button>
                        </div>
                    </div>
                {!! Form::close() !!}

                <!------------------------ END FORM ------------------------------------------>
                </div>
            </div>
        </div>


    </div>
    <div class="alert alert-info">
        <strong>{{trans('messages.note')}}!</strong> {{trans('messages.dateRangeNote')}}
    </div>
</div>
<script>

    jQuery(document).ready(function ($) {
        "use strict";
        $('.contentHolder').perfectScrollbar();

        $('#start_date').datepicker({
            dateFormat: 'dd/mm/yy',
            prevText: '<i class="fa fa-angle-left"></i>',
            nextText: '<i class="fa fa-angle-right"></i>',
            minDate: 0,

            onSelect: function (selectedDate) {

                var diff = ($("#end_date").datepicker("getDate") -
                    $("#start_date").datepicker("getDate")) /
                    1000 / 60 / 60 / 24 + 1; // days
                if ($("#end_date").datepicker("getDate") != null) {
                    $('#daysSelected').html(diff);
                    $('#days').val(diff);
                }
                $('#end_date').datepicker('option', 'minDate', selectedDate);
            }
        });
        $('#end_date').datepicker({
            dateFormat: 'dd/mm/yy',
            prevText: '<i class="fa fa-angle-left"></i>',
            nextText: '<i class="fa fa-angle-right"></i>',
            onSelect: function (selectedDate) {

                $('#start_date').datepicker('option', 'maxDate', selectedDate);

                var diff = ($("#end_date").datepicker("getDate") -
                    $("#start_date").datepicker("getDate")) /
                    1000 / 60 / 60 / 24 + 1; // days
                if ($("#start_date").datepicker("getDate") != null) {
                    $('#daysSelected').html(diff);
                    $('#days').val(diff);
                }

            }
        });

    });

    $('input[type=checkbox]').uniform();
    $('#leave').datepicker({
            prevText: '<i class="fa fa-angle-left"></i>',
            nextText: '<i class="fa fa-angle-right"></i>',
            dateFormat: 'dd/mm/yy',
            minDate: 0

        }
    );
    $('.halfLeaveType').hide();
    var $insertBefore = $('#insertBefore');
    var $i = 0;

    $('#plusButton').click(function () {

        $i = $i + 1;

        $(' <div class="row" id="row' + $i + '"> ' +
            '<div class="col-md-3 form-group"><div><label class="input"><i class="icon-append fa fa-calendar"></i><input type="text" class="margin-bottom-10 form-control" name="date[' + $i + ']" id="leave' + $i + '" placeholder="Leave Date"></label></div></div>' +
            '<div class="col-md-2">{!! Form::select('leaveType[]', $leaveTypes,null,['class' => 'form-control margin-bottom-10 leaveType','id'=>'leaveType','onchange'=>'halfDayToggle(0,this.value)'] ) !!}</div>' +
            '<div class="col-md-2">{!! Form::checkbox('halfleaveType[]', 'yes',null,['class' => 'form-control margin-bottom-10','id'=>'halfLeaveType'] ) !!} Half Day</div>' +
            '<div class="col-md-5"><input class="form-control margin-bottom-10" name="reason[' + $i + ']" type="text" value="" placeholder="Reason"/></div></div>').insertBefore($insertBefore);

        $("#row" + $i + " .leaveType").attr('id', 'leaveType' + $i);
        $("#row" + $i + " .halfLeaveType").hide();
        $("#row" + $i + " .halfLeaveType").attr('id', 'halfLeaveType' + $i);
        $("#row" + $i + " .leaveType").attr('onchange', 'halfDayToggle(' + $i + ',this.value)');
        $('input[type=checkbox]').uniform();
        $('#leave' + $i).datepicker({
            prevText: '<i class="fa fa-angle-left"></i>',
            nextText: '<i class="fa fa-angle-right"></i>',
            dateFormat: 'dd/mm/yy',
            minDate: 0,
        });
    });

    function halfDayToggle(id, value) {
        if (value == 'half day') {
            $('#halfLeaveType' + id).show(100);
        } else {
            $('#halfLeaveType' + id).hide(100);
        }
    }

    function submitLeaves(type) {

        var container = $('#' + type + '_form');
        console.log(container , 'submit leave');
        $.easyAjax({
            type: 'POST',
            url: '{{ route('leaves.store') }}',
            data: container.serialize(),
            container: container,
            success: function (response) {
                if (response.status === "success") {
                    // $('#applyLeave').modal('hide');
                    window.location.reload();
                }
            }
        });
    }

</script>

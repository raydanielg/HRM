@extends('front.layouts.frontlayout')

@section('head')

    {!! HTML::style("assets/global/css/plugins.css") !!}
@stop

@section('mainarea')
    <div class="col-md-9">
        <!--Profile Body-->
        <div class="profile-body">
            <div class="row margin-bottom-20">
                <!--Profile Post-->
                <div class="col-sm-12">
                    <a class="btn-u btn-u-dark" href="{{route('front.expenses.index')}}"><i
                                class="fa fa-arrow-left"></i> {{__('menu.back')}}</a>
                    <hr>
                    <div class="panel ">
                        <div class="panel-heading service-block-u">
                            <h3 class="panel-title"><span class="fa fa-plus"></span> Add New Expense</h3>
                        </div>
                        <div class="panel-body">

                            <div class="col-md-12">

                                <!-- Reg-Form -->
                                {!! Form::open(array('class'=>'sky-form ajax_form','id'=>'expenses_form','files'=>true)) !!}


                                <fieldset>
                                    <section>
                                        <div class="form-group">

                                            <label class="label col col-4">Name of item</label>
                                            <div class="col col-8">
                                                <label class="input">

                                                    <input type="text" name="item_name" placeholder="Item" class="form-control">
                                                </label>
                                            </div>
                                            <span class="help-block"></span>
                                        </div>

                                    </section>

                                    <section>
                                        <div class="form-group">

                                            <label class="label col col-4">Location of purchase</label>
                                            <div class="col col-8">
                                                <label class="input">
                                                    <input type="text" name="purchase_from" class="form-control"
                                                           placeholder="Purchased From">
                                                </label>
                                            </div>
                                            <span class="help-block"></span>
                                        </div>

                                    </section>
                                    <section>
                                        <div class="form-group">

                                            <label class="label col col-4">Price</label>
                                            <div class="col col-8">
                                                <label class="input">
                                                    <input type="text" name="price" placeholder="Price"
                                                           value="{{ Input::old('price') }}">
                                                </label>
                                            </div>
                                            <span class="help-block"></span>
                                        </div>


                                    </section>
                                    <section>
                                        <div class="form-group">

                                            <label class="label col col-4">Date of purchase</label>
                                            <div class="col col-8">
                                                <label class="input">
                                                    <input type="text" name="purchase_date" placeholder="Date of purchase"
                                                           id="purchase_date" value="{{ Input::old('purchase_date') }}">
                                                </label>
                                            </div>
                                            <span class="help-block"></span>
                                        </div>

                                    </section>


                                    <section>
                                        <div class="form-group">

                                            <label class="label col col-4">Bill</label>
                                            <div class="col col-8">
                                                <input type="file" name="bill">
                                            </div>
                                            <span class="help-block"></span>
                                        </div>


                                    </section>
                                </fieldset>


                                <footer>
                                    <button type="button" onclick="ajaxCreateExpense();return false;" class="btn-u">
                                        Submit
                                    </button>
                                </footer>
                            {!! Form::close() !!}
                            <!-- End Reg-Form -->
                            </div>
                        </div>
                    </div>


                    <!--End Profile Post-->


                </div><!--/end row-->

                <hr>


            </div>
            <!--End Profile Body-->
        </div>

    </div>


    {{--------------------------Show Notice MODALS-----------------}}


    <div class="modal fade show_notice" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 id="myLargeModalLabel" class="modal-title">
                        Leave Application
                    </h4>
                </div>
                <div class="modal-body" id="modal-data">
                    {{--Notice full Description using Javascript--}}
                </div>
            </div>
        </div>
    </div>


    {{------------------------END Notice MODALS---------------------}}

@stop

@section('footerjs')

    <script>
        $('#purchase_date').datepicker({
            prevText: '<i class="fa fa-angle-left"></i>',
            nextText: '<i class="fa fa-angle-right"></i>',
            dateFormat: 'dd-mm-yy'
        });

        function ajaxCreateExpense() {
            var url = "{{ route('front.expenses.store') }}";
            $.easyAjax({
                type: 'POST',
                url: url,
                container: '.ajax_form',
                file: true,
            });
        }
    </script>


@stop

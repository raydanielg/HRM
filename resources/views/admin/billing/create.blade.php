
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><strong><i class="fa fa-plus"></i> {{trans('core.createInvoice')}}</strong></h4>
    </div>
    {!! Form::open(['url'=>"",'class'=>'form-horizontal ','method'=>'POST','id'=>'create_invoice_form']) !!}
    <div class="modal-body" id="edit-modal-body">
        <div class="portlet-body form">
            <div id="error_edit"></div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-4 control-label">@lang('core.invoiceNumber'): <span class="required">
                            * </span>
                    </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control input-medium" name="invoice_number" id="invoice_number" value="{{ $invoice_number }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">@lang('core.company'): <span class="required">
                            * </span>
                    </label>

                    <div class="col-md-8">
                        <select class="form-control" id="company_id" name="company_id">
                            <option>Select a company...</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">@lang('core.license_number'): <span class="required">
                            * </span>
                    </label>

                    <div class="col-md-8">
                        <input type="text" class="form-control" name="license_number" id="license_number" readonly/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">@lang("core.invoiceDate"): <span class="required">
                            * </span></label>
                    <div class="col-md-8">
                        <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control" readonly name="invoice_date" id="invoice_date" value="{{ \Carbon\Carbon::now()->format("d-m-Y") }}">
                            <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">@lang("core.dueDate"): <span class="required">
                            * </span></label>
                    <div class="col-md-8">
                        <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control" readonly name="due_date" id="due_date" value="{{ \Carbon\Carbon::now()->format("d-m-Y") }}">
                            <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">@lang('core.amount'): <span class="required">
                            * </span>
                    </label>
                    <div class="col-md-8">
                        <input type="number" class="form-control input-medium" name="amount" id="amount"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">@lang('core.transactionID'):
                    </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="transaction_id" id="transaction_id"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">@lang('core.status'): <span class="required">
                            * </span>
                    </label>
                    <div class="col-md-8">
                        <select class="form-control" name="status" id="status">
                            <option value="Unpaid">Unpaid</option>
                            <option value="Paid">Paid</option>
                            <option value="Canceled">Canceled</option>
                            <option value="Error">Error</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">@lang('core.currency'):
                    </label>
                    <div class="col-md-8">
                        <select class="form-control" name="currency" id="currency">
                            <option value="INR">INR</option>
                            <option value="USD">USD</option>
                            <option value="GBP">GBP</option>
                            <option value="EUR">EUR</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">@lang('core.notes'):
                    </label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="notes" id="notes"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">&nbsp;</label>
                    <label>
                        <input type="checkbox" name="send_email" id="send_email"> Send Email
                    </label>
                </div>
                <div class="form-group">
                    <h3>Invoice Items</h3>
                    <table class="table" id="itemsTable">
                        <tr id="item_name_0">
                            <td><input class="form-control" name="item_name[]" placeholder="item"></td>
                            <td><input class="form-control" name="item_amount[]" placeholder="amount"></td>
                            <td><select class="form-control" name="item_type[]">
                                    <option value="Item">Item</option>
                                    <option value="Discount">Discount</option>
                                    <option value="Tax">Tax</option>
                                </select>
                            </td>
                            <td><button type="button" class="btn btn-danger hidden" onclick="removeItem(this);"><i class="fa fa-times"></i></button></td>
                        </tr>
                    </table>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" onclick="addNewItem()"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="submitbutton_create" onclick="submitInvoiceForm();return false;"
                            class=" btn green">{{trans('core.btnSubmit')}}</button>

                </div>
            </div>
        </div>
    </div>
    {!!  Form::close()  !!}			<!-- END EXAMPLE TABLE PORTLET-->
<script type="text/javascript">
    function formatRepo (repo) {
        if (repo.loading) return repo.text;

        var markup = "<div><strong>" + repo.text + "</strong></div><small>" + repo.subdomain + "</small>";

        return markup;
    }

    function formatRepoSelection (repo) {
        if (typeof repo.license_number != "undefined") {
            $("#license_number").val(repo.license_number);
        }
        return repo.text || repo.subdomain;
    }

    function prepareModal() {
        $("#company_id").select2({
            ajax: {
                url: "{{ route("admin.billing.ajax_company_name") }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data.items,
                        pagination: {
                            more: 0
                        }
                    };
                },
                cache: false
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 1,
            dropdownParent: "#createModal",
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        $("#send_email").uniform();

        $('.wysihtml5-sandbox, .wysihtml5-toolbar').remove();
        $('#notes').show();

        $('#notes').wysihtml5({
            "stylesheets": ["http://fonts.googleapis.com/css?family=Source+Sans+Pro&v2",
                "{{ asset("assets/quote-template/style.css") }}"]
        });

        $(".date-picker").datepicker({
            orientation: "left",
            autoclose: true
        });
    }

    var items = 1;

    function addNewItem() {
        var tr = $("#itemsTable").find("tr:first-child").clone();
        tr.attr("id", "item" + items++);

        tr.find("button").removeClass("hidden");

        $("#itemsTable").append(tr);

    }

    function removeItem(element) {
        $(element).closest("tr").remove();
    }

    function submitInvoiceForm() {
        var data = $("#create_invoice_form").serialize();

        $.ajax({
            url: "{{ route("admin.billing.store") }}",
            type: "POST",
            data: data,
            dataType: "json",
            beforeSend: function() {
                $("#submitbutton_create").prop("disabled", true).text("@lang("core.submitting")...");
            },
            success: function(response) {
                if(response.status == "success") {
                    showToastrMessage(response.message, "@lang("core.success")", "success");
                    $("#createModal").modal("hide");
                    table.fnDraw();
                }
                else{
                    showErrors(response.errors);
                }
                $("#submitbutton_create").prop("disabled", false).text("@lang("core.btnSubmit")");
            },
            error: function(xhr, textStatus, thrownError) {
                showToastrMessage("@lang("messages.generalError")", "@lang("core.error")", "error");
                $("#submitbutton_create").prop("disabled", false).val("@lang("core.btnSubmit")");
            }
        })
    }
</script>



<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><strong><i class="fa fa-plus"></i> {{trans('core.editInvoice')}}</strong></h4>
</div>
{!! Form::open(['url'=>"",'class'=>'form-horizontal ','method'=>'POST','id'=>'edit_invoice_form']) !!}
<input type="hidden" name="_method" value="put"/>
<div class="modal-body" id="edit-modal-body">
    <div class="portlet-body form">
        <div id="error_edit"></div>
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-4 control-label">@lang('core.invoiceNumber'): <span class="required">
                        * </span>
                </label>
                <div class="col-md-8">
                    <input type="text" class="form-control input-medium" name="invoice_number" id="invoice_number" value="{{ $invoice->invoice_number }}"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">@lang('core.company'): <span class="required">
                        * </span>
                </label>

                <div class="col-md-8">
                    <select class="form-control" id="company_id" name="company_id">
                        <option value="{{ $invoice->company->id }}" selected>{{ $invoice->company->company_name }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">@lang('core.license_number'): <span class="required">
                        * </span>
                </label>

                <div class="col-md-8">
                    <input type="text" class="form-control" name="license_number" id="license_number" readonly  value="{{ $invoice->license_number }}"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">@lang("core.invoiceDate"): <span class="required">
                        * </span></label>
                <div class="col-md-8">
                    <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy">
                        <input type="text" class="form-control" readonly name="invoice_date" id="invoice_date" value="{{ $invoice->invoice_date->format("d-m-Y") }}">
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
                        <input type="text" class="form-control" readonly name="due_date" id="due_date" value="{{ $invoice->due_date->format("d-m-Y") }}">
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
                    <input type="number" class="form-control input-medium" name="amount" id="amount" value="{{ $invoice->amount }}"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">@lang('core.transactionID'):
                </label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="transaction_id" id="transaction_id" value="{{ $invoice->transaction_id }}"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">@lang('core.status'): <span class="required">
                        * </span>
                </label>
                <div class="col-md-8">
                    <select class="form-control" name="status" id="status">
                        <option value="Unpaid" @if ($invoice->status == "Unpaid") selected @endif>Unpaid</option>
                        <option value="Paid" @if ($invoice->status == "Paid") selected @endif>Paid</option>
                        <option value="Cancelled" @if ($invoice->status == "Cancelled") selected @endif>Cancelled</option>
                        <option value="Error" @if ($invoice->status == "Error") selected @endif>Error</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">@lang('core.currency'): <span class="required">
                        * </span>
                </label>
                <div class="col-md-8">
                    <select class="form-control" name="currency" id="currency">
                        <option value="INR" @if ($invoice->currency == "INR") selected @endif>INR</option>
                        <option value="USD" @if ($invoice->currency == "USD") selected @endif>USD</option>
                        <option value="GBP" @if ($invoice->currency == "GBP") selected @endif>GBP</option>
                        <option value="EUR" @if ($invoice->currency == "EUR") selected @endif>EUR</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">@lang('core.notes'):
                </label>
                <div class="col-md-8">
                    <textarea class="form-control" name="notes" id="notes">{{ $invoice->notes }}</textarea>
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
                    @foreach($invoice->items as $item)
                    <tr id="item_name_0">
                        <td><input class="form-control" name="item_name[]" placeholder="item" value="{{ $item->name }}"></td>
                        <td><input class="form-control" name="item_amount[]" placeholder="amount" value="{{ $item->amount }}"></td>
                        <td><select class="form-control" name="item_type[]">
                                <option value="Item" @if ($item->type == "Item") selected @endif>Item</option>
                                <option value="Discount" @if ($item->type == "Discount") selected @endif>Discount</option>
                                <option value="Tax" @if ($item->type == "Tax") selected @endif>Tax</option>
                            </select>
                        </td>
                        <td><button type="button" class="btn btn-danger" onclick="removeItem(this);"><i class="fa fa-times"></i></button></td>
                    </tr>
                    @endforeach
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
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 1,
            {{--initSelection: function(element, callback) {--}}
                {{--callback({id: "{{ $invoice->id }}", text: "{{ $invoice->company->name }}"});--}}
            {{--}--}}
            dropdownParent: "#editModal",
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

        $("#company_id").trigger("change");

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
        var data = $("#edit_invoice_form").serialize();

        $.ajax({
            url: "{{ route("admin.billing.update", ["id" => $invoice->id]) }}",
            type: "POST",
            data: data,
            dataType: "json",
            beforeSend: function() {
                $("#submitbutton_create").prop("disabled", true).text("@lang("core.submitting")...");
            },
            success: function(response) {
                if(response.status == "success") {
                    showToastrMessage(response.message, "@lang("core.success")", "success");
                    $("#editModal").modal("hide");
                    table.fnDraw();
                }
                else{
                    showErrors(response.errors);
                }
                $("#submitbutton_create").prop("disabled", false).text("@lang("core.btnSubmit")");
            },
            error: function(xhr, textStatus, thrownError) {
                showToastrMessage("@lang("messages.generalError")", "@lang("core.error")", "error");
                $("#submitbutton_create").prop("disabled", false).text("@lang("core.btnSubmit")");
            }
        })
    }
</script>


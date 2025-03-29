<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="packageName">Package</label>
                                    <div>
                                        <select name="package" id="packageName" class="form-control select2">
                                            @foreach($packages as $package)
                                                <option value="{{ $package->id }}"
                                                        @if($company->subscription_plan_id == $package->id) selected @endif >{{ $package->plan_name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="packageType">Package Type</label>
                                    <div>
                                        <select name="packageType" id="packageType" class="form-control select2">
                                            <option value="annual" @if($company->package_type == 'annual') selected @endif >
                                                Annual
                                            </option>
                                            <option value="monthly"
                                                    @if($company->package_type == 'monthly') selected @endif >Monthly
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="packageAmount">Amount</label>
                                    <input type="text" name="amount" id="packageAmount" class="form-control" value="{{ !empty($currentPackage) ? $currentPackage->{$company->package_type . '_price'} : ''}}">
                                </div>
                            </div>

                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Pay Date</label>
                                    <div>
                                        <input type="text" name="pay_date" id="pay_date" class="form-control" data-date-format="dd-mm-yyyy" data-date-viewmode="years" value="{{ $lastInvoice && $lastInvoice->pay_date ? $lastInvoice->pay_date->format('d-m-Y') : ''}}">
                                    </div>

                                </div>
                            </div>

                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Next Pay Date</label>
                                    <div class="input-group input-medium date date-picker">
                                        <input type="text" class="form-control" name="next_pay_date" id="next_pay_date"
                                               data-date-format="dd-mm-yyyy" data-date-viewmode="years"
                                               id="close_date" value="{{ $lastInvoice && $lastInvoice->next_pay_date ? $lastInvoice->next_pay_date->format('d-m-Y') : ''}}" readonly>
                                        <span class="input-group-btn">
																		 <button class="btn default" type="button"><i
                                                                                     class="fa fa-calendar"></i>
																		 </button>
																		 </span>
                                    </div>
                                </div>
                            </div>

                            <!--/span-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Licence Expires On</label>
                                    <div class="input-group input-medium date date-picker">
                                        <input type="text" class="form-control" name="licence_expires_on" id="licence_expires_on" data-date-format="dd-mm-yyyy" data-date-viewmode="years"
                                               id="close_date" value="{{ $company->licence_expire_on ? $company->licence_expire_on->format('d-m-Y') : ''}}" disabled="disabled">
                                        <span class="input-group-btn">
														mm				 <button class="btn default" type="button"><i
                                                                                     class="fa fa-calendar"></i>
																		 </button>
																		 </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! HTML::style("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css") !!}
{!! HTML::script("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") !!}
<script>
    var packageInfo = @json($packageInfo)

    $("#pay_date").datepicker({
        todayHighlight: true,
        autoclose: true,
    }).on('change', function () {
        updateExpiryDate();
    });

    $("#next_pay_date").datepicker({
        todayHighlight: true,
        autoclose: true,
    });

    $('#packageType').off().on('change', function () {
        $('#packageAmount').val(packageInfo[$('#packageName').val()][$(this).val()]);
        updateExpiryDate();
    });

    $('#packageName').off().on('change', function () {
        $('#packageAmount').val(packageInfo[$(this).val()][$('#packageType').val()]);
    });

    function updateExpiryDate() {
        let startDate = moment($("#pay_date").val(), "MM-DD-YYYY");
        let endDate = startDate.add(1, ($('#packageType').val() === 'monthly') ? 'months' : 'year').format("MM/DD/YYYY");
        $('#licence_expires_on').val(endDate);
    }

    $('#update-company-form').off().submit(function (e) {
        e.preventDefault();
        const PackageName = $('#packageName').val();
        const PackageType = $('#PackageType').val();
        $.easyAjax({
            url: '{{route('admin.companies.edit-package.post', [$company->id])}}',
            container: '#update-company-form',
            type: "POST",
            redirect: false,
            data: $(this).serialize(),
            success: function (response) {
                if(response.status === 'success') {
                    $('#packageUpdateModal').modal('hide');
                }

            }
        });
    });
</script>

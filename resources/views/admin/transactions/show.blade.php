<div class="tabbable-custom ">
    <ul class="nav nav-tabs ">
        <li class="active">
            <a href="#details" data-toggle="tab" aria-expanded="true">
                Transactions </a>
        </li>
        <li class="">
            <a href="#user_details" data-toggle="tab" aria-expanded="false">
                User Details </a>
        </li>

    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="details">
            <p>
                Transactions Details
            </p>

            <div class="table-responsive">
                <table class="table table-striped table-hover">

                    <tbody>
                    <tr>
                        <td><strong>{{trans('core.id')}}:</strong></td>
                        <td>{{$transaction->id}}</td>
                    </tr>
                    <tr>
                        <td><strong>Payer Id:</strong></td>
                        <td>{{$transaction->payer_id}}</td>
                    </tr>
                    <tr>
                        <td><strong>Transaction Id:</strong></td>
                        <td>{{$transaction->transaction_id}}</td>
                    </tr>
                    <tr>
                        <td><strong>{{trans('core.name')}}:</strong></td>
                        <td>{{$transaction->payer_fname}} {{$transaction->payer_lname}}</td>

                    </tr>

                    <tr>
                        <td><strong>{{trans('core.email')}}:</strong></td>
                        <td> {{$transaction->payer_email}}</td>
                    </tr>
                    <tr>
                        <td><strong>Amount:</strong></td>
                        <td> {{ $transaction->amount }} {{ $transaction->currency_code }}</td>
                    </tr>
                    <tr>
                        <td><strong>Payment Status:</strong></td>
                        <td> {{ $transaction->payment_status }}</td>
                    </tr>
                    <tr>
                        <td><strong>Created At:</strong></td>
                        <td> {{$transaction->created_at}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane" id="user_details">
            <p><strong>User Details:</strong></p>

            <p>

            <div class="table-responsive">
                <table class="table table-striped table-hover">

                    <tbody>
                    @if($transaction->user_details!='')
                        @foreach(json_decode($transaction->user_details) as $index=>$value)
                            @if($index!='snap_time' && $index !='_token' && $index !='HRM')
                                <tr>
                                    <td><strong>{{$index}}:</strong></td>
                                    <td>@if($index=='plan'){{ \App\Models\LicenseType::getPlanName($value) }} @else{{ $value }}@endif</td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
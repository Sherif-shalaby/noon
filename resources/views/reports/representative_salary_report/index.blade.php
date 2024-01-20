@extends('layouts.app')
@section('title', __('lang.representative_salary_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.representative_salary_report')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.reports')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.representative_salary_report')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    {{-- <!-- Start row -->
    <div class="row d-flex justify-content-center">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30 p-2">


            </div>
        </div>
    </div> --}}
       <!-- Start Contentbar -->
       <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.products')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    {{-- @include('products.filters')  --}}
                                </div>
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>@lang('lang.date')</th>
                                    <th>@lang('lang.employee_name')</th>
                                    <th>@lang('lang.payment_method')</th>
                                    <th>@lang('lang.salary')</th>
                                    <th>@lang('lang.commission')</th>
                                    <th>@lang('lang.paid_amount')</th>
                                    <th>@lang('lang.duePaid')</th>
                                    <th>@lang('lang.payment_status')</th>
                                    {{-- <th>@lang('lang.action')</th>  --}}
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wages as $wage)
                                        @php
                                            $totalAmount = 0; // Initialize the totalAmount for each wage record
                                            foreach ($wage->wage_transaction->transaction_payments as $payment) {
                                                $totalAmount += $payment->amount;
                                            }
                                        @endphp
                                        <tr>
                                            <td title="@lang('lang.date')">{{ \Carbon\Carbon::parse($wage->wage_transaction->transaction_date)->format('Y-m-d') }}</td>
                                            <td title="@lang('lang.employee_name')">{{ $wage->employee->employee_name }}</td>
                                            <td title="@lang('lang.payment_method')">{{ $wage->payment_type }}</td>
                                            <td title="@lang('lang.salary')">{{ $wage->employee->fixed_wage_value }}</td>
                                            <td title="@lang('lang.commission')">{{ number_format($wage->employee->commission_value,num_of_digital_numbers()) }}</td>
                                            <td title="@lang('lang.paid_amount')">{{ number_format($totalAmount,num_of_digital_numbers()) }}</td>
                                            <td title="@lang('lang.duePaid')">{{ number_format($wage->wage_transaction->final_total - $totalAmount,num_of_digital_numbers()) }}</td>
                                            <td title="@lang('lang.payment_status')">{{ $wage->wage_transaction->payment_status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="view_modal no-print" >

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
@endsection



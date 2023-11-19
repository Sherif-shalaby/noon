@extends('layouts.app')
@section('title', __('lang.representative_salary_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.representative_salary_report')
                </h4>
                <div class="breadcrumb-list">
                    <ul style=" list-style: none;"
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                @lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                            aria-current="page">/ @lang('lang.reports')</li>
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                            aria-current="page">@lang('lang.representative_salary_report')</li>
                    </ul>
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
                        <h5 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            @lang('lang.products')</h5>
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
                        <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                            <table id="datatable-buttons" class="table table-button-wrapper table-striped table-bordered">
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
                                            <td>{{ \Carbon\Carbon::parse($wage->wage_transaction->transaction_date)->format('Y-m-d') }}
                                            </td>
                                            <td>{{ $wage->employee->employee_name }}</td>
                                            <td>{{ $wage->payment_type }}</td>
                                            <td>{{ $wage->employee->fixed_wage_value }}</td>
                                            <td>{{ number_format($wage->employee->commission_value, 2) }}</td>
                                            <td>{{ number_format($totalAmount, 2) }}</td>
                                            <td>{{ number_format($wage->wage_transaction->final_total - $totalAmount, 2) }}
                                            </td>
                                            <td>{{ $wage->wage_transaction->payment_status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="view_modal no-print">

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

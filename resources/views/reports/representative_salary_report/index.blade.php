@extends('layouts.app')
@section('title', __('lang.representative_salary_report'))


@push('css')
    <style>
        .table-top-head {
            top: 35px !important;
        }

        .table-scroll-wrapper {
            width: fit-content;
        }

        @media(min-width:1900px) {
            .table-scroll-wrapper {
                width: 100%;
            }
        }

        .rightbar {
            z-index: 2;
        }

        @media(max-width:991px) {
            .table-top-head {
                top: 35px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 35px !important
            }
        }

        .wrapper1 {
            margin-top: 30px;
        }

        .input-wrapper {
            width: 100% !important;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 115px;
            }

            .input-wrapper {
                width: 60%
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.representative_salary_report')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">/
        @lang('lang.reports')</li>
    <li class="breadcrumb-item   @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.representative_salary_report')</li>
@endsection

@section('content')
    <div class="animate-in-page">


        <!-- Start Contentbar -->
        <div class="contentbar mb-0 pb-0">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h6 class="card-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.products')</h6>
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
                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2 table-scroll-wrapper">
                                    <!-- content goes here -->
                                    <div style="min-width: 1800px;max-height: 90vh;overflow: auto">
                                        <table id="datatable-buttons"
                                            class="table table-striped table-hover table-bordered ">
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
                                                        <td title="@lang('lang.date')">
                                                            {{ \Carbon\Carbon::parse($wage->wage_transaction->transaction_date)->format('Y-m-d') }}
                                                        </td>
                                                        <td title="@lang('lang.employee_name')">{{ $wage->employee->employee_name }}
                                                        </td>
                                                        <td title="@lang('lang.payment_method')">{{ $wage->payment_type }}</td>
                                                        <td title="@lang('lang.salary')">
                                                            {{ $wage->employee->fixed_wage_value }}</td>
                                                        <td title="@lang('lang.commission')">
                                                            {{ number_format($wage->employee->commission_value, num_of_digital_numbers()) }}
                                                        </td>
                                                        <td title="@lang('lang.paid_amount')">
                                                            {{ number_format($totalAmount, num_of_digital_numbers()) }}
                                                        </td>
                                                        <td title="@lang('lang.duePaid')">
                                                            {{ number_format($wage->wage_transaction->final_total - $totalAmount, num_of_digital_numbers()) }}
                                                        </td>
                                                        <td title="@lang('lang.payment_status')">
                                                            {{ $wage->wage_transaction->payment_status }}
                                                        </td>
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
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
    </div>
    <!-- End Contentbar -->
@endsection

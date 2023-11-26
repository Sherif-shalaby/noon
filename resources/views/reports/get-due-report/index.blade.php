@extends('layouts.app')
@section('title', __('lang.get_due_report'))
@section('breadcrumbbar')
    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.get_due_report')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item"><a style="text-decoration: none;color: #596fd7"
                                    href="{{ url('/') }}">/ @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">/ @lang('lang.reports')</li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('lang.get_due_report')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">
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
                            <div class="table-responsive
                            @if (app()->isLocale('ar')) dir-rtl @endif"
                                style="height: 90vh;overflow: scroll">
                                <table id="datatable-buttons"
                                    class="table dataTable table-hover table-button-wrapper table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('lang.date')</th>
                                            <th>@lang('lang.reference')</th>
                                            <th>@lang('lang.customer')</th>
                                            <th>@lang('lang.amount')</th>
                                            <th>@lang('lang.paid')</th>
                                            <th>@lang('lang.duePaid')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $total_paid = 0;
                                            $total_due = 0;
                                        @endphp
                                        @foreach ($dues as $due)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.date')">

                                                        {{ @format_date($due->transaction_date) }}
                                                </td>
                                                </span>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.reference')">

                                                        {{ $due->invoice_no }}
                                                </td>
                                                </span>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.customer')">

                                                        {{ $due->customer->name ?? '' }}
                                                </td>
                                                </span>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.amount')">

                                                        {{ @num_format($due->final_total) }}
                                                </td>
                                                </span>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.paid')">

                                                        {{ @num_format($due->transaction_payments->sum('amount')) }}
                                                </td>
                                                </span>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.duePaid')">

                                                        {{ @num_format($due->final_total - $due->transaction_payments->sum('amount')) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                                $total_paid += $due->transaction_payments->sum('amount');
                                                $total_due += $due->final_total - $due->transaction_payments->sum('amount');
                                            @endphp
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
    </div>
    <!-- End Contentbar -->
@endsection

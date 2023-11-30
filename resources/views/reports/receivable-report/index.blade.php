@extends('layouts.app')
@section('title', __('lang.receivable_report'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.receivable_report')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">/ @lang('lang.reports')</li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.receivable_report')</li>
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
                                        @include('reports.receivable-report.filters')
                                    </div>
                                </div>
                            </div>
                            {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                            <div class="table-responsive  @if (app()->isLocale('ar')) dir-rtl @endif">
                                <table id="datatable-buttons"
                                    class="table  table-button-wrapper table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>تاريخ</th>
                                            <th>المرجعي</th>
                                            <th>عميل</th>
                                            <th>حالة المبيعات</th>
                                            <th>حالة السداد</th>
                                            {{-- <th>العملة المٌستلمة</th> --}}
                                            <th>المبلغ الاجمالي</th>
                                            {{-- <th>@lang('lang.action')</th>  --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaction_sell_lines as $key => $transaction_sell_line)
                                            <tr>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600" data-tooltip="تاريخ">
                                                        {{ $transaction_sell_line->created_at->format('Y-m-d') ?? '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600" data-tooltip="المرجعي">
                                                        {{ $transaction_sell_line->invoice_no ?? '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600" data-tooltip="عميل">
                                                        {{ $transaction_sell_line->customer->name ?? '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="حالة المبيعات">
                                                        {{ $transaction_sell_line->status ?? '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600" data-tooltip="حالة السداد">
                                                        {{ $transaction_sell_line->payment_status ?? '' }}
                                                    </span>
                                                </td>
                                                {{-- <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="العملة المٌستلمة">
                                                        {{ $transaction_sell_line->transaction_currency_relationship->symbol ?? '' }}
                                                    </span>
                                                </td> --}}
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="المبلغ الاجمالي">
                                                        {{ $transaction_sell_line->final_total ?? '' }}
                                                    </span>
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
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
    </div>
    <!-- End Contentbar -->
@endsection

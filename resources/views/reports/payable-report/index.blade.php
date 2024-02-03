@extends('layouts.app')
@section('title', __('lang.payable_report'))


@push('css')
    <style>
        .table-top-head {
            top: 65px !important;
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
                top: 65px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 160px !important
            }
        }

        .wrapper1 {
            margin-top: 20px;
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
    @lang('lang.payable_report')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">/
        @lang('lang.reports')</li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.payable_report')</li>
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
                        {{-- <div class="card-header">
                            <h5 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.products')</h5>
                        </div> --}}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="container-fluid">
                                        @include('reports.payable-report.filters')
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
                                            class="table table-striped table-bordered  table-hover ">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>@lang('lang.total_paid')</th>
                                                    <th>@lang('lang.action')</th>

                                                </tr>
                                            </thead>
                                            <tbody>



                                                @php
                                                    // ///////////////////// الرواتب/////////////////////
                                                    $wage_transactions_final_total = !empty($wage_transactions->sum('final_total')) ? $wage_transactions->sum('final_total') : '';
                                                    // ///////////////////// المشتريات /////////////////////
                                                    $stock_transactions_final_total = !empty($stock_transactions->sum('final_total')) ? $stock_transactions->sum('final_total') : '';
                                                @endphp

                                                {{-- ++++++++++++++++++ Row 1 : الرواتب ++++++++++++++++++ --}}
                                                <tr>
                                                    {{-- ====== column header ====== --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600">
                                                            <b>@lang('lang.wages')</b>
                                                        </span>
                                                    </td>
                                                    {{-- ====== wage_transactions_final_total ====== --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="total_paid">

                                                            @if (!empty($wage_transactions_final_total))
                                                                {{ $wage_transactions_final_total }}
                                                            @endif
                                                        </span>
                                                    </td>
                                                    {{-- ====== Actions button ====== --}}
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            style="font-size: 12px;font-weight: 600" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            @lang('lang.action')
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu">
                                                            <li>
                                                                <a href="{{ route('wages.index') }}"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                                    target="_blank">
                                                                    <i class="fa fa-eye"></i>
                                                                    @lang('lang.view') </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                {{-- +++++++++ Row 2 : المشتريات +++++++++ --}}
                                                <tr>
                                                    {{-- ====== column header ====== --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600">
                                                            <b>@lang('lang.stock')</b>
                                                        </span>
                                                    </td>
                                                    {{-- ====== stock_transactions_final_total ====== --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="total_paid">
                                                            @if (!empty($stock_transactions_final_total))
                                                                {{ $stock_transactions_final_total }}
                                                            @endif
                                                        </span>
                                                    </td>
                                                    {{-- ====== Actions button ====== --}}
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            @lang('lang.action')
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu">
                                                            <li>
                                                                <a href="{{ route('stocks.index') }}"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                                    target="_blank">
                                                                    <i class="fa fa-eye"></i>
                                                                    @lang('lang.view')
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                {{-- +++++++++ Row 3 : مجموع الرواتب و المشتريات  +++++++++ --}}
                                                <tr>
                                                    {{-- ====== column header ====== --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600">
                                                            <b>@lang('lang.total')</b>
                                                        </span>
                                                    </td>
                                                    {{-- ====== sum of stock_transactions and wage_transactions final_total ====== --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="total_paid">
                                                            @if (!empty($wage_transactions_final_total) && !empty($stock_transactions_final_total))
                                                                {{ $wage_transactions_final_total + $stock_transactions_final_total }}
                                                            @endif
                                                        </span>
                                                    </td>
                                                    {{-- ====== Actions button ====== --}}
                                                    <td>

                                                    </td>
                                                </tr>
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

@extends('layouts.app')
@section('title', __('lang.receivable_report'))
@section('breadcrumbbar')
    <style>
        .table-top-head {
            top: 130px !important;
        }

        .table-scroll-wrapper {
            width: fit-content;
        }

        @media(min-width:1900px) {
            .table-scroll-wrapper {
                width: 100%;
            }
        }



        @media(max-width:991px) {
            .table-top-head {
                top: 130px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 200px !important
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
        <div class="contentbar mb-0 pb-0">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card mb-0">
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
                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2 table-scroll-wrapper">
                                    <!-- content goes here -->
                                    <div style="min-width: 1800px;max-height: 90vh;overflow: auto">
                                        <table id="datatable-buttons"
                                            class="table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('lang.date') }}</th>
                                                    <th>{{ __('lang.reciever') }}</th>
                                                    <th>{{ __('lang.received_amount') }}</th>
                                                    <th>{{ __('lang.paid_by') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cash_register_transactions as $key => $cash_register_transaction)
                                                    <tr>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="{{ __('lang.date') }}">
                                                                {{ $cash_register_transaction->created_at->format('Y-m-d') ?? '' }}
                                                            </span>
                                                        </td>
                                                        <!-- Accessing the cash_register relationship to get the user's cash_register_id -->
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="{{ __('lang.reciever') }}">
                                                                {{ $cash_register_transaction->cash_register->cashier->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="{{ __('lang.received_amount') }}">
                                                                {{ $cash_register_transaction->amount ?? '' }}
                                                            </span>
                                                        </td>
                                                        <!-- Accessing the cash_register relationship to get the user_id -->
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="{{ __('lang.paid_by') }}">
                                                                {{ $cash_register_transaction->cash_register->store_pos->name ?? '' }}
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
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
    </div>
    <!-- End Contentbar -->
@endsection

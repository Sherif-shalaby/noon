@extends('layouts.app')
@section('title', __('lang.receivable_report'))


@push('css')
    <style>
        .table-top-head {
            top: 95px !important;
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
                top: 95px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 180px !important
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
    @lang('lang.receivable_report')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">/
        @lang('lang.reports')</li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.receivable_report')</li>
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
                            <h6 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.products')</h6>
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
                                        <table id="example" class="table table-hover table-striped table-bordered">
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
                                            <tfoot>
                                                <td colspan="2" style="text-align: right">@lang('lang.total')</td>
                                                <td id="sum1"></td>
                                                <td colspan="1"></td>
                                            </tfoot>
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

@push('javascripts')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: "<'row'<'col-md-3 'l><'col-md-5 text-center 'B><'col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4'i><'col-sm-4'p>>",
                lengthMenu: [10, 25, 50, 75, 100, 200, 300, 400],
                pageLength: 10,
                buttons: ['copy', 'csv', 'excel', 'pdf',
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ":visible:not(.notexport)"
                        }
                    }
                    // ,'colvis'
                ],
                "fnDrawCallback": function(row, data, start, end, display) {
                    var api = this.api();
                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };
                    // Total over all pages
                    total1 = api.rows({
                        'page': 'current'
                    }).nodes().to$().find('td:eq(2)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);

                    // Update status DIV
                    $('#sum1').html('<span>' + total1 + '<span/>');

                }
            });
        });
    </script>
@endpush

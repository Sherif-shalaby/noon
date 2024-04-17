@extends('layouts.app')
@section('title', __('lang.sells_return'))


@push('css')
    <style>
        .table-top-head {
            top: 35px;
        }

        .wrapper1 {
            margin-top: 35px;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 120px;
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.sells_return')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.sells_return')</li>
@endsection

@section('content')
    <div class="animate-in-page">

        <div class="contentbar">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h6 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.sells_return')</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    {{--                                <div class="container-fluid"> --}}
                                    {{--                                    @include('products.filters') --}}
                                    {{--                                </div> --}}
                                </div>
                            </div>
                            {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2 table-scroll-wrapper">
                                    <!-- content goes here -->
                                    <div style="min-width: 1300px;max-height: 90vh;overflow: auto">
                                        <table id="example" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="date">@lang('lang.date')</th>
                                                    <th>@lang('lang.reference')</th>
                                                    <th>@lang('lang.customer')</th>
                                                    <th>@lang('lang.payment_status')</th>
                                                    <th>@lang('lang.payment_type')</th>
                                                    <th class="currencies">@lang('lang.paying_currency')</th>
                                                    <th class="sum">@lang('lang.grand_total')</th>
                                                    <th class="sum">@lang('lang.paid')</th>
                                                    <th class="sum">@lang('lang.due')</th>
                                                    <th>@lang('lang.notes')</th>
                                                    <th>@lang('lang.files')</th>
                                                    <th class="notexport">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sell_returns as $return)
                                                    <tr>
                                                        <td class="col1">

                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.date')">
                                                                {{ $return->transaction_date }}
                                                            </span>
                                                        </td>
                                                        <td class="col2">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.reference')">
                                                                {{ $return->invoice_no }}
                                                            </span>
                                                        </td>
                                                        <td class="col3">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.customer')">
                                                                {{ $return->customer->name }}
                                                            </span>
                                                        </td>
                                                        <td class="col4">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.payment_status')">
                                                                {{ __('lang.' . $return->payment_status) }}
                                                            </span>
                                                        </td>
                                                        <td class="col5">
                                                            @foreach ($return->transaction_payments as $payment)
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 10px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.payment_type')">
                                                                    {{ __('lang.' . $payment->method) }}<br>
                                                                </span>
                                                            @endforeach
                                                        </td>
                                                        <td class="col6">
                                                            @foreach ($return->transaction_payments as $payment)
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 10px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.paying_currency')">
                                                                    {{ $payment->received_currency_relation->symbol ?? '' }}<br>
                                                                </span>
                                                            @endforeach
                                                        </td>
                                                        <td class="col7">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.grand_total')">
                                                                {{ number_format($return->final_total, num_of_digital_numbers()) }}
                                                            </span>
                                                        </td>
                                                        <td class="col8">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.paid')">
                                                                {{ $return->transaction_payments->sum('amount') }}
                                                            </span>
                                                        </td>
                                                        <td class="col9">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.due')">
                                                                {{ $return->transaction_payments->last()->paid_on ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td class="col10">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip=">@lang('lang.notes')">
                                                                {{ $return->notes }}
                                                            </span>
                                                        </td>
                                                        <td class="col11"></td>
                                                        <td class="col12">
                                                            <button type="button" style="font-size: 10px;font-weight: 600"
                                                                class="btn btn-default btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                @lang('lang.action')
                                                                <span class="caret"></span>
                                                            </button>
                                                            {{--                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu"> --}}
                                                            {{--                                                <li> --}}
                                                            {{--                                                    <a href="{{route('sell.return',$line->id)}}" class="btn"><i class="fa fa-undo"></i>@lang('lang.return') </a> --}}
                                                            {{--                                                </li> --}}
                                                            {{--                                                <li class="divider"></li> --}}

                                                            {{--                                            </ul> --}}
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
    <!-- This will be printed -->
    {{--    <section class="invoice print_section print-only" id="receipt_section"> </section> --}}
@endsection
@push('javascripts')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: "<'row flex-wrap my-2 justify-content-center table-top-head'<'d-flex justify-content-center col-md-2'l><'d-flex justify-content-center col-md-6 text-center 'B><'d-flex justify-content-center col-md-4'f>>" +
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
                    }).nodes().to$().find('td:eq(6)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    total2 = api.rows({
                        'page': 'current'
                    }).nodes().to$().find('td:eq(7)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    // Update status DIV
                    $('#sum1').html('<span>' + total1 + '<span/>');
                    $('#sum2').html('<span>' + total2 + '<span/>');
                }
            });
        });
    </script>
@endpush

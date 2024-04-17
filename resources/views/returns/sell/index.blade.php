@extends('layouts.app')
@section('title', __('lang.sells_return'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.sells_return')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.sells_return')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">

            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.sells_return')</h5>
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
                        <div class="table-responsive">
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
                                                {{ $return->transaction_date }}
                                            </td>
                                            <td class="col2">
                                                {{ $return->invoice_no }}
                                            </td>
                                            <td class="col3">
                                                {{ $return->customer->name }}
                                            </td>
                                            <td class="col4">
                                                {{ __('lang.' . $return->payment_status) }}
                                            </td>
                                            <td class="col5">
                                                @foreach ($return->transaction_payments as $payment)
                                                    {{ __('lang.' . $payment->method) }}<br>
                                                @endforeach
                                            </td>
                                            <td class="col6">
                                                @foreach ($return->transaction_payments as $payment)
                                                    {{ $payment->received_currency_relation->symbol ?? '' }}<br>
                                                @endforeach
                                            </td>
                                            <td class="col7">
                                                {{ number_format($return->final_total, num_of_digital_numbers()) }}
                                            </td>
                                            <td class="col8">
                                                {{ $return->transaction_payments->sum('amount') }}
                                            </td>
                                            <td class="col9">
                                                {{ $return->transaction_payments->last()->paid_on ?? '' }}
                                            </td>
                                            <td class="col10">
                                                {{ $return->notes }}
                                            </td>
                                            <td class="col11"></td>
                                            <td class="col12">
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                <tfoot>
                                    <td colspan="6" style="text-align: right">@lang('lang.total')</td>
                                    <td id="sum1"></td>
                                    <td id="sum2"></td>
                                    <td colspan="5"></td>
                                </tfoot>
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
    <!-- This will be printed -->
    {{-- <section class="invoice print_section print-only" id="receipt_section"> </section> --}}
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

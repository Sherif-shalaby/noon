@extends('layouts.app')
@section('title', __('lang.sales_report'))


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
                top: 55px !important
            }
        }

        .wrapper1 {
            margin-top: 35px;
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
    @lang('lang.sales_report')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">/
        @lang('lang.reports')</li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.sales_report')</li>
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
                                        <table id="example" class="table dataTable table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>اسم المنتج</th>
                                                    <th>مبلغ المبيعات</th>
                                                    <th>الكمية المباعة</th>
                                                    <th>في المخزن</th>
                                                    {{-- <th>@lang('lang.action')</th>  --}}
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($all_products as $index => $product)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="اسم المنتج">

                                                                {{ $product->name }}
                                                            </span>
                                                        </td>

                                                        @php
                                                            // ++++++++++++++++++++ sell_price_var ++++++++++++++++++++
                                                            $sell_price_var = 0;
                                                            $sell_price_var = 0;
                                                            // ++++++++++++++++++++ sell_quantity_var ++++++++++++++++++++
                                                            $sell_quantity = 0;
                                                            // ++++++++++++++++++++ sell_store_var ++++++++++++++++++++
                                                            $sell_store = 0;
                                                            foreach ($product->sell_lines as $key => $sellLine) {
                                                                // =========== sell_quantity ===========
                                                                $sell_quantity =
                                                                    $sell_quantity +
                                                                    ($sellLine->quantity -
                                                                        $sellLine->quantity_returned);
                                                                // =========== sell_price ===========
                                                                if (!empty($sellLine->sell_price)) {
                                                                    $sell_price_var =
                                                                        $sell_price_var + $sellLine->sell_price;
                                                                } else {
                                                                    $sell_price_var =
                                                                        $sell_price_var +
                                                                        $sellLine->dollar_sell_price *
                                                                            $sellLine->exchange_rate;
                                                                }
                                                                // =========== store ===========
                                                                foreach ($product->stock_lines as $key => $stock_line) {
                                                                    $sell_store =
                                                                        $stock_line->quantity -
                                                                        $stock_line->quantity_sold +
                                                                        $stock_line->quantity_returned;
                                                                }
                                                            }
                                                        @endphp
                                                        {{-- ++++++++++ مبلغ المبيعات ++++++++++ --}}
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="مبلغ المبيعات">

                                                                {{ number_format($sell_price_var, num_of_digital_numbers()) }}
                                                        </td>
                                                        </span>
                                                        {{-- ++++++++++ الكمية المباعة +++++++++ --}}
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="الكمية المباعة">


                                                                {{ $sell_quantity }}
                                                        </td>
                                                        </span>
                                                        {{-- ++++++++++ في المخزن ++++++++++ --}}
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="في المخزن">

                                                                {{ $sell_store }}
                                                            </span>
                                                        </td>
                                                        {{-- @foreach ($product->stock_lines as $stockLine)
                                                {{-- ++++++++++ مبلغ المشتريات ++++++++++ --}}
                                                        {{-- <td>
                                                    @if (!empty($stockLine->purchase_price))
                                                        @php
                                                            $purchase_price_var = $purchase_price_var + $stockLine->purchase_price;
                                                        @endphp
                                                        {{  number_format( $purchase_price_var ,num_of_digital_numbers() ) }}
                                                    @elseif( !empty($stockLine->dollar_purchase_price) )
                                                        @php
                                                            $last_exchange_rate = $stockLine->transaction->transaction_payments->last()->exchange_rate;
                                                            $purchase_price_var = $purchase_price_var + $stockLine->dollar_purchase_price * $last_exchange_rate;
                                                        @endphp
                                                        {{  number_format( ( $purchase_price_var ) ,num_of_digital_numbers() ) }}
                                                    @endif
                                                </td> --}}
                                                        {{-- ++++++++++ الكمية المشتراة++++++++++ --}}
                                                        {{-- <td>
                                                    {{ number_format($stockLine->quantity,num_of_digital_numbers()) }}
                                                </td> --}}
                                                        {{-- ++++++++++ في المخزن ++++++++++ --}}
                                                        {{-- <td>
                                                    {{ number_format( ( $stockLine->quantity - $stockLine->quantity_sold ) + ( $stockLine->quantity_returned ) ,num_of_digital_numbers() ) }}
                                                </td> --}}
                                                        {{-- @endforeach  --}}
                                                        {{-- ++++++++++++++++++++++++++ Actions +++++++++++++++++++ --}}
                                                        {{-- <td>
                                                <div class="btn-group">
                                                    <div class="bn-group">
                                                        <a href="{{ route('invoices.show', $product->id) }}" title="{{ __('Show') }}"
                                                            class=" btn btn-info btn-sm text-white mx-1">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm " data-toggle="modal" title="{{ __('Delete') }}"
                                                            data-target="#delete{{ $product->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal fade" id="delete{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">{{ __('site.Delete_an_invoice?') }}</h5>
                                                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    {{ __('site.Are_you_sure_to_delete_an_invoice?') }}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('site.Close') }}</button>
                                                                    <button click='delete({{ $product->id }})' type="button" class="btn btn-primary" data-dismiss="modal">{{ __('site.yes') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td> --}}
                                                    </tr>
                                                    {{-- @include('products.edit',$product) --}}
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <td colspan="2" style="text-align: right">@lang('lang.total')</td>
                                                <td id="sum1"></td>
                                                <td id="sum2"></td>
                                                <td id="sum3"></td>
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
                    }).nodes().to$().find('td:eq(2)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    total2 = api.rows({
                        'page': 'current'
                    }).nodes().to$().find('td:eq(3)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    total3 = api.rows({
                        'page': 'current'
                    }).nodes().to$().find('td:eq(4)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    // Update status DIV
                    $('#sum1').html('<span>' + total1 + '<span/>');
                    $('#sum2').html('<span>' + total2 + '<span/>');
                    $('#sum3').html('<span>' + total3 + '<span/>');
                }
            });
        });
    </script>
@endpush

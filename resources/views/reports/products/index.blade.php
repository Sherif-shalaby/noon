@extends('layouts.app')
@section('title', __('lang.product_report'))


@push('css')
<style>
    .table-top-head {
        top: 275px !important;
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
            top: 600px !important
        }
    }

    @media(max-width:768px) {
        .table-top-head {
            top: 635px !important
        }
    }

    .rightbar {
        z-index: 2;
    }

    .wrapper1 {
        margin-top: 25px;
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
@lang('lang.product_report')
@endsection

@section('breadcrumbs')
@parent
<li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
        style="text-decoration: none;color: #596fd7" href="">/ @lang('lang.reports')</a></li>
<li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
    @lang('lang.product_report')</li>
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
                            @lang('lang.product_report')</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    @include('reports.products.filters')
                                </div>
                            </div>
                        </div>
                        <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div1"></div>
                        </div>
                        <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div2 table-scroll-wrapper">
                                <!-- content goes here -->
                                <div style="min-width: 1800px;max-height: 90vh;overflow: auto">
                                    <div id="status"></div>
                                    <table id="example"
                                        class="table dataTable table-striped  table-hover  table-bordered"
                                        style="height: 90vh;overflow: scroll">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('lang.image')</th>
                                                <th>@lang('lang.product_name')</th>
                                                <th>@lang('lang.sku')</th>
                                                <th>@lang('lang.stock')</th>
                                                <th>@lang('lang.balance_return_request')</th>
                                                <th>@lang('lang.purchase_price')</th>
                                                <th>@lang('lang.sell_price')</th>
                                                <th class="dollar-cell showHideDollarCells">@lang('lang.purchase_price')
                                                    $</th>
                                                <th class="dollar-cell showHideDollarCells">@lang('lang.sell_price') $
                                                </th>
                                                <th>@lang('lang.amount_of_purchases')</th>
                                                <th>@lang('lang.purchased_qty')</th>
                                                <th>@lang('lang.amount_of_sells')</th>
                                                <th>@lang('lang.sold_qty')</th>
                                                {{-- <th>@lang('lang.profits')</th> --}}
                                                <th class="dollar-cell showHideDollarCells">
                                                    @lang('lang.amount_of_purchases') $</th>
                                                <th class="dollar-cell showHideDollarCells">
                                                    @lang('lang.amount_of_sells') $</th>
                                                {{-- <th>@lang('lang.profits') $</th> --}}
                                                <th>@lang('lang.category')</th>
                                                <th>@lang('lang.subcategories_name')</th>
                                                <th>@lang('lang.stores')</th>
                                                <th>@lang('lang.brand')</th>
                                                <th>@lang('added_by')</th>
                                                <th>@lang('updated_by')</th>
                                                @if (request()->sell_price_less_purchase_price == 'on')
                                                <th>@lang('view_details')</th>
                                                @endif
                                                <th>@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.image')">
                                                        <img src="{{ !empty($product->image) ? '/uploads/products/' . $product->image : '/uploads/' . $settings['logo'] }}"
                                                            style="width: 50px; height: 50px;"
                                                            alt="{{ $product->name }}">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.product_name')">
                                                        {{ $product->name }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.sku')">
                                                        {{ $product->sku }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.stock')">

                                                        @foreach ($product->product_stores as $store)
                                                        @php
                                                        $unit = !empty($store->variations)
                                                        ? $store->variations
                                                        : [];
                                                        $amount = 0;
                                                        @endphp
                                                        @endforeach

                                                        @forelse($product->variations as $variation)
                                                        @if (isset($unit->unit_id) && $unit->unit_id ==
                                                        $variation->unit_id)
                                                        <span class="product_unit"
                                                            data-variation_id="{{ $variation->id }}"
                                                            data-product_id="{{ $product->id }}">{{
                                                            $variation->unit->name ?? '' }}
                                                            <span class="unit_value">0</span></span>
                                                        <br>
                                                        @else
                                                        <span class="product_unit"
                                                            data-variation_id="{{ $variation->id }}"
                                                            data-product_id="{{ $product->id }}">{{
                                                            $variation->unit->name ?? '' }}
                                                            <span class="unit_value">{{
                                                                $product->product_stores->sum('quantity_available')
                                                                }}</span></span>
                                                        <br>
                                                        @endif
                                                        @empty
                                                        <span>{{ $product->product_stores->sum('quantity_available') }}
                                                        </span>
                                                        @endforelse
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.balance_return_request')">
                                                        {{ $product->balance_return_request }}
                                                    </span>
                                                </td>
                                                @if ($product->stock_lines->isNotEmpty())
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.purchase_price')">

                                                        {{ @num_format($product->stock_lines->last()->purchase_price) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.sell_price')">
                                                        {{ @num_format($product->stock_lines->last()->sell_price) }}
                                                    </span>
                                                </td>

                                                <td class="dollar-cell showHideDollarCells">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.purchase_price')">
                                                        {{
                                                        @num_format($product->stock_lines->last()->dollar_purchase_price)
                                                        }}
                                                    </span>
                                                </td>
                                                <td class="dollar-cell showHideDollarCells">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.sell_price')">
                                                        {{ @num_format($product->stock_lines->last()->dollar_sell_price)
                                                        }}
                                                    </span>
                                                </td>
                                                @else
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.purchase_price')">
                                                        {{ @num_format(0) }}
                                                    </span>

                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.sell_price')">
                                                        {{ @num_format(0) }}
                                                    </span>

                                                </td>
                                                <td class="dollar-cell showHideDollarCells">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.purchase_price')">
                                                        {{ @num_format(0) }}
                                                    </span>

                                                </td>
                                                <td class="dollar-cell showHideDollarCells">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.sell_price')">
                                                        {{ @num_format(0) }}
                                                    </span>

                                                </td>
                                                @endif
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.amount_of_purchases')">
                                                        {{ @num_format($product->total_purchase_amount) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.purchased_qty')">
                                                        @if ($product->stock_lines->isNotEmpty())
                                                        {{ @num_format($product->stock_lines->sum('quantity')) }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.amount_of_sells')">
                                                        {{ @num_format($product->total_sells_amount) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.sold_qty')">
                                                        {{ @num_format($product->stock_lines->sum('quantity_sold')) }}
                                                    </span>
                                                </td>

                                                <td class="dollar-cell showHideDollarCells">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.amount_of_purchases')">
                                                        {{ @num_format($product->total_dollar_purchase_amount) }}
                                                    </span>
                                                </td>
                                                <td class="dollar-cell showHideDollarCells">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.amount_of_sells')">
                                                        {{ @num_format($product->total_dollar_sells_amount) }}
                                                    </span>
                                                </td>
                                                {{-- <td></td> --}}
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.category')">
                                                        {{ $product->category->name ?? '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.subcategories_name')">

                                                        {{ $product->subCategory1 ? '- ' . $product->subCategory1->name
                                                        : '' }}
                                                        <br>
                                                        {{ $product->subCategory2 ? '- ' . $product->subCategory2->name
                                                        : '' }}
                                                        <br>
                                                        {{ $product->subCategory3 ? '- ' . $product->subCategory3->name
                                                        : '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.stores')">

                                                        @foreach ($product->stores as $store)
                                                        {{ $store->name }}<br>
                                                        @endforeach
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.brand')">

                                                        {{ !empty($product->brand) ? $product->brand->name : '' }}
                                                    </span>
                                                </td>
                                                {{-- ++++++++++++++++++++++ created_at column ++++++++++++++++++++++
                                                --}}
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('added_by')">

                                                        @if ($product->created_by > 0 and $product->created_by != null)
                                                        {{ $product->created_at->diffForHumans() }} <br>
                                                        {{ $product->created_at->format('Y-m-d') }}
                                                        ({{ $product->created_at->format('h:i') }})
                                                        {{ $product->created_at->format('A') == 'AM' ? __('am') :
                                                        __('pm') }}
                                                        <br>
                                                        {{ $product->createBy?->name }}
                                                        @else
                                                        {{ __('no_update') }}
                                                        @endif
                                                    </span>
                                                </td>
                                                {{-- ++++++++++++++++++++++ updated_at column ++++++++++++++++++++++
                                                --}}
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('updated_by')">

                                                        @if ($product->edited_by > 0 and $product->edited_by != null)
                                                        {{ $product->updated_at->diffForHumans() }} <br>
                                                        {{ $product->updated_at->format('Y-m-d') }}
                                                        ({{ $product->updated_at->format('h:i') }})
                                                        {{ $product->updated_at->format('A') == 'AM' ? __('am') :
                                                        __('pm') }}
                                                        <br>
                                                        {{ $product->updateBy?->name }}
                                                        @else
                                                        {{ __('no_update') }}
                                                        @endif
                                                    </span>
                                                </td>
                                                @if (request()->sell_price_less_purchase_price == 'on')
                                                <td>
                                                    <a type="button" class="btn btn-default btn-sm"
                                                        style="font-size: 12px;font-weight: 600"
                                                        href="{{ route('reports.sell_price_less_purchase_price', $product->id) }}">
                                                        @lang('lang.view_details')
                                                    </a>
                                                </td>
                                                @endif
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">خيارات <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu" x-placement="bottom-end"
                                                            style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                            <li>
                                                                <a data-href="{{ route('reports.product_details', $product->id) }}"
                                                                    data-container=".view_modal"
                                                                    class="btn  drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"
                                                                    data-toggle="modal">
                                                                    <i class="fa fa-eye"></i> @lang('lang.view')
                                                                </a>

                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <td colspan="6" style="text-align: right">@lang('lang.total')</td>
                                            <td id="sum1"></td>
                                            <td id="sum2"></td>
                                            <td id="sum3"></td>
                                            <td id="sum4"></td>
                                            <td id="sum5"></td>
                                            <td id="sum6"></td>
                                            <td id="sum7"></td>
                                            <td id="sum8"></td>
                                            <td id="sum9"></td>
                                            <td id="sum10"></td>
                                            <td colspan="7"></td>
                                        </tfoot>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
</div>
<!-- End row -->
<div class="view_modal no-print">@endsection
    @push('javascripts')
    <script src="{{ asset('js/product/product.js') }}"></script>
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
                        total3 = api.rows({
                            'page': 'current'
                        }).nodes().to$().find('td:eq(8)').map(function() {
                            return intVal($(this).text());
                        }).get().reduce(function(a, b) {
                            return a + b;
                        }, 0);
                        total4 = api.rows({
                            'page': 'current'
                        }).nodes().to$().find('td:eq(9)').map(function() {
                            return intVal($(this).text());
                        }).get().reduce(function(a, b) {
                            return a + b;
                        }, 0);
                        total5 = api.rows({
                            'page': 'current'
                        }).nodes().to$().find('td:eq(10)').map(function() {
                            return intVal($(this).text());
                        }).get().reduce(function(a, b) {
                            return a + b;
                        }, 0);
                        total6 = api.rows({
                            'page': 'current'
                        }).nodes().to$().find('td:eq(11)').map(function() {
                            return intVal($(this).text());
                        }).get().reduce(function(a, b) {
                            return a + b;
                        }, 0);
                        total7 = api.rows({
                            'page': 'current'
                        }).nodes().to$().find('td:eq(12)').map(function() {
                            return intVal($(this).text());
                        }).get().reduce(function(a, b) {
                            return a + b;
                        }, 0);
                        total8 = api.rows({
                            'page': 'current'
                        }).nodes().to$().find('td:eq(13)').map(function() {
                            return intVal($(this).text());
                        }).get().reduce(function(a, b) {
                            return a + b;
                        }, 0);
                        total9 = api.rows({
                            'page': 'current'
                        }).nodes().to$().find('td:eq(14)').map(function() {
                            return intVal($(this).text());
                        }).get().reduce(function(a, b) {
                            return a + b;
                        }, 0);
                        total10 = api.rows({
                            'page': 'current'
                        }).nodes().to$().find('td:eq(15)').map(function() {
                            return intVal($(this).text());
                        }).get().reduce(function(a, b) {
                            return a + b;
                        }, 0);
                        // Update status DIV
                        $('#sum1').html('<span>' + total1 + '<span/>');
                        $('#sum2').html('<span>' + total2 + '<span/>');
                        $('#sum3').html('<span>' + total3 + '<span/>');
                        $('#sum4').html('<span>' + total4 + '<span/>');
                        $('#sum5').html('<span>' + total5 + '<span/>');
                        $('#sum6').html('<span>' + total6 + '<span/>');
                        $('#sum7').html('<span>' + total7 + '<span/>');
                        $('#sum8').html('<span>' + total8 + '<span/>');
                        $('#sum9').html('<span>' + total9 + '<span/>');
                        $('#sum10').html('<span>' + total10 + '<span/>');
                    }
                });
            });
            $(document).on('click', '.product_unit', function() {
                var $this = $(this);
                var variation_id = $(this).data('variation_id');
                var product_id = $(this).data('product_id');
                $.ajax({
                    type: "get",
                    url: "/product/get-unit-store",
                    data: {
                        variation_id: variation_id,
                        product_id: product_id
                    },
                    success: function(response) {
                        $this.closest('td').find('.product_unit').each(function() {
                            $(this).find('.unit_value').text(
                                0); // Change "New Value" to the desired value
                        });
                        $this.children('.unit_value').text(response.store);
                    }
                });
            });
    </script>
    @endpush

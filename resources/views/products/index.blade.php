@extends('layouts.app')
@section('title', __('lang.products'))

@push('css')
    <style>
        th {
            padding: 10px 25px !important;
            font-weight: 700 !important;
            font-size: 11px !important;
            width: fit-content !important;
            text-align: center;
            border: 1px solid white !important;
            color: #fff !important;
            background-color: #596fd7 !important;
            text-transform: uppercase;
        }

        .table-top-head {
            top: 165px !important;
        }

        .table-scroll-wrapper {
            width: fit-content !important;
        }

        @media(min-width:2000px) {
            .table-scroll-wrapper {
                width: 100% !important;
            }
        }

        @media(max-width:991px) {
            .table-top-head {
                top: 165px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 430px !important
            }
        }

        @media(max-width:575px) {
            .table-top-head {
                top: 430px !important
            }
        }

        .wrapper1 {
            margin-top: 30px;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 115px;
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.products')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.products')</li>
@endsection

@section('button')
    <div class="widgetbar  d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            @lang('lang.add_products')
        </a>
    </div>
@endsection

@section('content')
    <!-- Start Contentbar -->
    <div class="animate-in-page">

        <div class="contentbar pb-0 mb-0">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h6 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.products')</h6>
                        </div>
                        <div class="card-body py-0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="container-fluid">
                                        @include('products.filters')
                                    </div>
                                </div>
                            </div>

                            {{-- ++++++++++++++++++ Table Columns ++++++++++++++++++ --}}
                            {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2 table-scroll-wrapper">
                                    <!-- content goes here -->
                                    <div style="min-width: 1800px;max-height: 90vh;overflow: auto;">
                                        <div id="status"></div>
                                        <table id="datatable-buttons"
                                            class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr
                                                    style="position: sticky;
                                                        top: 0;
                                                        z-index: 1000;">
                                                    <th>#</th>
                                                    <th class="col1">@lang('lang.image')</th>
                                                    <th class="col2">@lang('lang.product_name')</th>
                                                    <th class="col3">@lang('lang.sku')</th>
                                                    <th class="col4">@lang('lang.select_to_delete')</th>
                                                    <th class="col5">@lang('lang.stock')</th>
                                                    <th class="col6">@lang('lang.category') 1</th>
                                                    <th class="col7">@lang('lang.category') 2</th>
                                                    <th class="col19">@lang('lang.category') 3</th>
                                                    <th class="col20">@lang('lang.category') 4</th>
                                                    <th class="col8">@lang('lang.height')</th>
                                                    <th class="col9">@lang('lang.length')</th>
                                                    <th class="col10">@lang('lang.width')</th>
                                                    <th class="col11">@lang('lang.size')</th>
                                                    {{-- <th class="col1">@lang('lang.unit')</th> --}}
                                                    <th class="col12">@lang('lang.weight')</th>
                                                    <th class="col13">{{ __('lang.basic_unit_for_import_product') }}</th>
                                                    <th class="col14">@lang('lang.stores')</th>
                                                    <th class="col15">@lang('lang.brand')</th>
                                                    {{--                                    <th class="col1">@lang('lang.discount')</th> --}}
                                                    <th class="col16">@lang('added_by')</th>
                                                    <th class="col17">@lang('updated_by')</th>
                                                    <th class="col18">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $index => $product)
                                                    <tr class="text-center">
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                data-tooltip="#">
                                                                {{ $index + 1 }}
                                                            </span>
                                                        </td>
                                                        <td class="col1">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="width: 50px;height: 50px;font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.image')">
                                                                <img src="{{ !empty($product->image) ? '/uploads/products/' . $product->image : '/uploads/' . $settings['logo'] }}"
                                                                    style="width: 100%; height: 100%;"
                                                                    alt="{{ $product->name }}">

                                                            </span>
                                                        </td>
                                                        <td class="col2">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.product_name')">
                                                                {{ $product->name }}
                                                            </span>
                                                        </td>
                                                        <td class="col3">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.sku')">
                                                                {{ $product->sku }} <br>
                                                                @foreach ($product->variations as $index => $var)
                                                                    - {{ $var->sku }}
                                                                @endforeach
                                                            </span>
                                                        </td>
                                                        <td class="col4">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                data-tooltip="@lang('lang.select_to_delete')">
                                                                <input type="checkbox" name="product_selected_delete"
                                                                    class="product_selected_delete"
                                                                    value=" {{ $product->id }} "
                                                                    data-product_id="{{ $product->id }}" />
                                                            </span>
                                                        </td>
                                                        <td class="col5">
                                                            @foreach ($product->product_stores as $store)
                                                                @php
                                                                    $unit = !empty($store->variations)
                                                                        ? $store->variations
                                                                        : [];
                                                                    $amount = 0;
                                                                @endphp
                                                            @endforeach

                                                            @forelse($product->variations as $variation)
                                                                @if (isset($unit->unit_id) && $unit->unit_id == $variation->unit_id)
                                                                    <span
                                                                        class="product_unit custom-tooltip d-flex justify-content-center align-items-center"
                                                                        style="font-size: 12px;font-weight: 600"
                                                                        data-tooltip="@lang('lang.stock')"
                                                                        data-variation_id="{{ $variation->id }}"
                                                                        data-product_id="{{ $product->id }}">{{ $variation->unit->name ?? '' }}
                                                                        <span
                                                                            class="unit_value custom-tooltip d-flex justify-content-center align-items-center"
                                                                            style="font-size: 12px;font-weight: 600"
                                                                            data-tooltip="@lang('lang.stock')">{{ $product->product_stores->sum('quantity_available') }}</span></span>
                                                                    <br>
                                                                @else
                                                                    <span
                                                                        class="product_unit custom-tooltip d-flex justify-content-center align-items-center"
                                                                        style="font-size: 12px;font-weight: 600"
                                                                        data-tooltip="@lang('lang.stock')"
                                                                        data-variation_id="{{ $variation->id }}"
                                                                        data-product_id="{{ $product->id }}">{{ $variation->unit->name ?? '' }}
                                                                        <span
                                                                            class="unit_value custom-tooltip d-flex justify-content-center align-items-center"
                                                                            style="font-size: 12px;font-weight: 600"
                                                                            data-tooltip="@lang('lang.stock')">0</span></span>
                                                                    <br>
                                                                @endif
                                                            @empty
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.stock')">{{ $product->product_stores->sum('quantity_available') }}
                                                                </span>
                                                            @endforelse
                                                        </td>
                                                        <td class="col6">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.category') 1">
                                                                {{ $product->category->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td class="col7">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.category') 2">
                                                                {{ $product->subCategory1->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td class="col19">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.category') 3">
                                                                {{ $product->subCategory2->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td class="col20">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.category') 4">
                                                                {{ $product->subCategory3->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td class="col8">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.height')">
                                                                {{ $product->product_dimensions->height ?? 0 }}
                                                            </span>
                                                        </td>
                                                        <td class="col9">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.length')">
                                                                {{ $product->product_dimensions->length ?? 0 }}
                                                            </span>
                                                        </td>
                                                        <td class="col0">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.width')">
                                                                {{ $product->product_dimensions->width ?? 0 }}
                                                            </span>
                                                        </td>
                                                        <td class="col11">
                                                            <span
                                                                class="text-primary custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.size')">
                                                                {{ $product->product_dimensions->size ?? 0 }}
                                                            </span>
                                                        </td>
                                                        {{-- <td>{{!empty($product->unit)?$product->unit->name:''}}</td> --}}
                                                        <td class="col12">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.weight')">
                                                                {{ $product->product_dimensions->weight ?? 0 }}
                                                            </span>
                                                        </td>
                                                        <td class="col13">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.basic_unit_for_import_product')">
                                                                {{ !empty($product->product_dimensions->variations)
                                                                    ? (!empty($product->product_dimensions->variations->unit)
                                                                        ? $product->product_dimensions->variations->unit->name
                                                                        : '')
                                                                    : '' }}
                                                            </span>
                                                        </td>
                                                        <td class="col14">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.stores')">
                                                                @foreach ($product->stores as $store)
                                                                    {{ $store->name }}<br>
                                                                @endforeach
                                                            </span>
                                                        </td>
                                                        <td class="col15">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.brand')">
                                                                {{ !empty($product->brand) ? $product->brand->name : '' }}
                                                            </span>
                                                        </td>
                                                        {{--                                    <td> --}}
                                                        {{--                                        @foreach ($product->product_prices as $price) --}}
                                                        {{--                                        {{$price->price_category." : ".$price->price}} <br> --}}
                                                        {{--                                        @endforeach --}}
                                                        {{--                                    </td> --}}
                                                        {{-- ++++++++++++++++++++++ created_at column ++++++++++++++++++++++ --}}
                                                        <td class="col16">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.added_by')">

                                                                @if ($product->created_by > 0 and $product->created_by != null)
                                                                    {{ $product->created_at->diffForHumans() }} <br>
                                                                    {{ $product->created_at->format('Y-m-d') }}
                                                                    {{ $product->created_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                    ({{ $product->created_at->format('h:i') }})

                                                                    {{ $product->createBy?->name }}
                                                                @else
                                                                    {{ __('no_update') }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        {{-- ++++++++++++++++++++++ updated_at column ++++++++++++++++++++++ --}}
                                                        <td class="col17">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.updated_by')">

                                                                @if ($product->edited_by > 0 and $product->edited_by != null)
                                                                    {{ $product->updated_at->diffForHumans() }} <br>
                                                                    {{ $product->updated_at->format('Y-m-d') }}
                                                                    ({{ $product->updated_at->format('h:i') }})
                                                                    {{ $product->updated_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                    <br>
                                                                    {{ $product->updateBy?->name }}
                                                                @else
                                                                    {{ __('no_update') }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td class="col18">
                                                            <div class=" btn-group">
                                                                <button type="button"
                                                                    class="btn btn-default btn-sm dropdown-toggle d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">خيارات
                                                                    <span class="caret"></span>
                                                                    <span class="sr-only">Toggle Dropdown</span>
                                                                </button>
                                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                    user="menu" x-placement="bottom-end"
                                                                    style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;min-width: 200px !important;">
                                                                    <li>
                                                                        <a data-href="{{ route('products.show', $product->id) }}"
                                                                            data-container=".view_modal"
                                                                            class="btn btn-modal drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                                            <i class="fa fa-eye"></i>
                                                                            @lang('lang.view')
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a target="_blank"
                                                                            href="{{ route('remove_expiry', $product->id) }}"
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                                class="fa fa-hourglass-half"></i>
                                                                            @lang('lang.remove_expiry')
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a target="_blank"
                                                                            href="{{ route('get_remove_damage', $product->id) }}"
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                                class="fa fa-filter"></i>
                                                                            @lang('lang.remove_damage')
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a target="_blank"
                                                                            href="{{ url('add-stock/create?product_id=' . $product->id) }}"
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                                class="fa fa-plus"></i>
                                                                            @lang('lang.add_new_stock')
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a href="{{ route('products.edit', $product->id) }}"
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                                            target="_blank">
                                                                            <i class="dripicons-document-edit"></i>
                                                                            @lang('lang.update')
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a data-href="{{ route('products.destroy', $product->id) }}"
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif text-red delete_item">
                                                                            <i class="fa fa-trash"></i>
                                                                            @lang('lang.delete')
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    {{-- @include('products.edit',$product) --}}
                                                @endforeach
                                            </tbody>
                                            <tfoot>

                                                <td colspan="5" style="text-align: right">@lang('lang.total')</td>
                                                <td id="sum"></td>
                                                <td colspan="12">
                                                </td>
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
        </div>
    </div>
    <!-- End row -->

<div class="view_modal no-print">@endsection
    @push('javascripts')
        <script src="{{ asset('js/product/product.js') }}"></script>
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
                        var api = this.api(),
                            data;
                        // Remove the formatting to get integer data for summation
                        var intVal = function(i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                i : 0;
                        };
                        // Total over all pages
                        total = api
                            .column(5)
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                        // Update status DIV
                        $('#sum').html('<span>' + total + '<span/>');
                    }
                });
            });
        </script>
        <script>
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
            $(document).on('click', '#delete_all', function() {
                var checkboxes = document.querySelectorAll('input[name="product_selected_delete"]');
                var selected_delete_ids = [];
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].checked) {
                        selected_delete_ids.push(checkboxes[i].value);
                    }
                }
                console.log(selected_delete_ids)
                if (selected_delete_ids.length == 0) {
                    alert(1)
                    swal.fire({
                        title: 'Warning',
                        text: LANG.sorry_you_should_select_products_to_continue_delete,
                        icon: 'warning',
                    })
                } else {
                    swal.fire({
                        title: 'Are you sure?',
                        text: LANG.all_transactions_related_to_this_products_will_be_deleted,
                        icon: 'warning',
                    }).then(willDelete => {
                        if (willDelete) {
                            var check_password = $(this).data('check_password');
                            var href = $(this).data('href');
                            var data = $(this).serialize();
                            swal.fire({
                                title: "{!! __('lang.please_enter_your_password') !!}",
                                input: 'password',
                                inputAttributes: {
                                    placeholder: "{!! __('lang.type_your_password') !!}",
                                    autocomplete: 'off',
                                    autofocus: true,
                                },
                            }).then((result) => {
                                if (result) {
                                    $.ajax({
                                        url: check_password,
                                        method: 'POST',
                                        data: {
                                            value: result
                                        },
                                        dataType: 'json',
                                        success: (data) => {
                                            if (data.success == true) {
                                                // swal.fire(
                                                //     'Success',
                                                //     'Correct Password!',
                                                //     'success'
                                                // );
                                                Swal.fire({
                                                    title: "Success",
                                                    text: "Correct Password!",
                                                    icon: "success",
                                                    timer: 1000, // Set the timer to 1000 milliseconds (1 second)
                                                    showConfirmButton: false // This will hide the "OK" button
                                                });

                                                $.ajax({
                                                    method: 'POST',
                                                    url: "/product/multiDeleteRow",
                                                    dataType: 'json',
                                                    data: {
                                                        "ids": selected_delete_ids
                                                    },
                                                    success: function(result) {
                                                        if (result.success ==
                                                            true) {
                                                            // swal.fire(
                                                            //     'Success',
                                                            //     result.msg,
                                                            //     'success'
                                                            // );

                                                            Swal.fire({
                                                                title: "Success",
                                                                text: result
                                                                    .msg,
                                                                icon: "success",
                                                                timer: 1000, // Set the timer to 1000 milliseconds (1 second)
                                                                showConfirmButton: false // This will hide the "OK" button
                                                            });

                                                            setTimeout(() => {
                                                                location
                                                                    .reload();
                                                            }, 1500);
                                                            location.reload();
                                                        } else {
                                                            // swal.fire(
                                                            //     'Error',
                                                            //     result.msg,
                                                            //     'error'
                                                            // );
                                                            Swal.fire({
                                                                title: "Error",
                                                                text: response
                                                                    .msg,
                                                                icon: "error",
                                                                timer: 1000, // Set the timer to 1000 milliseconds (1 second)
                                                                showConfirmButton: false // This will hide the "OK" button
                                                            });

                                                        }
                                                    },
                                                });
                                            } else {
                                                // swal.fire(
                                                //     'Failed!',
                                                //     'Wrong Password!',
                                                //     'error'
                                                // )
                                                Swal.fire({
                                                    title: "Failed!",
                                                    text: "Wrong Password!",
                                                    icon: "error",
                                                    timer: 1000, // Set the timer to 1000 milliseconds (1 second)
                                                    showConfirmButton: false // This will hide the "OK" button
                                                });

                                            }
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            });
        </script>
        {{-- <script>
            // +++++++++++++++++ Checkboxs and label inside selectbox ++++++++++++++
            $(".checkbox_class:not(:checked)").each(function() {
                var column = "table ." + $(this).attr("name");
                $(column).hide();
            });
            $(".checkbox_class").click(function() {
                var column = "table ." + $(this).attr("name");
                $(column).toggle();
            });
            // +++++++++++++++++ Checkboxs and label inside selectbox : showCheckboxes() method ++++++++++++++
            var expanded = false;

            function showCheckboxes() {
                var checkboxes = document.getElementById("checkboxes");
                if (!expanded) {
                    checkboxes.style.display = "block";
                    expanded = true;
                } else {
                    checkboxes.style.display = "none";
                    expanded = false;
                }
            }
        </script> --}}
    @endpush

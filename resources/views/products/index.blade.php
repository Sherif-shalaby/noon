@extends('layouts.app')
@section('title', __('lang.products'))

@section('breadcrumbbar')
    <style>
        h1 {
            font-size: 30px;
            color: #000;
            text-transform: uppercase;
            font-weight: 300;
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            table-layout: fixed;
        }

        .tbl-header {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .tbl-content {
            height: 300px;
            overflow-x: auto;
            margin-top: 0px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        th {
            padding: 20px 15px;
            text-align: left;
            font-weight: 500;
            font-size: 12px;
            color: #fff;
            background-color: #596fd7;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            text-align: left;
            vertical-align: middle;
            font-weight: 300;
            font-size: 12px;
            color: #000;
            border-bottom: solid 1px rgba(0, 0, 0, 0.4);
        }

        tr:hover {
            background-color: rgba(0, 0, 0, 0.1)
        }
    </style>

    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.products')
                    </h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">
                                    / @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.products')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div
                        class="widgetbar  d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            @lang('lang.add_products')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('content')
    {{-- <!-- Start row -->
    <div class="row d-flex justify-content-center">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30 p-2">


            </div>
        </div>
    </div> --}}
    <!-- Start Contentbar -->
    <div class="animate-in-page">

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
                                        @include('products.filters')
                                    </div>
                                </div>
                            </div>
                            {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2">
                                    <!-- content goes here -->
                                    <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif"
                                        style="width: 1550px;height: 90vh;">
                                        <div class="my-2">
                                            <a data-href="{{ url('product/multiDeleteRow') }}" id="delete_all"
                                                data-check_password="{{ url('user/check-password') }}"
                                                class="btn btn-danger text-white delete_all"><i class="fa fa-trash"></i>
                                                @lang('lang.delete_all')</a>
                                        </div>
                                        <div id="status"></div>


                                        <table id="datatable-buttons"
                                            class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('lang.image')</th>
                                                    <th>@lang('lang.product_name')</th>
                                                    <th>@lang('lang.sku')</th>
                                                    <th>@lang('lang.select_to_delete')</th>
                                                    <th>@lang('lang.stock')</th>
                                                    <th>@lang('lang.category')</th>
                                                    <th>@lang('lang.subcategories_name')</th>
                                                    <th>@lang('lang.height')</th>
                                                    <th>@lang('lang.length')</th>
                                                    <th>@lang('lang.width')</th>
                                                    <th>@lang('lang.size')</th>
                                                    {{-- <th>@lang('lang.unit')</th> --}}
                                                    <th>@lang('lang.weight')</th>
                                                    <th>{{ __('lang.basic_unit_for_import_product') }}</th>
                                                    <th>@lang('lang.stores')</th>
                                                    <th>@lang('lang.brand')</th>
                                                    {{--                                    <th>@lang('lang.discount')</th> --}}
                                                    <th>@lang('added_by')</th>
                                                    <th>@lang('updated_by')</th>
                                                    <th>@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $index => $product)
                                                    <tr>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="#">
                                                                {{ $index + 1 }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.image')">
                                                                <img src="{{ !empty($product->image) ? '/uploads/products/' . $product->image : '/uploads/' . $settings['logo'] }}"
                                                                    style="width: 50px; height: 50px;"
                                                                    alt="{{ $product->name }}">
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.product_name')">
                                                                {{ $product->name }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.sku')">
                                                                {{ $product->sku }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.select_to_delete')">
                                                                <input type="checkbox" name="product_selected_delete"
                                                                    class="product_selected_delete"
                                                                    value=" {{ $product->id }} "
                                                                    data-product_id="{{ $product->id }}" />
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @foreach ($product->product_stores as $store)
                                                                @php
                                                                    $unit = !empty($store->variations) ? $store->variations : [];
                                                                    $amount = 0;
                                                                @endphp
                                                            @endforeach

                                                            @foreach ($product->variations as $variation)
                                                                @if (isset($unit->unit_id) && $unit->unit_id == $variation->unit_id)
                                                                    <span class="product_unit custom-tooltip"
                                                                        data-tooltip="@lang('lang.stock')"
                                                                        data-variation_id="{{ $variation->id }}"
                                                                        data-product_id="{{ $product->id }}">{{ $variation->unit->name ?? '' }}
                                                                        <span
                                                                            class="unit_value">{{ $product->product_stores->sum('quantity_available') }}</span></span>
                                                                @else
                                                                    <span class="product_unit custom-tooltip"
                                                                        data-tooltip="@lang('lang.stock')"
                                                                        data-variation_id="{{ $variation->id }}"
                                                                        data-product_id="{{ $product->id }}">{{ $variation->unit->name ?? '' }}
                                                                        <span class="unit_value">0</span></span>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.category')">
                                                                {{ $product->category->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.subcategories_name')">
                                                                {{ $product->subCategory1->name ?? '' }} <br>
                                                                {{ $product->subCategory2->name ?? '' }} <br>
                                                                {{ $product->subCategory3->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.height')">
                                                                {{ $product->product_dimensions->height ?? 0 }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.length')">
                                                                {{ $product->product_dimensions->length ?? 0 }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.width')">
                                                                {{ $product->product_dimensions->width ?? 0 }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="text-primary custom-tooltip"
                                                                data-tooltip="@lang('lang.size')">
                                                                {{ $product->product_dimensions->size ?? 0 }}
                                                            </span>
                                                        </td>
                                                        {{-- <td>{{!empty($product->unit)?$product->unit->name:''}}</td> --}}
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.weight')">
                                                                {{ $product->product_dimensions->weight ?? 0 }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.basic_unit_for_import_product')">
                                                                {{ !empty($product->product_dimensions->variations)
                                                                    ? (!empty($product->product_dimensions->variations->unit)
                                                                        ? $product->product_dimensions->variations->unit->name
                                                                        : '')
                                                                    : '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.stores')">
                                                                @foreach ($product->stores as $store)
                                                                    {{ $store->name }}<br>
                                                                @endforeach
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.brand')">
                                                                {{ !empty($product->brand) ? $product->brand->name : '' }}
                                                            </span>
                                                        </td>
                                                        {{--                                    <td> --}}
                                                        {{--                                        @foreach ($product->product_prices as $price) --}}
                                                        {{--                                        {{$price->price_category." : ".$price->price}} <br> --}}
                                                        {{--                                        @endforeach --}}
                                                        {{--                                    </td> --}}
                                                        {{-- ++++++++++++++++++++++ created_at column ++++++++++++++++++++++ --}}
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.added_by')">

                                                                @if ($product->created_by > 0 and $product->created_by != null)
                                                                    {{ $product->created_at->diffForHumans() }} <br>
                                                                    {{ $product->created_at->format('Y-m-d') }}
                                                                    ({{ $product->created_at->format('h:i') }})
                                                                    {{ $product->created_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                    <br>
                                                                    {{ $product->createBy?->name }}
                                                                @else
                                                                    {{ __('no_update') }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        {{-- ++++++++++++++++++++++ updated_at column ++++++++++++++++++++++ --}}
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.updated_by')">

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
                                                        <td>
                                                            <div class=" btn-group">
                                                                <button type="button"
                                                                    class="btn btn-default btn-sm dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">خيارات
                                                                    <span class="caret"></span>
                                                                    <span class="sr-only">Toggle Dropdown</span>
                                                                </button>
                                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                    user="menu" x-placement="bottom-end"
                                                                    style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                    <li>
                                                                        <a data-href="{{ route('products.show', $product->id) }}"
                                                                            data-container=".view_modal"
                                                                            class="btn btn-modal">
                                                                            <i class="fa fa-eye"></i>
                                                                            @lang('lang.view')
                                                                        </a>
                                                                    </li>
                                                                    <li class="divider"></li>
                                                                    <li>
                                                                        <a target="_blank"
                                                                            href="{{ route('get_remove_damage', $product->id) }}"
                                                                            class="btn"><i class="fa fa-filter"></i>
                                                                            @lang('lang.remove_damage')
                                                                        </a>
                                                                    </li>
                                                                    <li class="divider"></li>
                                                                    <li>
                                                                        <a href="{{ route('products.edit', $product->id) }}"
                                                                            class="btn" target="_blank">
                                                                            <i class="dripicons-document-edit"></i>
                                                                            @lang('lang.update')
                                                                        </a>
                                                                    </li>
                                                                    <li class="divider"></li>
                                                                    <li>
                                                                        <a data-href="{{ route('products.destroy', $product->id) }}"
                                                                            class="btn text-red delete_item">
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



                            <div class="tbl-header">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Company</th>
                                            <th>Price</th>
                                            <th>Change</th>
                                            <th>Change %</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tbl-content">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td>AAC</td>
                                            <td>AUSTRALIAN COMPANY </td>
                                            <td>$1.38</td>
                                            <td>+2.01</td>
                                            <td>-0.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAD</td>
                                            <td>AUSENCO</td>
                                            <td>$2.38</td>
                                            <td>-0.01</td>
                                            <td>-1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAX</td>
                                            <td>ADELAIDE</td>
                                            <td>$3.22</td>
                                            <td>+0.01</td>
                                            <td>+1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>XXD</td>
                                            <td>ADITYA BIRLA</td>
                                            <td>$1.02</td>
                                            <td>-1.01</td>
                                            <td>+2.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAC</td>
                                            <td>AUSTRALIAN COMPANY </td>
                                            <td>$1.38</td>
                                            <td>+2.01</td>
                                            <td>-0.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAD</td>
                                            <td>AUSENCO</td>
                                            <td>$2.38</td>
                                            <td>-0.01</td>
                                            <td>-1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAX</td>
                                            <td>ADELAIDE</td>
                                            <td>$3.22</td>
                                            <td>+0.01</td>
                                            <td>+1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>XXD</td>
                                            <td>ADITYA BIRLA</td>
                                            <td>$1.02</td>
                                            <td>-1.01</td>
                                            <td>+2.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAC</td>
                                            <td>AUSTRALIAN COMPANY </td>
                                            <td>$1.38</td>
                                            <td>+2.01</td>
                                            <td>-0.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAD</td>
                                            <td>AUSENCO</td>
                                            <td>$2.38</td>
                                            <td>-0.01</td>
                                            <td>-1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAX</td>
                                            <td>ADELAIDE</td>
                                            <td>$3.22</td>
                                            <td>+0.01</td>
                                            <td>+1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>XXD</td>
                                            <td>ADITYA BIRLA</td>
                                            <td>$1.02</td>
                                            <td>-1.01</td>
                                            <td>+2.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAC</td>
                                            <td>AUSTRALIAN COMPANY </td>
                                            <td>$1.38</td>
                                            <td>+2.01</td>
                                            <td>-0.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAD</td>
                                            <td>AUSENCO</td>
                                            <td>$2.38</td>
                                            <td>-0.01</td>
                                            <td>-1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAX</td>
                                            <td>ADELAIDE</td>
                                            <td>$3.22</td>
                                            <td>+0.01</td>
                                            <td>+1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>XXD</td>
                                            <td>ADITYA BIRLA</td>
                                            <td>$1.02</td>
                                            <td>-1.01</td>
                                            <td>+2.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAC</td>
                                            <td>AUSTRALIAN COMPANY </td>
                                            <td>$1.38</td>
                                            <td>+2.01</td>
                                            <td>-0.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAD</td>
                                            <td>AUSENCO</td>
                                            <td>$2.38</td>
                                            <td>-0.01</td>
                                            <td>-1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAX</td>
                                            <td>ADELAIDE</td>
                                            <td>$3.22</td>
                                            <td>+0.01</td>
                                            <td>+1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>XXD</td>
                                            <td>ADITYA BIRLA</td>
                                            <td>$1.02</td>
                                            <td>-1.01</td>
                                            <td>+2.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAC</td>
                                            <td>AUSTRALIAN COMPANY </td>
                                            <td>$1.38</td>
                                            <td>+2.01</td>
                                            <td>-0.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAD</td>
                                            <td>AUSENCO</td>
                                            <td>$2.38</td>
                                            <td>-0.01</td>
                                            <td>-1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAX</td>
                                            <td>ADELAIDE</td>
                                            <td>$3.22</td>
                                            <td>+0.01</td>
                                            <td>+1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>XXD</td>
                                            <td>ADITYA BIRLA</td>
                                            <td>$1.02</td>
                                            <td>-1.01</td>
                                            <td>+2.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAC</td>
                                            <td>AUSTRALIAN COMPANY </td>
                                            <td>$1.38</td>
                                            <td>+2.01</td>
                                            <td>-0.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAD</td>
                                            <td>AUSENCO</td>
                                            <td>$2.38</td>
                                            <td>-0.01</td>
                                            <td>-1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAX</td>
                                            <td>ADELAIDE</td>
                                            <td>$3.22</td>
                                            <td>+0.01</td>
                                            <td>+1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>XXD</td>
                                            <td>ADITYA BIRLA</td>
                                            <td>$1.02</td>
                                            <td>-1.01</td>
                                            <td>+2.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAC</td>
                                            <td>AUSTRALIAN COMPANY </td>
                                            <td>$1.38</td>
                                            <td>+2.01</td>
                                            <td>-0.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAD</td>
                                            <td>AUSENCO</td>
                                            <td>$2.38</td>
                                            <td>-0.01</td>
                                            <td>-1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>AAX</td>
                                            <td>ADELAIDE</td>
                                            <td>$3.22</td>
                                            <td>+0.01</td>
                                            <td>+1.36%</td>
                                        </tr>
                                        <tr>
                                            <td>XXD</td>
                                            <td>ADITYA BIRLA</td>
                                            <td>$1.02</td>
                                            <td>-1.01</td>
                                            <td>+2.36%</td>
                                        </tr>
                                    </tbody>
                                </table>
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
    @endpush

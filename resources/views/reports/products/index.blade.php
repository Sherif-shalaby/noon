@extends('layouts.app')
@section('title', __('lang.product_report'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.product_report')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="">/ @lang('lang.reports')</a></li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.product_report')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="widgetbar">
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
                                @lang('lang.product_report')</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="container-fluid">
                                        @include('reports.products.filters')
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive
                            @if (app()->isLocale('ar')) dir-rtl @endif"
                                style="height: 90vh;overflow: scroll">
                                <div id="status"></div>
                                <table id="datatable-buttons"
                                    class="table dataTable table-striped  table-button-wrapper table-hover  table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('lang.image')</th>
                                            <th>@lang('lang.product_name')</th>
                                            <th>@lang('lang.sku')</th>
                                            <th>@lang('lang.stock')</th>
                                            <th>@lang('lang.balance_return_request')</th>
                                            <th>@lang('lang.category')</th>
                                            <th>@lang('lang.subcategories_name')</th>
                                            <th>@lang('lang.stores')</th>
                                            <th>@lang('lang.brand')</th>
                                            <th>@lang('added_by')</th>
                                            <th>@lang('updated_by')</th>
                                            @if (request()->sell_price_less_purchase_price == 'on')
                                                <th>@lang('actions')</th>
                                            @endif
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
                                                            style="width: 50px; height: 50px;" alt="{{ $product->name }}">
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
                                                                $unit = !empty($store->variations) ? $store->variations : [];
                                                                $amount = 0;
                                                            @endphp
                                                        @endforeach

                                                        @forelse($product->variations as $variation)
                                                            @if (isset($unit->unit_id) && $unit->unit_id == $variation->unit_id)
                                                                <span class="product_unit"
                                                                    data-variation_id="{{ $variation->id }}"
                                                                    data-product_id="{{ $product->id }}">{{ $variation->unit->name ?? '' }}
                                                                    <span
                                                                        class="unit_value">{{ $product->product_stores->sum('quantity_available') }}</span></span>
                                                                <br>
                                                            @else
                                                                <span class="product_unit"
                                                                    data-variation_id="{{ $variation->id }}"
                                                                    data-product_id="{{ $product->id }}">{{ $variation->unit->name ?? '' }}
                                                                    <span
                                                                        class="unit_value">{{ $product->product_stores->sum('quantity_available') }}</span></span>
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

                                                        {{ $product->subCategory1->name ?? '' }} <br>
                                                        {{ $product->subCategory2->name ?? '' }} <br>
                                                        {{ $product->subCategory3->name ?? '' }}
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
                                                {{-- ++++++++++++++++++++++ created_at column ++++++++++++++++++++++ --}}
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('added_by')">

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
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('updated_by')">

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
                                                @if (request()->sell_price_less_purchase_price == 'on')
                                                    <td>
                                                        <a type="button" class="btn btn-default btn-sm"
                                                            style="font-size: 12px;font-weight: 600"
                                                            href="{{ route('reports.sell_price_less_purchase_price', $product->id) }}">
                                                            @lang('lang.view_details')
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    {{--                                <tfoot> --}}

                                    {{--                                <td colspan="4" style="text-align: right">@lang('lang.total')</td> --}}
                                    {{--                                <td id="sum"></td> --}}
                                    {{--                                <td colspan="7"></td> --}}
                                    {{--                                </tfoot> --}}
                                </table>
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

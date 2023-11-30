@extends('layouts.app')
@section('title', __('lang.product_report'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.best_seller_report')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="">/ @lang('lang.reports')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.best_seller_report')</li>
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
                                @lang('lang.best_seller_report')</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="container-fluid">
                                        @include('reports.best_seller.filters')
                                    </div>
                                </div>
                            </div>
                            <div>
                                @php
                                    $color = '#6e81dc';
                                    $color_rgba = 'rgba(110, 129, 220, 0.8)';

                                @endphp
                                <canvas id="bestSeller" data-color="{{ $color }}"
                                    data-color_rgba="{{ $color_rgba }}" data-product = "{{ json_encode($product) }}"
                                    data-sold_qty="{{ json_encode($sold_qty) }}"></canvas>
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
        <script src="{{ asset('js/npm/chart.js') }}"></script>
        <script>
            var BESTSELLER = $("#bestSeller");

            if (BESTSELLER.length > 0) {
                var sold_qty = BESTSELLER.data("sold_qty");
                brandPrimary = BESTSELLER.data("color");
                brandPrimaryRgba = BESTSELLER.data("color_rgba");
                var product_info = BESTSELLER.data("product");
                var bestSeller = new Chart(BESTSELLER, {
                    type: "bar",
                    data: {
                        labels: [product_info[0], product_info[1], product_info[2]],
                        datasets: [{
                            label: "Sale Qty",
                            backgroundColor: [
                                brandPrimaryRgba,
                                brandPrimaryRgba,
                                brandPrimaryRgba,
                                brandPrimaryRgba,
                            ],
                            borderColor: [
                                brandPrimary,
                                brandPrimary,
                                brandPrimary,
                                brandPrimary,
                            ],
                            borderWidth: 1,
                            data: [sold_qty[0], sold_qty[1], sold_qty[2], 0],
                        }, ],
                    },
                });
            }
        </script>
    @endpush

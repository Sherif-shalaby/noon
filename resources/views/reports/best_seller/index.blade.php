@extends('layouts.app')
@section('title', __('lang.product_report'))


@push('css')
    <style>
        .input-wrapper {
            width: 100% !important;
        }

        @media(max-width:767px) {

            .input-wrapper {
                width: 60%
            }
        }

        .rightbar {
            z-index: 2;
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.best_seller_report')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
            style="text-decoration: none;color: #596fd7" href="">/ @lang('lang.reports')</a></li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.best_seller_report')</li>
@endsection

@section('content')
    <div class="animate-in-page">

        <!-- Start Contentbar -->
        <div class="contentbar mb-0 pb-0 ">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h6 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.best_seller_report')</h6>
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

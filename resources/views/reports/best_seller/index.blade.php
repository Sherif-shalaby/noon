@extends('layouts.app')
@section('title', __('lang.product_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.best_seller_report')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="">@lang('lang.reports')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.best_seller_report')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.best_seller_report')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    @include('reports.best_seller.filters')
                                </div>
                            </div>
                        </div>
                        <div >
                            @php
                                $color = '#6e81dc';
                                $color_rgba = 'rgba(110, 129, 220, 0.8)';

                            @endphp
                            <canvas id="bestSeller" data-color="{{$color}}" data-color_rgba="{{$color_rgba}}" data-product = "{{json_encode($product)}}" data-sold_qty="{{json_encode($sold_qty)}}" ></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
    <div class="view_modal no-print" >@endsection
@push('javascripts')
    <script src="{{ asset('js/product/product.js') }}"></script>
    <script src="{{asset('js/npm/chart.js')}}"></script>
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
                    datasets: [
                        {
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
                        },
                    ],
                },
            });
        }
    </script>

@endpush

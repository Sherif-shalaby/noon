@extends('layouts.app')
@section('title', __('lang.store_stock_chart'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.store_stock_chart')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            {{-- <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">@lang('lang.reports')</li> --}}
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.store_stock_chart')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">
        <div class="card-body">
            <div class="col-md-12">
                <form action="{{ route('report.store_stock_chart') }}">
                    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                            style="animation-delay: 1.1s">
                            {!! Form::label('store_id', __('lang.store'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">
                                {!! Form::select('store_id', $stores, request()->store_id, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('lang.all'),
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-2 mb-2 d-flex align-items-end justify-content-end animate__animated animate__bounceInLeft flex-column"
                            style="animation-delay: 1.1s">
                            <button type="submit" class="btn btn-primary ">@lang('lang.filter')</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6 offset-md-3 mt-3 mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span>Total @lang('lang.items')</span>
                                        <h2><strong>{{ @num_format($total_item) }}</strong></h2>
                                    </div>
                                    <div class="col-md-6">
                                        <span>Total @lang('lang.quantity')</span>
                                        <h2><strong>{{ @num_format($total_qty) }}</strong></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $color = '#733686';
                                $color_rgba = 'rgba(115, 54, 134, 0.8)';

                            @endphp
                            <div class="col-md-5 offset-md-3 mt-2">
                                <div class="pie-chart">
                                    <canvas id="pieChart" data-color="{{ $color }}"
                                        data-color_rgba="{{ $color_rgba }}" data-price={{ $total_price }}
                                        data-cost={{ $total_cost }} width="5" height="5"
                                        data-label1="@lang('lang.stock_value_by_price')" data-label2="@lang('lang.stock_value_by_cost')"
                                        data-label3="@lang('lang.estimate_profit')">
                                    </canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('javascripts')
    <script src="{{ asset('js/npm/chart.js') }}"></script>
    <script>
        var PIECHART = $("#pieChart");
        if (PIECHART.length > 0) {
            var brandPrimary = PIECHART.data("color");
            var brandPrimaryRgba = PIECHART.data("color_rgba");
            var price = PIECHART.data("price");
            var cost = PIECHART.data("cost");
            var label1 = PIECHART.data("label1");
            var label2 = PIECHART.data("label2");
            var label3 = PIECHART.data("label3");
            var myPieChart = new Chart(PIECHART, {
                type: "pie",
                data: {
                    labels: [label1, label2, label3],
                    datasets: [{
                        data: [price, cost, price - cost],
                        borderWidth: [1, 1, 1],
                        backgroundColor: [brandPrimary, "#ff8952", "#858c85"],
                        hoverBackgroundColor: [
                            brandPrimaryRgba,
                            "rgba(255, 137, 82, 0.8)",
                            "rgb(133, 140, 133, 0.8)",
                        ],
                        hoverBorderWidth: [4, 4, 4],
                        hoverBorderColor: [
                            brandPrimaryRgba,
                            "rgba(255, 137, 82, 0.8)",
                            "rgb(133, 140, 133, 0.8)",
                        ],
                    }, ],
                },
                options: {
                    //rotation: -0.7*Math.PI
                },
            });
        }
    </script>
@endpush

@extends('layouts.app')
@section('title', __('lang.store_stock_chart'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.store_stock_chart')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        {{-- <li class="breadcrumb-item active" aria-current="page">@lang('lang.reports')</li> --}}
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.store_stock_chart')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="card-body">
        <div class="col-md-12">
            <form action="{{ route('report.store_stock_chart') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('store_id', __('lang.store'), []) !!}
                            {!! Form::select('store_id', $stores, request()->store_id, [
                                'class' => 'form-control select2',
                                'placeholder' => __('lang.all'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <br>
                        <button type="submit" class="btn btn-success mt-2">@lang('lang.filter')</button>
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
@endsection
@push('javascripts')
    <script src="{{asset('js/npm/chart.js')}}"></script>
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
                datasets: [
                    {
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
                    },
                ],
            },
            options: {
                //rotation: -0.7*Math.PI
            },
        });
    }

    </script>

@endpush

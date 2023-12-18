@extends('layouts.app')
@section('title', __('lang.monthly_sale_and_purchase_report'))
@section('breadcrumbbar')
    <style>
        .months td {
            border-bottom: 2px solid rgb(241, 89, 89);
        }

        .sale-row td {
            border-top: 2px solid rgb(241, 89, 89);
            border-bottom: 2px solid rgb(241, 89, 89);
        }

        .sale-row td:first-child {
            border-left: 2px solid rgb(241, 89, 89);
        }

        .sale-row td:last-child {
            border-right: 2px solid rgb(241, 89, 89);
        }

        .purchase-row td {
            border-top: 2px solid rgb(84, 235, 177);
            border-bottom: 2px solid rgb(84, 235, 177);
        }

        .purchase-row td:first-child {
            border-left: 2px solid rgb(84, 235, 177);
        }

        .purchase-row td:last-child {
            border-right: 2px solid rgb(84, 235, 177);
        }

        nav {
            z-index: 2;
            position: relative;
        }

        .rightbar {
            z-index: 1;
        }
    </style>
    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.monthly_sale_and_purchase_report')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            {{-- <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">@lang('lang.reports')</li> --}}
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.monthly_sale_and_purchase_report')</li>
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
                <form action="{{ route('report.monthly_sale_report') }}">
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
                        <div class="col-md-2 mb-2 d-flex align-items-end justify-content-center animate__animated animate__bounceInLeft flex-column"
                            style="animation-delay: 1.15s">

                            <button type="submit" class="btn btn-primary">@lang('lang.filter')</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                    <div class="div1"></div>
                </div>
                <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                    <div class="div2 table-scroll-wrapper">
                        <!-- content goes here -->
                        <div style="min-width: 1300px;max-height: 90vh;overflow: auto">
                            <table class="table table-bordered  table-hove"
                                style="border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
                                <thead>
                                    @php
                                        $next_year = $year + 1;
                                        $pre_year = $year - 1;
                                    @endphp
                                    <tr>
                                        <th></th>
                                        <th><a style="color: white;text-decoration: none"
                                                href="{{ url('report/get-monthly-sale-report?year=' . $pre_year) }}"><i
                                                    class="fa fa-arrow-right"></i> {{ trans('lang.previous') }}</a>
                                        </th>
                                        <th colspan="10" class="text-center">{{ $year }}</th>
                                        <th><a style="color: white;text-decoration: none"
                                                href="{{ url('report/get-monthly-sale-report?year=' . $next_year) }}">{{ trans('lang.next') }}
                                                <i class="fa fa-arrow-left"></i></a></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="months">
                                        <td></td>
                                        <td><strong>@lang('lang.January')</strong></td>
                                        <td><strong>@lang('lang.February')</strong></td>
                                        <td><strong>@lang('lang.March')</strong></td>
                                        <td><strong>@lang('lang.April')</strong></td>
                                        <td><strong>@lang('lang.May')</strong></td>
                                        <td><strong>@lang('lang.June')</strong></td>
                                        <td><strong>@lang('lang.July')</strong></td>
                                        <td><strong>@lang('lang.August')</strong></td>
                                        <td><strong>@lang('lang.September')</strong></td>
                                        <td><strong>@lang('lang.October')</strong></td>
                                        <td><strong>@lang('lang.November')</strong></td>
                                        <td><strong>@lang('lang.December')</strong></td>
                                    </tr>
                                    <tr class="sale-row">
                                        <td>
                                            <h5 class="text-primary">@lang('lang.sales')</h5>
                                        </td>
                                        @foreach ($total_discount_sell as $key => $discount)
                                            <td>
                                                @if ($discount > 0)
                                                    <strong>{{ trans('lang.product_discount') }}</strong><br>
                                                    <span>{{ @num_format($discount) }}</span><br><br>
                                                @endif
                                                @if ($total_tax_sell[$key] > 0)
                                                    <strong>{{ trans('lang.product_tax') }}</strong><br>
                                                    <span>{{ isset($total_tax_sell) ? @num_format($total_tax_sell[$key]) : 0 }}</span><br><br>
                                                @endif
                                                @if ($shipping_cost_sell[$key] > 0)
                                                    <strong>{{ trans('lang.delivery_cost') }}</strong><br>
                                                    <span>{{ @num_format($shipping_cost_sell[$key]) }}</span><br><br>
                                                @endif
                                                @if ($total_sell[$key] > 0)
                                                    <strong>{{ trans('lang.grand_total') }}</strong><br>
                                                    <span>{{ @num_format($total_sell[$key]) }}</span><br>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                    <tr class="purchase-row">
                                        <td>
                                            <h5 class="text-primary">@lang('lang.purchases')</h5>
                                        </td>
                                        @foreach ($total_discount_addstock as $key => $discount)
                                            <td>
                                                @if ($discount > 0)
                                                    <strong>{{ trans('lang.product_discount') }}</strong><br>
                                                    <span>{{ @num_format($discount) }}</span><br><br>
                                                @endif
                                                {{-- @if ($total_tax_addstock[$key] > 0)
                        <strong>{{trans("lang.product_tax")}}</strong><br>
                        <span>{{@num_format($total_tax_addstock[$key])}}</span><br><br>
                        @endif --}}
                                                {{-- @if ($shipping_cost_addstock[$key] > 0)
                        <strong>{{trans("lang.delivery_cost")}}</strong><br>
                        <span>{{@num_format($shipping_cost_addstock[$key])}}</span><br><br>
                        @endif --}}
                                                @if ($total_addstock[$key] > 0)
                                                    <strong>{{ trans('lang.grand_total') }}</strong><br>
                                                    <span>{{ @num_format($total_addstock[$key]) }}</span><br>
                                                    {{-- <span>{{@num_format($total_p[$key])}}</span><br> --}}
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td></td>
                                        @foreach ($total_net_profit as $key => $net_profit)
                                            <td>
                                                <strong>{{ trans('lang.wins') }}</strong><br>
                                                <strong>{{ @num_format($net_profit) }}</strong>
                                            </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

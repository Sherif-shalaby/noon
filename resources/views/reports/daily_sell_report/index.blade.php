@extends('layouts.app')
@section('title', __('lang.daily_sale_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.daily_sale_report')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('initial-balance.create')}}">@lang('lang.reports')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.daily_sale_report')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                {{--                <div class="widgetbar">--}}
                {{--                    <a type="button" class="btn btn-primary" href="{{route('initial-balance.create')}}">@lang('lang.add_initial_balance')</a>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-md-12  no-print">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4>@lang('lang.daily_sale_report')</h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="container-fluid">
                        @include('reports.daily_sell_report.filters')
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <table class="table table-bordered"
                           style="border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
                        <thead>
                        <tr>
                            <th>
                                <a style="color: #6e81dc" href="{{url('reports/daily_sales_report?year='.$prev_year.'&month='.$prev_month)}}">
                                    <i class="fa fa-arrow-left"></i> @lang('lang.previous')
                                </a>
                            </th>
                            <th colspan="5" class="text-center">
                                {{date("F", strtotime($year.'-'.$month.'-01')).' ' .$year}}
                            </th>
                            <th>
                                <a style="color: #6e81dc" href="{{url('reports/daily_sales_report?year='.$next_year.'&month='.$next_month)}}">
                                    @lang('lang.next')
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><strong>@lang('lang.sunday')</strong></td>
                            <td><strong>@lang('lang.monday')</strong></td>
                            <td><strong>@lang('lang.tuesday')</strong></td>
                            <td><strong>@lang('lang.wednesday')</strong></td>
                            <td><strong>@lang('lang.thursday')</strong></td>
                            <td><strong>@lang('lang.friday')</strong></td>
                            <td><strong>@lang('lang.saturday')</strong></td>
                        </tr>
                        @php
                            $i = 1;
                            $flag = 0;
                        @endphp
                        @while ($i <= $number_of_day) <tr>
                            @for($j=1 ; $j<=7 ; $j++) @if($i> $number_of_day)
                                @php
                                    break;
                                @endphp
                            @endif
                            @if($flag)
                                @if($year.'-'.$month.'-'.$i == date('Y').'-'.date('m').'-'.(int)date('d'))
                                    <td>
                                        <p style="color:red"><strong>{{$i}}</strong></p>
                                @else
                                    <td>
                                        <p><strong>{{$i}}</strong></p>
                                        @endif

                                        @if(!empty($total_surplus[$i]))
                                            <strong>@lang("lang.total_surplus")</strong><br><span>{{@num_format($total_surplus[$i])}}</span><br><br>
                                        @endif

                                        @if(!empty($total_discount[$i]))
                                            <strong>@lang("lang.product_discount")</strong><br><span>{{@num_format($total_discount[$i])}}</span><br><br>
                                        @endif

                                        @if(!empty($total_tax[$i]))
                                            <strong>@lang("lang.product_tax")</strong><br><span>{{@num_format($total_tax[$i])}}</span><br><br>
                                        @endif

                                        @if(!empty($order_tax[$i]))
                                            <strong>@lang("lang.order_tax")</strong><br><span>{{@num_format($order_tax[$i])}}</span><br><br>
                                        @endif

                                        @if(!empty($shipping_cost[$i]))
                                            <strong>@lang("lang.delivery_cost")</strong><br><span>{{@num_format($shipping_cost[$i])}}</span><br><br>
                                        @endif

                                        @if(!empty($grand_total[$i]))
                                            <strong>@lang("lang.grand_total")</strong><br><span>{{@num_format($grand_total[$i])}}</span><br><br>
                                        @endif
                                        @if(!empty($dollar_grand_total[$i]) && (isset($toggle_dollar) && $toggle_dollar != 1))
                                            <strong>@lang("lang.grand_total") $</strong><br><span>{{@num_format($dollar_grand_total[$i])}}</span><br><br>
                                        @endif
                                    </td>
                                    @php
                                        $i++;
                                    @endphp
                                    @elseif($j == $start_day)
                                        @if($year.'-'.$month.'-'.$i == date('Y').'-'.date('m').'-'.(int)date('d'))
                                            <td>
                                                <p style="color:red"><strong>'.$i.'</strong></p>
                                        @else
                                            <td>
                                                <p><strong>{{$i}}</strong></p>
                                                @endif

                                                @if(!empty($total_discount[$i]))
                                                    <strong>@lang("lang.product_discount")</strong><br><span>{{@num_format($total_discount[$i])}}</span><br><br>
                                                @endif

                                                @if(!empty($total_tax[$i]))
                                                    <strong>@lang("lang.product_tax")</strong><br><span>{{@num_format($total_tax[$i])}}</span><br><br>
                                                @endif

                                                @if(!empty($order_tax[$i]))
                                                    <strong>@lang("lang.order_tax")</strong><br><span>{{@num_format($order_tax[$i])}}</span><br><br>
                                                @endif

                                                @if(!empty($shipping_cost[$i]))
                                                    <strong>@lang("lang.delivery_cost")</strong><br><span>{{@num_format($shipping_cost[$i])}}</span><br><br>
                                                @endif

                                                @if(!empty($grand_total[$i]))
                                                    <strong>@lang("lang.grand_total")</strong><br><span>{{@num_format($grand_total[$i])}}</span><br><br>
                                                @endif

                                            </td>
                                            @php
                                                $flag = 1;
                                                $i++;
                                                continue;
                                            @endphp

                                            @else
                                                <td></td>
                                            @endif

                                            @endfor

                        </tr>
                        @endwhile

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('javascripts')
    <script src="{{ asset('js/product/product.js') }}"></script>
@endpush


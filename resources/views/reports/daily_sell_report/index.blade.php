@extends('layouts.app')
@section('title', __('lang.daily_sale_report'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.daily_sale_report')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7"
                                    href="{{ route('initial-balance.create') }}">/ @lang('lang.reports')</a>
                            </li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.daily_sale_report')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    {{--                <div class="widgetbar"> --}}
                    {{--                    <a type="button" class="btn btn-primary" href="{{route('initial-balance.create')}}">@lang('lang.add_initial_balance')</a> --}}
                    {{--                </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">
        <div class="col-md-12 mt-3 no-print">
            <div class="card">
                <div
                    class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
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
                        <table
                            class="table table-bordered table-hover table-striped  @if (app()->isLocale('ar')) dir-rtl @endif"
                            style="border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
                            <thead>
                                <tr>
                                    <th>
                                        <a style="color: white;text-decoration: none"
                                            href="{{ url('reports/daily_sales_report?year=' . $prev_year . '&month=' . $prev_month) }}">
                                            <i class="fa fa-arrow-right"></i> @lang('lang.previous')
                                        </a>
                                    </th>
                                    <th colspan="5" class="text-center">
                                        {{ date('F', strtotime($year . '-' . $month . '-01')) . ' ' . $year }}
                                    </th>
                                    <th>
                                        <a style="color: white;text-decoration: none"
                                            href="{{ url('reports/daily_sales_report?year=' . $next_year . '&month=' . $next_month) }}">
                                            @lang('lang.next')
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="position: sticky;top:37px;">
                                    <td style="color:#596fd7"><strong>@lang('lang.sunday')</strong></td>
                                    <td style="color:#596fd7"><strong>@lang('lang.monday')</strong></td>
                                    <td style="color:#596fd7"><strong>@lang('lang.tuesday')</strong></td>
                                    <td style="color:#596fd7"><strong>@lang('lang.wednesday')</strong></td>
                                    <td style="color:#596fd7"><strong>@lang('lang.thursday')</strong></td>
                                    <td style="color:#596fd7"><strong>@lang('lang.friday')</strong></td>
                                    <td style="color:#596fd7"><strong>@lang('lang.saturday')</strong></td>
                                </tr>
                                @php
                                    $i = 1;
                                    $flag = 0;
                                @endphp
                                @while ($i <= $number_of_day)
                                    <tr>
                                        @for ($j = 1; $j <= 7; $j++)
                                            @if ($i > $number_of_day)
                                                @php
                                                    break;
                                                @endphp
                                            @endif
                                            @if ($flag)
                                                @if ($year . '-' . $month . '-' . $i == date('Y') . '-' . date('m') . '-' . (int) date('d'))
                                                    <td>
                                                        <p style="color:red"><strong>{{ $i }}</strong></p>
                                                    @else
                                                    <td>
                                                        <p><strong>{{ $i }}</strong></p>
                                                @endif

                                                @if (!empty($total_surplus[$i]))
                                                    <strong>@lang('lang.total_surplus')</strong><br><span>{{ @num_format($total_surplus[$i]) }}</span><br><br>
                                                @endif

                                                @if (!empty($total_discount[$i]))
                                                    <strong>@lang('lang.product_discount')</strong><br><span>{{ @num_format($total_discount[$i]) }}</span><br><br>
                                                @endif

                                                @if (!empty($total_tax[$i]))
                                                    <strong>@lang('lang.product_tax')</strong><br><span>{{ @num_format($total_tax[$i]) }}</span><br><br>
                                                @endif

                                                @if (!empty($order_tax[$i]))
                                                    <strong>@lang('lang.order_tax')</strong><br><span>{{ @num_format($order_tax[$i]) }}</span><br><br>
                                                @endif

                                                @if (!empty($shipping_cost[$i]))
                                                    <strong>@lang('lang.delivery_cost')</strong><br><span>{{ @num_format($shipping_cost[$i]) }}</span><br><br>
                                                @endif

                                                @if (!empty($grand_total[$i]))
                                                    <strong>@lang('lang.grand_total')</strong><br><span>{{ @num_format($grand_total[$i]) }}</span><br><br>
                                                @endif
                                                @if (!empty($dollar_grand_total[$i]))
                                                    <strong>@lang('lang.grand_total')
                                                        $</strong><br><span>{{ @num_format($dollar_grand_total[$i]) }}</span><br><br>
                                                @endif

                                                </td>
                                                @php
                                                    $i++;
                                                @endphp
                                            @elseif($j == $start_day)
                                                @if ($year . '-' . $month . '-' . $i == date('Y') . '-' . date('m') . '-' . (int) date('d'))
                                                    <td>
                                                        <p style="color:red"><strong>'.$i.'</strong></p>
                                                    @else
                                                    <td>
                                                        <p><strong>{{ $i }}</strong></p>
                                                @endif

                                                @if (!empty($total_discount[$i]))
                                                    <strong>@lang('lang.product_discount')</strong><br><span>{{ @num_format($total_discount[$i]) }}</span><br><br>
                                                @endif

                                                @if (!empty($total_tax[$i]))
                                                    <strong>@lang('lang.product_tax')</strong><br><span>{{ @num_format($total_tax[$i]) }}</span><br><br>
                                                @endif

                                                @if (!empty($order_tax[$i]))
                                                    <strong>@lang('lang.order_tax')</strong><br><span>{{ @num_format($order_tax[$i]) }}</span><br><br>
                                                @endif

                                                @if (!empty($shipping_cost[$i]))
                                                    <strong>@lang('lang.delivery_cost')</strong><br><span>{{ @num_format($shipping_cost[$i]) }}</span><br><br>
                                                @endif

                                                @if (!empty($grand_total[$i]))
                                                    <strong>@lang('lang.grand_total')</strong><br><span>{{ @num_format($grand_total[$i]) }}</span><br><br>
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
    </div>

@endsection
@push('javascripts')
    <script src="{{ asset('js/product/product.js') }}"></script>
@endpush

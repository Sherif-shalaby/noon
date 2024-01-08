@extends('layouts.app')
@section('title', __('lang.dashboard'))
{{-- @section('breadcrumbbar') --}}
{{-- <div class="breadcrumbbar"> --}}
{{--        <div class="row align-items-center"> --}}
{{--            <div class="col-md-8 col-lg-8"> --}}
{{--                <h4 class="page-title">Starter</h4> --}}
{{--                <div class="breadcrumb-list"> --}}
{{--                    <ol class="breadcrumb"> --}}
{{--                        <li class="breadcrumb-item"><a href="index.html">Home</a></li> --}}
{{--                        <li class="breadcrumb-item"><a href="#">Basic Pages</a></li> --}}
{{--                        <li class="breadcrumb-item active" aria-current="page">Starter</li> --}}
{{--                    </ol> --}}
{{--                </div> --}}
{{--            </div> --}}
{{--            <div class="col-md-4 col-lg-4"> --}}
{{--                <div class="widgetbar"> --}}
{{--                    <button class="btn btn-primary">Add Widget</button> --}}
{{--                </div> --}}
{{--            </div> --}}
{{--        </div> --}}
{{-- </div> --}}
{{-- @endsection --}}

@section('content')
    <div class="animate-in-page">

        <div class="contentbar">
            <!-- Start row -->
            <div
                class="row justify-content-evenly  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                {{-- ################ نظرة عامة ################ --}}
                <div class="card-deck home-card-deck m-b-30 col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
                    style="animation-delay: 0.7s">
                    <a href="{{ route('home') }}">
                        <div class="card home-card-deck p-3">
                            <img class="card-img-top" src="{{ asset('images/dashboard-icon/dashboard (1).png') }}"
                                alt="Card image cap">
                            <div class="card-body pt-2 p-0 text-center">
                                <a class="font-weight-bold text-decoration-none card-title font-16"
                                    href="{{ route('home') }}">{{ __('lang.dashboard') }}</a>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- ################ المنتجات ################ --}}
                <div class="card-deck home-card-deck m-b-30 col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
                    style="animation-delay: 0.8s">
                    <a href={{ route('products.create') }}>
                        <div class="card p-3">
                            <img class="card-img-top" src="{{ asset('images/dashboard-icon/dairy-products.png') }}"
                                alt="Card image cap">
                            <div class="card-body pt-2 p-0 text-center">
                                <a class="font-weight-bold text-decoration-none card-title font-16"
                                    href="{{ route('products.create') }}">{{ __('lang.products') }}</a>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- ################  المشتريات ################ --}}
                <div class="card-deck home-card-deck m-b-30 col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
                    style="animation-delay: 0.9s">
                    <a href="{{ route('pos.index') }}">
                        <div class="card p-3">
                            <img class="card-img-top" src="{{ asset('images/dashboard-icon/cash-machine.png') }}"
                                alt="Card image cap">
                            <div class="card-body pt-2 p-0 text-center">
                                <a class="font-weight-bold text-decoration-none card-title font-16"
                                    href="{{ route('pos.index') }}">{{ __('lang.sells') }}</a>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- ################ المشتريات ################ --}}
                <div class="card-deck home-card-deck m-b-30 col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
                    style="animation-delay: 1s">
                    <a href="{{ route('stocks.create') }}">
                        <div class="card p-3">
                            <img class="card-img-top" src="{{ asset('images/dashboard-icon/warehouse.png') }}"
                                alt="Card image cap">
                            <div class="card-body pt-2 p-0 text-center">
                                <a class="font-weight-bold text-decoration-none card-title font-16"
                                    href="{{ route('stocks.create') }}">{{ __('lang.stock') }}</a>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- ################ المرتجعات ################ --}}
                <div class="card-deck home-card-deck m-b-30 col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
                    style="animation-delay: 1.1s">
                    <a href="{{ route('returns') }}">
                        <div class="card p-3">
                            <img class="card-img-top" src="{{ asset('images/dashboard-icon/return.png') }}"
                                alt="Card image cap">
                            <div class="card-body pt-2 p-0 text-center">
                                <a class="font-weight-bold text-decoration-none card-title font-16"
                                    href="{{ route('returns') }}">{{ __('lang.returns') }}</a>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- ################ الموظفين ################ --}}
                <div class="card-deck home-card-deck m-b-30 col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
                    style="animation-delay: 1.2s">
                    <a href="{{ route('employees.create') }}">
                        <div class="card p-3">
                            <img class="card-img-top" src="{{ asset('images/dashboard-icon/employment.png') }}"
                                alt="Card image cap">
                            <div class="card-body pt-2 p-0 text-center">
                                <a class="font-weight-bold text-decoration-none card-title font-16"
                                    href="{{ route('employees.create') }}">{{ __('lang.employees') }}</a>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- ################ العملاء ################ --}}
                <div class="card-deck home-card-deck m-b-30 col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
                    style="animation-delay: 1.3s">
                    <a href="{{ route('customers.create') }}">
                        <div class="card p-3">
                            <img class="card-img-top" src="{{ asset('images/dashboard-icon/customer-satisfaction.png') }}"
                                alt="Card image cap">
                            <div class="card-body pt-2 p-0 text-center ">
                                <a class="font-weight-bold text-decoration-none card-title font-16"
                                    href="{{ route('customers.create') }}">{{ __('lang.customers') }}</a>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- ################ الموردين ################ --}}
                <div class="card-deck home-card-deck m-b-30 col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
                    style="animation-delay: 1.4s">
                    <a href="{{ route('suppliers.create') }}">
                        <div class="card p-3">
                            <img class="card-img-top" src="{{ asset('images/dashboard-icon/inventory.png') }}"
                                alt="Card image cap">
                            <div class="card-body pt-2 p-0 text-center">
                                <a class="font-weight-bold text-decoration-none card-title font-16"
                                    href="{{ route('suppliers.create') }}">{{ __('lang.suppliers') }}</a>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- ################ الاعدادات ################ --}}
                <div class="card-deck home-card-deck m-b-30 col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
                    style="animation-delay: 1.5s">
                    <a href="{{ route('settings.all') }}">
                        <div class="card p-3">
                            <img class="card-img-top" src="{{ asset('images/dashboard-icon/settings.png') }}"
                                alt="Card image cap">
                            <div class="card-body pt-2 p-0 text-center">
                                <a class="font-weight-bold text-decoration-none card-title font-16"
                                    href="{{ route('settings.all') }}">{{ __('lang.settings') }}</a>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- ################ التفارير ################ --}}
                <div class="card-deck home-card-deck m-b-30 col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn align-content-center"
                    style="animation-delay: 1.6s">
                    <a href="{{ route('reports.all') }}">
                        <div class="card p-3">
                            <img class="card-img-top" src="{{ asset('images/dashboard-icon/report.png') }}"
                                alt="Card image cap">
                            <div class="card-body pt-2 p-0 text-center">
                                <a class="font-weight-bold text-decoration-none card-title ont-16 "
                                    href="{{ route('reports.all') }}">{{ __('lang.reports') }}</a>
                            </div>
                        </div>
                    </a>
                </div>
                <br>
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-md-12">
                            <div class="brand-text float-left mt-4">
                                <h3>@lang('lang.welcome') <span>{{ Auth::user()->name }}</span> </h3>
                            </div>
                            @if (auth()->user()->can('superadmin') ||
                                    auth()->user()->is_admin ||
                                    auth()->user()->can('dashboard.profit.view'))
                                @if (strtolower(session('user.job_title')) != 'deliveryman')
                                    <div class="filter-toggle btn-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="store_id"><b>@lang('lang.store')</b></label>
                                                {!! Form::select('store_id', $stores, session('user.is_superadmin') ? null : key($stores), [
                                                    'class' => 'form-control ',
                                                    'multiple',
                                                    'data-live-search' => 'true',
                                                    'id' => 'store_id',
                                                ]) !!}

                                            </div>
                                            <div class="col-md-3">
                                                <label for="from_date"><b>@lang('lang.from_date')</b></label>
                                                <input type="date" class="form-control filter" name="from_date"
                                                    id="from_date" value="{{ date('Y-m-01') }}"
                                                    placeholder="{{ __('lang.from_date') }}">

                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="start_time"><b>@lang('lang.start_time')</b></label>
                                                    {!! Form::text('start_time', null, ['class' => 'form-control time_picker filter', 'id' => 'start_time']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="to_date"><b>@lang('lang.to_date')</b></label>
                                                <input type="date" class="form-control filter" name="to_date"
                                                    id="to_date" value="{{ date('Y-m-t') }}"
                                                    placeholder="{{ __('lang.to_date') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="end_time"><b>@lang('lang.end_time')</b></label>
                                                    {!! Form::text('end_time', null, ['class' => 'form-control time_picker filter', 'id' => 'end_time']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <!-- End row -->
                <div class="container-fluid">
                    @if (auth()->user()->can('superadmin') || auth()->user()->is_admin)
                        <div class="row">

                            <!-- Count item widget-->
                            <div class="col-sm-2">
                                <div class="wrapper count-title text-center">
                                    <div class="icon"><i class="fa fa-cubes" style="color: #498636"></i>
                                    </div>
                                    <div class="name"><strong style="color: #498636">@lang('lang.current_stock_value')</strong>
                                    </div>
                                    <div class="count-number current_stock_value-data">
                                        {{ @num_format(0) }}</div>
                                </div>
                            </div>
                            <!-- Count item widget-->
                            <div class="col-sm-2">
                                <div class="wrapper count-title text-center">
                                    <div class="icon"><i class="dripicons-graph-bar" style="color: #733686"></i>
                                    </div>
                                    <div class="name"><strong style="color: #733686">@lang('lang.revenue')</strong>
                                    </div>
                                    <div class="count-number revenue-data">{{ @num_format(0) }}
                                    </div>
                                </div>
                            </div>
                            <!-- Count item widget-->
                            <div class="col-sm-2">
                                <div class="wrapper count-title text-center">
                                    <div class="icon"><i class="dripicons-return" style="color: #ff8952"></i>
                                    </div>
                                    <div class="name"><strong style="color: #ff8952">@lang('lang.sale_return')</strong>
                                    </div>
                                    <div class="count-number sell_return-data">
                                        {{ @num_format(0) }}
                                    </div>
                                </div>
                            </div>
                            <!-- Count item widget-->
                            <div class="col-sm-2">
                                <div class="wrapper count-title text-center">
                                    <div class="icon"><i class="dripicons-media-loop" style="color: #297ff9"></i>
                                    </div>
                                    <div class="name"><strong style="color: #297ff9">@lang('lang.total_taxes')</strong>
                                    </div>
                                    <div class="count-number total_tax">{{ @num_format(0) }}
                                    </div>
                                </div>
                            </div>
                            <!-- Count item widget-->
                            {{-- <div class="col-sm-2">
                        <div class="wrapper count-title text-center">
                            <div class="icon"><i class="dripicons-media-loop"
                                    style="color: #00c689"></i>
                            </div>
                            <div class="name"><strong
                                    style="color: #00c689">@lang('lang.purchase_return')</strong>
                            </div>
                            <div class="count-number purchase_return-data">
                                {{ @num_format(0) }}</div>
                        </div>
                </div> --}}
                            <!-- Count item widget-->
                            <div class="col-sm-2">
                                <div class="wrapper count-title text-center">
                                    <div class="icon"><i class="dripicons-trophy" style="color: #297ff9"></i>
                                    </div>
                                    <div class="name"><strong style="color: #297ff9">@lang('lang.profit')</strong>
                                    </div>
                                    <div class="count-number profit-data">{{ @num_format(0) }}
                                    </div>
                                </div>
                            </div>


                            {{-- </div> --}}
                    @endif
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="wrapper count-title text-center" style="margin-top: 20px;">
                            <div class="icon"><i class="dripicons-trophy" style="color: #3f6dad"></i>
                            </div>
                            <div class="name"><strong style="color: #3f6dad">@lang('lang.net_profit')</strong>
                            </div>
                            <div class="count-number net_profitt-data">{{ @num_format(0) }}
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-2">
                        <div class="wrapper count-title text-center" style="margin-top: 20px;">
                            <div class="icon"><i class="dripicons-trophy" style="color: #3f6dad"></i>
                            </div>
                            <div class="name"><strong style="color: #3f6dad">@lang('lang.expense')</strong>
                            </div>
                            <div class="count-number expense-data">{{ @num_format(0) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="wrapper count-title text-center" style="margin-top: 20px;">
                            <div class="icon"><i class="dripicons-trophy" style="color: #3f6dad"></i>
                            </div>
                            <div class="name"><strong style="color: #3f6dad">@lang('lang.purchase')</strong>
                            </div>
                            <div class="count-number purchase-data">{{ @num_format(0) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;" id="exchange-rate"
        data-exchange-rate="{{ App\Models\System::getProperty('dollar_exchange') }}"></div>

@endsection
@section('javascript')
    <script>
        var exchangeRate = parseFloat($('#exchange-rate').data('exchange-rate'));
        console.log(exchangeRate);
        $(document).ready(function() {
            $('#store_id').change();
            var exchangeRate = $('#exchange-rate').data('exchange-rate');
        });
        $(document).on("change", '.filter, #store_id', function() {
            var store_id = $('select#store_id').val();
            var start_date = $('#from_date').val();
            var start_time = $('#start_time').val();
            var end_time = $('#end_time').val();
            if (!start_date) {
                start_date = 0;
            }
            var end_date = $('#to_date').val();
            if (!end_date) {
                end_date = 0;
            }
            getDashboardData(store_id, start_date, end_date, start_time, end_time);
        });
        $('#start_time, #end_time').focusout(function(event) {
            var store_id = $('#store_id').val();
            var start_date = $('#from_date').val();
            var start_time = $('#start_time').val();
            var end_time = $('#end_time').val();
            if (!start_date) {
                start_date = 0;
            }
            var end_date = $('#to_date').val();
            if (!end_date) {
                end_date = 0;
            }
            getDashboardData(store_id, start_date, end_date, start_time, end_time)
        })

        function getDashboardData(store_id, start_date, end_date, start_time, end_time) {
            console.log(store_id, 'store_id');
            console.log('test');
            // console.log('element.data.net_profit' + element.data.net_profit);
            $.ajax({
                method: 'get',
                url: '/get-dashboard-data/' + start_date + '/' + end_date,
                data: {
                    store_id: store_id,
                    start_time: start_time,
                    end_time: end_time,
                },
                // processData: false,
                success: function(result) {
                    console.log(result, 'result');
                    $('.revenue-data').hide();
                    // $(".revenue-data").text(__currency_trans_from_en(result.revenue, false));
                    let currenct_stock_string = '<div>';
                    let revenue_string = '<div>';
                    let sell_return_string = '<div>';
                    let total_tax_string = '<div>';
                    // let purchase_return_string = '<div>';
                    let profit_string = '<div>';
                    let net_profit_string = '<div>';
                    let expense_string = '<div>';
                    let purchase_string = '<div>';
                    result.forEach(element => {
                        // console.log('currenct_stock_string'+ parseFloat(element.data.current_stock_value));
                        currenct_stock_string += `<h3 class="dashboard_currency
                                            data-orig_value="${element.data.current_stock_value}">
                                            <span class="symbol" style="padding-right: 10px;">
                                               د.ع</span>
                                            <span
                                                class="total">${element.data.current_stock_value}</span>
                                                <span class="symbol" style="padding-right: 10px;">
                                               $ </span>
                                                <span
                                                class="doll_total">${(parseFloat(element.data.current_stock_value.replace(/,/g, '')) / exchangeRate).toFixed(2)}</span>
                                        </h3>
                                      `;

                        revenue_string += `<h3 class="dashboard_currency
                                            data-orig_value="${element.data.revenue}">
                                            <span class="symbol" style="padding-right: 10px;">
                                                 د.ع</span>
                                            <span
                                                class="total">${element.data.revenue}</span>
                                                <span class="symbol" style="padding-right: 10px;">
                                               $ </span>
                                                <span
                                                class="doll_total">${(parseFloat(element.data.revenue.replace(/,/g, '')) / exchangeRate).toFixed(2)}</span>
                                        </h3>
                                        </h3>`;
                        sell_return_string += `<h3 class="dashboard_currency

                                            data-orig_value="${element.data.sell_return}">
                                            <span class="symbol" style="padding-right: 10px;">
                                                 د.ع</span>
                                            <span
                                                class="total">${element.data.sell_return}</span>
                                                <span class="symbol" style="padding-right: 10px;">
                                               $ </span>
                                                <span
                                                class="doll_total">${(parseFloat(element.data.sell_return.replace(/,/g, '')) / exchangeRate).toFixed(2)}</span>

                                        </h3>`;

                        total_tax_string += `<h3 class="dashboard_currency

                                            data-orig_value="${element.data.total_tax}">
                                            <span class="symbol" style="padding-right: 10px;">
                                                د.ع</span>
                                            <span
                                                class="total">${element.data.total_tax}</span>
                                                <span class="symbol" style="padding-right: 10px;">
                                               $ </span>
                                                <span
                                                class="doll_total">${(parseFloat(element.data.total_tax.replace(/,/g, '')) / exchangeRate).toFixed(2)}</span>
                                        </h3>`;
                        profit_string += `<h3 class="dashboard_currency
                                            data-orig_value="${element.data.profit}">
                                            <span class="symbol" style="padding-right: 10px;">
                                                د.ع</span>
                                            <span
                                                class="total">${element.data.profit}</span>
                                                <span class="symbol" style="padding-right: 10px;">
                                               $ </span>
                                                <span
                                                class="doll_total">${(parseFloat(element.data.profit.replace(/,/g, '')) / exchangeRate).toFixed(2)}</span>
                                        </h3>`;
                        net_profit_string += `<h3 class="dashboard_currency
                                            data-orig_value="${element.data.net_profit}">
                                            <span class="symbol" style="padding-right: 10px;">
                                                 د.ع</span>
                                            <span
                                                class="total">${element.data.net_profit}</span>
                                                <span class="symbol" style="padding-right: 10px;">
                                               $ </span>
                                                <span
                                                class="doll_total">${(parseFloat(element.data.net_profit.replace(/,/g, '')) / exchangeRate).toFixed(2)}</span>
                                        </h3>`;
                        expense_string += `<h3 class="dashboard_currency
                                            data-orig_value="${element.data.expense}">
                                            <span class="symbol" style="padding-right: 10px;">
                                             د.ع</span>
                                            <span
                                                class="total">${element.data.expense}</span>
                                                <span class="symbol" style="padding-right: 10px;">
                                               $ </span>
                                                <span
                                                class="doll_total">${(parseFloat(element.data.expense.replace(/,/g, '')) / exchangeRate).toFixed(2)}</span>
                                        </h3>`;
                        purchase_string += `<h3 class="dashboard_currency
                                            data-orig_value="${element.data.purchase}">
                                            <span class="symbol" style="padding-right: 10px;">
                                                 د.ع</span>
                                            <span
                                                class="total">${element.data.purchase}</span>
                                                <span class="symbol" style="padding-right: 10px;">
                                               $ </span>
                                                <span
                                                class="doll_total">${(parseFloat(element.data.purchase.replace(/,/g, '')) / exchangeRate).toFixed(2)}</span>
                                        </h3>`;
                    });
                    currenct_stock_string += `</div>`;
                    revenue_string += `</div>`;
                    sell_return_string += `</div>`;
                    // purchase_return_string += `</div>`;
                    total_tax_string += `</div>`;
                    profit_string += `</div>`;
                    net_profit_string += '</div>';
                    expense_string += '</div>';
                    purchase_string += '</div>';
                    $(".revenue-data").html(revenue_string);
                    $('.revenue-data').show(500);
                    $('.current_stock_value-data').hide();
                    $(".current_stock_value-data").html(currenct_stock_string);
                    $('.current_stock_value-data').show(500);
                    $('.sell_return-data').hide();
                    $(".sell_return-data").html(sell_return_string);
                    $('.sell_return-data').show(500);
                    // $('.purchase_return-data').hide();
                    // $(".purchase_return-data").html(purchase_return_string);
                    // $('.purchase_return-data').show(500);
                    $('.total_tax').hide();
                    $(".total_tax").html(total_tax_string);
                    $('.total_tax').show(500);
                    $('.profit-data').hide();
                    $(".profit-data").html(profit_string);
                    $('.profit-data').show(500);
                    $('.net_profitt-data').hide();
                    $(".net_profitt-data").html(net_profit_string);
                    $('.net_profitt-data').show(500);
                    $('.expense-data').hide();
                    $(".expense-data").html(expense_string);
                    $('.expense-data').show(500);
                    $('.purchase-data').hide();
                    $(".purchase-data").html(purchase_string);
                    $('.purchase-data').show(500);
                },
            });

        }
    </script>
@endsection

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
    <style>
        .table-scroll-wrapper {
            width: fit-content;
        }

        @media(min-width:1900px) {
            .table-scroll-wrapper {
                width: 100%;
            }
        }
    </style>
    <div class="animate-in-page">

        <div class="contentbar">
            <!-- Start row -->
            <div
                class="row justify-content-evenly  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                {{-- ################ نظرة عامة ################ --}}
                <div class="card-deck home-card-deck col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
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
                <div class="card-deck home-card-deck col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
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
                <div class="card-deck home-card-deck col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
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
                <div class="card-deck home-card-deck col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
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
                <div class="card-deck home-card-deck col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
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
                <div class="card-deck home-card-deck col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
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
                <div class="card-deck home-card-deck col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
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
                <div class="card-deck home-card-deck col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
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
                <div class="card-deck home-card-deck col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn"
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
                <div class="card-deck home-card-deck col-6 col-md-4 col-lg-2 animate__animated  animate__bounceIn align-content-center"
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

                <div
                    class="row justify-content-evenly  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div class="container-fluid">
                        <div class="col-md-12">
                            {!! Form::open([
                                'route' => ['home'],
                                'method' => 'get',
                                'enctype' => 'multipart/form-data',
                            ]) !!}
                            <div
                                class="row @if (app()->isLocale('ar')) justify-content-start flex-row-reverse @else  justify-content-end   flex-row @endif">
                                <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                                    style="animation-delay: 1.15s">
                                    {!! Form::label('customer_name', __('lang.customer_name')) !!}
                                    <div class="input-wrapper width-full">
                                        {!! Form::text('customer_name', request()->customer_name, [
                                            'class' => 'form-control width-full initial-balance-input m-0',
                                            'placeholder' => __('lang.customer_name'),
                                            'id' => 'customer_name',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-2"></div>
                                <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                                    style="animation-delay: 1.15s">
                                    {!! Form::label('customer_phone', __('lang.customer_phone')) !!}
                                    <div class="input-wrapper width-full">
                                        {!! Form::text('customer_phone', request()->customer_phone, [
                                            'class' => 'form-control width-full initial-balance-input m-0',
                                            'placeholder' => __('lang.customer_phone'),
                                            'id' => 'customer_phone',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 p-1 mb-1 justify-content-end d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                                    style="animation-delay: 1.15s">
                                    <button type="submit" class="btn btn-primary">@lang('lang.filter')</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                {{--    End customer Filter --}}

                {{-- Show Customers    --}}
                @if (!empty($customers))
                    <div class="row">
                        <div class="container-fluid">
                            <div class="col-md-12">
                                <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                    <div class="div1"></div>
                                </div>
                                <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                    <div class="div2 table-scroll-wrapper">
                                        <!-- content goes here -->
                                        <div style="min-width: 1800px;max-height: 90vh;overflow: auto">
                                            {{-- +++++++++++++++++++++++++++ Table +++++++++++++++++++++++++++ --}}
                                            <table class="table table-striped table-bordered hideShowTable"
                                                style="max-height: 90vh">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th class="col1">@lang('lang.customer_name')</th>
                                                        <th class="col2">@lang('lang.customer_type')</th>
                                                        <th class="col3">@lang('lang.email')</th>
                                                        <th class="col4">@lang('lang.phone')</th>
                                                        <th class="col5">@lang('lang.state')</th>
                                                        <th class="col6">@lang('lang.city')</th>
                                                        <th class="col7">@lang('lang.min_amount_in_dinar')</th>
                                                        <th class="col8">@lang('lang.max_amount_in_dinar')</th>
                                                        <th class="col9">@lang('lang.min_amount_in_dollar')</th>
                                                        <th class="col10">@lang('lang.max_amount_in_dollar')</th>
                                                        <th class="col11">@lang('lang.balance_in_dinar')</th>
                                                        <th class="col12">@lang('lang.balance_in_dollar')</th>
                                                        <th class="col13">@lang('lang.balance')</th>
                                                        <th class="col14">@lang('lang.purchases')</th>
                                                        <th class="col15">@lang('lang.discount')</th>
                                                        <th class="col16">@lang('lang.points')</th>
                                                        <th class="col17">@lang('updated_by')</th>
                                                        <th class="col18">@lang('lang.action')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($customers as $index => $customer)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td class="col1">{{ $customer->name }}</td>
                                                            <td class="col2">{{ $customer->customer_type->name }}</td>
                                                            {{-- Convert the email and phone strings to arrays --}}
                                                            @php
                                                                $emailArray = explode(',', $customer->email);
                                                                $phoneArray = explode(',', $customer->phone);
                                                                // Remove square brackets from each element in the emailArray
                                                                foreach ($emailArray as $key => $email) {
                                                                    $emailArray[$key] = str_replace(['[', ']', '"'], '', $email);
                                                                }
                                                                // Remove square brackets from each element in the emailArray
                                                                foreach ($phoneArray as $key => $phone) {
                                                                    $phoneArray[$key] = str_replace(['[', ']', '"'], '', $phone);
                                                                }
                                                            @endphp
                                                            <td class="col3">
                                                                {{-- Iterate over the email array elements --}}
                                                                @foreach ($emailArray as $email)
                                                                    {{ $email }}<br>
                                                                @endforeach
                                                            </td>
                                                            <td class="col4">
                                                                {{-- Iterate over the phone array elements --}}
                                                                @foreach ($phoneArray as $phone)
                                                                    {{ $phone }}<br>
                                                                @endforeach
                                                            </td>

                                                            @php
                                                                $state = \App\Models\State::find($customer->state_id);
                                                                $city = \App\Models\City::find($customer->city_id);
                                                            @endphp
                                                            <td class="col5">{{ $state ? $state->name : '' }}</td>
                                                            <td class="col6">{{ $city ? $city->name : '' }}</td>
                                                            <td class="col7">{{ $customer->min_amount_in_dinar }}</td>
                                                            <td class="col8">{{ $customer->max_amount_in_dinar }}</td>
                                                            <td class="col9">{{ $customer->min_amount_in_dollar }}</td>
                                                            <td class="col10">{{ $customer->max_amount_in_dollar }}</td>
                                                            <td class="col11">{{ $customer->balance_in_dinar }}</td>
                                                            <td class="col12">{{ $customer->balance_in_dollar }}</td>
                                                            <td class="col13">{{ $customer->added_balance }}</td>
                                                            <td class="col14">{{ $customer->added_balance }}</td>
                                                            <td class="col15">{{ $customer->added_balance }}</td>
                                                            <td class="col16">
                                                                @if ($customer->created_by > 0 and $customer->created_by != null)
                                                                    {{ $customer->created_at->diffForHumans() }} <br>
                                                                    {{ $customer->created_at->format('Y-m-d') }}
                                                                    ({{ $customer->created_at->format('h:i') }})
                                                                    {{ $customer->created_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                    <br>
                                                                    {{ $customer->createBy?->name }}
                                                                @else
                                                                    {{ __('no_update') }}
                                                                @endif
                                                            </td>
                                                            <td class="col17">
                                                                @if ($customer->updated_by > 0 and $customer->updated_by != null)
                                                                    {{ $customer->updated_at->diffForHumans() }} <br>
                                                                    {{ $customer->updated_at->format('Y-m-d') }}
                                                                    ({{ $customer->updated_at->format('h:i') }})
                                                                    {{ $customer->updated_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                    <br>
                                                                    {{ $customer->updateBy?->name }}
                                                                @else
                                                                    {{ __('no_update') }}
                                                                @endif
                                                            </td>
                                                            <td class="col18">
                                                                <a href="{{ route('customer_invoices', $customer->id) }}"
                                                                    class="btn btn-default btn-sm">
                                                                    @lang('lang.details')
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif





                <div class="row">
                    <div class="container-fluid">
                        <div class="col-md-12">
                            <div
                                class="brand-text d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <h3
                                    class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    @lang('lang.welcome')<span class="mx-1">{{ Auth::user()->name }}</span> </h3>
                            </div>
                            @if (auth()->user()->can('superadmin') ||
                                    auth()->user()->is_admin ||
                                    auth()->user()->can('dashboard.profit.view'))
                                @if (strtolower(session('user.job_title')) != 'deliveryman')
                                    <div class="filter-toggle btn-group d-flex justify-content-end">
                                        <div
                                            class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <div
                                                class="mb-2 col-md-4 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                                <label class="mb-1" for="store_id"><b>@lang('lang.store')</b></label>
                                                <div class="input-wrapper main-card width-full main-page-select">
                                                    {!! Form::select('store_id', $stores, session('user.is_superadmin') ? null : key($stores), [
                                                        'class' => 'form-control select2',
                                                        'multiple',
                                                        'data-live-search' => 'true',
                                                        'id' => 'store_id',
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div
                                                class="mb-2 col-md-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                                <label class="mb-1" for="from_date"><b>@lang('lang.from_date')</b></label>
                                                <div class="input-wrapper main-card width-full">

                                                    <input type="date"
                                                        class="form-control initial-balance-input width-full mx-0 filter"
                                                        name="from_date" id="from_date" value="{{ date('Y-m-01') }}"
                                                        placeholder="{{ __('lang.from_date') }}">
                                                </div>

                                            </div>
                                            <div
                                                class="mb-2 col-md-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                                <label class="mb-1" for="start_time"><b>@lang('lang.start_time')</b></label>
                                                <div class="input-wrapper main-card width-full">
                                                    {!! Form::text('start_time', null, [
                                                        'class' => 'form-control initial-balance-input width-full mx-0 time_picker filter',
                                                        'id' => 'start_time',
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div
                                                class="mb-2 col-md-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                                <label class="mb-1" for="to_date"><b>@lang('lang.to_date')</b></label>
                                                <div class="input-wrapper main-card width-full">

                                                    <input type="date"
                                                        class="form-control initial-balance-input width-full mx-0 filter"
                                                        name="to_date" id="to_date" value="{{ date('Y-m-t') }}"
                                                        placeholder="{{ __('lang.to_date') }}">
                                                </div>
                                            </div>
                                            <div
                                                class="mb-2 col-md-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                                <label class="mb-1" for="end_time"><b>@lang('lang.end_time')</b></label>
                                                <div class="input-wrapper main-card width-full">

                                                    {!! Form::text('end_time', null, [
                                                        'class' => 'form-control initial-balance-input width-full mx-0 time_picker filter',
                                                        'id' => 'end_time',
                                                    ]) !!}
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
                    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        @if (auth()->user()->can('superadmin') || auth()->user()->is_admin)
                            <!-- Count item widget-->
                            <div class="col-sm-2">
                                <div class="wrapper main-card count-title text-center">
                                    <div class="icon d-flex justify-content-center align-items-center"
                                        style="width: 100%">
                                        <img style="width: 30px"
                                            src="{{ asset('/images/main/icons8-warehouse-100.png') }}"
                                            alt="@lang('lang.current_stock_value')">
                                    </div>
                                    <div class="name"><strong style="color: #498636">@lang('lang.current_stock_value')</strong>
                                    </div>
                                    <div class="count-number current_stock_value-data">
                                        {{ @num_format(0) }}</div>
                                </div>
                            </div>
                            <!-- Count item widget-->
                            <div class="col-sm-2">
                                <div class="wrapper main-card count-title text-center">
                                    <div class="icon d-flex justify-content-center align-items-center"
                                        style="width: 100%">
                                        <img style="width: 30px" src="{{ asset('/images/main/icons8-revenue-100.png') }}"
                                            alt="@lang('lang.revenue')">
                                    </div>
                                    <div class="name"><strong style="color: #733686">@lang('lang.revenue')</strong>
                                    </div>
                                    <div class="count-number revenue-data">{{ @num_format(0) }}
                                    </div>
                                </div>
                            </div>
                            <!-- Count item widget-->
                            <div class="col-sm-2">
                                <div class="wrapper main-card count-title text-center">
                                    <div class="icon d-flex justify-content-center align-items-center"
                                        style="width: 100%">
                                        <img style="width: 30px"
                                            src="{{ asset('/images/main/icons8-return-purchase-100.png') }}"
                                            alt="@lang('lang.sale_return')">
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
                                <div class="wrapper main-card count-title text-center">
                                    <div class="icon d-flex justify-content-center align-items-center"
                                        style="width: 100%">
                                        <img style="width: 30px" src="{{ asset('/images/main/icons8-tax-100.png') }}"
                                            alt="@lang('lang.total_taxes')">
                                    </div>
                                    <div class="name"><strong style="color: #297ff9">@lang('lang.total_taxes')</strong>
                                    </div>
                                    <div class="count-number total_tax">{{ @num_format(0) }}
                                    </div>
                                </div>
                            </div>
                            <!-- Count item widget-->
                            {{-- <div class="col-sm-2">
                                <div class="wrapper main-card count-title text-center">
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
                                <div class="wrapper main-card count-title text-center">
                                    <div class="icon d-flex justify-content-center align-items-center"
                                        style="width: 100%">
                                        <img style="width: 30px"
                                            src="{{ asset('/images/main/icons8-sales-performance-100.png') }}"
                                            alt="@lang('lang.profit')">
                                    </div>
                                    <div class="name"><strong style="color: #297ff9">@lang('lang.profit')</strong>
                                    </div>
                                    <div class="count-number profit-data">{{ @num_format(0) }}
                                    </div>
                                </div>
                            </div>
                            {{-- </div> --}}
                        @endif
                        <div class="col-sm-2">
                            <div class="wrapper main-card count-title text-center">
                                <div class="icon d-flex justify-content-center align-items-center" style="width: 100%">
                                    <img style="width: 30px" src="{{ asset('/images/main/icons8-profit-100.png') }}"
                                        alt="@lang('lang.net_profit')">
                                </div>
                                <div class="name"><strong style="color: #3f6dad">@lang('lang.net_profit')</strong>
                                </div>
                                <div class="count-number net_profitt-data">{{ @num_format(0) }}
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-2">
                            <div class="wrapper main-card count-title text-center">
                                <div class="icon d-flex justify-content-center align-items-center" style="width: 100%">
                                    <img style="width: 30px" src="{{ asset('/images/main/icons8-paid-100.png') }}"
                                        alt="@lang('lang.expense')">
                                </div>
                                <div class="name"><strong style="color: #3f6dad">@lang('lang.expense')</strong>
                                </div>
                                <div class="count-number expense-data">{{ @num_format(0) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="wrapper main-card count-title text-center">
                                <div class="icon d-flex justify-content-center align-items-center" style="width: 100%">
                                    <img style="width: 30px" src="{{ asset('/images/main/icons8-purchase-100.png') }}"
                                        alt="@lang('lang.purchase')">
                                </div>
                                <div class="name"><strong style="color: #3f6dad">@lang('lang.purchase')</strong>
                                </div>
                                <div class="count-number purchase-data">{{ @num_format(0) }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                {{-- <div class="row">
                    <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                        <div class="div1"></div>
                    </div>
                    <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                        <div class="div2 table-scroll-wrapper">
                            <!-- content goes here -->
                            <div style="min-width: 1800px;max-height: 90vh;overflow: auto">


                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="col1">@lang('lang.image')</th>
                                            <th class="col2">@lang('lang.product_name')</th>
                                            <th class="col3">@lang('lang.sku')</th>
                                            <th class="col5">@lang('lang.stock')</th>
                                            <th class="col6">@lang('lang.category') 1</th>
                                            <th class="col7">@lang('lang.category') 2</th>
                                            <th class="col19">@lang('lang.category') 3</th>
                                            <th class="col20">@lang('lang.category') 4</th>
                                            <th class="col8">@lang('lang.height')</th>
                                            <th class="col9">@lang('lang.length')</th>
                                            <th class="col10">@lang('lang.width')</th>
                                            <th class="col11">@lang('lang.size')</th>
                                            <th class="col12">@lang('lang.weight')</th>
                                            <th class="col13">{{ __('lang.basic_unit_for_import_product') }}</th>
                                            <th class="col14">@lang('lang.stores')</th>
                                            <th class="col15">@lang('lang.brand')</th>
                                            <th class="col16">@lang('added_by')</th>
                                            <th class="col17">@lang('updated_by')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td class="col1"><img
                                                        src="{{ !empty($product->image) ? '/uploads/products/' . $product->image : '/uploads/' . $settings['logo'] }}"
                                                        style="width: 50px; height: 50px;" alt="{{ $product->name }}">
                                                </td>
                                                <td class="col2">{{ $product->name }}</td>
                                                <td class="col3">{{ $product->sku }}</td>
                                                <td class="col5">
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
                                                                <span class="unit_value">0</span></span> <br>
                                                        @endif
                                                    @empty
                                                        <span>{{ $product->product_stores->sum('quantity_available') }}
                                                        </span>
                                                    @endforelse
                                                </td>
                                                <td class="col6">{{ $product->category->name ?? '' }}</td>
                                                <td class="col7">
                                                    {{ $product->subCategory1->name ?? '' }}
                                                </td>
                                                <td class="col19">
                                                    {{ $product->subCategory2->name ?? '' }}
                                                </td>
                                                <td class="col20">
                                                    {{ $product->subCategory3->name ?? '' }}
                                                </td>
                                                <td class="col8">{{ $product->product_dimensions->height ?? 0 }}</td>
                                                <td class="col9">{{ $product->product_dimensions->length ?? 0 }}</td>
                                                <td class="col10">{{ $product->product_dimensions->width ?? 0 }}</td>
                                                <td class="col11"><span
                                                        class="text-primary">{{ $product->product_dimensions->size ?? 0 }}</span>
                                                </td>
                                                <td class="col12">{{ $product->product_dimensions->weight ?? 0 }}</td>
                                                <td class="col13">
                                                    {{ !empty($product->product_dimensions->variations)
                                                        ? (!empty($product->product_dimensions->variations->unit)
                                                            ? $product->product_dimensions->variations->unit->name
                                                            : '')
                                                        : '' }}
                                                </td>
                                                <td class="col14">
                                                    @foreach ($product->stores as $store)
                                                        {{ $store->name }}<br>
                                                    @endforeach
                                                </td>
                                                <td class="col15">
                                                    {{ !empty($product->brand) ? $product->brand->name : '' }}</td>

                                                <td class="col16">
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
                                                </td>

                                                <td class="col17">
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
                                                </td>
                                            </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}
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

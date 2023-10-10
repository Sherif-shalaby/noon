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
    <div class="contentbar">
        <!-- Start row -->
        <div class="row justify-content-evenly  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            {{-- ################ نظرة عامة ################ --}}
            <div class="card-deck m-b-30 col-md-2">
                <a href="{{ route('home') }}">
                    <div class="card p-3">
                        <img class="card-img-top" src="{{ asset('images/dashboard-icon/dashboard (1).png') }}"
                            alt="Card image cap">
                        <div class="card-body pt-2 p-0 text-center">
                            <a class="font-weight-bold text-decoration-none text-dark  font-16"
                                href="{{ route('home') }}">{{ __('lang.dashboard') }}</a>
                        </div>
                    </div>
                </a>
            </div>

            {{-- ################ المنتجات ################ --}}
            <div class="card-deck m-b-30 col-md-2">
                <a href={{ route('products.create') }}>
                    <div class="card p-3">
                        <img class="card-img-top" src="{{ asset('images/dashboard-icon/dairy-products.png') }}"
                            alt="Card image cap">
                        <div class="card-body pt-2 p-0 text-center">
                            <a class="font-weight-bold text-decoration-none text-dark  font-16"
                                href="{{ route('products.create') }}">{{ __('lang.products') }}</a>
                        </div>
                    </div>
                </a>
            </div>
            {{-- ################  المشتريات ################ --}}
            <div class="card-deck m-b-30 col-md-2">
                <a href="{{ route('pos.index') }}">
                    <div class="card p-3">
                        <img class="card-img-top" src="{{ asset('images/dashboard-icon/cash-machine.png') }}"
                            alt="Card image cap">
                        <div class="card-body pt-2 p-0 text-center">
                            <a class="font-weight-bold text-decoration-none text-dark  font-16"
                                href="{{ route('pos.index') }}">{{ __('lang.sells') }}</a>
                        </div>
                    </div>
                </a>
            </div>
            {{-- ################ المشتريات ################ --}}
            <div class="card-deck m-b-30 col-md-2">
                <a href="{{ route('stocks.create') }}">
                    <div class="card p-3">
                        <img class="card-img-top" src="{{ asset('images/dashboard-icon/warehouse.png') }}"
                            alt="Card image cap">
                        <div class="card-body pt-2 p-0 text-center">
                            <a class="font-weight-bold text-decoration-none text-dark  font-16"
                                href="{{ route('stocks.create') }}">{{ __('lang.stock') }}</a>
                        </div>
                    </div>
                </a>
            </div>
            {{-- ################ المرتجعات ################ --}}
            <div class="card-deck m-b-30 col-md-2">
                <a href="{{ route('returns') }}">
                    <div class="card p-3">
                        <img class="card-img-top" src="{{ asset('images/dashboard-icon/return.png') }}"
                            alt="Card image cap">
                        <div class="card-body pt-2 p-0 text-center">
                            <a class="font-weight-bold text-decoration-none text-dark  font-16"
                                href="{{ route('returns') }}">{{ __('lang.returns') }}</a>
                        </div>
                    </div>
                </a>
            </div>
            {{-- ################ الموظفين ################ --}}
            <div class="card-deck m-b-30 col-md-2">
                <a href="{{ route('employees.create') }}">
                    <div class="card p-3">
                        <img class="card-img-top" src="{{ asset('images/dashboard-icon/employment.png') }}"
                            alt="Card image cap">
                        <div class="card-body pt-2 p-0 text-center">
                            <a class="font-weight-bold text-decoration-none text-dark  font-16"
                                href="{{ route('employees.create') }}">{{ __('lang.employees') }}</a>
                        </div>
                    </div>
                </a>
            </div>
            {{-- ################ العملاء ################ --}}
            <div class="card-deck m-b-30 col-md-2">
                <a href="{{ route('customers.create') }}">
                    <div class="card p-3">
                        <img class="card-img-top" src="{{ asset('images/dashboard-icon/customer-satisfaction.png') }}"
                            alt="Card image cap">
                        <div class="card-body pt-2 p-0 text-center ">
                            <a class="font-weight-bold text-decoration-none text-dark  font-16"
                                href="{{ route('customers.create') }}">{{ __('lang.customers') }}</a>
                        </div>
                    </div>
                </a>
            </div>
            {{-- ################ الموردين ################ --}}
            <div class="card-deck m-b-30 col-md-2">
                <a href="{{ route('suppliers.create') }}">
                    <div class="card p-3">
                        <img class="card-img-top" src="{{ asset('images/dashboard-icon/inventory.png') }}"
                            alt="Card image cap">
                        <div class="card-body pt-2 p-0 text-center">
                            <a class="font-weight-bold text-decoration-none text-dark  font-16"
                                href="{{ route('suppliers.create') }}">{{ __('lang.suppliers') }}</a>
                        </div>
                    </div>
                </a>
            </div>
            {{-- ################ الاعدادات ################ --}}
            <div class="card-deck m-b-30 col-md-2">
                <a href="{{ route('settings.all') }}">
                    <div class="card p-3">
                        <img class="card-img-top" src="{{ asset('images/dashboard-icon/settings.png') }}"
                            alt="Card image cap">
                        <div class="card-body pt-2 p-0 text-center">
                            <a class="font-weight-bold text-decoration-none text-dark  font-16"
                                href="{{ route('settings.all') }}">{{ __('lang.settings') }}</a>
                        </div>
                    </div>
                </a>
            </div>
            {{-- ################ التفارير ################ --}}
            <div class="card-deck m-b-30 col-md-2 align-content-center">
                <a href="{{ route('reports.all') }}">
                    <div class="card p-3">
                        <img class="card-img-top" src="{{ asset('images/dashboard-icon/report.png') }}"
                            alt="Card image cap">
                        <div class="card-body pt-2 p-0 text-center">
                            <a class="font-weight-bold text-decoration-none text-dark font-16 "
                                href="{{ route('reports.all') }}">{{ __('lang.reports') }}</a>
                        </div>
                    </div>
                </a>
            </div>



        </div>
        <!-- End row -->
    </div>
@endsection

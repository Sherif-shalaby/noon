@extends('layouts.app')
@section('title', __('lang.dashboard'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
{{--        <div class="row align-items-center">--}}
{{--            <div class="col-md-8 col-lg-8">--}}
{{--                <h4 class="page-title">Starter</h4>--}}
{{--                <div class="breadcrumb-list">--}}
{{--                    <ol class="breadcrumb">--}}
{{--                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>--}}
{{--                        <li class="breadcrumb-item"><a href="#">Basic Pages</a></li>--}}
{{--                        <li class="breadcrumb-item active" aria-current="page">Starter</li>--}}
{{--                    </ol>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-4 col-lg-4">--}}
{{--                <div class="widgetbar">--}}
{{--                    <button class="btn btn-primary">Add Widget</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
@section('content')
<div class="contentbar">
    <!-- Start row -->
    <div class="row justify-content-between">
            <div class="col-md-1"></div>
            {{-- ################ نظرة عامة ################ --}}
            <div class="card-deck m-b-30 col-md-2">
                <div class="card p-3">
                    <img class="card-img-top" src="{{asset('images/dashboard-icon/dashboard (1).png')}}" alt="Card image cap">
                    <div class="card-body text-center">
                        <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('home')}}">{{__('lang.dashboard')}}</a>
                    </div>
                </div>
            </div>
            {{-- ################ المنتجات ################ --}}
            <div class="card-deck m-b-30 col-md-2">
                <div class="card p-3">
                    <img class="card-img-top" src="{{asset('images/dashboard-icon/dairy-products.png')}}" alt="Card image cap">
                    <div class="card-body">
                        <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('products.index')}}">{{__('lang.products')}}</a>
                    </div>
                </div>
            </div>
            {{-- ################  المشتريات ################ --}}
            <div class="card-deck m-b-30 col-md-2">
                <div class="card p-3">
                    <img class="card-img-top" src="{{asset('images/dashboard-icon/cash-machine.png')}}" alt="Card image cap">
                    <div class="card-body">
                        <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('pos.index')}}">{{__('lang.sells')}}</a>
                    </div>
                </div>
            </div>
            {{-- ################ المشتريات ################ --}}
            <div class="card-deck m-b-30 col-md-2">
                <div class="card p-3">
                    <img class="card-img-top" src="{{asset('images/dashboard-icon/warehouse.png')}}" alt="Card image cap">

                    <div class="card-body">
                        <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('stocks.index')}}">{{__('lang.stock')}}</a>
                    </div>
                </div>
            </div>
            {{-- ################ المرتجعات ################ --}}
            <div class="card-deck m-b-30 col-md-2">
                <div class="card p-3">
                    <img class="card-img-top" src="{{asset('images/dashboard-icon/return.png')}}" alt="Card image cap">
                    <div class="card-body">
                        <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('returns')}}">{{__('lang.returns')}}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        <!-- End col -->
    </div>
    <div class="row justify-content-between">
        <div class="col-md-1"></div>
        <div class="card-deck m-b-30 col-md-2">
            <div class="card p-3">
                <img class="card-img-top" src="{{asset('images/dashboard-icon/employment.png')}}" alt="Card image cap">
                <div class="card-body">
                    <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('employees.index')}}">{{__('lang.employees')}}</a>
                </div>
            </div>
        </div>
        <div class="card-deck m-b-30 col-md-2">
            <div class="card p-3">
                <img class="card-img-top" src="{{asset('images/dashboard-icon/customer-satisfaction.png')}}" alt="Card image cap">
                <div class="card-body">
                    <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('customers.index')}}">{{__('lang.customers')}}</a>
                </div>
            </div>
        </div>
        <div class="card-deck m-b-30 col-md-2">
            <div class="card p-3">
                <img class="card-img-top" src="{{asset('images/dashboard-icon/inventory.png')}}" alt="Card image cap">
                <div class="card-body">
                    <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('suppliers.index')}}">{{__('lang.suppliers')}}</a>
                </div>
            </div>
        </div>
        <div class="card-deck m-b-30 col-md-2">
            <div class="card p-3">
                <img class="card-img-top" src="{{asset('images/dashboard-icon/settings.png')}}" alt="Card image cap">
                <div class="card-body">
                    <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('settings.all')}}">{{__('lang.settings')}}</a>
                </div>
            </div>
        </div>
        <div class="card-deck m-b-30 col-md-2">
            <div class="card p-3">
                <img class="card-img-top" src="{{asset('images/dashboard-icon/report.png')}}" alt="Card image cap">
                <div class="card-body">
                    <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('reports.all')}}">{{__('lang.reports')}}</a>
                </div>
            </div>
        </div>

        <div class="col-md-1"></div>
    </div>
    <!-- End row -->
</div>
@endsection

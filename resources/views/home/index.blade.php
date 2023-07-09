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
            <div class="card-deck m-b-30 col-md-2">
                <div class="card p-3">
                    <img class="card-img-top" src="{{asset('images/dashboard-icon/dashboard (1).png')}}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title font-18 text-center">{{__('lang.dashboard')}}</h5>
                    </div>
                </div>
            </div>
            <div class="card-deck m-b-30 col-md-2">
                <div class="card p-3">
                    <img class="card-img-top" src="{{asset('images/dashboard-icon/dairy-products.png')}}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title font-18 text-center">{{__('lang.products')}}</h5>
                    </div>
                </div>
            </div>
            <div class="card-deck m-b-30 col-md-2">
                <div class="card p-3">
                    <img class="card-img-top" src="{{asset('images/dashboard-icon/warehouse.png')}}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title font-18 text-center">{{__('lang.stock')}}</h5>
                    </div>
                </div>
            </div>
            <div class="card-deck m-b-30 col-md-2">
                <div class="card p-3">
                    <img class="card-img-top" src="{{asset('images/dashboard-icon/cash-machine.png')}}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title font-18 text-center">{{__('lang.cashier')}}</h5>
                    </div>
                </div>
            </div>
            <div class="card-deck m-b-30 col-md-2">
                <div class="card p-3">
                    <img class="card-img-top" src="{{asset('images/dashboard-icon/return.png')}}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title font-18 text-center">{{__('lang.returns')}}</h5>
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
                    <h5 class="card-title font-18 text-center">{{__('lang.employees')}}</h5>
                </div>
            </div>
        </div>
        <div class="card-deck m-b-30 col-md-2">
            <div class="card p-3">
                <img class="card-img-top" src="{{asset('images/dashboard-icon/customer-satisfaction.png')}}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title font-18 text-center">{{__('lang.customers')}}</h5>
                </div>
            </div>
        </div>
        <div class="card-deck m-b-30 col-md-2">
            <div class="card p-3">
                <img class="card-img-top" src="{{asset('images/dashboard-icon/inventory.png')}}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title font-18 text-center">{{__('lang.suppliers')}}</h5>
                </div>
            </div>
        </div>
        <div class="card-deck m-b-30 col-md-2">
            <div class="card p-3">
                <img class="card-img-top" src="{{asset('images/dashboard-icon/settings.png')}}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title font-18 text-center">{{__('lang.settings')}}</h5>
                </div>
            </div>
        </div>
        <div class="card-deck m-b-30 col-md-2">
            <div class="card p-3">
                <img class="card-img-top" src="{{asset('images/dashboard-icon/report.png')}}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title font-18 text-center">{{__('lang.reports')}}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-1"></div>
    </div>
    <!-- End row -->
</div>
@endsection

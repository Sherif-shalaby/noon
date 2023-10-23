@extends('layouts.app')
@section('title', __('lang.create_customer_price_offer'))
@push('css')
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{ asset('salescreen/css/main.css')}}" />
    @endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.customer_price_offer')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="{{route('customer_price_offer.index')}}">@lang('lang.customer_price_offer')</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                           @lang('lang.create_customer_price_offer')
                        </li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                  <div class="widgetbar">
                    <a type="button" class="btn btn-primary" target="_blank" href="{{route('customer_price_offer.index')}}">@lang('lang.customer_price_offer')</a>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <livewire:customer-price-offer.create />
@endsection
@push('javascripts')
@endpush

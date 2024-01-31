@extends('layouts.app')
@section('title', __('lang.create_customer_price_offer'))
@push('css')
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{ asset('salescreen/css/main.css') }}" />
@endpush

@section('page_title')
    @lang('lang.customer_price_offer')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        <a style="text-decoration: none;color: #596fd7" href="{{ route('customer_price_offer.index') }}">
            / @lang('lang.customer_price_offer')</a>
    </li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('lang.create_customer_price_offer')
    </li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">

        <a type="button" class="btn btn-primary" target="_blank"
            href="{{ route('customer_price_offer.index') }}">@lang('lang.customer_price_offer')</a>
    </div>
@endsection


@section('content')
    <div class="animate-in-page">
        <livewire:customer-price-offer.create />
    </div>
@endsection

@push('javascripts')
@endpush

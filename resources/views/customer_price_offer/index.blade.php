@extends('layouts.app')
@section('title', __('lang.show_customer_price_offer'))


@section('page_title')
    @lang('lang.customer_price_offer')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.customer_price_offer')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        {{-- ++++++++++++++++++++ create purchase_order ++++++++++++ --}}
        <a href="{{ route('customer_price_offer.create') }}" class="btn btn-primary" target="__blank">
            @lang('lang.create_customer_price_offer')
        </a>
    </div>
@endsection

@section('content')
    <livewire:customer-price-offer.index />
@endsection

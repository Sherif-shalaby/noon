@extends('layouts.app')
@section('title', __('lang.edit_customer_price_offer'))

@section('page_title')
    @lang('lang.edit_customer_price_offer')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('lang.edit_customer_price_offer')</li>
@endsection

@section('content')
    <div class="animate-in-page">
        <livewire:customer-price-offer.edit :id="$id" />
    </div>
@endsection

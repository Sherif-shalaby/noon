@extends('layouts.app')
@section('title', __('lang.edit_purchase_order'))
@push('css')
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{ asset('salescreen/css/main.css') }}" />
@endpush

@section('page_title')
    @lang('lang.purchase_order')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
            style="text-decoration: none;color: #596fd7" href="{{ route('stocks.index') }}">/
            @lang('lang.purchase_order')</a></li>
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.edit_purchase_order')</li>
@endsection

@section('button')

    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a type="button" class="btn btn-primary" href="{{ route('purchase_order.index') }}">@lang('lang.stock')</a>
    </div>

@endsection

@section('content')
    {{-- {{dd($id)}} --}}
    @livewire('purchase-order.edit', ['id' => $id])
@endsection
@push('javascripts')
@endpush

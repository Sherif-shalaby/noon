@extends('layouts.app')
@section('title', __('lang.create_purchase_order'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush

@section('page_title')
    @lang('lang.create_purchase_order')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.create_purchase_order')</li>
@endsection

@section('button')
    <div class="widgetbar">
        <a href="{{ route('purchase_order.index') }}" class="btn btn-primary">
            @lang('lang.show_purchase_order')
        </a>
    </div>
@endsection


@section('content')
    <livewire:purchase-order.create />
@endsection

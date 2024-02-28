@extends('layouts.app')
@section('title', __('lang.add_transfer'))
@push('css')
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{ asset('salescreen/css/main.css') }}" />
@endpush

@section('page_title')
    @lang('lang.add_transfer')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
            style="text-decoration: none;color: #596fd7" href=""> @lang('lang.store_transfer')</a>
    </li>

@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a type="button" class="btn btn-primary" href="{{ route('store_transfer.index') }}">@lang('lang.store_transfer')</a>
    </div>
@endsection

@section('content')
    <div class="animate-in-page">
        @livewire('store-transfer.create')
    </div>
@endsection
@push('javascripts')
@endpush

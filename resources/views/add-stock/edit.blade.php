@extends('layouts.app')
@section('title', __('lang.add_stock'))

@push('css')
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{ asset('salescreen/css/main.css') }}" />
@endpush

@section('page_title')
    @lang('lang.stock')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
            style="text-decoration: none;color: #596fd7" href="{{ route('stocks.index') }}">/
            @lang('lang.stock')</a></li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('lang.add-stock')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <div class="widgetbar">
            <a type="button" class="btn btn-primary" href="{{ route('stocks.index') }}">@lang('lang.stock')</a>
        </div>
    </div>
@endsection

@section('content')
    {{--    {{dd($id)}} --}}
    @livewire('add-stock.edit', ['id' => $id])
@endsection
@push('javascripts')
@endpush

@extends('layouts.app')
@section('title', __('lang.add_stock'))
@push('css')
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{ asset('salescreen/css/main.css') }}" />
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.stock')
                </h4>
                <div class="breadcrumb-list">
                    <ul style=" list-style: none;"
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                @lang('lang.dashboard')</a>
                        </li>
                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                            aria-current="page">@lang('lang.add-stock')</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div
                    class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                    <div class="widgetbar">
                        <a type="button" class="btn btn-primary" href="{{ route('stocks.index') }}">@lang('lang.stock')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @livewire('add-stock.create')
@endsection
@push('javascripts')
@endpush

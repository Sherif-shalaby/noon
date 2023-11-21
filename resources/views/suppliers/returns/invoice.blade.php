@extends('layouts.app')
@section('title', __('lang.invoices'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.supplier_returns')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif">
                                / @lang('lang.supplier_returns')</li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.invoices')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    {{--                <div class="widgetbar"> --}}
                    {{--                    <a href="{{ route('suppliers.create') }}" class="btn btn-primary"> --}}
                    {{--                        <i class="fa fa-plus"></i> --}}
                    {{--                        @lang('lang.add_supplier') --}}
                    {{--                    </a> --}}
                    {{--                </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    @livewire('returns.suppliers.invoice')
@endsection

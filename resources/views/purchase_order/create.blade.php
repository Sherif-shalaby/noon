@extends('layouts.app')
@section('title', __('lang.create_purchase_order'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.create_purchase_order')</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            {{-- <li class="breadcrumb-item"><a href="{{route('purchase_order.index')}}">@lang('lang.purchase_order')</a></li> --}}
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.create_purchase_order')</li>
                        </ul>
                    </div>
                </div>
                {{-- +++++++ "show_purchase_order" button +++++++ --}}
                <div
                    class="col-md-4  d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                    <div class="widgetbar">
                        <a href="{{ route('purchase_order.index') }}" class="btn btn-primary">
                            @lang('lang.show_purchase_order')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('content')
    <livewire:purchase-order.create />
@endsection

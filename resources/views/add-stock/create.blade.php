@extends('layouts.app')
@section('title', __('lang.add_stock'))
@push('css')
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{ asset('salescreen/css/main.css') }}" />
@endpush
@section('breadcrumbbar')
    <style>
        /* .select2-selection__rendered {
                width: 100px;
            } */

        .extra_store_accordion .select2-selection__rendered {
            width: 100%;
        }

        .categories_drop_down .select2-container--open {
            left: -85px !important;
            font-size: 12px !important
        }

        .categories_drop_down .select2-selection__rendered {
            font-size: 12px !important;
            display: flex !important
        }

        .store_drop_down .select2-container {
            width: 95% !important
        }

        .form-select {
            height: 100%;
            padding-bottom: 0;
            padding-top: 0;
            background-color: #dedede !important;
            border-radius: 16px;
            border: 2px solid #cececf;
            font-size: 14px;
            font-weight: 500
        }

        .form-select:focus {
            border-color: #cececf !important;
            outline: 0;
            box-shadow: 0 0 0 0 !important;
            background-color: white !important;
        }

        .initial-balance-input {
            border: 2px solid #cececf;
            font-size: 14px;
            font-weight: 500
        }

        .accordion-button:focus {
            border: none !important;
            outline: none !important
        }
    </style>
    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.stock')
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
                        <a type="button" class="btn btn-primary" href="{{ route('stocks.index') }}">@lang('lang.stock')</a>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('content')
        @livewire('add-stock.create')
    </div>
@endsection


@push('javascripts')
@endpush

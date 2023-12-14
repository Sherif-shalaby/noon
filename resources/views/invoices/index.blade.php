@extends('layouts.app')
@section('title', __('lang.sells'))
@section('breadcrumbbar')
    <style>
        @media(max-width:768px) {

            .wrapper1 {
                margin-top: 125px !important
            }
        }
    </style>
    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.sells')
                    </h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.sells')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    {{--                <div class="widgetbar"> --}}
                    {{--                    <a href="{{route('customers.create')}}" class="btn btn-primary"> --}}
                    {{--                    </a> --}}
                    {{--                </div> --}}
                </div>
            </div>
        </div>
    @endsection
    @section('content')
        @livewire('invoices.index')
    </div>

@endsection

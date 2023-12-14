@extends('layouts.app')
@section('title', __('lang.initial_balance'))
@section('breadcrumbbar')
    <style>
        .table-top-head {
            top: 175px;
        }

        .wrapper1 {
            margin-top: 25px;
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 265px !important
            }

            .wrapper1 {
                margin-top: 110px !important;
            }
        }
    </style>
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <div>
                <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.initial_balance')
                </h4>
                <div class="breadcrumb-list">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                href="{{ url('/') }}" style="text-decoration: none;color: #596fd7">
                                @lang('lang.dashboard')</a>
                        </li>
                        {{--                        <li class="breadcrumb-item"><a href="#">@lang('lang.employees')</a></li> --}}
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                            aria-current="page" style="text-decoration: none;color: #596fd7">/ @lang('lang.initial_balance')</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 ">
                <div
                    class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                    <a type="button" class="btn btn-primary"
                        href="{{ route('new-initial-balance.create') }}">@lang('lang.add_initial_balance')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    @livewire('initial-balance.index')
@endsection

@extends('layouts.app')
@section('title', __('lang.initial_balance'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.initial_balance')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.initial_balance')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    {{--                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createBrandModal">--}}
                    {{--                        @lang('lang.add_stock')--}}
                    {{--                    </button>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @livewire('initial-balance.create')
@endsection
@push('javascripts')
@endpush

@extends('layouts.app')
@section('title', __('lang.add_stock'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.stock')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.stock')</li>
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
    @livewire('add-stock.create')
@endsection
@push('javascripts')
@endpush

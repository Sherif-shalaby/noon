@extends('layouts.app')
@section('title', __('lang.products'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.supplier_returns')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item">@lang('lang.supplier_returns')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.products')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
{{--                <div class="widgetbar">--}}
{{--                    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">--}}
{{--                        <i class="fa fa-plus"></i>--}}
{{--                        @lang('lang.add_supplier')--}}
{{--                    </a>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection
@section('content')
    @livewire('returns.suppliers.product')
@endsection

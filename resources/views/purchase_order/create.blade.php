@extends('layouts.app')
@section('title', __('lang.create_purchase_order'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.create_purchase_order')</h4> <br/>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('purchase_order.index')}}">@lang('lang.purchase_order')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.create_purchase_order')</li>
                    </ol>
                </div>
            </div>
            {{-- +++++++ "show_purchase_order" button +++++++ --}}
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('purchase_order.index')}}" class="btn btn-primary">
                        @lang('lang.show_purchase_order')
                      </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <livewire:purchase-order.create />
@endsection

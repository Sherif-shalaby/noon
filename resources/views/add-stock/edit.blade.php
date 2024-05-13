@extends('layouts.app')
@section('title', __('lang.add_stock'))
@push('css')
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{ asset('salescreen/css/main.css')}}" />
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.stock')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('stocks.index')}}">@lang('lang.stock')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.add-stock')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <div class="widgetbar">
                        <a type="button" class="btn btn-primary" href="{{route('stocks.index')}}">@lang('lang.stock')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
   {{-- @dd($id) --}}
    @livewire('add-stock.edit',['id' => $id])
@endsection
@push('javascripts')
@endpush

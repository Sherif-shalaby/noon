@extends('layouts.app')
@section('title', __('site.Sale_Screen'))
@push('css')
        <link rel="stylesheet" href="{{ asset('salescreen/css/normalize.css')}}" />
        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{ asset('salescreen/css/bootstrap.rtl.min.css')}}" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('salescreen/css/all.min.css')}}" />
        <!-- Main Faile Css  -->
        <link rel="stylesheet" href="{{ asset('salescreen/css/main.css')}}" />
        <!-- Font Google -->
{{--        <link rel="preconnect" href="https://fonts.googleapis.com" />--}}
{{--        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />--}}
{{--        <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@500;600;700;800&display=swap" rel="stylesheet"/>--}}
@endpush
{{--@section('breadcrumbbar')--}}
{{--    <div class="breadcrumbbar">--}}
{{--        <div class="row align-items-center">--}}
{{--            <div class="col-md-8 col-lg-8">--}}
{{--                <h4 class="page-title">@lang('sale_screen')</h4>--}}
{{--                <div class="breadcrumb-list">--}}
{{--                    <ol class="breadcrumb">--}}
{{--                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>--}}
{{--                        <li class="breadcrumb-item active" aria-current="page">{{ __('site.Sale_Screen') }}</li>--}}
{{--                    </ol>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
@section('content')
    @livewire('invoices.create')
@endsection
@push('js')
        <script src="{{ asset('salescreen/js/main.js') }}"></script>
        <script src="{{ asset('salescreen/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('salescreen/js/all.min.js') }}"></script>
@endpush

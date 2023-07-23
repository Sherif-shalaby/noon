@extends('layouts.app')
@section('title', __('sale_screen'))
@push('css')
        <link rel="stylesheet" href="{{ asset('salescreen/css/normalize.css')}}" />
        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{ asset('salescreen/css/bootstrap.rtl.min.css')}}" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('salescreen/css/all.min.css')}}" />
        <!-- Main Faile Css  -->
        <link rel="stylesheet" href="{{ asset('salescreen/css/main.css')}}" />
        <!-- Font Google -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@500;600;700;800&display=swap"
            rel="stylesheet"
        />
        <style>
            .row-gap-24 {
                row-gap: 24px;
            }

            .box-white {
                background-color: white;
                border: 1px solid #ddd;
                padding: 0.5rem 1rem;
            }

            .w-fit {
                width: -webkit-fit-content;
                width: -moz-fit-content;
                width: fit-content;
            }

            .box-price {
                background-color: #000000;
                color: #0FBD17;
                padding: 5px 1rem;
                font-weight: bold;
                font-size: 65px;
            }

            .width-btns .btn {
                min-width: 140px;
            }

            .inp-num-small {
                width: 100px !important;
                padding: 0 5px !important;
                height: auto !important;
            }

            .box-grey {
                background-color: #BBB9BA;
                padding: 5px 10px;
                border: 1px solid #A8AAA7;
                border-radius: 3px;
                height: 30px;
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
            }

            .box-grey-2 {
                background-color: #d6d3d6;
                padding: 5px 10px;
                border: 1px solid #A8AAA7;
                border-radius: 3px;
                height: 30px;
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                font-size: 20px;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
                color: #66676b;
            }

            .w-60px {
                width: 60px !important;
            }
        </style>
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('sale_screen')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('sale_screen')</li>
                    </ol>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('content')
    {{-- <livewire:invoices.create /> --}}
    @livewire('invoices.create')
@endsection
@push('js')
        <script src="{{ asset('salescreen/js/main.js') }}"></script>
        <script src="{{ asset('salescreen/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('salescreen/js/all.min.js') }}"></script>
@endpush

@extends('layouts.app')
@section('title', __('lang.sells'))
@section('breadcrumbbar')
    <style>
        .selectBox {
            position: relative;
        }

        /* selectbox style */
        .selectBox select {
            width: 100%;
            padding: 0 !important;
            padding-left: 4px;
            padding-right: 4px;
            color: #000;
            border: 1px solid #ccc;
            background-color: #dadada;
            /* height: 39px !important; */
        }

        .overSelect {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }

        #checkboxes {
            display: none;
            border: 1px #dadada solid;
            height: 125px;
            overflow: auto;
            padding-top: 10px;
            background-color: white
                /* text-align: end;  */
        }

        #checkboxes label {
            display: block;
            padding: 5px;
        }

        #checkboxes label:hover {
            background-color: #ddd;
        }

        #checkboxes label span {
            font-weight: normal;
        }

        .table-top-head {
            top: 265px !important;
        }

        .table-scroll-wrapper {
            width: fit-content;
        }

        @media(min-width:1900px) {
            .table-scroll-wrapper {
                width: 100%;
            }
        }



        @media(max-width:991px) {
            .table-top-head {
                top: 265px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 615px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 630px !important
            }
        }

        @media(max-width:575px) {
            .table-top-head {
                top: 625px !important
            }
        }

        .wrapper1 {
            margin-top: 35px;
        }

        .input-wrapper {
            width: 100% !important;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 128px;
            }

            .input-wrapper {
                width: 60%
            }
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

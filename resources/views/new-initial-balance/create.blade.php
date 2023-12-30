@extends('layouts.app')
@section('title', __('lang.initial_balance'))
@section('breadcrumbbar')
    <style>
        .select2-selection__rendered {
            width: 100px;
        }

        .extra_store_accordion .select2-selection__rendered {
            width: 100%;
        }

        .form-select {
            padding: 0 !important;
            background-color: transparent;
        }

        .select2 {
            background: transparent;
            width: 100%;
        }

        .plus-button,
        .plus-button-x {
            /* width: fit-content !important; */
            background-color: #596fd7 !important;
            color: white !important;
            outline: none;
            border-radius: 6px !important;
            cursor: pointer;
            border: 2px solid #596fd7;
            transition: 0.4s;
            box-shadow: 0 0 0 0 !important;
            min-width: 38px;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .del-button {
            /* width: fit-content !important; */
            background-color: #dc3545 !important;
            color: white !important;
            outline: none;
            border-radius: 6px !important;
            cursor: pointer;
            border: 2px solid #dc3545;
            transition: 0.4s;
            box-shadow: 0 0 0 0 !important;
            min-width: 38px;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .plus-button i {
            font-size: 14px
        }

        .plus-button:hover {
            box-shadow: 2px 2px 3px 1px #7489e8 !important;
        }

        .del-button i {
            font-size: 14px
        }

        .del-button:hover {
            box-shadow: 2px 2px 3px 1px #dc3545 !important;
        }

        .plus-button-x i {
            font-size: 14px
        }

        .plus-button-x:hover {
            box-shadow: 2px 2px 3px 1px #7489e8 !important;
        }

        .accordion-button,
        .accordion-button-down {
            padding: 6px !important;
            /* width: fit-content !important; */
            background-color: #596fd7 !important;
            color: white !important;
            outline: none;
            border-radius: 6px !important;
            cursor: pointer;
            border: 2px solid #596fd7;
            justify-content: space-between;
            transition: 0.4s;
            box-shadow: 0 0 0 0 !important;
            min-width: 38px;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .accordion-button i {
            font-size: 14px
        }

        .accordion-button:hover {
            box-shadow: 2px 2px 3px 1px #7489e8 !important;
        }

        .accordion-button-down i {
            font-size: 14px
        }

        .accordion-button-down:hover {
            box-shadow: 2px 2px 3px 1px #7489e8 !important;
        }


        @keyframes bounceToLeft {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-10px);
            }

            50% {
                transform: translateX(0);
            }

            75% {
                transform: translateX(-5px);
            }

            100% {
                transform: translateX(0);
            }
        }

        @keyframes bounceUpDown {
            0% {
                transform: translateY(0);
            }

            25% {
                transform: translateY(-10px);
            }

            50% {
                transform: translateY(0);
            }

            75% {
                transform: translateY(-5px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .accordion-button:hover i {
            animation: bounceToLeft 0.5s ease-in-out;
        }

        .accordion-button i {
            transition: 0.4s;
        }

        .plus-button-x:hover i {
            animation: bounceToLeft 0.5s ease-in-out;
        }

        .plus-button-x i {
            transition: 0.4s;
        }

        .accordion-button-down:hover i {
            animation: bounceUpDown 0.5s ease-in-out;
        }

        .accordion-button-down i {
            transition: 0.4s;
        }

        .plus-button:hover i {
            animation: bounceUpDown 0.5s ease-in-out;
        }

        .plus-button i {
            transition: 0.4s;
        }

        .del-button:hover i {
            animation: bounceUpDown 0.5s ease-in-out;
        }

        .del-button i {
            transition: 0.4s;
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
    <div class="animate-in-page relative">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="animate__animated  animate__backInRight">
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.initial_balance')</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7"
                                    href="{{ route('initial-balance.index') }}">/ @lang('lang.initial_balance')</a>
                            </li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.add_initial_balance')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <a type="button" class="btn btn-primary"
                            href="{{ route('initial-balance.index') }}">@lang('lang.initial_balance')</a>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('content')
        <div class="animate-in-page">
            @livewire('new-initial-balance.create')
        </div>

    @endsection
    @push('javascripts')
        <script></script>
    @endpush

@extends('layouts.app')
@section('title', __('lang.product_damage'))
@section('breadcrumbbar')
    <style>
        .table-top-head {
            top: 20px !important;
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
                top: 20px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 20px !important
            }
        }

        @media(max-width:575px) {
            .table-top-head {
                top: 20px !important
            }
        }

        .wrapper1 {
            margin-top: 35px;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 115px;
            }
        }
    </style>
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif"></h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ route('products.index') }}">
                                    @lang('lang.products')</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('content')
        <div class="contentbar">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                        </div>
                        @livewire('product-options.remove-damage', ['productId' => $id])
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>

    @endsection

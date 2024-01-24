@extends('layouts.app')
@section('title', __('lang.brands'))
@section('breadcrumbbar')
    <style>
        .table-top-head {
            top: 32px;
        }

        .rightbar {
            z-index: 2;
        }

        .wrapper1 {
            margin-top: 30px;
        }

        @media(max-width:768px) {
            .wrapper1 {
                margin-top: 140px
            }
        }
    </style>
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.brands')
                    </h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a>
                            </li>
                            {{-- <li class="breadcrumb-item"><a href="#">Brands</a></li> --}}
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.brands')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createBrandModal">
                            @lang('lang.add_brand_name')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('brands.create')
@endsection
@section('content')
    <div class="animate-in-page">

        <!-- End Breadcrumbbar -->
        <!-- Start Contentbar -->
        <div class="contentbar">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h6 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.brands')</h5>
                        </div>
                        <div class="card-body">
                            {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2 table-scroll-wrapper">
                                    <!-- content goes here -->
                                    <div style="min-width:1300px;max-height: 90vh;overflow: auto">
                                        <table id="datatable-buttons" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('lang.brand_name')</th>
                                                    <th>@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($brands as $index => $brand)
                                                    <tr>
                                                        <td style="font-size: 12px;font-weight: 600">

                                                            {{ $index + 1 }}</td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.brand_name')">
                                                                {{ $brand->name }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button"
                                                                    class="btn btn-default btn-sm dropdown-toggle"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">خيارات <span
                                                                        class="caret"></span>
                                                                    <span class="sr-only">Toggle Dropdown</span>
                                                                </button>
                                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                    user="menu" x-placement="bottom-end"
                                                                    style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                    <li>

                                                                        <a data-href="{{ route('brands.edit', $brand->id) }}"
                                                                            data-container=".view_modal"
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"
                                                                            data-toggle="modal"><i
                                                                                class="dripicons-document-edit"></i>
                                                                            @lang('lang.update')</a>

                                                                    </li>
                                                                    <li>
                                                                        <a data-href="{{ route('brands.destroy', $brand->id) }}"
                                                                            {{-- data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}" --}}
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif text-red delete_item"><i
                                                                                class="fa fa-trash"></i>
                                                                            @lang('lang.delete')</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    {{-- @include('brands.edit',$brand) --}}
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="view_modal no-print">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
        <!-- End Contentbar -->
    </div>
    <!-- End Rightbar -->
@endsection

@extends('layouts.app')
@section('title', __('lang.product_damage'))
@section('breadcrumbbar')
    <style>
        th {
            padding: 10px 25px !important;
            font-weight: 700 !important;
            font-size: 11px !important;
            width: fit-content !important;
            text-align: center;
            border: 1px solid white !important;
            color: #fff !important;
            background-color: #596fd7 !important;
            text-transform: uppercase;
        }

        .table-top-head {
            top: 35px !important;
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
                top: 35px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 35px !important
            }
        }

        @media(max-width:575px) {
            .table-top-head {
                top: 35px !important
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
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.stock')</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ route('products.index') }}">/
                                    @lang('lang.products')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.product_damage')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <a type="button" class="btn btn-primary"
                            href="{{ $status == 'damage' ? route('getDamageProduct', ['id' => $id]) : route('addConvolution', ['id' => $id]) }}">{{ $status == 'damage' ? __('lang.remove_damage') : __('lang.remove_expiry') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">

        <!-- Start Contentbar -->
        <div class="contentbar mb-0 pb-0">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h6 class="card-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.product_damage')</h6>
                        </div>
                        <div class="card-body">
                            {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2 table-scroll-wrapper">
                                    <!-- content goes here -->
                                    <div style="min-width: 1300px;max-height: 90vh;overflow: auto">
                                        <table id="datatable-buttons" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>@lang('lang.image')</th>
                                                    <th>@lang('lang.name')</th>
                                                    <th>@lang('lang.product_code')</th>
                                                    <th>@lang('lang.quantity_of_expired_stock_removed')</th>
                                                    <th>@lang('lang.value_of_the_removed_stocks')</th>
                                                    <th>@lang('lang.date_of_the_removal')</th>
                                                    <th>@lang('lang.date_of_purchase_of_the_expired_stock_removed')</th>
                                                    <th>@lang('lang.deleted_by')</th>
                                                    <th>@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @isset($product_damages)
                                                    @foreach ($product_damages as $product_expiry)
                                                        <tr>
                                                            <td>
                                                                @if (!empty($product_expiry->product->image))
                                                                    <img src="{{ $product_expiry->product->image }}"
                                                                        height="50px" width="50px">
                                                                @else
                                                                    <img src="{{ asset('/uploads/' . session('logo')) }}"
                                                                        height="50px" width="50px">
                                                                @endif
                                                            </td>
                                                            <td>{{ $product_expiry->product->name ?? '' }}</td>
                                                            <td>{{ $product_expiry->variation->sku ?? '' }}</td>
                                                            <td>{{ $product_expiry->quantity_of_expired_stock_removed }}</td>
                                                            <td>{{ $product_expiry->value_of_removed_stocks }}</td>
                                                            <td>{{ $product_expiry->created_at }}</td>
                                                            <td>{{ $product_expiry->date_of_purchase_of_expired_stock_removed }}
                                                            </td>
                                                            <td>{{ $product_expiry->addedBy->name }}</td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                        class="btn btn-default btn-sm dropdown-toggle"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">@lang('lang.action')
                                                                        <span class="caret"></span>
                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                    </button>
                                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                        user="menu">
                                                                        {{-- @can('adjustment.customer_balance_adjustment.delete') --}}
                                                                        <li>
                                                                            <a data-href="{{ route('deleteExpiryRow', $product_expiry->id) }}"
                                                                                class="btn text-red delete_item"><i
                                                                                    class="fa fa-trash"></i>
                                                                                @lang('lang.delete')</a>
                                                                        </li>
                                                                        {{-- @endcan --}}
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endisset
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
    </div>
    <!-- End Contentbar -->
@endsection

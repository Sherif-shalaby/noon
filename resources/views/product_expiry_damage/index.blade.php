@extends('layouts.app')
@section('title', __('lang.product_damage'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.stock')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">@lang('lang.products')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.product_damage')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a type="button" class="btn btn-primary"
                        href="{{ route('getDamageProduct', ['id' => $id]) }}">@lang('lang.remove_damage')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.product_damage')</h5>
                    </div>
                    <div class="card-body">
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
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
                                                    @if (!empty($product_expiry->product->getFirstMediaUrl('product')))
                                                        <img src="{{ $product_expiry->product->getFirstMediaUrl('product') }}"
                                                            height="50px" width="50px">
                                                    @else
                                                        <img src="{{ asset('/uploads/' . session('logo')) }}" height="50px"
                                                            width="50px">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($product_expiry->variation->name != 'Default')
                                                        {{ $product_expiry->variation->name }}
                                                    @else
                                                        {{ $product_expiry->product->name }}
                                                    @endif
                                                </td>
                                                <td>{{ $product_expiry->variation->sub_sku }}</td>

                                                <td>{{ $product_expiry->quantity_of_expired_stock_removed }}</td>
                                                <td>{{ $product_expiry->value_of_removed_stocks }}</td>
                                                <td>{{ $product_expiry->created_at }}</td>
                                                <td> {{ $product_expiry->date_of_purchase_of_expired_stock_removed }} </td>
                                                <td>{{ $product_expiry->addedBy->name }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">@lang('lang.action')
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu">
                                                            @can('adjustment.customer_balance_adjustment.delete')
                                                                <li>
                                                                    <a data-href="{{ action('ProductController@deleteExpiryRow', $product_expiry->id) }}"
                                                                        data-check_password="{{ action('UserController@checkPassword', Auth::user()->id) }}"
                                                                        class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                                        @lang('lang.delete')</a>
                                                                </li>
                                                            @endcan
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
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
@endsection

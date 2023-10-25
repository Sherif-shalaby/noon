@extends('layouts.app')
@section('title', __('lang.product_damage'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title"></h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">@lang('lang.products')</a></li>
                    </ol>
                </div>
            </div>
            {{--            <div class="col-md-4 col-lg-4"> --}}
            {{--                <div class="widgetbar"> --}}
            {{--                    <a type="button" class="btn btn-primary" href="{{route('getDamageProduct',["id"=> $id ])}}">@lang('lang.remove_damage')</a> --}}
            {{--                </div> --}}
            {{--            </div> --}}
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
                        {{--                    <h5 class="card-title">@lang('lang.product_damage')</h5> --}}
                    </div>
                    <div class="card-body">
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>@lang('lang.image')</th>
                                        <th style="">@lang('lang.name')</th>
                                        <th>@lang('lang.product_code')</th>
                                        <th class="sum">@lang('lang.current_stock')</th>
                                        <th>@lang('lang.quantity_to_be_removed')</th>
                                        <th>@lang('lang.date_of_expired_stock')</th>
                                        <th>@lang('lang.date_of_purchase_of_the_expired_stock')</th>
                                        <th>@lang('lang.avg_purchase_price')</th>
                                        <th>@lang('lang.value_of_removed_stock')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="view_modal no-print">
                            </div>
                        </div>
                        <button style="margin-left: 25px" data-check_password=""
                            class="btn btn-primary check_pass">Save</button>
                        <a style="margin-left: 25px" id="cancel_btn" class="btn btn-danger text-white ">Cancel</a>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>

@endsection

@extends('layouts.app')
@section('title', __('lang.product_tax'))

@push('css')
    <style>
        .table-top-head {
            top: 32px;
        }

        .rightbar {
            z-index: 2;
        }

        .wrapper1 {
            margin-top: 35px;
        }

        @media(max-width:768px) {
            .wrapper1 {
                margin-top: 140px
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.product_tax')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif ">
        <a style="text-decoration: none;color: #596fd7" href="">/ @lang('lang.settings')</a>
    </li>
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('lang.product_tax')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a data-href="{{ route('general-tax.create') }}" data-container=".view_modal"
            class="btn btn-modal btn-primary text-white" data-toggle="modal">
            @lang('lang.add_general_tax')
        </a>
    </div>
@endsection

@section('content')
    <div class="animate-in-page">

        <!-- Start Contentbar -->
        <div class="contentbar">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h6 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.product_tax')</h6>
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
                                                    <th>@lang('lang.tax_name')</th>
                                                    <th>@lang('lang.tax_rate')</th>
                                                    {{-- <th>@lang('lang.tax_method')</th>  --}}
                                                    <th>@lang('lang.tax_details')</th>
                                                    <th>@lang('lang.tax_status')</th>
                                                    {{-- <th>@lang('lang.products')</th> --}}
                                                    <th class="notexport">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($product_taxes as $product_tax)
                                                    <tr>
                                                        <td>{{ $product_tax->id }}</td>
                                                        <td>{{ $product_tax->name ?? '' }}</td>
                                                        <td>{{ $product_tax->rate }}</td>
                                                        {{-- <td>{{$product_tax->method}}</td>  --}}
                                                        <td>{{ $product_tax->details }}</td>
                                                        <td>{{ $product_tax->status }}</td>
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
                                                                    {{-- ++++++++++++ Edit Button ++++++++++++  --}}
                                                                    <li>
                                                                        <a data-href="{{ route('product-tax.edit', $product_tax->id) }}"
                                                                            data-container=".view_modal"
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"><i
                                                                                class="dripicons-document-edit"></i>
                                                                            @lang('lang.edit')</a>
                                                                    </li>
                                                                    {{-- ++++++++++++ destroy Button ++++++++++++  --}}
                                                                    <li>
                                                                        <a data-href="{{ route('product-tax.destroy', $product_tax->id) }}"
                                                                            data-check_password=""
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif text-red delete_item">
                                                                            <i class="fa fa-trash"></i>@lang('lang.delete')
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End Contentbar -->
        </div>
    </div>
@endsection
<div class="view_modal no-print"></div>

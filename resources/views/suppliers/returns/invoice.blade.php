@extends('layouts.app')
@section('title', __('lang.invoices'))


@push('css')
    <style>
        .table-top-head {
            top: 35px;
        }

        .wrapper1 {
            margin-top: 35px;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 120px;
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.supplier_returns')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif">
        / @lang('lang.supplier_returns')</li>
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.invoices')</li>
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
                                @lang('lang.products')</h6>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    {{--                                @include('add-stock.partials.filters') --}}
                                </div>
                            </div>
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
                                        {{-- +++++++++++++++++++++++++++ Table +++++++++++++++++++++++++++ --}}
                                        <table id="datatable-buttons"
                                            class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>@lang('lang.po_ref_no')</th>
                                                    <th>@lang('lang.invoice_no')</th>
                                                    <th>@lang('lang.date_and_time')</th>
                                                    <th>@lang('lang.invoice_date')</th>
                                                    <th>@lang('lang.supplier')</th>
                                                    <th>@lang('lang.products')</th>
                                                    <th>@lang('lang.created_by')</th>
                                                    <th class="notexport">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($stocks as $index => $stock)
                                                    <tr>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.po_ref_no')">

                                                                {{ $stock->po_no ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.invoice_no')">

                                                                {{ $stock->invoice_no ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.date_and_time')">

                                                                {{ $stock->created_at }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.invoice_date')">

                                                                {{ $stock->transaction_date }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.supplier')">

                                                                {{ $stock->supplier->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.products')">

                                                                @if (!empty($stock->add_stock_lines))
                                                                    @foreach ($stock->add_stock_lines as $stock_line)
                                                                        {{ $stock_line->product->name ?? '' }}<br>
                                                                    @endforeach
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.created_by')">
                                                                {{ $stock->created_by_relationship->first()->name }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-default btn-sm dropdown-toggle"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                @lang('lang.action')
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                user="menu">
                                                                <li>
                                                                    <a href="{{ route('stocks.show', $stock->id) }}"
                                                                        class="btn  drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                            class="fa fa-eye"></i>
                                                                        @lang('lang.view') </a>
                                                                </li>
                                                                {{--                                            <li class="divider"></li> --}}
                                                            </ul>
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
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
@endsection

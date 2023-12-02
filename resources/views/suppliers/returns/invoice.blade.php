@extends('layouts.app')
@section('title', __('lang.invoices'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.supplier_returns')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif">
                                / @lang('lang.supplier_returns')</li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.invoices')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">

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
                        <h5 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            @lang('lang.products')</h5>
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
                        <div class="table-responsive  @if (app()->isLocale('ar')) dir-rtl @endif"
                            style="height: 90vh;overflow: scroll">
                            {{-- +++++++++++++++++++++++++++ Table +++++++++++++++++++++++++++ --}}
                            <table id="datatable-buttons"
                                class="table table-striped table-bordered table-hover table-button-wrapper">
                                <thead>
                                    <tr>
                                        <th>@lang('lang.po_ref_no')</th>
                                        <th>@lang('lang.invoice_no')</th>
                                        <th>@lang('lang.date_and_time')</th>
                                        <th>@lang('lang.invoice_date')</th>
                                        <th>@lang('lang.supplier')</th>
                                        <th>@lang('lang.products')</th>
                                        <th>@lang('lang.created_by')</th>
                                        <th>@lang('lang.return_invoice')</th>
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
                                                <button type="button" style="font-size: 12px;font-weight: 600"
                                                    class="btn btn-default btn-sm" data-toggle="modal"
                                                    data-target="#paymentModal">
                                                    @lang('lang.return_invoice')
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                    style="font-size: 12px;font-weight: 600" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
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
            <!-- End col -->
        </div>
        <!-- End row -->
        @include('suppliers.returns.partials.payment')
    </div>
    <!-- End Contentbar -->
@endsection

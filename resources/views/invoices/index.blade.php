@extends('layouts.app')
@section('title', __('lang.sells'))
@section('breadcrumbbar')

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
        <!-- Start Contentbar -->
        <div class="contentbar">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.sells')</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="container-fluid">
                                        {{-- @include('customers.filters') --}}
                                    </div>
                                </div>
                            </div>
                            {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}

                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2">
                                    <!-- content goes here -->
                                    <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif"
                                        style="width: 1750px">
                                        <table id="datatable-buttons" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>@lang('lang.date_and_time')</th>
                                                    <th>@lang('lang.reference')</th>
                                                    <th>@lang('lang.store')</th>
                                                    <th>@lang('lang.customer')</th>
                                                    <th>@lang('lang.phone')</th>
                                                    <th>@lang('lang.sale_status')</th>
                                                    <th>@lang('lang.payment_status')</th>
                                                    <th>@lang('lang.payment_type')</th>
                                                    <th>@lang('lang.ref_number')</th>
                                                    <th class="currencies">@lang('lang.received_currency')</th>
                                                    <th class="sum">@lang('lang.grand_total')</th>
                                                    <th class="sum">@lang('lang.paid')</th>
                                                    <th class="sum">@lang('lang.due_sale_list')</th>
                                                    <th>@lang('lang.payment_date')</th>
                                                    <th>@lang('lang.cashier_man')</th>
                                                    <th>@lang('lang.commission')</th>
                                                    <th>@lang('lang.products')</th>
                                                    <th>@lang('lang.sale_note')</th>
                                                    <th>@lang('lang.files')</th>
                                                    <th class="notexport">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sell_lines as $index => $line)
                                                    <tr>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.date_and_time')">
                                                                {{ $line->transaction_date ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.reference')">
                                                                {{ $line->invoice_no ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.store')">
                                                                {{ $line->store->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.customer')">
                                                                {{ $line->customer->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.phone')">
                                                                {{ $line->customer->phone ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-success custom-tooltip"
                                                                data-tooltip="@lang('lang.sale_status')">{{ $line->status ?? '' }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.payment_status')">
                                                                {{ $line->payment_status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @foreach ($line->transaction_payments as $payment)
                                                                <span class="custom-tooltip"
                                                                    data-tooltip="@lang('lang.payment_type')">
                                                                    {{ __('lang.' . $payment->method) }}<br>
                                                                </span>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ($line->transaction_payments as $payment)
                                                                <span class="custom-tooltip"
                                                                    data-tooltip="@lang('lang.ref_number')">
                                                                    {{ $payment->ref_no ?? '' }}<br>
                                                                </span>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ($line->transaction_payments as $payment)
                                                                <span class="custom-tooltip"
                                                                    data-tooltip="@lang('lang.received_currency')">
                                                                    {{ $payment->received_currency_relation->symbol ?? '' }}<br>
                                                                </span>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.grand_total')">
                                                                {{ number_format($line->final_total, 2) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.paid')">
                                                                {{ $line->transaction_payments->sum('amount') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.due_sale_list')">
                                                                {{ $line->final_total - $line->transaction_payments->sum('amount') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip="@lang('lang.payment_date')">
                                                                {{ $line->transaction_payments->last()->paid_on ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="custom-tooltip" data-tooltip=">@lang('lang.cashier_man')">
                                                                {{ $line->created_by_user->name }}
                                                            </span>
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            @foreach ($line->transaction_sell_lines as $sell_line)
                                                                @if (!empty($sell_line->product))
                                                                    <span class="custom-tooltip"
                                                                        data-tooltip="@lang('lang.products')">
                                                                        {{ $sell_line->product->name ?? ' ' }} -
                                                                        {{ $sell_line->product->sku ?? ' ' }}<br>
                                                                    </span>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ($line->transaction_payments as $payment)
                                                                <span class="custom-tooltip"
                                                                    data-tooltip="@lang('lang.sale_note')">
                                                                    {{ $payment->received_currency_relation->payment_note ?? '' }}<br>
                                                                </span>
                                                            @endforeach
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-default btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                @lang('lang.action')
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                user="menu">
                                                                <li>
                                                                    <a href="{{ route('sell.return', $line->id) }}"
                                                                        class="btn"><i
                                                                            class="fa fa-undo"></i>@lang('lang.return')
                                                                    </a>
                                                                </li>
                                                                <li class="divider"></li>
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
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
        <!-- End Contentbar -->
    </div>

@endsection

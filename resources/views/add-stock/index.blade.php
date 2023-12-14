@extends('layouts.app')
@section('title', __('lang.stock'))
@section('breadcrumbbar')
    <style>
        .table-top-head {
            top: 315px;
        }
    </style>
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.stock')
                </h4>
                <div class="breadcrumb-list">
                    <ul
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                @lang('lang.dashboard')</a>
                        </li>
                        {{--                        <li class="breadcrumb-item"><a href="#">@lang('lang.employees')</a></li> --}}
                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                            aria-current="page">@lang('lang.stock')</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div
                    class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                    <a type="button" class="btn btn-primary" href="{{ route('stocks.create') }}">@lang('lang.add-stock')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    {{-- @livewire('add-stock.add-payment') --}}
    <section class="">
        <div class="col-md-22">
            <div class="card mt-3 mb-0">
                <div
                    class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                    <h3 class="print-title">@lang('lang.stock')</h3>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="container-fluid">
                            @include('add-stock.partials.filters')
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif" style="margin-top:25px ">
                        <div class="div1"></div>
                    </div>
                    <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                        <div class="div2 table-scroll-wrapper">
                            <!-- content goes here -->
                            <div style="min-width: 1300px;max-height: 90vh;overflow: auto;">

                                <table id="datatable-buttons" class="table table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <th>@lang('lang.po_ref_no')</th>
                                            <th>@lang('lang.invoice_no')</th>
                                            <th>@lang('lang.date_and_time')</th>
                                            <th>@lang('lang.invoice_date')</th>
                                            <th>@lang('lang.supplier')</th>
                                            <th>@lang('lang.products')</th>
                                            <th>@lang('lang.created_by')</th>
                                            <th class="sum">@lang('lang.value')</th>
                                            <th class="sum">@lang('lang.paid_amount')</th>
                                            <th class="sum">@lang('lang.pending_amount')</th>
                                            <th>@lang('lang.due_date')</th>
                                            <th>@lang('lang.notes')</th>
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
                                                    @if (!empty($stock->add_stock_lines))
                                                        @foreach ($stock->add_stock_lines as $stock_line)
                                                            <span class="custom-tooltip"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.products')">

                                                                {{ $stock_line->product->name ?? '' }} <br>
                                                            </span>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.created_by')">
                                                        {{ $stock->created_by_relationship->first()->name }}
                                                    </span>
                                                </td>
                                                @if ($stock->transaction_currency == 2)
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.value')">
                                                            {{ @num_format($stock->dollar_final_total) }}
                                                        </span>
                                                    </td>
                                                @else
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.value')">
                                                            {{ @num_format($stock->final_total) }}
                                                        </span>
                                                    </td>
                                                @endif
                                                @php
                                                    $final_total = 0;
                                                    $paid = 0;
                                                    $payments = $stock->transaction_payments;
                                                    if ($stock->transaction_currency == 2) {
                                                        $final_total = $stock->dollar_final_total;
                                                        foreach ($payments as $payment) {
                                                            if ($payment->paying_currency == 2) {
                                                                $paid += $payment->amount;
                                                            } else {
                                                                $paid += $payment->amount / $payment->exchange_rate;
                                                            }
                                                        }
                                                    } else {
                                                        $final_total = $stock->final_total;
                                                        foreach ($payments as $payment) {
                                                            if ($payment->paying_currency == 2) {
                                                                $paid += $payment->amount * $payment->exchange_rate;
                                                            } else {
                                                                $paid += $payment->amount;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.paid_amount')">
                                                        {{ @num_format($paid) }}
                                                    </span>
                                                </td>
                                                @php
                                                    $final_total = 0;
                                                    $pending = 0;
                                                    $amount = 0;
                                                    $payments = $stock->transaction_payments;
                                                    if ($stock->transaction_currency == 2) {
                                                        $final_total = $stock->dollar_final_total;
                                                        foreach ($payments as $payment) {
                                                            if ($payment->paying_currency == 2) {
                                                                $amount += $payment->amount;
                                                                $pending = $final_total - $amount;
                                                            } else {
                                                                $amount += $payment->amount / $payment->exchange_rate;
                                                                $pending = $final_total - $amount;
                                                            }
                                                        }
                                                    } else {
                                                        $final_total = $stock->final_total;
                                                        foreach ($payments as $payment) {
                                                            if ($payment->paying_currency == 2) {
                                                                $amount += $payment->amount * $payment->exchange_rate;
                                                                $pending = $final_total - $amount;
                                                            } else {
                                                                $amount += $payment->amount;
                                                                $pending = $final_total - $amount;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.pending_amount')">
                                                        {{ @num_format($pending) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.due_date')">
                                                        {{ $stock->due_date ?? '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.notes')">
                                                        {{ $stock->notes ?? '' }}
                                                    </span>
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
                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                    class="fa fa-eye"></i>
                                                                @lang('lang.view') </a>
                                                        </li>

                                                        <li>
                                                            <a href="{{ route('stocks.edit', $stock->id) }}"
                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                    class="fa fa-edit"></i>
                                                                @lang('lang.edit') </a>
                                                        </li>

                                                        <li>
                                                            <a data-href="{{ route('stocks.delete', $stock->id) }}"
                                                                {{-- data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}" --}}
                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif text-red delete_item"><i
                                                                    class="fa fa-trash"></i>
                                                                @lang('lang.delete')</a>
                                                        </li>
                                                        @if ($stock->payment_status != 'paid')
                                                            <li>
                                                                <a data-href="{{ route('stocks.addPayment', $stock->id) }}"
                                                                    data-container=".view_modal"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal">
                                                                    <i class="fa fa-money"></i>
                                                                    @lang('lang.pay')
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- add Payment Modal -->
        {{--    @include('add-stock.partials.add-payment') --}}

    </section>
    <div class="view_modal no-print"></div>
    @push('javascripts')
        <script>
            window.addEventListener('openAddPaymentModal', event => {
                $("#addPayment").modal('show');
            })
            window.addEventListener('closeAddPaymentModal', event => {
                $("#addPayment").modal('hide');
            })
        </script>
    @endpush
@endsection

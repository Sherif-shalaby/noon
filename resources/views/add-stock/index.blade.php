@extends('layouts.app')
@section('title', __('lang.stock'))
@push('css')
    <style>
        .table-top-head {
            top: 262px !important;
        }

        .table-scroll-wrapper {
            width: fit-content !important;
        }

        @media(min-width:1900px) {
            .table-scroll-wrapper {
                width: 100% !important;
            }
        }

        @media(max-width:991px) {
            .table-top-head {
                top: 262px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 620px !important
            }
        }

        @media(max-width:575px) {
            .table-top-head {
                top: 620px !important
            }
        }

        .wrapper1 {
            margin-top: 15px;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 95px;
            }
        }

        .select2-selection__rendered {
            display: flex !important;
        }

        .select2-selection__rendered li {
            display: block !important;
        }

        .select2-selection__choice {
            color: black !important;
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.stock')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.stock')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a type="button" class="btn btn-primary" href="{{ route('stocks.create') }}">@lang('lang.add-stock')</a>
    </div>
@endsection

@section('content')
    {{-- @livewire('add-stock.add-payment') --}}
    <section class="">
        <div class="col-md-12">
            <div class="card mb-0">
                <div
                    class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                    <h6 class="print-title">@lang('lang.stock')</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="container-fluid">
                                @include('add-stock.partials.filters')
                            </div>
                        </div>
                    </div>

                    <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                        <div class="div1"></div>
                    </div>
                    <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                        <div class="div2 table-scroll-wrapper">
                            <!-- content goes here -->
                            <div style="min-width: 1800px;max-height: 90vh;overflow: auto;">
                                {{--  --}}
                                <table id="datatable-buttons" class="table table-hover dataTable">
                                    <thead>
                                        <tr
                                            style="position: sticky;
                                                        top: 0;
                                                        z-index: 1000;">
                                            <th class="col1">@lang('lang.po_ref_no')</th>
                                            <th class="col2">@lang('lang.invoice_no')</th>
                                            <th class="col3">@lang('lang.date_and_time')</th>
                                            <th class="col4">@lang('lang.invoice_date')</th>
                                            <th class="col5">@lang('lang.supplier')</th>
                                            <th class="col6">@lang('lang.products')</th>
                                            <th class="col7">@lang('lang.created_by')</th>
                                            <th class="sum col8">@lang('lang.value')</th>
                                            <th class="sum col9">@lang('lang.paid_amount')</th>
                                            <th class="sum col10">@lang('lang.pending_amount')</th>
                                            <th class="col11">@lang('lang.due_date')</th>
                                            <th class="col12">@lang('lang.invoice_discount')</th>
                                            <th class="dollar-cell col13">@lang('lang.product_discount')</th>
                                            <th class="dollar-cell col14">@lang('lang.product_discount_percent')</th>
                                            <th class="dollar-cell col15">@lang('lang.cash_discount')</th>
                                            <th class="dollar-cell col16">@lang('lang.seasonal_discount')</th>
                                            <th class="dollar-cell col17">@lang('lang.annual_discount')</th>
                                            <th class="col18">@lang('lang.notes')</th>
                                            <th class="notexport col19">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stocks as $index => $stock)
                                            <tr>
                                                <td class="col1">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.po_ref_no')">
                                                        {{ $stock->po_no ?? '' }}
                                                    </span>
                                                </td>
                                                <td class="col2">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.invoice_no')">
                                                        {{ $stock->invoice_no ?? '' }}
                                                    </span>
                                                </td>
                                                <td class="col3">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.date_and_time')">
                                                        {{ $stock->created_at }}
                                                    </span>
                                                </td>
                                                <td class="col4">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.invoice_date')">
                                                        {{ $stock->transaction_date }}
                                                    </span>
                                                </td>
                                                <td class="col5">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.supplier')">
                                                        {{ $stock->supplier->name ?? '' }}
                                                    </span>
                                                </td>
                                                <td class="col6">
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
                                                <td class="col7">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.created_by')">
                                                        {{ $stock->created_by_relationship->first()->name }}
                                                    </span>
                                                </td>
                                                @if ($stock->transaction_currency == 2)
                                                    <td class="col8">
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.value')">
                                                            {{ @num_format($stock->dollar_final_total) }}
                                                        </span>
                                                    </td>
                                                @else
                                                    <td class="col8">
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
                                                <td class="col9">
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
                                                <td class="col10">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.pending_amount')">
                                                        {{ @num_format($pending) }}
                                                    </span>
                                                </td>
                                                <td class="col11">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.due_date')">
                                                        {{ $stock->due_date ?? '' }}
                                                    </span>
                                                </td>
                                                <td class="col12">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.invoice_discount')">
                                                        {{ $stock->discount_amount }}
                                                    </span>
                                                </td>
                                                <td class="col13">
                                                    <span
                                                        class="custom-tooltip dollar-cell d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.product_discount')">
                                                        @if (!empty($stock->add_stock_lines) && $stock->add_stock_lines->count() > 0)
                                                            {{ $stock->add_stock_lines->where('used_currency', '!=', 2)->sum('discount') }}
                                                            <span>
                                                                {{ $stock->add_stock_lines->where('used_currency', 2)->sum('discount') }}</span>
                                                            $
                                                        @else
                                                            0
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="col14">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center dollar-cell"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.product_discount_percent')">
                                                        @if (!empty($stock->add_stock_lines) && $stock->add_stock_lines->count() > 0)
                                                            {{ $stock->add_stock_lines->where('used_currency', '!=', 2)->sum('discount_percent') }}
                                                            %
                                                            <span>
                                                                {{ $stock->add_stock_lines->where('used_currency', 2)->sum('discount_percent') }}</span>
                                                            $
                                                        @else
                                                            0
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="col15">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center dollar-cell"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.cash_discount')">
                                                        @if (!empty($stock->add_stock_lines) && $stock->add_stock_lines->count() > 0)
                                                            {{ $stock->add_stock_lines->where('used_currency', '!=', 2)->sum('cash_discount') }}
                                                            <span>
                                                                {{ $stock->add_stock_lines->where('used_currency', 2)->sum('cash_discount') }}</span>
                                                            $
                                                        @else
                                                            0
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="col16">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center dollar-cell"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.seasonal_discount')">
                                                        @if (!empty($stock->add_stock_lines) && $stock->add_stock_lines->count() > 0)
                                                            {{ $stock->add_stock_lines->where('used_currency', '!=', 2)->sum('seasonal_discount') }}
                                                            %
                                                            <span>
                                                                {{ $stock->add_stock_lines->where('used_currency', 2)->sum('seasonal_discount') }}</span>$
                                                        @else
                                                            0
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="col17">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center dollar-cell"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.annual_discount')">
                                                        @if (!empty($stock->add_stock_lines) && $stock->add_stock_lines->count() > 0)
                                                            {{ $stock->add_stock_lines->where('used_currency', '!=', 2)->sum('annual_discount') }}
                                                            %
                                                            <span>
                                                                {{ $stock->add_stock_lines->where('used_currency', 2)->sum('annual_discount') }}</span>$
                                                        @else
                                                            0
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="col18">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.notes')">
                                                        {{ $stock->notes ?? '' }}
                                                    </span>
                                                </td>
                                                <td class="col19">
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
@endsection

@push('javascripts')
    <script>
        window.addEventListener('openAddPaymentModal', event => {
            $("#addPayment").modal('show');
        })
        window.addEventListener('closeAddPaymentModal', event => {
            $("#addPayment").modal('hide');
        })
    </script>
    {{-- +++++++++++++++++ Checkboxs and label inside selectbox ++++++++++++++ --}}
    <script>
        $("input:checkbox:not(:checked)").each(function() {
            var column = "table ." + $(this).attr("name");
            $(column).hide();
        });
        $("input:checkbox").click(function() {
            var column = "table ." + $(this).attr("name");
            $(column).toggle();
        });
        // +++++++++++++++++ Checkboxs and label inside selectbox : showCheckboxes() method ++++++++++++++
        var expanded = false;

        function showCheckboxes() {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }
    </script>
@endpush

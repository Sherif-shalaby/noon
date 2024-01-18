@extends('layouts.app')
@section('title', __('lang.stock'))
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
            top: 262px !important;
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
            margin-top: 0;
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

        .form-select {
            height: 100%;
            padding-bottom: 0;
            padding-top: 0;
            background-color: #dedede !important;
            border-radius: 16px;
            border: 2px solid #cececf;
            font-size: 14px;
            font-weight: 500
        }

        .form-select:focus {
            border-color: #cececf !important;
            outline: 0;
            box-shadow: 0 0 0 0 !important;
            background-color: white !important;
        }

        .selectBox {
            position: relative;
        }

        /* selectbox style */
        .selectBox select {
            width: 100%;
            padding: 0 !important;
            padding-left: 4px;
            padding-right: 4px;
            color: #000;
            border: 1px solid #ccc;
            background-color: #dedede;
            /* height: 39px !important; */
        }

        .overSelect {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }

        #checkboxes {
            display: none;
            border: 1px #dadada solid;
            height: 125px;
            overflow: auto;
            padding-top: 10px;
            /* text-align: end;  */
        }

        #checkboxes label {
            display: block;
            padding: 5px;
        }

        #checkboxes label:hover {
            background-color: #ddd;
        }

        #checkboxes label span {
            font-weight: normal;
        }
    </style>
    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.stock')
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
    </div>
@endsection
@section('content')
    {{-- @livewire('add-stock.add-payment') --}}
    <section class="">
        <div class="col-md-22">
            <div class="card mt-1 mb-0">
                <div
                    class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                    <h6 class="print-title">@lang('lang.stock')</h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="container-fluid">
                            @include('add-stock.partials.filters')
                        </div>

                    </div>

                    {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                    <div class="col-md-4" style="position: relative;z-index: 9;margin-top: 20px">
                        <div class="multiselect col-md-6">
                            <div class="selectBox" onclick="showCheckboxes()">
                                <select class="form-select">
                                    <option>@lang('lang.show_hide_columns')</option>
                                </select>
                                <div class="overSelect"></div>
                            </div>
                            <div id="checkboxes">
                                {{-- +++++++++++++++++ checkbox1 : po_ref_no +++++++++++++++++ --}}
                                <label for="col1_id">
                                    <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                    <span>{{ __('lang.po_ref_no') }}</span> &nbsp;
                                </label>
                                {{-- +++++++++++++++++ checkbox2 : invoice_no +++++++++++++++++ --}}
                                <label for="col2_id">
                                    <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                    <span>@lang('lang.invoice_no')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox3 : date_and_time +++++++++++++++++ --}}
                                <label for="col3_id">
                                    <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                    <span>@lang('lang.date_and_time')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox4 : invoice_date +++++++++++++++++ --}}
                                <label for="col4_id">
                                    <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                    <span>@lang('lang.invoice_date')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox5 : supplier +++++++++++++++++ --}}
                                <label for="col5_id">
                                    <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                    <span>@lang('lang.supplier')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox6 : products +++++++++++++++++ --}}
                                <label for="col6_id">
                                    <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                    <span>@lang('lang.products')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox7 : created_by +++++++++++++++++ --}}
                                <label for="col7_id">
                                    <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                    <span>@lang('lang.created_by')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox8 : value +++++++++++++++++ --}}
                                <label for="col8_id">
                                    <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                    <span>@lang('lang.value')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox9 : paid_amount +++++++++++++++++ --}}
                                <label for="col9_id">
                                    <input type="checkbox" id="col9_id" name="col9" checked="checked" />
                                    <span>@lang('lang.paid_amount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox10 : pending_amount +++++++++++++++++ --}}
                                <label for="col10_id">
                                    <input type="checkbox" id="col10_id" name="col10" checked="checked" />
                                    <span>@lang('lang.pending_amount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox11 : due_date +++++++++++++++++ --}}
                                <label for="col11_id">
                                    <input type="checkbox" id="col11_id" name="col11" checked="checked" />
                                    <span>@lang('lang.due_date')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox12 : invoice_discount +++++++++++++++++ --}}
                                <label for="col12_id">
                                    <input type="checkbox" id="col12_id" name="col12" checked="checked" />
                                    <span>@lang('lang.invoice_discount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox13 : product_discount +++++++++++++++++ --}}
                                <label for="col13_id">
                                    <input type="checkbox" id="col13_id" name="col13" checked="checked" />
                                    <span>@lang('lang.product_discount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox14 : product_discount_percent +++++++++++++++++ --}}
                                <label for="col14_id">
                                    <input type="checkbox" id="col14_id" name="col14" checked="checked" />
                                    <span>@lang('lang.product_discount_percent')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox15 : cash_discount +++++++++++++++++ --}}
                                <label for="col15_id">
                                    <input type="checkbox" id="col15_id" name="col15" checked="checked" />
                                    <span>@lang('lang.cash_discount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox16 : seasonal_discount +++++++++++++++++ --}}
                                <label for="col16_id">
                                    <input type="checkbox" id="col16_id" name="col16" checked="checked" />
                                    <span>@lang('lang.seasonal_discount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox17 : annual_discount +++++++++++++++++ --}}
                                <label for="col17_id">
                                    <input type="checkbox" id="col17_id" name="col17" checked="checked" />
                                    <span>@lang('lang.annual_discount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox18 : notes +++++++++++++++++ --}}
                                <label for="col18_id">
                                    <input type="checkbox" id="col18_id" name="col18" checked="checked" />
                                    <span>@lang('lang.notes')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox19 : action +++++++++++++++++ --}}
                                <label for="col19_id">
                                    <input type="checkbox" id="col19_id" name="col19" checked="checked" />
                                    <span>@lang('lang.action')</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                        <div class="div1"></div>
                    </div>
                    <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                        <div class="div2 table-scroll-wrapper">
                            <!-- content goes here -->
                            <div style="min-width: 1800px;max-height: 90vh;overflow: auto;">
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
@endsection

@extends('layouts.app')
@section('title', __('lang.recent_transactions'))
@section('content')
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
            top: 145px !important;
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
                top: 145px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 155px !important
            }
        }

        @media(max-width:575px) {
            .table-top-head {
                top: 250px !important
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
        <div class="contentbar pb-0 mb-0 no-print">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="container-fluid">
                                        <div class="card-body no-print">
                                            <form action="{{ route('recent_transactions') }}" method="get">
                                                <div
                                                    class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                    <div class="col-6 col-sm-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                        style="animation-delay: 1.15s">
                                                        <div class="input-wrapper width-full">
                                                            {!! Form::select('customer_id', $customers, null, [
                                                                'class' => 'form-control select2',
                                                                'placeholder' => __('lang.customer'),
                                                            ]) !!}
                                                        </div>
                                                    </div>

                                                    <div class="col-6 col-sm-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                        style="animation-delay: 1.15s">
                                                        <div class="input-wrapper width-full">
                                                            {!! Form::select('method', $payment_types, null, [
                                                                'class' => 'form-control select2',
                                                                'placeholder' => __('lang.payment_type'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-sm-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                        style="animation-delay: 1.15s">
                                                        <div class="input-wrapper width-full">
                                                            {!! Form::select('employee_id', $employees, null, [
                                                                'class' => 'form-control select2',
                                                                'placeholder' => __('lang.cashier_man'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-sm-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                        style="animation-delay: 1.15s">
                                                        <div class="input-wrapper width-full">
                                                            {!! Form::select('deliveryman_id', $delivery_men, null, [
                                                                'class' => 'form-control select2',
                                                                'placeholder' => __('lang.deliveryman'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-sm-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                        style="animation-delay: 1.15s">
                                                        <div class="input-wrapper width-full">
                                                            {!! Form::select('created_by', $users, null, [
                                                                'class' => 'form-control select2',
                                                                'placeholder' => __('lang.created_by'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-sm-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                        style="animation-delay: 1.15s">
                                                        <div class="input-wrapper width-full">
                                                            {!! Form::text('phone_number', request()->phone_number, [
                                                                'class' => 'form-control initial-balance-input width-full',
                                                                'placeholder' => __('lang.phone_number'),
                                                                'wire:model' => 'phone_number',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-sm-2 p-1 mb-4 d-flex  animate__animated animate__bounceInLeft flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                                        style="animation-delay: 1.15s">
                                                        <label class="mb-0 text-end d-block mx-2"
                                                            for="from">{{ __('lang.customer_name') }}</label>
                                                        {!! Form::text('customer_name', request()->customer_name, [
                                                            'class' => 'form-control initial-balance-input width-full mx-0',
                                                            'placeholder' => __('lang.customer_name'),
                                                            'wire:model' => 'customer_name',
                                                        ]) !!}
                                                    </div>
                                                    <div class="col-6 col-sm-2 p-1 mb-4 d-flex  animate__animated animate__bounceInLeft flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                                        style="animation-delay: 1.15s">
                                                        <label class="mb-0 text-end d-block mx-2"
                                                            for="from">{{ __('site.From') }}</label>
                                                        <div class="input-wrapper width-full">
                                                            {!! Form::date('from', null, [
                                                                'class' => 'form-control initial-balance-input width-full mx-0',
                                                                'placeholder' => __('lang.from'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-sm-2 p-1 mb-2 d-flex  animate__animated animate__bounceInLeft flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                                        style="animation-delay: 1.15s">
                                                        <label class="mb-0 text-end d-block mx-2"
                                                            for="to">{{ __('site.To') }}</label>
                                                        <div class="input-wrapper width-full">
                                                            {!! Form::date('to', null, [
                                                                'class' => 'form-control  initial-balance-input width-full mx-0',
                                                                'placeholder' => __('lang.to'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-sm-2 p-1 mt-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                        style="animation-delay: 1.15s">
                                                        <button type="submit" name="submit"
                                                            class="btn btn-success width-100" title="search">
                                                            {{ __('lang.filter') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2 table-scroll-wrapper">
                                    <!-- content goes here -->
                                    <div style="min-width: 1800px;max-height: 90vh;overflow: auto" class="no-print">
                                        <table id="example" class="table table-striped table-bordered">
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
                                                    <th class="sum dollar-cell">@lang('lang.grand_total') $</th>
                                                    <th class="sum dollar-cell">@lang('lang.paid') $</th>
                                                    <th class="sum dollar-cell">@lang('lang.due_sale_list') $</th>
                                                    <th>@lang('lang.payment_date')</th>
                                                    <th>@lang('lang.cashier_man')</th>
                                                    <th>@lang('lang.representative')</th>
                                                    <th>@lang('lang.products')</th>
                                                    <th class="notexport">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                @endphp
                                                @foreach ($sell_lines as $index => $line)
                                                    <tr>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.date_and_time')">
                                                                {{ $line->transaction_date ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.reference')">
                                                                {{ $line->invoice_no ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.store')">
                                                                {{ $line->store->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.customer')">
                                                                {{ $line->customer->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.phone')">
                                                                {{ $line->customer->phone ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.sale_status')">
                                                                <span class="badge badge-success">{{ $line->status ?? '' }}
                                                                </span>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.payment_status')">
                                                                {{ $line->payment_status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.payment_type')">
                                                                @foreach ($line->transaction_payments as $payment)
                                                                    {{ __('lang.' . $payment->method) }}<br>
                                                                @endforeach
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.ref_number')">
                                                                @foreach ($line->transaction_payments as $payment)
                                                                    {{ $payment->ref_no ?? '' }}<br>
                                                                @endforeach
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.received_currency')">
                                                                @foreach ($line->transaction_payments as $payment)
                                                                    {{ $payment->received_currency_relation->symbol ?? '' }}<br>
                                                                @endforeach
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.grand_total')">
                                                                {{ number_format($line->final_total, num_of_digital_numbers()) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.paid')">
                                                                {{ $line->transaction_payments->sum('amount') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.due_sale_list')">
                                                                {{ number_format($line->dollar_final_total, num_of_digital_numbers()) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip dollar-cell d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.grand_total')">
                                                                {{ $line->transaction_payments->sum('dollar_amount') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip dollar-cell d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.paid')">
                                                                {{ $line->final_total - $line->transaction_payments->sum('amount') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip dollar-cell d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.due_sale_list')">
                                                                {{ $line->dollar_final_total - $line->transaction_payments->sum('dollar_amount') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.payment_date')">
                                                                {{ $line->transaction_payments->last()->paid_on ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.cashier_man')">
                                                                {{ $line->created_by_user->name }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.representative')">
                                                                {{ $line->representative->employee_name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 10px;font-weight: 600"
                                                                data-tooltip="@lang('lang.products')">
                                                                @foreach ($line->transaction_sell_lines as $sell_line)
                                                                    @if (!empty($sell_line->product))
                                                                        {{ $sell_line->product->name ?? ' ' }} -
                                                                        {{ $sell_line->product->sku ?? ' ' }}<br>
                                                                    @endif
                                                                @endforeach
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <button type="button"
                                                                style="font-size: 10px;font-weight: 600"
                                                                class="btn btn-default btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                @lang('lang.action')
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                user="menu">
                                                                <li>
                                                                    <a data-href="{{ route('print_invoice', $line->id) }}"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif print-invoice"><i
                                                                            class="dripicons-print"></i>
                                                                        {{ __('lang.generate_invoice') }}</a>
                                                                </li>
                                                                <li>
                                                                    <a data-href=" {{ route('pos.show', $line->id) }}"
                                                                        data-container=".view_modal"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"><i
                                                                            class="fa fa-eye"></i>{{ __('lang.view') }}
                                                                    </a>
                                                                </li>
                                                                @if ($line->status != 'draft' && $line->payment_status != 'paid' && $line->status != 'canceled')
                                                                    <li>
                                                                        {{-- if (auth()->user()->can('sale.pay.create_and_edit')) { --}}
                                                                        @php
                                                                            $final_total = $line->final_total;
                                                                            $dollar_final_total =
                                                                                $line->dollar_final_total;
                                                                            if (!empty($line->return_parent)) {
                                                                                $final_total = @num_uf($line->final_total - $line->return_parent->final_total);
                                                                                $dollar_final_total = @num_uf($line->dollar_final_total - $line->return_parent->dollar_final_total);
                                                                            }
                                                                        @endphp

                                                                        @if ($final_total > 0 || $dollar_final_total > 0)
                                                                            <a data-href="{{ url('transaction-payment/add-payment/' . $line->id) }}"
                                                                                title="{{ __('lang.pay_now') }}"
                                                                                data-toggle="tooltip"
                                                                                data-container=".view_modal"
                                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif  btn-modal"><i
                                                                                    class="fa fa-money"></i>
                                                                                {{ __('lang.pay') }}</a>';
                                                                        @endif
                                                                        {{-- @endif --}}
                                                                    </li>
                                                                @endif
                                                                <li>
                                                                    <a href="{{ route('sell.return', $line->id) }}"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                            class="fa fa-undo"></i>@lang('lang.return')
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a data-href="{{ route('show_payment', $line->id) }}"
                                                                        data-container=".view_modal"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"><i
                                                                            class="fa fa-money"></i>
                                                                        {{ __('lang.view_payments') }}
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('invoices.edit', $line->id) }}"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                            class="dripicons-document-edit"></i>
                                                                        {{ __('lang.edit') }}</a>
                                                                </li>
                                                                <li>
                                                                    <a data-href=" {{ route('upload_receipt', $line->id) }}"
                                                                        data-container=".view_modal" data-dismiss="modal"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"><i
                                                                            class="fa fa-plus"></i>{{ __('lang.upload_receipt') }}
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a data-href="{{ route('pos.destroy', $line->id) }}"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif text-red delete_item"><i
                                                                            class="fa fa-trash"></i>
                                                                        {{ __('lang.delete') }}
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <td colspan="10" style="text-align: right">@lang('lang.total')</td>
                                                <td id="sum1"></td>
                                                <td id="sum2"></td>
                                                <td id="sum3"></td>
                                                <td id="sum4"></td>
                                                <td id="sum5"></td>
                                                <td id="sum6"></td>
                                                <td colspan="5"></td>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="view_modal no-print"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="invoice print_section print-only col-md-10" id="receipt_section_print"></section>

            @endsection
            @push('javascripts')
                <script>
                    $(document).ready(function() {
                        $('#example').DataTable({
                            dom: "<'row flex-wrap my-2 justify-content-center table-top-head'<'d-flex justify-content-center col-md-2'l><'d-flex justify-content-center col-md-6 text-center 'B><'d-flex justify-content-center col-md-4'f>>" +
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-4'i><'col-sm-4'p>>",
                            lengthMenu: [10, 25, 50, 75, 100, 200, 300, 400],
                            pageLength: 10,
                            buttons: ['copy', 'csv', 'excel', 'pdf',
                                {
                                    extend: 'print',
                                    exportOptions: {
                                        columns: ":visible:not(.notexport)"
                                    }
                                }
                                // ,'colvis'
                            ],
                            "fnDrawCallback": function(row, data, start, end, display) {
                                var api = this.api();
                                // Remove the formatting to get integer data for summation
                                var intVal = function(i) {
                                    return typeof i === 'string' ?
                                        i.replace(/[\$,]/g, '') * 1 :
                                        typeof i === 'number' ?
                                        i : 0;
                                };
                                // Total over all pages
                                total1 = api.rows({
                                    'page': 'current'
                                }).nodes().to$().find('td:eq(10)').map(function() {
                                    return intVal($(this).text());
                                }).get().reduce(function(a, b) {
                                    return a + b;
                                }, 0);
                                total2 = api.rows({
                                    'page': 'current'
                                }).nodes().to$().find('td:eq(11)').map(function() {
                                    return intVal($(this).text());
                                }).get().reduce(function(a, b) {
                                    return a + b;
                                }, 0);
                                total3 = api.rows({
                                    'page': 'current'
                                }).nodes().to$().find('td:eq(12)').map(function() {
                                    return intVal($(this).text());
                                }).get().reduce(function(a, b) {
                                    return a + b;
                                }, 0);
                                total4 = api.rows({
                                    'page': 'current'
                                }).nodes().to$().find('td:eq(13)').map(function() {
                                    return intVal($(this).text());
                                }).get().reduce(function(a, b) {
                                    return a + b;
                                }, 0);
                                total5 = api.rows({
                                    'page': 'current'
                                }).nodes().to$().find('td:eq(14)').map(function() {
                                    return intVal($(this).text());
                                }).get().reduce(function(a, b) {
                                    return a + b;
                                }, 0);
                                total6 = api.rows({
                                    'page': 'current'
                                }).nodes().to$().find('td:eq(15)').map(function() {
                                    return intVal($(this).text());
                                }).get().reduce(function(a, b) {
                                    return a + b;
                                }, 0);
                                // Update status DIV
                                $('#sum1').html('<span>' + total1 + '<span/>');
                                $('#sum2').html('<span>' + total2 + '<span/>');
                                $('#sum3').html('<span>' + total3 + '<span/>');
                                $('#sum4').html('<span>' + total4 + '<span/>');
                                $('#sum5').html('<span>' + total5 + '<span/>');
                                $('#sum6').html('<span>' + total6 + '<span/>');
                            }
                        });
                    });
                    $(document).on("click", ".print-invoice", function() {
                        // $(".modal").modal("hide");
                        $.ajax({
                            method: "get",
                            url: $(this).data("href"),
                            data: {},
                            success: function(result) {
                                if (result.success) {
                                    setTimeout(() => {
                                        pos_print(result.html_content);
                                        // $("#receipt_section_print").html(result.html_content);
                                        // window.print();
                                    }, 3000);
                                }
                            },
                        });
                    });

                    function pos_print(receipt) {
                        $("#receipt_section_print").html(receipt);
                        const sectionToPrint = document.getElementById('receipt_section_print');
                        __print_receipt(sectionToPrint);
                    }

                    function __print_receipt(section = null) {
                        setTimeout(function() {
                            section.style.display = 'block';
                            window.print();
                            section.style.display = 'none';

                        }, 1000);
                    }
                </script>
            @endpush

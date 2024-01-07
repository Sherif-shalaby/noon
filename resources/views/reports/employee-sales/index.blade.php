@extends('layouts.app')
@section('title', __('lang.customer_report'))
@section('breadcrumbbar')
    <style>
        .table-top-head {
            top: -10px !important;
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
                top: -10px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: -10px !important
            }
        }

        .wrapper1 {
            margin-top: 35px;
        }

        .input-wrapper {
            width: 100% !important;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 115px;
            }

            .input-wrapper {
                width: 60%
            }
        }
    </style>
    <!-- Start row -->
    <div class="animate-in-page">
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card mb-0">
                    <div class="card-header">
                        <h6 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            @lang('lang.customer_report')</h6>
                    </div>
                    <div class="card-body">
                        @include('reports.employee-sales.filters')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                    <div class="div1"></div>
                                </div>
                                <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                    <div class="div2 table-scroll-wrapper">
                                        <!-- content goes here -->
                                        <div style="min-width: 1800px;max-height: 90vh;overflow: auto">
                                            <table id="datatable-buttons"
                                                class="table table-hover table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('lang.date')</th>
                                                        <th>@lang('lang.reference')</th>
                                                        <th>@lang('lang.employee')</th>
                                                        <th class="currencies">@lang('lang.currency')</th>
                                                        <th class="sum">@lang('lang.commission')</th>
                                                        <th class="sum">@lang('lang.paid')</th>
                                                        <th>متأخرات</th>
                                                        <th class="sum">@lang('lang.due')</th>
                                                        <th>@lang('lang.payment_type')</th>
                                                        <th>@lang('lang.payment_status')</th>
                                                        <th class="notexport">@lang('lang.action')</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($sales as $key => $sale)
                                                        <tr>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.date')">
                                                                    {{ @format_date($sale->created_at->format('Y-m-d')) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $ref_numbers = '';
                                                                    if (!empty($request->method)) {
                                                                        $payments = $sale->transaction_payments->where('method', $request->method);
                                                                    } else {
                                                                        $payments = $sale->transaction_payments;
                                                                    }

                                                                    foreach ($payments as $payment) {
                                                                        if (!empty($payment->ref_number)) {
                                                                            $ref_numbers .= $payment->ref_number . '<br>';
                                                                        }
                                                                    }
                                                                @endphp
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.reference')">

                                                                    {{ $ref_numbers }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.employee')">

                                                                    {{ $sale->employee->name ?? '' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $default_currency = \App\Models\Currency::find($default_currency_id);
                                                                @endphp
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.currency')">

                                                                    {{ $sale->paying_currency_symbol ?? $default_currency->symbol }}
                                                                </span>
                                                            </td>
                                                            <td>

                                                            </td>
                                                            <td>
                                                                @php
                                                                    $amount_paid = $sale->transaction_payments->sum('amount');
                                                                    $paying_currency_id = $sale->paying_currency_id ?? $default_currency_id;
                                                                @endphp
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.paid')">

                                                                    <span data-currency_id="{{ $paying_currency_id }}">
                                                                        {{ $amount_paid }}</span>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $due = $sale->final_total - $sale->transaction_payments->sum('amount');
                                                                    $paying_currency_id = $sale->paying_currency_id ?? $default_currency_id;
                                                                @endphp
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="متأخرات">

                                                                    <span
                                                                        data-currency_id="$paying_currency_id ">{{ $due }}</span>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.due')">

                                                                    {{ @format_datetime($sale->paid_on) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.payment_type')">

                                                                    @foreach ($sale->transaction_payments as $payment)
                                                                        @if (!empty($payment->method))
                                                                            {{ $payment_types[$payment->method] }} <br>
                                                                        @endif
                                                                    @endforeach
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.payment_status')">

                                                                    @if ($sale->payment_status == 'pending')
                                                                        <span
                                                                            class="label label-success">{{ __('lang.pay_later') }}</span>
                                                                    @else
                                                                        <span
                                                                            class="label label-danger">{{ ucfirst($sale->status) }}</span>
                                                                    @endif
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                        style="font-size: 12px;font-weight: 600"
                                                                        class="btn btn-default btn-sm dropdown-toggle"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">خيارات <span
                                                                            class="caret"></span>
                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                    </button>
                                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                        user="menu" x-placement="bottom-end"
                                                                        style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                        <li>
                                                                            <a data-href="{{ route('show_payment', $sale->id) }}"
                                                                                data-container=".view_modal"
                                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal">
                                                                                <i class="fa fa-money"></i>
                                                                                @lang('lang.view_payments')
                                                                            </a>
                                                                        </li>
                                                                        @if ($sale->status != 'draft' && $sale->payment_status != 'paid' && $sale->status != 'canceled')
                                                                            <li>
                                                                                <a data-href="{{ route('add_payment', $sale->id) }}"
                                                                                    data-container=".view_modal"
                                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal">
                                                                                    <i class="fa fa-plus"></i>
                                                                                    @lang('lang.add_payments')
                                                                                </a>
                                                                            </li>
                                                                        @endif

                                                                        <li>
                                                                            <a data-href="{{ route('pos.show', $sale->id) }}"
                                                                                data-container=".view_modal"
                                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal">
                                                                                <i class="fa fa-eye"></i>
                                                                                @lang('lang.view')
                                                                            </a>
                                                                        </li>

                                                                        <li>
                                                                            <a data-href="{{ route('pos.destroy', $sale->id) }}"
                                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif text-red delete_item">
                                                                                <i class="fa fa-trash"></i>
                                                                                @lang('lang.delete')
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <th style="text-align: right">@lang('lang.total')</th>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="view_modal no-print">

    </div>
@endsection
@section('content')

@endsection

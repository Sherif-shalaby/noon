@extends('layouts.app')
@section('title', __('lang.stock'))
@section('breadcrumbbar')
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
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center">
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
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
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
                                        <td>{{ $stock->po_no ?? '' }}</td>
                                        <td>{{ $stock->invoice_no ?? '' }}</td>
                                        <td>{{ $stock->created_at }}</td>
                                        <td>{{ $stock->transaction_date }}</td>
                                        <td>{{ $stock->supplier->name ?? '' }}</td>
                                        <td>
                                            @if (!empty($stock->add_stock_lines))
                                                @foreach ($stock->add_stock_lines as $stock_line)
                                                    {{ $stock_line->product->name ?? '' }}<br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $stock->created_by_relationship->first()->name }}</td>
                                        @if ($stock->transaction_currency == 2)
                                            <td>{{ @num_format($stock->dollar_final_total) }}</td>
                                        @else
                                            <td>{{ @num_format($stock->final_total) }}</td>
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
                                            {{ @num_format($paid) }}
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
                                            {{ @num_format($pending) }}
                                        </td>
                                        <td>{{ $stock->due_date ?? '' }}</td>
                                        <td>{{ $stock->notes ?? '' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                user="menu">
                                                <li>
                                                    <a href="{{ route('stocks.show', $stock->id) }}" class="btn"><i
                                                            class="fa fa-eye"></i>
                                                        @lang('lang.view') </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{ route('stocks.edit', $stock->id) }}" class="btn"><i
                                                            class="fa fa-edit"></i>
                                                        @lang('lang.edit') </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{ route('stocks.delete', $stock->id) }}"
                                                        {{-- data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}" --}} class="btn text-red delete_item"><i
                                                            class="fa fa-trash"></i>
                                                        @lang('lang.delete')</a>
                                                </li>
                                                @if ($stock->payment_status != 'paid')
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a data-href="{{ route('stocks.addPayment', $stock->id) }}"
                                                            data-container=".view_modal" class="btn btn-modal">
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

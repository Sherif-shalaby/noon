@extends('layouts.app')
@section('title', __('lang.sell_price_less_purchase_price'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.sell_price_less_purchase_price')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="">/ @lang('lang.reports')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">/ @lang('lang.product_report')</li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.sell_price_less_purchase_price')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="widgetbar">
                    </div>
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
                        <h6 class="card-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            @lang('lang.sell_price_less_purchase_price')</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    {{--                                    @include('reports.products.filters') --}}
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive  @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div id="status"></div>
                            <table id="datatable-buttons"
                                class="table dataTable table-striped table-bordered table-button-wrapper table-hover ">
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
                                        <th>@lang('lang.due_date')</th>
                                        <th>@lang('lang.payment_date')</th>
                                        <th>@lang('lang.cashier_man')</th>
                                        <th>@lang('lang.commission')</th>
                                        <th>@lang('lang.products')</th>
                                        <th>@lang('lang.sale_note')</th>
                                        <th>@lang('lang.receipts')</th>
                                        <th class="notexport">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sell_lines as $index => $line)
                                        <tr>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.date_and_time')">

                                                    {{ $line->transaction_date ?? '' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.reference')">

                                                    {{ $line->invoice_no ?? '' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.store')">

                                                    {{ $line->store->name ?? '' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.customer')">

                                                    {{ $line->customer->name ?? '' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.phone')">

                                                    {{ $line->customer->phone ?? '' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.sale_status')">
                                                    <span class="badge badge-success">{{ $line->status ?? '' }}</span>
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.payment_status')">{{ $line->payment_status }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.payment_type')">

                                                    @foreach ($line->transaction_payments as $payment)
                                                        {{ __('lang.' . $payment->method) }}<br>
                                                    @endforeach
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.ref_number')">

                                                    @foreach ($line->transaction_payments as $payment)
                                                        {{ $payment->ref_no ?? '' }}<br>
                                                    @endforeach
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.received_currency')">

                                                    @foreach ($line->transaction_payments as $payment)
                                                        {{ $payment->received_currency_relation->symbol ?? '' }}<br>
                                                    @endforeach
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.grand_total')">

                                                    {{ number_format($line->final_total, num_of_digital_numbers()) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.paid')">

                                                    {{ $line->transaction_payments->sum('amount') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.due_sale_list')">

                                                    {{ $line->final_total - $line->transaction_payments->sum('amount') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.due_date')">

                                                    {{ $line->transaction_payments->last()->due_date ?? '' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.payment_date')">

                                                    {{ $line->transaction_payments->last()->paid_on ?? '' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.cashier_man')">

                                                    {{ $line->created_by_user->name }}
                                                </span>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
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
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.sale_note')">

                                                    @foreach ($line->transaction_payments as $payment)
                                                        {{ $payment->received_currency_relation->payment_note ?? '' }}<br>
                                                    @endforeach
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.receipts')">

                                                    @if (count($line->receipts) > 0)
                                                        <a data-href=" {{ route('show_receipt', $line->id) }}"
                                                            data-container=".view_modal" class="btn btn-default btn-modal">
                                                            {{ __('lang.view') }}
                                                        </a>
                                                    @endif
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

                                                    <li>
                                                        <a href="{{ route('sell.return', $line->id) }}"
                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                class="fa fa-undo"></i>@lang('lang.return') </a>
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
                                                            {{--                                                       data-check_password="{{ action('UserController@checkPassword', Auth::user()->id) }} " --}}
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
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
<div class="view_modal no-print">@endsection
    @push('javascripts')
        <script src="{{ asset('js/product/product.js') }}"></script>
        <script>
            $(document).on('click', '.product_unit', function() {
                var $this = $(this);
                var variation_id = $(this).data('variation_id');
                var product_id = $(this).data('product_id');
                $.ajax({
                    type: "get",
                    url: "/product/get-unit-store",
                    data: {
                        variation_id: variation_id,
                        product_id: product_id
                    },
                    success: function(response) {
                        $this.closest('td').find('.product_unit').each(function() {
                            $(this).find('.unit_value').text(
                                0); // Change "New Value" to the desired value
                        });
                        $this.children('.unit_value').text(response.store);
                    }
                });
            });
        </script>
    @endpush

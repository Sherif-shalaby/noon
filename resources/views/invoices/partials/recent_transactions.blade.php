<div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif" style="max-height: 80vh;overflow: scroll">
    <table id="datatable-buttons" class="table table-striped table-bordered table-hover">
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
                        <span data-tooltip="@lang('lang.date_and_time')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">

                            {{ $line->transaction_date ?? '' }}
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.reference')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">

                            {{ $line->invoice_no ?? '' }}
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.store')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">

                            {{ $line->store->name ?? '' }}
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.customer')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">

                            {{ $line->customer->name ?? '' }}
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.phone')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">

                            {{ $line->customer->phone ?? '' }}
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.sale_status')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">

                            <span class="badge badge-success">{{ $line->status ?? '' }}</span>
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.payment_status')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">

                            {{ $line->payment_status }}
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.payment_type')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">

                            @foreach ($line->transaction_payments as $payment)
                                {{ __('lang.' . $payment->method) }}<br>
                            @endforeach
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.ref_number')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">
                            @foreach ($line->transaction_payments as $payment)
                                {{ $payment->ref_no ?? '' }}<br>
                            @endforeach
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.received_currency')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">
                            @foreach ($line->transaction_payments as $payment)
                                {{ $payment->received_currency_relation->symbol ?? '' }}<br>
                            @endforeach
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.grand_total')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">

                            {{ number_format($line->final_total, 2) }}
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.paid')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">

                            {{ $line->transaction_payments->sum('amount') }}
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.due_sale_list')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">

                            {{ $line->final_total - $line->transaction_payments->sum('amount') }}
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.payment_date')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">

                            {{ $line->transaction_payments->last()->paid_on ?? '' }}
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.cashier_man')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">

                            {{ $line->created_by_user->name }}
                        </span>
                    </td>
                    <td>
                        <span data-tooltip="@lang('lang.products')"
                            class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                            style="font-size: 12px;font-weight: 600">
                            @foreach ($line->transaction_sell_lines as $sell_line)
                                @if (!empty($sell_line->product))
                                    {{ $sell_line->product->name ?? ' ' }} -
                                    {{ $sell_line->product->sku ?? ' ' }}<br>
                                @endif
                            @endforeach
                        </span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                            style="font-size: 12px;font-weight: 600" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            @lang('lang.action')
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                            <li>
                                <a data-href="{{ route('print_invoice', $line->id) }}"
                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif print-invoice"><i
                                        class="dripicons-print"></i>
                                    {{ __('lang.generate_invoice') }}</a>
                            </li>

                            <li>
                                <a data-href=" {{ route('pos.show', $line->id) }}" data-container=".view_modal"
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
                                <a data-href="{{ route('show_payment', $line->id) }}" data-container=".view_modal"
                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"><i
                                        class="fa fa-money"></i>
                                    {{ __('lang.view_payments') }}
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('invoices.edit', $line->id) }}"
                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                        class="dripicons-document-edit"></i> {{ __('lang.edit') }}</a>
                            </li>

                            <li>
                                <a data-href=" {{ route('upload_receipt', $line->id) }}" data-container=".view_modal"
                                    data-dismiss="modal"
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
    </table>
</div>
<div class="view_modal no-print"></div>
<section class="invoice print_section print-only" id="receipt_section"> </section>

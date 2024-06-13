<style>
    @media print {
        * {
            font-size: 12px;
            line-height: 20px;
            font-family: 'Times New Roman';
        }

        td,
        th {
            padding: 5px 0;
        }

        .hidden-print {
            display: none !important;
        }

        @page {
            margin: 0;
        }

        body {
            margin: 0.5cm;
            margin-bottom: 1.6cm;
        }

        .page {
            position: absolute;
            top: 0;
            right: 0;
        }

        #header_invoice_img {
            max-width: 80mm;
        }
    }

    #receipt_section * {
        font-size: 14px;
        line-height: 24px;
        font-family: 'Ubuntu', sans-serif;
        text-transform: capitalize;
        color: black !important;
    }

    #receipt_section .btn {
        padding: 7px 10px;
        text-decoration: none;
        border: none;
        display: block;
        text-align: center;
        margin: 7px;
        cursor: pointer;
    }

    #receipt_section .btn-info {
        background-color: #999;
        color: #FFF;
    }

    #receipt_section .btn-primary {
        background-color: #6449e7;
        color: #FFF;
        width: 100%;
    }

    #receipt_section td,
    #receipt_section th,
    #receipt_section tr,
    #receipt_section table {
        border-collapse: collapse;
    }

    #receipt_section tr {
        border-bottom: 1px dotted #ddd;
    }

    #receipt_section td,
    #receipt_section th {
        padding: 7px 0;
        width: 50%;
    }

    #receipt_section table {
        width: 100%;
    }

    #receipt_section tfoot tr th:first-child {
        text-align: left;
    }

    .centered {
        text-align: center;
        align-content: center;
    }

    small {
        font-size: 11px;
    }
</style>

<div style="max-width:350px;margin:0 auto;color: black !important;">

    <div id="receipt-data">
        <div class="centered">
            @include('layouts.partials.print_header')

            <p>{{ $transaction->store->name }} {{ $transaction->store->location }}</p>
            <p>{{ $transaction->store->phone_number }} </p>

        </div>
        <div style="width: 70%; float:left;">
            <p style="padding: 0 7px;  font-weight: bold;">{{ __('lang.date', [], 'ar') }}: {{ $transaction->transaction_date }}
                {{ __('lang.reference', [], 'ar') }}:
                @if (!empty($transaction->customer) && $transaction->customer->is_default == 0)
                    {{ $transaction->customer->name }}<br>
                    {{ $transaction->customer->address }}<br>
                    {{ $transaction->customer->mobile_number }}<br>
                @endif
                @if (!empty($transaction->sale_note))
                    {{ $transaction->sale_note }} @lang('lang.address', [], 'ar')
                    <br>
                @endif
            </p>
        </div>
        <div class="table_div" style=" width:100%; height:100%; padding: 0 7px;">
            <table style="margin: 0 auto; width: 100%">
                <thead>
                <tr>
                    @if (empty($print_gift_invoice))
                        <th style="width: 20%">{{ __('lang.amount', [], 'ar') }}
                        </th>
                    @endif
                    <th style="width: 20%">{{ __('lang.qty', [], 'ar') }}  </th>
                    @if (empty($print_gift_invoice))
                        <th style="width: 20%;text-align:center !important;">{{ __('lang.price', [], 'ar') }}</th>
                    @endif
                    <th style="width: 40%; padding: 0 50px !important;">{{ __('lang.item', [], 'ar') }}  </th>
                </tr>
                </thead>
                <tbody>

                @foreach ($transaction->transaction_sell_lines as $line)
                    <tr>
                        @if (empty($print_gift_invoice))
                            <td style="text-align:left;vertical-align:bottom">
                                @if ($line->product_discount_type != 'surplus')
                                    {{ $line->sub_total + $line->product_discount_amount }}
                                @else
                                    {{ @num_format($line->sub_total) }}
                                @endif
                            </td>
                        @endif
                        <td style="text-align:left;vertical-align:bottom">{{ $line->quantity }}</td>
                        @if (empty($print_gift_invoice))
                            <td style="text-align:center !important;vertical-align:bottom">
                                {{ $line->sell_price }}</td>
                        @endif
                        <td style="width: 40% !important;padding: 0 5px 0 10px !important;">
                            @if (!empty($line->variation))
                                @if ($line->variation->name != 'Default')
                                    {{ $line->variation->name }}
                                @else
                                    {{ $line->product->translated_name($line->product->id, 'ar') }}
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                @if (empty($print_gift_invoice))
                    <tr>
                        <th colspan="2" style="text-align:left">
                            {{ ($transaction->grand_total + $transaction->transaction_sell_lines->where('product_discount_type', '!=', 'surplus')->sum('product_discount_amount')) }}
                            {{ $transaction->received_currency->symbol }}
                        </th>
                        <th colspan="2" style="text-align:right">{{ __('lang.total', [], 'ar') }}
                    </tr>
                    @if ($transaction->transaction_sell_lines->where('product_discount_type', '!=', 'surplus')->sum('product_discount_amount') > 0)
                        <tr>
                            <th colspan="2" style="text-align:left">
                                {{ ($transaction->transaction_sell_lines->where('product_discount_type', '!=', 'surplus')->sum('product_discount_amount')) }}
                                {{ $transaction->received_currency->symbol }}
                            </th>
                            <th colspan="2" style="text-align:right">{{ __('lang.discount', [], 'ar') }} </th>
                        </tr>
                    @endif
                    @if ($transaction->total_item_tax != 0)
                        <tr>
                            <th colspan="2" style="text-align:left">
                                {{ @num_format($transaction->total_item_tax) }}
                                {{ $transaction->received_currency->symbol }}
                            </th>
                            <th colspan="2" style="text-align:right">{{ __('lang.tax', [], 'ar') }}  </th>
                        </tr>
                    @endif
                    @if ($transaction->service_fee_value > 0)
                        <tr>
                            <th colspan="2" style="text-align:left">
                                {{ @num_format($transaction->service_fee_value) }}
                                {{ $transaction->received_currency->symbol }}
                            </th>
                            <th colspan="2" style="text-align:right">{{ __('lang.service', [], 'ar') }}  </th>
                        </tr>
                    @endif
                    @if ($transaction->total_tax != 0)
                        <tr>
                            <th colspan="2" style="text-align:left">{{ @num_format($transaction->total_tax) }}
                                {{ $transaction->received_currency->symbol }}
                            </th>
                            <th colspan="2" style="text-align:right">{{ $transaction->tax->name ?? '' }}</th>
                        </tr>
                    @endif
                    @if ($transaction->discount_amount != 0)
                        <tr>
                            <th colspan="2" style="text-align:left">
                                {{ @num_format($transaction->discount_amount) }}
                                {{ $transaction->received_currency->symbol }}
                            </th>
                            <th colspan="2" style="text-align:right">{{ __('lang.order_discount', [], 'ar') }}</th>
                        </tr>
                    @endif
                    @if ($transaction->total_sp_discount != 0)
                        <tr>
                            <th colspan="2" style="text-align:left">
                                {{ @num_format($transaction->total_sp_discount) }}
                                {{ $transaction->received_currency->symbol }}
                            </th>
                            <th colspan="2" style="text-align:right">{{ __('lang.sales_promotion', [], 'ar') }}</th>
                        </tr>
                    @endif
                    @if ($transaction->transaction_sell_lines->sum('coupon_discount'))
                        <tr>
                            <th colspan="2" style="text-align:left">
                                {{ @num_format($transaction->transaction_sell_lines->sum('coupon_discount')) }}
                                {{ $transaction->received_currency->symbol }}
                            </th>
                            <th colspan="2" style="text-align:right">{{ __('lang.coupon_discount', [], 'ar') }}</th>
                        </tr>
                    @endif

                        <tr>
                            @if (!empty($transaction->delivery_cost))
                            <th colspan="2" style="text-align:left">
                                {{ @num_format($transaction->delivery_cost) }}
                                {{ $transaction->received_currency->symbol }}
                            </th>
                            @endif
                            @if (!empty($transaction->deliveryman_id))
                            <th colspan="2" style="text-align:right">{{ __('lang.delivery_cost', [], 'ar') }}
                                @if (!empty($transaction->deliveryman->employee_name))
                                    ({{ $transaction->deliveryman->employee_name }})
                                @endif
                            </th>
                            @endif
                        </tr>

                    @if (!empty($transaction->rp_redeemed_value))
                        <tr>
                            <th colspan="2" style="text-align:left">
                                {{ @num_format($transaction->rp_redeemed_value) }}</th>
                            <th colspan="2" style="text-align:right">
                                {{ __('lang.redeemed_point_value', [], 'ar') }}
                            </th>
                        </tr>
                    @endif
                    <tr>
                        <th colspan="2" style="text-align:left">
                            @if ($transaction->delivery_cost_given_to_deliveryman)
                                {{ @num_format($transaction->final_total + $transaction->delivery_cost) }}
                            @else
                                {{ @num_format($transaction->final_total) }}
                            @endif
                            {{ $transaction->received_currency->symbol }}
                        </th>
                        <th colspan="2" style="text-align:right">{{ __('lang.grand_total', [], 'ar') }}</th>
                    </tr>
                    <tr>

                    </tr>
                @endif <!-- end of print gift invoice -->
                </tfoot>
            </table>
        </div>
        <div style="padding: 0 7px;">
            <table>
                <tbody>
                @if (empty($print_gift_invoice))
                    @if (!$transaction->delivery_cost_given_to_deliveryman)
                        @foreach ($transaction->transaction_payments as $payment_data)
                            @if ($payment_data->method != 'deposit')
                                <tr style="background-color:#ddd;">
                                    <td style="padding: 7px;width:30%">
                                        @if (!empty($payment_data->method))
                                            {{ __('lang.' . $payment_data->method, [], 'ar') }}
                                        @endif
                                    </td>
                                    <td style="padding: 7px;width:40%; text-align: right;" colspan="2">
                                        {{ @num_format($payment_data->amount + $payment_data->change_amount) }}
                                        {{ $transaction->received_currency->symbol }}</td>
                                </tr>
                            @endif
                            @if (!empty($payment_data->change_amount) && $payment_data->change_amount > 0 && $payment_data->method != 'deposit')
                                <tr>
                                    <td style="padding: 7px;width:30%">{{ __('lang.change', [], 'ar') }}}</td>
                                    <td colspan="2" style="padding: 7px;width:40%; text-align: right;">
                                        {{ @num_format($payment_data->change_amount) }}
                                        {{ $transaction->received_currency->symbol }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                    @if (!empty($payment_data->add_to_deposit) && $payment_data->add_to_deposit > 0 && $payment_data->method == 'deposit')
                        <tr>
                            <td style="padding: 7px;width:30%">{{ __('lang.deposit', [], 'ar') }}}</td>
                            <td colspan="2" style="padding: 7px;width:40%; text-align: right;">
                                {{ @num_format($payment_data->add_to_deposit) }}</td>
                        </tr>
                    @endif
                    @if (!empty($payment_data->used_deposit_balance) && $payment_data->used_deposit_balance > 0 && $payment_data->method == 'deposit')
                        <tr>
                            <td style="padding: 7px;width:30%">{{ __('lang.used_deposit_balance', [], 'ar') }}</td>
                            <td colspan="2" style="padding: 7px;width:40%; text-align: right;">
                                {{ @num_format($payment_data->used_deposit_balance) }}</td>
                        </tr>
                    @endif
                    @if ($transaction->payment_status != 'paid' && $transaction->final_total - $transaction->transaction_payments->sum('amount') > 0)
                        <tr>
                            <td style="padding: 7px;width:30%">{{ __('lang.due_sale_list', [], 'ar') }}}</td>
                            <td colspan="2" style="padding: 7px;width:40%; text-align: right;">
                                {{ @num_format($transaction->final_total - $transaction->transaction_payments->sum('amount')) }}
                                {{ $transaction->received_currency->symbol }}
                            </td>
                        </tr>
                    @endif
                    @if(env('SHOW_DUE',false) && $transaction->customer_id !=  env('DEFAULT_CUSTMER',1) && $total_due < 0)
                        <tr>
                            <td style="padding: 7px;width:30%">{{ __('lang.total_due', [], 'ar') }}</td>
                            <td colspan="2" style="font-size: 16px; padding: 5px;width:40%; text-align: right;">
                                {{ @num_format($total_due*-1) }}
                                {{ $transaction->received_currency->symbol }}
                            </td>
                        </tr>

                    @endif
                @endif <!-- end of print gift invoice -->
                <tr>
                    <td class="centered" colspan="3">
                        {{ __('lang.thank_you_and_come_again', [], 'ar') }}
                    </td>
                </tr>
                @if (!empty($transaction->terms_and_conditions))
                    <tr>
                        <td>{!! $transaction->terms_and_conditions->description !!}</td>
                    </tr>
                @endif
{{--                <tr>--}}
{{--                    <td class="centered" colspan="3">--}}
{{--                        <img style="margin-top:10px;"--}}
{{--                             src="data:image/png;base64,{{ DNS1D::getBarcodePNG($transaction->invoice_no ?? '1', 'C128') }}"--}}
{{--                             width="300" alt="barcode" />--}}
{{--                    </td>--}}
{{--                </tr>--}}
                </tbody>
            </table>
        </div>

{{--        @include('layouts.partials.print_footer')--}}

        <div style="width: 100%; text-align: center;">
            <p><span class="">Proudly Developed at <a style="text-decoration: none;" target="_blank"
                                                      href="http://sherifshalaby.tech">sherifshalaby.tech</a></span></p>
        </div>

    </div>
</div>

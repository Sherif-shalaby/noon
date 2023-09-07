<style>
    .print-only {
        display: none;
    }

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
        .no-print {
            display: none;
        }

        .print-only {
            display: block;
        }
        .ui-pnotify-container{
            display: none !important;
        }
        @livewireScripts {
            display: none !important;
        }
    }
    section{
        max-width: 90%;
        margin: 0 auto
    }
    .content_table{
        width: 100%;
        border-collapse: collapse;
    }
    th,td,.content_table{
        border: 1px solid;
    }
    td{
        text-align: right;
        padding: 5px;
    }
    h3{
        text-align: center;
    }
    th{
        background-color: #CACACA;
        padding: 5px;
    }
    p{
        text-align: right
    }
    .d-flex{
        display: flex;
    }
</style>

    @php
        if (empty($invoice_lang)) {
            $invoice_lang = request()
            ->session()
            ->get('language');
        }
    @endphp

<section>
    @include('layouts.partials.print_header')

    <div class="description">
        <h3>@lang('lang.invoice')</h3>
        <div class="d-flex" style="justify-content: space-between">
            <p>
                @lang('lang.number') : 1
            </p>
            <p>
                {{__('lang.'.$transaction->payment_status)}}
            </p>
            <p>
                @lang('lang.date_and_time') : {{$transaction->transaction_date}}
            </p>
        </div>
        <div class="address d-flex" style="flex-wrap: wrap;">
            <p style="width: 50%;"> <span style="text-decoration: underline">{{$transaction->customer->address}} </span></p>
            <p style="width: 50%;"> @lang('lang.respected') <span style="text-decoration: underline">{{$transaction->customer->name}}</span>  : @lang('lang.dear') </p>
            <p style="width: 50%;"> <span style="text-decoration: underline"></span></p>
            <p style="width: 50%;"> <span style="text-decoration: underline"> {{$transaction->customer->phone}} </span> </p>
        </div>
    </div>
    <div class="invoice">
        <table class="content_table">
            <thead>
                <th style="width:10%">@lang('lang.total')</th>
                <th style="width:10%">@lang('lang.price_of_piece')</th>
                <th style="width:10%">@lang('lang.quantity')</th>
                <th style="width:10%">@lang('lang.fill')</th>
                <th style="width:10%">@lang('lang.carton')</th>
                <th style="width:40%">@lang('lang.description')</th>
                <th style="width:10%">@lang('lang.notes')</th>
            </thead>
            <tbody>
                @foreach ($transaction->transaction_sell_lines as $line)
                    <tr>
                        <td>{{number_format($line->sub_total,2)}}</td>
                        <td>
                            @if(!empty($line->dollar_sell_price))
                                {{number_format($line->dollar_sell_price * $line->exchange_rate,2)}}
                            @else
                                {{$line->sell_price}}
                            @endif
                        </td>
                        <td>{{number_format($line->quantity * $line->product->unit->base_unit_multiplier,2)}}</td>
                        <td style="background-color: #CACACA">{{$line->product->unit->base_unit_multiplier}}</td>
                        <td>{{number_format($line->quantity,2)}}</td>
                        <td style="text-align: center"> {{$line->product->name}}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex" style="flex-wrap: wrap; justify-content: space-between">
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%;">
            <tr >
                @if($transaction->customer->balance < 0)
                    <td> {{$transaction->customer->balance + ($transaction->final_total - $transaction->transaction_payments->where('received_currency' ,'!=',2)->sum('amount'))}}</td>
                @else
                    <td> {{$transaction->customer->balance - ($transaction->final_total - $transaction->transaction_payments->where('received_currency' ,'!=',2)->sum('amount'))}}</td>
                @endif
                <td style="background-color: #CACACA; width: 50%"> @lang('lang.previous_balance') </td>
            </tr>
        </table>
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%">
            <tr>
                <td > {{$transaction->final_total}}</td>
                <td style="background-color: #CACACA; width: 50%"> @lang('lang.total_after_discount') </td>
            </tr>
        </table>
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%;">
            <tr>
                <td> {{$transaction->discount_value}}</td>
                <td style="background-color: #CACACA; width: 50%"> @lang('lang.discount') </td>
            </tr>
        </table>
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%;">
            <tr >
                <td> {{$transaction->grand_total}}</td>
                <td style="background-color: #CACACA; width: 50%"> @lang('lang.total') </td>
            </tr>
        </table>


    </div>
    <div class="d-flex" style="flex-wrap: wrap; justify-content: space-between">
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%;">
            <tr >
                <td> {{$transaction->customer->balance}}</td>
                <td style="background-color: #CACACA; width: 50%"> @lang('lang.remaining_balance') </td>
            </tr>
        </table>
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%">
            <tr>
                <td > {{$transaction->store->name}}</td>
                <td style="background-color: #CACACA; width: 50%"> @lang('lang.store') </td>
            </tr>
        </table>
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%;">
            <tr>
                <td> {{$transaction->transaction_payments->where('received_currency' ,2)->sum('amount')}}</td>
                <td style="background-color: #CACACA; width: 50%"> @lang('lang.dollar') </td>
            </tr>
        </table>
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%;">
            <tr >
                <td> {{$transaction->transaction_payments->where('received_currency' ,'!=',2)->sum('amount')}}</td>
                <td style="background-color: #CACACA; width: 50%"> @lang('lang.dinar') </td>
            </tr>
        </table>


    </div>

</section>



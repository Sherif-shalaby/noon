<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print</title>
</head>
<style>
   
    .print-only {
        display: none;
    }

    @media print {
        *  , *::after , *::before
        {
            color: #000 !important;
        }
        * {
            font-size: 12px;
            line-height: 20px;
            font-family: 'Times New Roman';
        }

        td,
        th {
            padding: 5px 0;
        }
        thead
        {
            background-color: #dddddd !important;
        }
        .hidden-print {
            display: none !important;
        }
        #watermark {
                position: fixed;
                width: 100%;
                height: auto;
                top: 10%;
                left: 0%;
                opacity: 0.2;
            }

            #watermark img {
                width: 100%;
                height: 100%;
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
        /* @livewireScripts {
            display: none !important;
        } */
   
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
        background-color: #DDD !important;
        padding: 5px;
    }
    p{
        text-align: right
    }
    .d-flex{
        display: flex;
    }
}
</style>
<body style="background-color:transparent !important;">


    @php
        if (empty($invoice_lang)) {
            $invoice_lang = request()
            ->session()
            ->get('language');
        }
    @endphp

<section>
    @include('layouts.partials.print_header')
    @php
        $logo = App\Models\System::getProperty('logo');
    @endphp
    @if (empty($create_pdf))
        <div id="watermark"><img src="{{ asset('/uploads/' . $logo) }}" alt=""></div>
    @endif
    <div class="row">
        <div class="col-md-6" style="width: 50%;@if (!empty($create_pdf)) float:left; @endif">
            <div class="col-md-12">
                <h5>@lang('lang.date'): {{ now()->format('Y-m-d') }}</h5>
                {{-- <h5>@lang('lang.store'): {{ $sale->store->name ?? '' }}</h5> --}}
            </div>
        </div>
    </div>
    <div class="description pt-3">
        <!-- ++++++++++++++++++ system info +++++++++++++ -->
        <div style="border: 2px dashed #000; justify-content: center;">

            <div class="row">
                <div class="col-sm-12 text-center">
                    <h1>
                        @lang('lang.invoice_title1') <br/>
                        @lang('lang.invoice_title2')
                    </h1>
                   
                </div>
            </div>

            <div class="row pl-2 pr-2">
                <div class="col-sm-6 pl-3">
                    @php
                        $watsapp_numbers = App\Models\System::getProperty('watsapp_numbers');
                    @endphp
                    <p class="text-left">
                        <b>@lang('lang.invoice_address_en') </b>
                        
                        
                    </p>
                </div>
                <div class="col-sm-6 pr-3">
                    <p class="text-right">
                        <b>@lang('lang.invoice_address_ar') </b><br>
                        <b>@lang('lang.contact_number') : {{$watsapp_numbers }}</b>
                    </p>
                </div>
            </div>
        </div>
        <br/><br/>
        <!-- ++++++++++++++++++ invoice info +++++++++++++  -->
        <div>
            <!-- ======== row 1 ========  -->
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h1> @lang('lang.invoice')</h1>
                </div>
            </div>
            <!-- ======== row 2 ========  -->
            <div class="row">
                <div class="col-sm-4">
                    <p>
                        <b> @lang('lang.invoice_no') </b> : 1
                    </p>
                </div>
                <div class="col-sm-4">
                    <p>
                        <b> @lang('lang.payment_status') </b> : @lang('lang.'.$transaction->payment_status)
                    </p>
                </div>
                <div class="col-sm-4">
                    <p>
                        <b>@lang('lang.date_and_time') </b> : {{$transaction->transaction_date}}
                    </p>
                </div>
            </div>
            <!-- ======== row 3 ========  -->
            <div class="row">
                <div class="col-sm-4">
                    <p class="text-left">
                        <b>@lang('lang.phone') </b> : <span style="text-decoration: underline"> {{$transaction->customer->phone}} </span>
                    </p>
                </div>

                <div class="col-sm-4">
                    <p class="text-center">
                       <span style="text-decoration: underline"> Address is {{$transaction->customer->address}} </span>  :
                       <b>@lang('lang.address')</b>
                    </p>
                </div>

                <div class="col-sm-4">
                    <p class="text-right">
                        <span style="text-decoration: underline">{{$transaction->customer->name}}</span>
                        <b> : @lang('lang.dear')  @lang('lang.respected') </b>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- +++++++++++++++++++++++++ Invoice Table +++++++++++++++++++++++++  -->
    <div class="invoice">
        <table class="content_table">
            <thead style="background-color:#DDD !important;">
                <th style="width:10%;text-align: center">@lang('lang.total')</th>
                <th style="width:10%;text-align: center">@lang('lang.price_of_piece')</th>
                <th style="width:10%;text-align: center">@lang('lang.quantity')</th>
                <th style="width:10%;text-align: center">@lang('lang.extra_quantity')</th>
                <th style="width:10%;text-align: center">@lang('lang.carton')</th>
                <th style="width:40%;text-align: center">@lang('lang.description')</th>
                <th style="width:10%;text-align: center">@lang('lang.notes')</th>
            </thead>
            <tbody>
                @foreach ($transaction->transaction_sell_lines as $line)
                    <tr style="text-align: center;">
                        <td style="text-align: center;background-color: #dddddd !important;">{{number_format($line->sub_total,2)}}</td>
                        <td style="text-align: center;background-color: #dddddd !important;">
                            @if(!empty($line->dollar_sell_price))
                                {{number_format($line->dollar_sell_price * $line->exchange_rate,2)}}
                            @else
                                {{$line->sell_price}}
                            @endif
                        </td>
                        <td style="text-align: center;">{{$line->quantity??0}}</td>
                        <td style="text-align: center;">{{$line->extra_quantity??0}}</td>
                        <td style="text-align: center">{{number_format($line->quantity??0 + $line->extra_quantity??0,2)}}</td>
                        <td style="text-align: center"> {{$line->product->name}}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex" style="flex-wrap: wrap; justify-content: space-between">
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%;">
            <tr style="text-align: center;">
                @if($transaction->customer->balance < 0)
                    <td style="text-align: center;"> {{$transaction->customer->balance + ($transaction->final_total - $transaction->transaction_payments->where('received_currency' ,'!=',2)->sum('amount'))}}</td>
                @else
                    <td style="text-align: center;"> {{$transaction->customer->balance - ($transaction->final_total - $transaction->transaction_payments->where('received_currency' ,'!=',2)->sum('amount'))}}</td>
                @endif
                <td style="background-color: #CACACA; width: 50%;text-align: center;"> @lang('lang.previous_balance') </td>
            </tr>
        </table>
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%">
            <tr style="text-align: center;">
                <td style="text-align: center;"> {{$transaction->final_total}}</td>
                <td style="background-color: #CACACA;width: 50%;text-align: center;"> @lang('lang.total_after_discount') </td>
            </tr>
        </table>
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%;">
            <tr style="text-align: center;">
                <td style="text-align: center;"> {{$transaction->discount_value}}</td>
                <td style="background-color: #CACACA; width: 50%;text-align: center;"> @lang('lang.discount') </td>
            </tr>
        </table>
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%;">
            <tr style="text-align: center;">
                <td style="text-align: center;"> {{$transaction->grand_total}}</td>
                <td style="background-color: #CACACA; width: 50%;text-align: center;"> @lang('lang.total') </td>
            </tr>
        </table>
    </div>

    <div class="d-flex" style="flex-wrap: wrap; justify-content: space-between">
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%;">
            <tr style="text-align: center;">
                <td style="text-align: center;"> {{$transaction->customer->balance}}</td>
                <td style="background-color: #CACACA; width: 50%;text-align: center;"> @lang('lang.remaining_balance') </td>
            </tr>
        </table>
        @if(!empty($transaction->delivery))
            <table style="border-collapse: collapse; margin-top: 20px; width: 23%;">
                <tr style="text-align: center;">
                    <td style="text-align: center;"> {{$transaction->delivery_cost??''}}</td>
                    <td style="background-color: #CACACA; width: 50%;text-align: center;"> @lang('lang.delivery') : ({{!empty($transaction->delivery)?$transaction->delivery->employee_name:''}}) </td>
                </tr>
            </table>
        @endif
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%">
            <tr style="text-align: center;">
                <td style="text-align: center;"> {{$transaction->store->name}}</td>
                <td style="background-color: #CACACA;width: 50%;text-align: center;"> @lang('lang.store') </td>
            </tr>
        </table>
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%;">
            <tr style="text-align: center;">
                <td style="text-align: center;"> {{$transaction->transaction_payments->where('received_currency' ,2)->sum('amount')}}</td>
                <td style="background-color: #CACACA;width: 50%;text-align: center;"> @lang('lang.dollar') </td>
            </tr>
        </table>
        <table style="border-collapse: collapse; margin-top: 20px; width: 23%;">
            <tr style="text-align: center;">
                <td style="text-align: center;"> {{$transaction->transaction_payments->where('received_currency' ,'!=',2)->sum('amount')}}</td>
                <td style="background-color: #CACACA;width: 50%;text-align: center;"> @lang('lang.dinar') </td>
            </tr>
        </table>


    </div>

</section>


</body>

</html>
@extends('layouts.app')
@section('title', __('lang.invoice_no'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.stock')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('stocks.index')}}">@lang('lang.stock')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.view')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a type="button" class="btn btn-primary" href="{{route('stocks.index')}}">@lang('lang.stock')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="forms">
        <div class="container-fluid">
            <div class="col-md-12 print-only">
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center no-print">
                            <h4>@lang('lang.invoice_no'): {{$add_stock->invoice_no}}</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    {!! Form::label('supplier_name', __('lang.supplier_name'), []) !!}:
                                    <b>{{$add_stock->supplier->name ?? ''}}</b>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::label('email', __('lang.email'), []) !!}: <b>{{$add_stock->supplier->email ?? ''}}</b>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::label('mobile_number', __('lang.mobile_number'), []) !!}:
                                    <b>{{$add_stock->supplier->mobile_number ?? ''}}</b>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::label('address', __('lang.address'), []) !!}: <b>{{$add_stock->supplier->address ?? ''}}</b>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::label('store', __('lang.store'), []) !!}: <b>{{$add_stock->store->name ??
                                    ''}}</b>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::label('store', __('lang.paying_currency'), []) !!}: <b>{{$add_stock->paying_currency_relationship()->first()->currency ??''}}</b>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::label('store', __('lang.exchange_rate'), []) !!}: <b>{{$add_stock->transaction_payments()->latest()->first()->exchange_rate ??''}}</b>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::label('store', __('lang.divide_costs'), []) !!}: <b>{{$add_stock->divide_costs ??''}}</b>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped table-condensed" id="product_table">
                                        <thead>
                                        <tr>
                                            <th style="width: 15%" class="col-sm-8">@lang( 'lang.products' )</th>
                                            <th style="width: 15%" class="col-sm-4">@lang( 'lang.sku' )</th>
                                            <th style="width: 10%" class="col-sm-4">@lang( 'lang.quantity' )</th>
                                            <th style="width: 12%" class="col-sm-4">@lang( 'lang.purchase_price' )</th>
                                            <th style="width: 12%" class="col-sm-4">@lang( 'lang.purchase_price' ) $</th>
                                            <th style="width: 12%" class="col-sm-4">@lang( 'lang.final_cost' )</th>
                                            <th style="width: 12%" class="col-sm-4">@lang( 'lang.final_cost' ) $</th>
                                            <th style="width: 12%" class="col-sm-4">@lang( 'lang.sub_total' )</th>
                                            <th style="width: 12%" class="col-sm-4">@lang( 'lang.sub_total' ) $</th>
                                            <th style="width: 12%" class="col-sm-4">@lang( 'lang.expiry_date' )</th>
                                            <th style="width: 12%" class="col-sm-4">@lang(
                                                'lang.days_before_the_expiry_date' )</th>
                                            <th style="width: 12%" class="col-sm-4">@lang( 'lang.convert_status_expire'
                                                )</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($add_stock->add_stock_lines as $line)
                                            <tr>
                                                <td>
                                                    {{$line->product->name ?? ''}}

                                                    @if(!empty($line->variation))
                                                        @if($line->variation->name != "Default")
                                                            <b>{{$line->variation->name}}</b>
                                                        @endif
                                                    @endif
                                                    @if(empty($line->variation) && empty($line->product))
                                                        <span class="text-red">@lang('lang.deleted')</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$line->product->sku}}
                                                </td>
                                                <td>
                                                    @if(isset($line->quantity)){{number_format($line->quantity,App\Models\System::getProperty('num_of_digital_numbers()'))}}@else{{1}}@endif
                                                </td>
                                                <td>
                                                    @if(isset($line->purchase_price)){{@num_format($line->purchase_price)}}@else{{0}}@endif
                                                </td>
                                                <td>
                                                    @if(isset($line->dollar_purchase_price)){{@num_format($line->dollar_purchase_price)}}@else{{0}}@endif
                                                </td>
                                                <td>
                                                    @if(isset($line->final_cost)){{@num_format($line->final_cost)}}@else{{0}}@endif
                                                </td>
                                                <td>
                                                    @if(isset($line->dollar_final_cost)){{@num_format($line->dollar_final_cost)}}@else{{0}}@endif
                                                </td>
                                                <td>
                                                    {{number_format($line->sub_total,num_of_digital_numbers()) }}
                                                </td>
                                                <td>
                                                    {{number_format($line->dollar_sub_total,num_of_digital_numbers()) }}
                                                </td>
{{--                                                <td>{{$line->batch_number}}</td>--}}
{{--                                                <td>@if(!empty($line->manufacturing_date)){{@format_date($line->manufacturing_date)}}@endif--}}
                                                </td>
                                                <td>@if(!empty($line->expiry_date)){{@format_date($line->expiry_date)}}@endif
                                                </td>
                                                <td>{{$line->expiry_warning}}</td>
                                                <td>{{$line->convert_status_expire}}</td>
                                            </tr>
                                            @foreach($line->prices as $price)
                                                <tr>
                                                    <td>
                                                        {!! Form::label('price' ,__('lang.quantity').': ') !!}
                                                        {{ $price->quantity ?? '' }}
                                                    </td>
                                                    <td>
                                                        {!! Form::label('price_category' ,__('lang.price_category').': ') !!}
                                                        {{ $price->price_category ?? '' }}
                                                    </td>
                                                    <td>
                                                        {!! Form::label('b_qty',__('lang.b_qty').': ') !!}
                                                        {{ $price->bonus_quantity ?? '' }}
                                                    </td>
                                                    <td>
                                                        {!! Form::label('price_type' ,__('lang.type').': ') !!}
                                                        {{ $price_customer_types ?? '' }}

                                                    </td>
                                                    <td>
                                                        {!! Form::label('price' ,!empty($price->price_type) && $price->price_type == 'fixed' ? __('lang.amount').'$: ' : __('lang.percent').'$: ') !!}
                                                        {{ $price->price_after_desc ?? '' }}<br>
                                                        {!! Form::label('price' ,!empty($price->price_type) && $price->price_type == 'fixed' ? __('lang.amount').': ' : __('lang.percent').': ') !!}
                                                        {{ $price->dinar_price_after_desc ?? '' }}
                                                    </td>
                                                    <td>
                                                        {!! Form::label('total_price' , __('lang.total_price').'$: ') !!}
                                                        {{ $price->total_price }}<br>
                                                        {!! Form::label('total_price' , __('lang.total_price').': ') !!}
                                                        {{ $price->dinar_total_price }}
                                                    </td>
                                                    <td>
                                                        {!! Form::label('piece_price' , __('lang.piece_price').'$: ') !!}
                                                        {{ $price->piece_price }}<br>
                                                        {!! Form::label('piece_price' , __('lang.piece_price').': ') !!}
                                                        {{ $price->dinar_piece_price }}
                                                    </td>
                                                    <td>
                                                        {!! Form::label('customer_type',__('lang.customer_type').': ') !!}
                                                        {{ is_array($price->price_customer_types) ? implode(', ', $price->price_customer_types) : $price->price_customer_types }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3 offset-md-8 text-right">
                                    <h3> @lang('lang.total'): <span
                                            class="final_total_span">{{@num_format($add_stock->add_stock_lines->sum('sub_total'))}}</span>
                                    </h3>

                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    {!! Form::label('other_expenses', __('lang.other_expenses'), []) !!}:
                                    <b>{{@num_format($add_stock->other_expenses)}}</b>
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('discount_amount', __('lang.discount'), []) !!}:
                                    <b>{{@num_format($add_stock->discount_amount)}}</b>
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('other_payments', __('lang.other_payments'), []) !!}:
                                    <b>{{@num_format($add_stock->other_payments)}}</b>
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('source_of_payment', __('lang.source_of_payment'), []) !!}:
                                    <b>{{$add_stock->source_name}}</b>
                                </div>
                            </div>
                            <br>
                            <br>
                            @include('transaction_payment.partials.payment_table', ['payments' =>$add_stock->transaction_payments])

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('notes', __('lang.notes'), []) !!}: <br>
                                        {{$add_stock->notes}}

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('files', __('lang.files'), []) !!}: <br>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 print-only">
            </div>
        </div>


    </section>
@endsection

@push('javascripts')
    <script type="text/javascript">
        @if(!empty(request()->print))
        $(document).ready(function(){
            setTimeout(() => {
                window.print();
            }, 1000);
        })
        @endif
    </script>
@endpush

@extends('layouts.app')
@section('title', __('lang.initial_balance'))

@section('page_title')
    @lang('lang.initial_balance')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
            style="text-decoration: none;color: #596fd7" href="{{ route('initial-balance.index') }}">/ @lang('lang.initial_balance')</a>
    </li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.show_initial_balance')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a type="button" class="btn btn-primary" href="{{ route('initial-balance.index') }}">@lang('lang.initial_balance')</a>
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
                        <div
                            class="card-header d-flex align-items-center no-print @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                            <h6>@lang('lang.invoice_no') {{ $add_stock->invoice_no }}</h6>
                        </div>

                        <div class="card-body">
                            <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div
                                    class="col-md-4 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                    {!! Form::label('supplier_name', __('lang.supplier_name'), ['class' => 'mb-0']) !!}:
                                    <b>{{ $add_stock->supplier->name ?? '' }}</b>
                                </div>
                                <div
                                    class="col-md-4
                                    d-flex mb-2 align-items-center
                                    @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label('email', __('lang.email'), ['class' => 'mb-0']) !!}: <b>{{ $add_stock->supplier->email ?? '' }}</b>
                                </div>
                                <div
                                    class="col-md-4 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                    {!! Form::label('mobile_number', __('lang.mobile_number'), ['class' => 'mb-0']) !!}:
                                    <b>{{ $add_stock->supplier->mobile_number ?? '' }}</b>
                                </div>
                                <div
                                    class="col-md-4
                                    d-flex mb-2 align-items-center
                                    @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label('address', __('lang.address'), ['class' => 'mb-0']) !!}: <b>{{ $add_stock->supplier->address ?? '' }}</b>
                                </div>
                                <div
                                    class="col-md-4 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                    {!! Form::label('store', __('lang.store'), ['class' => 'mb-0']) !!}:
                                    <b>{{ $add_stock->store->name . ' ( ' . $add_stock->store->branch->name . ' ) ' ?? '' }}</b>
                                </div>
                                <div
                                    class="col-md-4
                                    d-flex mb-2 align-items-center
                                    @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label('store', __('lang.paying_currency'), ['class' => 'mb-0']) !!}:
                                    <b>{{ $add_stock->paying_currency_relationship()->first()->currency ?? '' }}</b>
                                </div>
                                <div
                                    class="col-md-4 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                    {!! Form::label('store', __('lang.exchange_rate'), ['class' => 'mb-0']) !!}:
                                    <b>{{ $add_stock->transaction_payments()->latest()->first()->exchange_rate ?? '' }}</b>
                                </div>
                                <div
                                    class="col-md-4
                                    d-flex mb-2 align-items-center
                                    @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label('store', __('lang.divide_costs'), ['class' => 'mb-0']) !!}: <b>{{ $add_stock->divide_costs ?? '' }}</b>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                                        <table class="table table-bordered table-hover table-striped table-condensed"
                                            id="product_table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 15%" class="col-sm-8">@lang('lang.products')</th>
                                                    <th style="width: 15%" class="col-sm-4">@lang('lang.sku')</th>
                                                    <th style="width: 10%" class="col-sm-4">@lang('lang.quantity')</th>
                                                    <th style="width: 12%" class="col-sm-4">@lang('lang.purchase_price')</th>
                                                    <th style="width: 12%" class="col-sm-4 dollar-cell">@lang('lang.purchase_price') $
                                                    </th>
                                                    <th style="width: 12%" class="col-sm-4">@lang('lang.final_cost')</th>
                                                    <th style="width: 12%" class="col-sm-4 dollar-cell">@lang('lang.final_cost') $
                                                    </th>
                                                    <th style="width: 12%" class="col-sm-4">@lang('lang.sub_total')</th>
                                                    <th style="width: 12%" class="col-sm-4 dollar-cell">@lang('lang.sub_total') $
                                                    </th>
                                                    <th style="width: 12%" class="col-sm-4">@lang('lang.expiry_date')</th>
                                                    <th style="width: 12%" class="col-sm-4">@lang('lang.days_before_the_expiry_date')</th>
                                                    <th style="width: 12%" class="col-sm-4">@lang('lang.convert_status_expire')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($add_stock->add_stock_lines as $line)
                                                    <tr>
                                                        <td>
                                                            <span class="d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600">

                                                                {{ $line->product->name ?? '' }}

                                                                @if (!empty($line->variation))
                                                                    @if ($line->variation->name != 'Default')
                                                                        <b>{{ $line->variation->name }}</b>
                                                                    @endif
                                                                @endif
                                                                @if (empty($line->variation) && empty($line->product))
                                                                    <span class="text-red">@lang('lang.deleted')</span>
                                                                @endif
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <span class="d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ $line->product->sku }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                @if (isset($line->quantity))
                                                                    {{ number_format($line->quantity, num_of_digital_numbers()) }}@else{{ 1 }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                @if (isset($line->purchase_price))
                                                                    {{ @num_format($line->purchase_price) }}@else{{ 0 }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td class="dollar-cell">
                                                            <span class="d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                @if (isset($line->dollar_purchase_price))
                                                                    {{ @num_format($line->dollar_purchase_price) }}@else{{ 0 }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                @if (isset($line->final_cost))
                                                                    {{ @num_format($line->final_cost) }}@else{{ 0 }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td class="dollar-cell">
                                                            <span class="d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                @if (isset($line->dollar_final_cost))
                                                                    {{ @num_format($line->dollar_final_cost) }}@else{{ 0 }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ number_format($line->sub_total, num_of_digital_numbers()) }}
                                                            </span>
                                                        </td>
                                                        <td class="dollar-cell">
                                                            <span class="d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ number_format($line->dollar_sub_total, num_of_digital_numbers()) }}
                                                            </span>
                                                        </td>
                                                        {{--                                                <td>{{$line->batch_number}}</td> --}}
                                                        {{--                                                <td>@if (!empty($line->manufacturing_date)){{@format_date($line->manufacturing_date)}}@endif --}}
                                                        </td>
                                                        <td>
                                                            <span class="d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                @if (!empty($line->expiry_date))
                                                                    {{ @format_date($line->expiry_date) }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ $line->expiry_warning }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ $line->convert_status_expire }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @foreach ($line->prices as $price)
                                                        <tr>
                                                            <td>
                                                                <span
                                                                    class="d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600">
                                                                    {!! Form::label('price', __('lang.quantity') . ': ', [
                                                                        'style' => 'font-size: 12px;',
                                                                    ]) !!}
                                                                    {{ $price->quantity ?? '' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600">

                                                                    {!! Form::label('price_category', __('lang.price_category') . ': ', [
                                                                        'style' => 'font-size: 12px;',
                                                                    ]) !!}
                                                                    {{ $price->price_category ?? '' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600">
                                                                    {!! Form::label('b_qty', __('lang.b_qty') . ': ', [
                                                                        'style' => 'font-size: 12px;',
                                                                    ]) !!}
                                                                    {{ $price->bonus_quantity ?? '' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600">
                                                                    {!! Form::label('price_type', __('lang.type') . ': ', [
                                                                        'style' => 'font-size: 12px;',
                                                                    ]) !!}
                                                                    {{ $price_customer_types ?? '' }}
                                                                </span>

                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600">
                                                                    <span class="dollar-cell">

                                                                        {!! Form::label(
                                                                            'price',
                                                                            !empty($price->price_type) && $price->price_type == 'fixed'
                                                                                ? __('lang.amount') . '$: '
                                                                                : __('lang.percent') . '$: ',
                                                                            [
                                                                                'style' => 'font-size: 12px;',
                                                                            ],
                                                                        ) !!}
                                                                        {{ $price->price_after_desc ?? '' }}<br>
                                                                    </span>
                                                                    {!! Form::label(
                                                                        'price',
                                                                        !empty($price->price_type) && $price->price_type == 'fixed' ? __('lang.amount') . ': ' : __('lang.percent') . ': ',
                                                                        [
                                                                            'style' => 'font-size: 12px;',
                                                                        ],
                                                                    ) !!}
                                                                    {{ $price->dinar_price_after_desc ?? '' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600">
                                                                    <span class="dollar-cell">

                                                                        {!! Form::label('total_price', __('lang.total_price') . '$: ', [
                                                                            'style' => 'font-size: 12px;',
                                                                        ]) !!}
                                                                        {{ $price->total_price }}<br>
                                                                    </span>
                                                                    {!! Form::label('total_price', __('lang.total_price') . ': ', [
                                                                        'style' => 'font-size: 12px;',
                                                                    ]) !!}
                                                                    {{ $price->dinar_total_price }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600">
                                                                    <span class="dollar-cell">

                                                                        {!! Form::label('piece_price', __('lang.piece_price') . '$: ', [
                                                                            'style' => 'font-size: 12px;',
                                                                        ]) !!}
                                                                        {{ $price->piece_price }}<br>
                                                                    </span>
                                                                    {!! Form::label('piece_price', __('lang.piece_price') . ': ', [
                                                                        'style' => 'font-size: 12px;',
                                                                    ]) !!}
                                                                    {{ $price->dinar_piece_price }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600">

                                                                    {!! Form::label('customer_type', __('lang.customer_type') . ': ', [
                                                                        'style' => 'font-size: 12px;',
                                                                    ]) !!}
                                                                    {{ is_array($price->price_customer_types) ? implode(', ', $price->price_customer_types) : $price->price_customer_types }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3 offset-md-8 text-right">
                                    <h3> @lang('lang.total'): <span
                                            class="final_total_span">{{ @num_format($add_stock->add_stock_lines->sum('sub_total')) }}</span>
                                    </h3>

                                </div>
                            </div>

                            <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div
                                    class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                    {!! Form::label('other_expenses', __('lang.other_expenses'), [
                                        'style' => 'font-size: 12px;font-weight:600;margin-bottom:0',
                                    ]) !!}:
                                    <b>{{ @num_format($add_stock->other_expenses) }}</b>
                                </div>
                                <div
                                    class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                    {!! Form::label('discount_amount', __('lang.discount'), [
                                        'style' => 'font-size: 12px;font-weight:600;margin-bottom:0',
                                    ]) !!}:
                                    <b>{{ @num_format($add_stock->discount_amount) }}</b>
                                </div>
                                <div
                                    class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                    {!! Form::label('other_payments', __('lang.other_payments'), [
                                        'style' => 'font-size: 12px;font-weight:600;margin-bottom:0',
                                    ]) !!}:
                                    <b>{{ @num_format($add_stock->other_payments) }}</b>
                                </div>
                                <div
                                    class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                    {!! Form::label('source_of_payment', __('lang.source_of_payment'), [
                                        'style' => 'font-size: 12px;font-weight:600;margin-bottom:0',
                                    ]) !!}:
                                    <b>{{ $add_stock->source_name }}</b>
                                </div>
                            </div>

                            @include('transaction_payment.partials.payment_table', [
                                'payments' => $add_stock->transaction_payments,
                            ])

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('notes', __('lang.notes'), ['class' => 'text-end d-block']) !!}: <br>
                                        {{ $add_stock->notes }}

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('files', __('lang.files'), ['class' => 'text-end d-block']) !!}: <br>

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
        @if (!empty(request()->print))
            $(document).ready(function() {
                setTimeout(() => {
                    window.print();
                }, 1000);
            })
        @endif
    </script>
@endpush

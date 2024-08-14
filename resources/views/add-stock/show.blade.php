@extends('layouts.app')
@section('title', __('lang.invoice_no'))

@section('page_title')
@lang('lang.stock')
@endsection

@section('breadcrumbs')
@parent
<li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
        style="text-decoration: none;color: #596fd7" href="{{ route('stocks.index') }}">@lang('lang.stock')</a></li>
<li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
    @lang('lang.view')</li>
@endsection

@section('button')
<div class="widgetbar">
    <a type="button" class="btn btn-primary" href="{{ route('stocks.index') }}">@lang('lang.stock')</a>
</div>
@endsection

@section('content')
<div class="animate-in-page">
    <section class="forms">
        <div class="container-fluid">
            <div class="col-md-12 print-only">
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div
                            class="card-header  d-flex align-items-center no-print @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                            <h6>@lang('lang.invoice_no'): {{ $add_stock->invoice_no }}</h6>
                        </div>

                        <div class="card-body">
                            <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div class="col-md-4 animate__animated animate__bounceInLeft d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                    style="animation-delay: 1.15s">
                                    {!! Form::label('supplier_name', __('lang.supplier_name'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 width-quarter' : '
                                    mx-2 mb-0 h5 width-quarter',
                                    'style' => 'font-size: 16px;font-weight: 500;',
                                    ]) !!}:
                                    <b>{{ $add_stock->supplier->name ?? '' }}</b>
                                </div>
                                <div class="col-md-4 animate__animated animate__bounceInLeft d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                    style="animation-delay: 1.2s">
                                    {!! Form::label('email', __('lang.email'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 width-quarter' : '
                                    mx-2 mb-0 h5 width-quarter',
                                    'style' => 'font-size: 16px;font-weight: 500;',
                                    ]) !!}: <b>{{ $add_stock->supplier->email ?? '' }}</b>
                                </div>
                                <div class="col-md-4 animate__animated animate__bounceInLeft d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                    style="animation-delay: 1.25s">
                                    {!! Form::label('mobile_number', __('lang.mobile_number'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 width-quarter' : '
                                    mx-2 mb-0 h5 width-quarter',
                                    'style' => 'font-size: 16px;font-weight: 500;',
                                    ]) !!}:
                                    <b>{{ $add_stock->supplier->mobile_number ?? '' }}</b>
                                </div>
                                <div class="col-md-4 animate__animated animate__bounceInLeft d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                    style="animation-delay: 1.3s">
                                    {!! Form::label('address', __('lang.address'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 width-quarter' : '
                                    mx-2 mb-0 h5 width-quarter',
                                    'style' => 'font-size: 16px;font-weight: 500;',
                                    ]) !!}: <b>{{ $add_stock->supplier->address ?? '' }}</b>
                                </div>
                                <div class="col-md-4 animate__animated animate__bounceInLeft d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                    style="animation-delay: 1.35s">
                                    {!! Form::label('store', __('lang.store'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 width-quarter' : '
                                    mx-2 mb-0 h5 width-quarter',
                                    'style' => 'font-size: 16px;font-weight: 500;',
                                    ]) !!}:
                                    <b>{{ $add_stock->store->name ?? '' }}</b>
                                </div>
                                <div class="col-md-4 animate__animated animate__bounceInLeft d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                    style="animation-delay: 1.4s">
                                    {!! Form::label('store', __('lang.paying_currency'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 width-quarter' : '
                                    mx-2 mb-0 h5 width-quarter',
                                    'style' => 'font-size: 16px;font-weight: 500;',
                                    ]) !!}:
                                    <b>{{ $add_stock->paying_currency_relationship()->first()->currency ?? '' }}</b>
                                </div>
                                <div class="col-md-4 animate__animated animate__bounceInLeft d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                    style="animation-delay: 1.45s">
                                    {!! Form::label('store', __('lang.exchange_rate'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 width-quarter' : '
                                    mx-2 mb-0 h5 width-quarter',
                                    'style' => 'font-size: 16px;font-weight: 500;',
                                    ]) !!}:
                                    <b>{{ $add_stock->transaction_payments()->latest()->first()->exchange_rate ?? ''
                                        }}</b>
                                </div>
                                <div class="col-md-4 animate__animated animate__bounceInLeft d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                    style="animation-delay: 1.5s">
                                    {!! Form::label('store', __('lang.divide_costs'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 width-quarter' : '
                                    mx-2 mb-0 h5 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}: <b>{{ $add_stock->divide_costs ?? '' }}</b>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <table
                                        class="table table-bordered table-hover table-striped table-condensed @if (app()->isLocale('ar')) dir-rtl @endif"
                                        id="product_table">
                                        <thead>
                                            <tr>
                                                <th style="width: 15%" class="col-sm-8">@lang('lang.products')</th>
                                                <th style="width: 15%" class="col-sm-4">@lang('lang.sku')</th>
                                                <th style="width: 10%" class="col-sm-4">@lang('lang.quantity')</th>
                                                <th style="width: 12%" class="col-sm-4">@lang('lang.purchase_price')
                                                </th>
                                                <th style="width: 12%" class="col-sm-4 dollar-cell showHideDollarCells">
                                                    @lang('lang.purchase_price') $
                                                </th>
                                                <th style="width: 12%" class="col-sm-4">@lang('lang.final_cost')</th>
                                                <th style="width: 12%" class="col-sm-4 dollar-cell showHideDollarCells">
                                                    @lang('lang.final_cost') $
                                                </th>
                                                <th style="width: 12%" class="col-sm-4">@lang('lang.sub_total')</th>
                                                <th style="width: 12%" class="col-sm-4 dollar-cell showHideDollarCells">
                                                    @lang('lang.sub_total') $
                                                </th>
                                                <th style="width: 12%" class="col-sm-4">@lang('lang.expiry_date')</th>
                                                <th style="width: 12%" class="col-sm-4">
                                                    @lang('lang.days_before_the_expiry_date')</th>
                                                <th style="width: 12%" class="col-sm-4">
                                                    @lang('lang.convert_status_expire')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($add_stock->add_stock_lines as $line)
                                            <tr>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.products')">
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
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.sku')">
                                                        {{ $line->product->sku }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.quantity')">

                                                        @if (isset($line->quantity))
                                                        {{ number_format($line->quantity,
                                                        App\Models\System::getProperty('num_of_digital_numbers()'))
                                                        }}@else{{ 1 }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.purchase_price')">
                                                        @if (isset($line->purchase_price))
                                                        {{ @num_format($line->purchase_price) }}@else{{ 0 }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="dollar-cell showHideDollarCells">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.purchase_price')$">
                                                        @if (isset($line->dollar_purchase_price))
                                                        {{ @num_format($line->dollar_purchase_price) }}@else{{ 0 }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.final_cost')">
                                                        @if (isset($line->final_cost))
                                                        {{ @num_format($line->final_cost) }}@else{{ 0 }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="dollar-cell showHideDollarCells">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.final_cost')$">
                                                        @if (isset($line->dollar_final_cost))
                                                        {{ @num_format($line->dollar_final_cost) }}@else{{ 0 }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.sub_total')">
                                                        {{ number_format($line->sub_total, num_of_digital_numbers()) }}
                                                    </span>
                                                </td>
                                                <td class="dollar-cell showHideDollarCells">
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.sub_total')$">
                                                        {{ number_format($line->dollar_sub_total,
                                                        num_of_digital_numbers()) }}
                                                    </span>
                                                </td>
                                                {{-- <td>{{$line->batch_number}}</td> --}}
                                                {{-- <td>@if
                                                    (!empty($line->manufacturing_date)){{@format_date($line->manufacturing_date)}}@endif
                                                </td> --}}
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.expiry_date')">
                                                        @if (!empty($line->expiry_date))
                                                        {{ @format_date($line->expiry_date) }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.days_before_the_expiry_date')">
                                                        {{ $line->expiry_warning }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.convert_status_expire')">
                                                        {{ $line->convert_status_expire }}
                                                    </span>
                                                </td>
                                            </tr>

                                            @foreach ($line->prices as $price)
                                            <tr>
                                                <td>
                                                    {!! Form::label('price', __('lang.quantity') . ': ') !!}
                                                    {{ $price->quantity ?? '' }}
                                                </td>
                                                <td>
                                                    {!! Form::label('price_category', __('lang.price_category') . ': ')
                                                    !!}
                                                    {{ $price->price_category ?? '' }}
                                                </td>
                                                <td>
                                                    {!! Form::label('b_qty', __('lang.b_qty') . ': ') !!}
                                                    {{ $price->bonus_quantity ?? '' }}
                                                </td>
                                                <td>
                                                    {!! Form::label('price_type', __('lang.type') . ': ') !!}
                                                    {{ $price_customer_types ?? '' }}

                                                </td>
                                                <td>
                                                    <span class="dollar-cell showHideDollarCells">

                                                        {!! Form::label(
                                                        'price',
                                                        !empty($price->price_type) && $price->price_type == 'fixed'
                                                        ? __('lang.amount') . '$: '
                                                        : __('lang.percent') . '$: ',
                                                        ) !!}
                                                        {{ $price->price_after_desc ?? '' }}<br>
                                                    </span>
                                                    {!! Form::label(
                                                    'price',
                                                    !empty($price->price_type) && $price->price_type == 'fixed' ?
                                                    __('lang.amount') . ': ' : __('lang.percent') . ': ',
                                                    ) !!}
                                                    {{ $price->dinar_price_after_desc ?? '' }}
                                                </td>
                                                <td>
                                                    <span class="dollar-cell showHideDollarCells">
                                                        {!! Form::label('total_price', __('lang.total_price') . '$: ')
                                                        !!}
                                                        {{ $price->total_price }}<br>
                                                    </span>
                                                    {!! Form::label('total_price', __('lang.total_price') . ': ') !!}
                                                    {{ $price->dinar_total_price }}
                                                </td>
                                                <td>
                                                    <span class="dollar-cell showHideDollarCells">
                                                        {!! Form::label('piece_price', __('lang.piece_price') . '$: ')
                                                        !!}
                                                        {{ $price->piece_price }}<br>
                                                    </span>
                                                    {!! Form::label('piece_price', __('lang.piece_price') . ': ') !!}
                                                    {{ $price->dinar_piece_price }}
                                                </td>
                                                <td>
                                                    {!! Form::label('customer_type', __('lang.customer_type') . ': ')
                                                    !!}
                                                    {{ is_array($price->price_customer_types) ? implode(', ',
                                                    $price->price_customer_types) : $price->price_customer_types }}
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="text-center">
                                    <h3> @lang('lang.total'): <span class="final_total_span">{{
                                            @num_format($add_stock->add_stock_lines->sum('sub_total')) }}</span>
                                    </h3>

                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row mb-3 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div
                                    class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                    {!! Form::label('other_expenses', __('lang.other_expenses'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 width-quarter' : '
                                    mx-2 mb-0 h5 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}:
                                    <b>{{ @num_format($add_stock->other_expenses) }}</b>
                                </div>
                                <div
                                    class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                    {!! Form::label('discount_amount', __('lang.discount'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 width-quarter' : '
                                    mx-2 mb-0 h5 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}:
                                    <b>{{ @num_format($add_stock->discount_amount) }}</b>
                                </div>
                                <div
                                    class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                    {!! Form::label('other_payments', __('lang.other_payments'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 width-quarter' : '
                                    mx-2 mb-0 h5 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}:
                                    <b>{{ @num_format($add_stock->other_payments) }}</b>
                                </div>
                                <div
                                    class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                    {!! Form::label('source_of_payment', __('lang.source_of_payment'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 width-quarter' : '
                                    mx-2 mb-0 h5 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
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
                                        {!! Form::label('notes', __('lang.notes'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 ' : ' mx-2
                                        mb-0 h5 ',
                                        'style' => 'font-size: 16px;font-weight: 500;',
                                        ]) !!}: <br>
                                        {{ $add_stock->notes }}

                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div>
                                    {!! Form::label('files', __('lang.files'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 ' : ' mx-2 mb-0 h5
                                    ',
                                    'style' => 'font-size: 16px;font-weight: 500;',
                                    ]) !!}: <br>
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
</div>

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

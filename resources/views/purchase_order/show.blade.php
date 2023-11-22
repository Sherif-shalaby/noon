@extends('layouts.app')
@section('title', __('lang.purchase_order'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="animate__animated  animate__backInRight">
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.show_purchase_order')</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7"
                                    href="{{ route('purchase_order.index') }}">/ @lang('lang.purchase_order')</a>
                            </li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.view')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div
                        class="widgetbar  d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <a type="button" class="btn btn-primary"
                            href="{{ route('purchase_order.index') }}">@lang('lang.purchase_order')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="animate-in-page">
        <section class="forms mt-4">
            <div class="container-fluid">
                <div class="col-md-12 print-only">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div
                                class="card-header d-flex align-items-center no-print @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                                <h4>@lang('lang.purchase_order'): {{ $purchase_order->po_no }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <div class="col-md-4 animate__animated animate__flipInX d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                        style="animation-delay: 1.15s">
                                        {!! Form::label('supplier_name', __('lang.supplier_name'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : ' mx-2 mb-0 h5 width-quarter',
                                            'style' => 'font-size: 16px;font-weight: 500;',
                                        ]) !!}:
                                        <b>
                                            @if (!empty($purchase_order->supplier))
                                                {{ $purchase_order->supplier->name }}
                                            @endif
                                        </b>
                                    </div>
                                    <div class="col-md-4 animate__animated animate__flipInX d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                        style="animation-delay: 1.2s">
                                        {!! Form::label('email', __('lang.email'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : ' mx-2 mb-0 h5 width-quarter',
                                            'style' => 'font-size: 16px;font-weight: 500;',
                                        ]) !!}: <b>
                                            @if (!empty($purchase_order->supplier))
                                                {{ $purchase_order->supplier->email }}
                                            @endif
                                        </b>
                                    </div>
                                    <div class="col-md-4 animate__animated animate__flipInX d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                        style="animation-delay: 1.25s">
                                        {!! Form::label('mobile_number', __('lang.mobile_number'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : ' mx-2 mb-0 h5 width-quarter',
                                            'style' => 'font-size: 16px;font-weight: 500;',
                                        ]) !!}:
                                        <b>
                                            @if (!empty($purchase_order->supplier))
                                                {{ $purchase_order->supplier->mobile_number }}
                                            @endif
                                        </b>
                                    </div>
                                    <div class="col-md-4 animate__animated animate__flipInX d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                        style="animation-delay: 1.3s">
                                        {!! Form::label('address', __('lang.address'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : ' mx-2 mb-0 h5 width-quarter',
                                            'style' => 'font-size: 16px;font-weight: 500;',
                                        ]) !!}: <b>
                                            @if (!empty($purchase_order->supplier))
                                                {{ $purchase_order->supplier->address }}
                                            @endif
                                        </b>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <table
                                            class="table table-bordered table-hover table-striped table-condensed @if (app()->isLocale('ar')) dir-rtl @endif"
                                            id="product_table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 25%" class="col-sm-8">@lang('lang.products')</th>
                                                    @if (session('system_mode') == 'pos' || session('system_mode') == 'garments' || session('system_mode') == 'supermarket')
                                                        <th style="width: 25%" class="col-sm-4">@lang('lang.sku')</th>
                                                    @endif
                                                    <th style="width: 25%" class="col-sm-4">@lang('lang.quantity')</th>
                                                    <th style="width: 12%" class="col-sm-4">@lang('lang.purchase_price')</th>
                                                    <th style="width: 12%" class="col-sm-4">@lang('lang.sub_total')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($purchase_order->transaction_purchase_order_lines as $line)
                                                    <tr>
                                                        {{-- +++++++ product_name +++++++ --}}
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
                                                            </span>

                                                        </td>
                                                        {{-- +++++++ variation_name +++++++ --}}
                                                        @if (session('system_mode') == 'pos' || session('system_mode') == 'garments' || session('system_mode') == 'supermarket')
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.sku')">

                                                                    @if (!empty($line->variation))
                                                                        @if ($line->variation->name != 'Default')
                                                                            {{ $line->variation->sub_sku }}
                                                                        @else
                                                                            {{ $line->product->sku ?? '' }}
                                                                        @endif
                                                                    @else
                                                                        {{ $line->product->sku ?? '' }}
                                                                    @endif
                                                                </span>
                                                            </td>
                                                        @endif
                                                        {{-- +++++++ quantity +++++++ --}}
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.quantity')">

                                                                @if (isset($line->quantity))
                                                                    {{ $line->quantity }}@else{{ 1 }}
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
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.sub_total')">

                                                                {{ preg_match('/\.\d*[1-9]+/', (string) $line->sub_total) ? $line->sub_total : @num_format($line->sub_total) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class=" text-center">
                                        <h3> @lang('lang.total'): <span
                                                class="final_total_span">{{ @num_format($purchase_order->final_total) }}</span>
                                        </h3>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        {!! Form::label('details', __('lang.details'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0' : ' mx-2 mb-0 h5',
                                            'style' => 'font-size: 12px;font-weight: 500;',
                                        ]) !!}:
                                        {{ $purchase_order->details }}

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

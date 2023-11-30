@extends('layouts.app')
@section('title', __('lang.get_due_report'))
@section('breadcrumbbar')
    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.get_due_report')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">/ @lang('lang.reports')</li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.get_due_report')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">
        <!-- Start Contentbar -->
        <div class="contentbar">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.products')</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="container-fluid">
                                        <form action="{{ route('get-due-report.index') }}">
                                            <div
                                                class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                                                    style="animation-delay: 1.1s">

                                                    {!! Form::label('start_date', __('lang.start_date'), [
                                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                                        'style' => 'font-size: 12px;font-weight: 500;',
                                                    ]) !!}
                                                    {!! Form::text('start_date', request()->start_date, [
                                                        'class' => 'form-control mt-0 initial-balance-input width-full',
                                                    ]) !!}

                                                </div>
                                                <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                                                    style="animation-delay: 1.15s">

                                                    {!! Form::label('end_date', __('lang.end_date'), [
                                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                                        'style' => 'font-size: 12px;font-weight: 500;',
                                                    ]) !!}
                                                    {!! Form::text('end_date', request()->end_date, [
                                                        'class' => 'form-control mt-0 initial-balance-input width-full',
                                                    ]) !!}

                                                </div>
                                                <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                                                    style="animation-delay: 1.2s">

                                                    {!! Form::label('store_id', __('lang.store'), [
                                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                                        'style' => 'font-size: 12px;font-weight: 500;',
                                                    ]) !!}
                                                    <div class="input-wrapper">

                                                        {!! Form::select('store_id', $stores, request()->store_id, [
                                                            'class' => 'form-control select2',
                                                            'placeholder' => __('lang.all'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                                                    style="animation-delay: 1.25s">

                                                    {!! Form::label('pos_id', __('lang.pos'), [
                                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                                        'style' => 'font-size: 12px;font-weight: 500;',
                                                    ]) !!}
                                                    <div class="input-wrapper">

                                                        {!! Form::select('pos_id', $store_pos, request()->pos_id, [
                                                            'class' => 'form-control select2',
                                                            'placeholder' => __('lang.all'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-2 d-flex align-items-end justify-content-center animate__animated animate__bounceInLeft flex-column"
                                                    style="animation-delay: 1.3s">
                                                    <button type="submit"
                                                        class="btn btn-primary mt-2">@lang('lang.filter')</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                            <div class="table-responsive
                            @if (app()->isLocale('ar')) dir-rtl @endif"
                                style="height: 90vh;overflow: scroll">
                                <table id="datatable-buttons"
                                    class="table dataTable table-hover table-button-wrapper table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('lang.date')</th>
                                            <th>@lang('lang.reference')</th>
                                            <th>@lang('lang.customer')</th>
                                            <th>@lang('lang.amount')</th>
                                            <th>@lang('lang.paid')</th>
                                            <th>@lang('lang.duePaid')</th>
                                            <th class="notexport">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $total_paid = 0;
                                            $total_due = 0;
                                        @endphp
                                        @foreach ($dues as $due)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.date')">

                                                        {{ @format_date($due->transaction_date) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.reference')">

                                                        {{ $due->invoice_no }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.customer')">

                                                        {{ $due->customer->name ?? '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.amount')">

                                                        {{ @num_format($due->final_total > 0 ? $due->final_total : $due->dollar_final_total * $due->exchange_rate) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.paid')">

                                                        {{ @num_format($due->transaction_payments->sum('amount')) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.duePaid')">

                                                        {{ @num_format(($due->final_total > 0 ? $due->final_total : $due->dollar_final_total * $due->exchange_rate) - $due->transaction_payments->sum('amount')) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" style="font-size: 12px;font-weight: 600"
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">@lang('lang.action')
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu">
                                                            {{-- @can('sale.pos.create_and_edit')
                                                            <li>

                                                                <a data-href="{{action('SellController@print', $due->id)}}"
                                                        class="btn print-invoice"><i class="dripicons-print"></i>
                                                        @lang('lang.generate_invoice')</a>
                                                        </li>

                                                        @endcan --}}
                                                            {{-- @can('sale.pos.view') --}}
                                                            <li>

                                                                <a data-href="{{ route('pos.show', $due->id) }}"
                                                                    data-container=".view_modal"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"><i
                                                                        class="fa fa-eye"></i> @lang('lang.view')</a>
                                                            </li>

                                                            {{-- @endcan --}}
                                                            {{-- @can('sale.pos.create_and_edit') --}}
                                                            {{-- <li>

                                                            <a href="{{action('SellController@edit', $due->id)}}"
                                                                class="btn"><i class="dripicons-document-edit"></i>
                                                                @lang('lang.edit')</a>
                                                        </li> --}}
                                                            {{--  --}}
                                                            {{-- @endcan --}}
                                                            {{-- @can('return.sell_return.create_and_edit') --}}
                                                            <li>
                                                                <a href="{{ route('sell.return', $due->id) }}"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                        class="fa fa-undo"></i>
                                                                    @lang('lang.sale_return')</a>
                                                            </li>

                                                            {{-- @endcan --}}
                                                            {{-- @can('sale.pay.create_and_edit') --}}
                                                            @if ($due->payment_status != 'paid')
                                                                <li>
                                                                    <a data-href="{{ route('add_payment', ['id' => $due->id]) }}"
                                                                        data-container=".view_modal"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"><i
                                                                            class="fa fa-plus"></i>
                                                                        @lang('lang.add_payment')</a>
                                                                </li>
                                                            @endif
                                                            {{-- @endcan --}}
                                                            {{-- @can('sale.pay.view') --}}
                                                            @if ($due->payment_status != 'pending')
                                                                <li>
                                                                    <a data-href="{{ route('show_payment', $due->id) }}"
                                                                        data-container=".view_modal"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"><i
                                                                            class="fa fa-money"></i>
                                                                        @lang('lang.view_payments')</a>
                                                                </li>
                                                            @endif
                                                            {{-- @endcan --}}
                                                            {{-- @can('sale.pos.delete') --}}
                                                            <li>
                                                                <a data-href="{{ route('customers-report.destroy', $due->id) }}"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif text-red delete_item">
                                                                    <i class="fa fa-trash"></i>
                                                                    @lang('lang.delete')
                                                                </a>
                                                            </li>
                                                            {{-- @endcan --}}
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                                $total_paid += $due->transaction_payments->sum('amount');
                                                $total_due += $due->final_total - $due->transaction_payments->sum('amount');
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="view_modal no-print">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
    </div>
    <!-- End Contentbar -->
@endsection

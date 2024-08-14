@extends('layouts.app')
@section('title', __('lang.cash'))

@push('css')
<style>
    th {
        padding: 10px 25px !important;
        font-weight: 700 !important;
        font-size: 11px !important;
        width: fit-content !important;
        text-align: center;
        border: 1px solid white !important;
        color: #fff !important;
        background-color: #596fd7 !important;
        text-transform: uppercase;
    }

    .table-top-head {
        top: 235px !important;
    }

    .table-scroll-wrapper {
        width: fit-content;
    }

    @media(min-width:1900px) {
        .table-scroll-wrapper {
            width: 100%;
        }
    }

    @media(max-width:991px) {
        .table-top-head {
            top: 235px !important
        }
    }

    @media(max-width:768px) {
        .table-top-head {
            top: 388px !important
        }
    }

    @media(max-width:575px) {
        .table-top-head {
            top: 415px !important
        }
    }
</style>
@endpush

@section('page_title')
@lang('lang.cash')
@endsection

@section('breadcrumbs')
@parent
<li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
    @lang('lang.cash')</li>
@endsection



@section('content')
<!-- Start Contentbar -->
<div class="animate-in-page">
    <div class="contentbar mb-0 pb-0">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card mb-0">
                    <div class="card-header">
                        <h6 class="print-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            @lang('lang.cash')</h6>
                    </div>
                    {{-- +++++++++++++++++ Filters +++++++++++++++++ --}}
                    <div class="col-md-12">
                        <form action="">
                            <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {{-- ========= start_date filter ========= --}}
                                <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                                    style="animation-delay: 1.15s">
                                    {!! Form::label('start_date', __('lang.start_date'), [
                                    'class' => 'mb-0',
                                    ]) !!}
                                    <div class="input-wrapper width-full">
                                        {!! Form::date('start_date', request()->start_date, [
                                        'class' => 'form-control initial-balance-input width-full',
                                        ]) !!}
                                    </div>
                                </div>
                                {{-- ========= end_date filter ========= --}}
                                <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                                    style="animation-delay: 1.15s">
                                    {!! Form::label('end_date', __('lang.end_date'), [
                                    'class' => 'mb-0',
                                    ]) !!}
                                    <div class="input-wrapper width-full">
                                        {!! Form::date('end_date', request()->end_date, ['class' => 'form-control
                                        initial-balance-input width-full']) !!}
                                    </div>
                                </div>
                                {{-- ========= stores filter ========= --}}
                                <div class="col-6 col-md-1 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                                    style="animation-delay: 1.15s">
                                    {!! Form::label('store_id', __('lang.store'), [
                                    'class' => 'mb-0',
                                    ]) !!}
                                    <div class="input-wrapper width-full">
                                        {!! Form::select('store_id', $stores, request()->store_id, [
                                        'class' => 'form-select',
                                        'placeholder' => __('lang.all'),
                                        'data-live-search' => 'true',
                                        ]) !!}
                                    </div>
                                </div>
                                {{-- ========= store_pos filter ========= --}}
                                <div class="col-6 col-md-1 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                                    style="animation-delay: 1.15s">
                                    {!! Form::label('store_pos_id', __('lang.pos'), [
                                    'class' => 'mb-0',
                                    ]) !!}
                                    <div class="input-wrapper width-full">
                                        {!! Form::select('store_pos_id', $store_pos, request()->store_pos_id, [
                                        'class' => 'form-select',
                                        'placeholder' => __('lang.all'),
                                        'data-live-search' => 'true',
                                        ]) !!}
                                    </div>
                                </div>
                                {{-- ========= users filter ========= --}}
                                <div class="col-6 col-md-1 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                                    style="animation-delay: 1.15s">
                                    {!! Form::label('user_id', __('lang.user'), [
                                    'class' => 'mb-0',
                                    ]) !!}
                                    <div class="input-wrapper width-full">
                                        {!! Form::select('user_id', $users, request()->user_id, [
                                        'class' => 'form-select',
                                        'placeholder' => __('lang.all'),
                                        'data-live-search' => 'true',
                                        ]) !!}
                                    </div>
                                </div>
                                {{-- ========= filter button ========= --}}
                                <div class="col-6 col-md-3 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-row-reverse"
                                    style="animation-delay: 1.15s">
                                    <button type="submit" class="btn btn-primary px-1"
                                        style="font-size: 14px;font-weight: 400">
                                        <i class="fa fa-eye"></i>
                                        @lang('lang.filter')
                                    </button>
                                    <a href="{{ route('cash.index') }}" class="btn btn-danger px-1 mx-1"
                                        style="font-size: 14px;font-weight: 400">@lang('lang.clear_filters')</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- +++++++++++++++++ Table +++++++++++++++++ --}}
                    <div class="card-body">
                        <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div1"></div>
                        </div>
                        <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div2 table-scroll-wrapper">
                                <!-- content goes here -->
                                <div style="min-width: 1800px;max-height: 90vh;overflow: auto">
                                    <table id="store_table" class="table dataTable">
                                        {{-- ++++++++++ thead ++++++++++ --}}
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.date_and_time')</th>
                                                <th>@lang('lang.user')</th>
                                                <th>@lang('lang.pos')</th>
                                                <th>@lang('lang.store')</th>
                                                <th>@lang('lang.notes')</th>
                                                <th>@lang('lang.status')</th>
                                                <th class="sum">@lang('lang.cash_sales')</th>
                                                <th class="sum dollar-cell showHideDollarCells">@lang('lang.cash_sales')
                                                    $</th>
                                                <th class="sum">@lang('lang.total_latest_payments')</th>
                                                <th class="sum dollar-cell showHideDollarCells">
                                                    @lang('lang.total_latest_payments') $</th>
                                                <th class="sum">@lang('lang.cash_in')</th>
                                                <th class="sum dollar-cell showHideDollarCells">@lang('lang.cash_in') $
                                                </th>
                                                <th class="sum">@lang('lang.cash_out')</th>
                                                <th class="sum dollar-cell showHideDollarCells">@lang('lang.cash_out') $
                                                </th>
                                                <th class="sum">@lang('lang.purchases')</th>
                                                <th class="sum dollar-cell showHideDollarCells">@lang('lang.purchases')
                                                    $</th>
                                                <th class="sum">@lang('lang.expenses')</th>
                                                <th class="sum dollar-cell showHideDollarCells">@lang('lang.expenses') $
                                                </th>
                                                <th class="sum">@lang('lang.wages_and_compensation')</th>
                                                <th class="sum dollar-cell showHideDollarCells">
                                                    @lang('lang.wages_and_compensation') $</th>
                                                <th class="sum">@lang('lang.current_cash')</th>
                                                <th class="sum dollar-cell showHideDollarCells">
                                                    @lang('lang.current_cash') $</th>
                                                <th class="sum">@lang('lang.closing_cash')</th>
                                                <th class="sum dollar-cell showHideDollarCells">
                                                    @lang('lang.closing_cash') $</th>
                                                <th class="sum">@lang('lang.closing_date_and_time')</th>
                                                <th>@lang('lang.cash_given_to')</th>
                                                <th class="notexport">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        {{-- ++++++++++ tbody ++++++++++ --}}
                                        <tbody>
                                            @foreach ($cash_registers as $cash_register)
                                            <tr>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.date_and_time')">

                                                        {{ @format_datetime($cash_register->created_at) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.user')">

                                                        {{ ucfirst($cash_register->cashier->name ?? '') }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.pos')">

                                                        {{ ucfirst($cash_register->store_pos->name ?? '') }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.store')">

                                                        {{ ucfirst($cash_register->store->name ?? '') }}
                                                    </span>
                                                </td>



                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.notes')">

                                                        {{ ucfirst($cash_register->notes) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.status')">

                                                        {{ ucfirst($cash_register->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.cash_sales')">
                                                        {{ @num_format($cash_register->dinar_total_cash_sales -
                                                        $cash_register->dinar_total_refund_cash -
                                                        $cash_register->dinar_total_sell_return) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip dollar-cell showHideDollarCells d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.cash_sales')">
                                                        {{ @num_format($cash_register->dollar_total_cash_sales -
                                                        $cash_register->dollar_total_refund_cash -
                                                        $cash_register->dollar_total_sell_return) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.total_latest_payments')">
                                                        {{ @num_format($cash_register->dinar_total_latest_payments) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip dollar-cell showHideDollarCells d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.total_latest_payments')">
                                                        {{ @num_format($cash_register->dollar_total_latest_payments) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.cash_in')">
                                                        {{ @num_format($cash_register->dinar_total_cash_in) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip dollar-cell showHideDollarCells d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.cash_in')">
                                                        {{ @num_format($cash_register->dollar_total_cash_in) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.cash_out')">
                                                        {{ @num_format($cash_register->dinar_total_cash_out) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip dollar-cell showHideDollarCells d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.cash_out')">
                                                        {{ @num_format($cash_register->dollar_total_cash_out) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.purchases')">
                                                        {{ @num_format($cash_register->dinar_total_purchases) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip dollar-cell showHideDollarCells d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.purchases')">
                                                        {{ @num_format($cash_register->dollar_total_purchases) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.expenses')">
                                                        {{ @num_format($cash_register->dinar_total_expenses) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip dollar-cell showHideDollarCells d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.expenses')">
                                                        {{ @num_format($cash_register->dollar_total_expenses) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.wages_and_compensation')">
                                                        {{
                                                        @num_format($cash_register->dinar_total_wages_and_compensation)
                                                        }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip dollar-cell showHideDollarCells d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.wages_and_compensation')">
                                                        {{
                                                        @num_format($cash_register->dollar_total_wages_and_compensation)
                                                        }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.current_cash')">
                                                        {{ @num_format($cash_register->dinar_total_cash_sales -
                                                        $cash_register->dinar_total_refund_cash +
                                                        $cash_register->dinar_total_cash_in -
                                                        $cash_register->dinar_total_cash_out -
                                                        $cash_register->dinar_total_purchases -
                                                        $cash_register->dinar_total_expenses -
                                                        $cash_register->dinar_total_wages_and_compensation -
                                                        $cash_register->dinar_total_sell_return) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip dollar-cell showHideDollarCells d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.current_cash')">
                                                        {{ @num_format(
                                                        $cash_register->dollar_total_cash_sales -
                                                        $cash_register->dollar_total_refund_cash +
                                                        $cash_register->dollar_total_cash_in -
                                                        $cash_register->dollar_total_cash_out -
                                                        $cash_register->dollar_total_purchases -
                                                        $cash_register->dollar_total_expenses -
                                                        $cash_register->dollar_total_wages_and_compensation -
                                                        $cash_register->dollar_total_sell_return
                                                        ) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.closing_cash')">
                                                        {{ @num_format($cash_register->closing_amount) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip dollar-cell showHideDollarCells d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.closing_cash')">
                                                        {{ @num_format($cash_register->closing_dollar_amount) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.closing_date_and_time')">
                                                        @if (!empty($cash_register->closed_at))
                                                        {{ @format_datetime($cash_register->closed_at) }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.cash_given_to')">

                                                        {{ !empty($cash_register->cash_given) ?
                                                        $cash_register->cash_given->name : '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">@lang('lang.action')
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu">
                                                            <li>
                                                                <a href="{{ route('cash.show', $cash_register->id) }}"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                                    target="_blank">
                                                                    <i class="fa fa-eye"></i>@lang('lang.view')
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        {{-- ++++++++++ tfoot ++++++++++ --}}
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th style="text-align: right">@lang('lang.total')</th>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

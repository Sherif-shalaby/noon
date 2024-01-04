@extends('layouts.app')
@section('title', __('lang.cash'))
@section('breadcrumbbar')
   <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.cash')</h4>
                <div class="breadcrumb-list">
                      <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif">
                            <a   style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/ @lang('lang.dashboard')</a>
                        </li>
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">@lang('lang.cash')</li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
        </div>
    @endsection
    @section('content')
        <!-- End Breadcrumbbar -->
        <!-- Start Contentbar -->
        <div class="animate-in-page">

        <div class="contentbar mb-0 pb-0">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="print-title @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.cash')</h5>
                        </div>
                        {{-- +++++++++++++++++ Filters +++++++++++++++++ --}}
                        {{-- <div class="col-md-12 card">
                        <form action="">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('start_date', __('lang.start_date'), []) !!}
                                        {!! Form::text('start_date', request()->start_date, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('start_time', __('lang.start_time'), []) !!}
                                        {!! Form::text('start_time', request()->start_time, ['class' => 'form-control
                                        time_picker sale_filter']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('end_date', __('lang.end_date'), []) !!}
                                        {!! Form::text('end_date', request()->end_date, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('end_time', __('lang.end_time'), []) !!}
                                        {!! Form::text('end_time', request()->end_time, ['class' => 'form-control time_picker
                                        sale_filter']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('store_id', __('lang.store'), []) !!}
                                        {!! Form::select('store_id', $stores, request()->store_id, ['class' =>
                                        'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('store_pos_id', __('lang.pos'), []) !!}
                                        {!! Form::select('store_pos_id', $store_pos, request()->store_pos_id, ['class' =>
                                        'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('user_id', __('lang.user'), []) !!}
                                        {!! Form::select('user_id', $users, request()->user_id, ['class' =>
                                        'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <button type="submit" class="btn btn-primary mt-2">
                                        <i class="fa fa-eye"></i>
                                        @lang('lang.filter')
                                    </button>
                                    <a href="{{route('cash.index')}}" class="btn btn-danger mt-2 ml-2">@lang('lang.clear_filters')</a>
                                </div>
                            </div>
                        </form>
                    </div> --}}
                        {{-- +++++++++++++++++ Table +++++++++++++++++ --}}
                        <div class="card-body">
                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2 table-scroll-wrapper">
                                    <!-- content goes here -->
                                    <div style="min-width: 1300px;max-height: 90vh;overflow: auto">
                                <table id="store_table" class="table dataTable">
                                    {{-- ++++++++++ thead ++++++++++ --}}
                                    <thead>
                                        <tr>
                                            <th>@lang('lang.date_and_time')</th>
                                            <th>@lang('lang.user')</th>
                                            <th>@lang('lang.pos')</th>
                                            <th>@lang('lang.notes')</th>
                                            <th>@lang('lang.status')</th>
                                            <th class="sum">@lang('lang.cash_sales')</th>
                                            @if (session('system_mode') == 'restaurant')
                                                <th class="sum">@lang('lang.dining_in')</th>
                                            @endif
                                            <th class="sum">@lang('lang.cash_in')</th>
                                            <th class="sum">@lang('lang.cash_out')</th>
                                            <th class="sum">@lang('lang.purchases')</th>
                                            <th class="sum">@lang('lang.expenses')</th>
                                            <th class="sum">@lang('lang.wages_and_compensation')</th>
                                            <th class="sum">@lang('lang.current_cash')</th>
                                            <th class="sum">@lang('lang.closing_cash')</th>
                                            <th class="sum">@lang('lang.closing_date_and_time')</th>
                                            <th>@lang('lang.cash_given_to')</th>
                                            {{-- <th class="notexport">@lang('lang.action')</th> --}}
                                        </tr>
                                    </thead>
                                    {{-- ++++++++++ tbody ++++++++++ --}}
                                    <tbody>
                                        @foreach ($cash_registers as $cash_register)
                                            <tr>
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.date_and_time')">

                                                        {{ @format_datetime($cash_register->created_at) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.user')">

                                                        {{ ucfirst($cash_register->cashier->name ?? '') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.pos')">

                                                        {{ ucfirst($cash_register->store_pos->name ?? '') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.notes')">

                                                        {{ ucfirst($cash_register->notes) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.status')">

                                                        {{ ucfirst($cash_register->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.cash_sales')">
                                                        {{ @num_format($cash_register->totalCashSales - $cash_register->totalRefundCash - $cash_register->totalSellReturn) }}
                                                    </span>
                                                </td>
                                                @if (session('system_mode') == 'restaurant')
                                                <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.dining_in')">
                                                    <td>{{ @num_format($cash_register->totalDiningIn) }}</td>
                                                </span>
                                                @endif
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.cash_in')">

                                                        {{ @num_format($cash_register->totalCashIn) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.cash_out')">

                                                        {{ @num_format($cash_register->totalCashOut) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.purchases')">

                                                        {{ @num_format($cash_register->totalPurchases) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.expenses')">

                                                        {{ @num_format($cash_register->totalExpenses) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.wages_and_compensation')">

                                                        {{ @num_format($cash_register->totalWagesAndCompensation) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.current_cash')">

                                                        {{ @num_format(
                                                            $cash_register->totalCashSales -
                                                                $cash_register->totalRefundCash +
                                                                $cash_register->totalCashIn -
                                                                $cash_register->totalCashOut -
                                                                $cash_register->totalPurchases -
                                                                $cash_register->totalExpenses -
                                                                $cash_register->totalWagesAndCompensation -
                                                                $cash_register->totalSellReturn
                                                        ) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.closing_cash')">

                                                        {{ @num_format($cash_register->closing_amount) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.closing_date_and_time')">

                                                        @if (!empty($cash_register->closed_at))
                                                    </span>
                                                        {{ @format_datetime($cash_register->closed_at) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <span   class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.cash_given_to')">

                                                        {{ !empty($cash_register->cash_given) ? $cash_register->cash_given->name : '' }}
                                                    </span>
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

@section('javascript')

@endsection

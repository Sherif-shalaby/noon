@extends('layouts.app')
@section('title', __('lang.cash'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.cash')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{url('/')}}">@lang('lang.dashboard')</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.cash')</li>
                    </ol>
                </div>
            </div>
   </div>
@endsection
@section('content')
     <!-- End Breadcrumbbar -->
    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="print-title">@lang('lang.cash')</h3>
                    </div>
                    {{-- +++++++++++++++++ Filters +++++++++++++++++ --}}
                    <div class="col-md-12 card">
                        <form action="">
                            <div class="row">
                                {{-- ========= start_date filter ========= --}}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('start_date', __('lang.start_date'), []) !!}
                                        {!! Form::text('start_date', request()->start_date, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                {{-- ========= end_date filter ========= --}}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('end_date', __('lang.end_date'), []) !!}
                                        {!! Form::text('end_date', request()->end_date, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                {{-- ========= stores filter ========= --}}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('store_id', __('lang.store'), []) !!}
                                        {!! Form::select('store_id', $stores, request()->store_id, ['class' =>
                                        'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                    </div>
                                </div>
                                {{-- ========= store_pos filter ========= --}}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('store_pos_id', __('lang.pos'), []) !!}
                                        {!! Form::select('store_pos_id', $store_pos, request()->store_pos_id, ['class' =>
                                        'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                    </div>
                                </div>
                                {{-- ========= users filter ========= --}}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('user_id', __('lang.user'), []) !!}
                                        {!! Form::select('user_id', $users, request()->user_id, ['class' =>
                                        'form-control', 'placeholder' => __('lang.all'),'data-live-search'=>"true"]) !!}
                                    </div>
                                </div>
                                {{-- ========= filter button ========= --}}
                                <div class="col-md-2">
                                    <br>
                                    <button type="submit" class="btn btn-primary mt-2">
                                        <i class="fa fa-eye"></i>
                                        @lang('lang.filter')
                                    </button>
                                    <a href="{{route('cash.index')}}" class="btn btn-danger mt-2">@lang('lang.clear_filters')</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- +++++++++++++++++ Table +++++++++++++++++ --}}
                    <div class="card-body">
                        <div class="table-responsive">
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
                                        @if(session('system_mode') == 'restaurant')
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
                                        <th class="notexport">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                {{-- ++++++++++ tbody ++++++++++ --}}
                                <tbody>
                                    @foreach($cash_registers as $cash_register)
                                    <tr>
                                        <td>{{ @format_datetime($cash_register->created_at) }}</td>
                                        <td>{{ ucfirst($cash_register->cashier->name ?? '') }}</td>
                                        <td>{{ ucfirst($cash_register->store_pos->name ?? '') }}</td>
                                        <td>{{ ucfirst($cash_register->notes) }}</td>
                                        <td>{{ ucfirst($cash_register->status) }}</td>
                                        <td>{{ @num_format($cash_register->totalCashSales - $cash_register->totalRefundCash - $cash_register->totalSellReturn) }}</td>
                                        @if(session('system_mode') == 'restaurant')
                                            <td>{{ @num_format($cash_register->totalDiningIn) }}</td>
                                        @endif
                                        <td>{{ @num_format($cash_register->totalCashIn) }}</td>
                                        <td>{{ @num_format($cash_register->totalCashOut) }}</td>
                                        <td>{{ @num_format($cash_register->totalPurchases) }}</td>
                                        <td>{{ @num_format($cash_register->totalExpenses) }}</td>
                                        <td>{{ @num_format($cash_register->totalWagesAndCompensation) }}</td>
                                        <td>{{ @num_format(
                                                $cash_register->totalCashSales - $cash_register->totalRefundCash +
                                                $cash_register->totalCashIn - $cash_register->totalCashOut -
                                                $cash_register->totalPurchases - $cash_register->totalExpenses -
                                                $cash_register->totalWagesAndCompensation - $cash_register->totalSellReturn
                                            ) }}
                                        </td>
                                        <td>{{ @num_format($cash_register->closing_amount) }}</td>
                                        <td>@if(!empty($cash_register->closed_at)){{ @format_datetime($cash_register->closed_at) }}@endif</td>
                                        <td>{{ !empty($cash_register->cash_given) ? $cash_register->cash_given->name : '' }}</td>
                                        {{-- ++++++++++++ Actions ++++++++++++ --}}
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('lang.action')
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                                    <li>
                                                        <a href="{{route('cash.show', $cash_register->id)}}" class="btn" target="_blank">
                                                            <i class="fa fa-eye"></i>@lang('lang.view')
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        {{-- <td class="col18">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات                                            <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <li>
                                                        <a href="{{route('customer_dues', $customer->id)}}" class="btn" target="_blank"><i class="dripicons-document-edit"></i> @lang('lang.dues')</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{route('customers.show', $customer->id)}}" class="btn">
                                                            <i class="fa fa-eye"></i>@lang('lang.view')
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{route('customers.edit', $customer->id)}}" class="btn" target="_blank"><i class="dripicons-document-edit"></i> @lang('lang.update')</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                        <li>
                                                            <a data-href="{{route('customers.destroy', $customer->id)}}"
                                                                class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                                @lang('lang.delete')</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td> --}}
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
@endsection

@section('javascript')

@endsection

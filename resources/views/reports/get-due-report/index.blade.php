@extends('layouts.app')
@section('title', __('lang.get_due_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.get_due_report')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.reports')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.get_due_report')</li>
                    </ol>
                </div>
            </div>
            {{-- <div class="col-md-4 col-lg-4">

                <div class="widgetbar">
                    <a href="{{route('products.create')}}" class="btn btn-primary">
                        @lang('lang.add_products')
                      </a>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
@section('content')
    {{-- <!-- Start row -->
    <div class="row d-flex justify-content-center">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30 p-2">


            </div>
        </div>
    </div> --}}
    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.products')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    <form action="{{route('get-due-report.index')}}">
                                        <div class="row pb-3">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::label('start_date', __('lang.start_date'), []) !!}
                                                    {!! Form::text('start_date', request()->start_date, ['class' => 'form-control']) !!}
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
                                                        {!! Form::label('store_id', __('lang.store'), []) !!}
                                                        {!! Form::select('store_id', $stores, request()->store_id, [
                                                            'class' => 'form-control select2',
                                                            'placeholder' => __('lang.all'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        {!! Form::label('pos_id', __('lang.pos'), []) !!}
                                                        {!! Form::select('pos_id', $store_pos, request()->pos_id, [
                                                            'class' => 'form-control select2',
                                                            'placeholder' => __('lang.all'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            <div class="col-md-3">
                                                <br>
                                                <button type="submit"
                                                    class="btn btn-success mt-2">@lang('lang.filter')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
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
                                            <td>{{ @format_date($due->transaction_date) }}</td>
                                            <td> {{ $due->invoice_no }}</td>
                                            <td> {{ $due->customer->name ?? '' }}</td>
                                            <td> {{ @num_format($due->final_total>0?$due->final_total :$due->dollar_final_total*$due->exchange_rate) }}</td>
                                            <td> {{ @num_format($due->transaction_payments->sum('amount')) }}</td>
                                            <td> {{ @num_format(($due->final_total>0?$due->final_total :$due->dollar_final_total*$due->exchange_rate) - $due->transaction_payments->sum('amount')) }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle"
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
                                                        <li class="divider"></li>
                                                        @endcan --}}
                                                        {{-- @can('sale.pos.view') --}}
                                                        <li>
            
                                                            <a data-href="{{route('pos.show', $due->id)}}"
                                                                data-container=".view_modal" class="btn btn-modal"><i
                                                                    class="fa fa-eye"></i> @lang('lang.view')</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        {{-- @endcan --}}
                                                        {{-- @can('sale.pos.create_and_edit') --}}
                                                        {{-- <li>
            
                                                            <a href="{{action('SellController@edit', $due->id)}}"
                                                                class="btn"><i class="dripicons-document-edit"></i>
                                                                @lang('lang.edit')</a>
                                                        </li> --}}
                                                        {{-- <li class="divider"></li> --}}
                                                        {{-- @endcan --}}
                                                        {{-- @can('return.sell_return.create_and_edit') --}}
                                                        <li>
                                                            <a href="{{route('sell.return', $due->id)}}"
                                                                class="btn"><i class="fa fa-undo"></i>
                                                                @lang('lang.sale_return')</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        {{-- @endcan --}}
                                                        {{-- @can('sale.pay.create_and_edit') --}}
                                                        @if($due->payment_status != 'paid')
                                                        <li>
                                                            <a data-href="{{route('add_payment', ['id' => $due->id])}}"
                                                                data-container=".view_modal" class="btn btn-modal"><i
                                                                    class="fa fa-plus"></i> @lang('lang.add_payment')</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        @endif
                                                        {{-- @endcan --}}
                                                        {{-- @can('sale.pay.view') --}}
                                                        @if($due->payment_status != 'pending')
                                                        <li>
                                                            <a data-href="{{route('show_payment', $due->id)}}"
                                                                data-container=".view_modal" class="btn btn-modal"><i
                                                                    class="fa fa-money"></i> @lang('lang.view_payments')</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        @endif
                                                        {{-- @endcan --}}
                                                        {{-- @can('sale.pos.delete') --}}
                                                        <li>
                                                            <a data-href="{{ route('customers-report.destroy', $due->id) }}"
                                                                class="btn text-red delete_item">
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
    <!-- End Contentbar -->
@endsection

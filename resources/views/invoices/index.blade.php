@extends('layouts.app')
@section('title', __('lang.sells'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.sells')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.sells')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
{{--                <div class="widgetbar">--}}
{{--                    <a href="{{route('customers.create')}}" class="btn btn-primary">--}}
{{--                    </a>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.sells')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    {{-- @include('customers.filters') --}}
                                </div>
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>@lang('lang.date_and_time')</th>
                                    <th>@lang('lang.reference')</th>
                                    <th>@lang('lang.store')</th>
                                    <th>@lang('lang.customer')</th>
                                    <th>@lang('lang.phone')</th>
                                    <th>@lang('lang.sale_status')</th>
                                    <th>@lang('lang.payment_status')</th>
                                    <th>@lang('lang.payment_type')</th>
                                    <th>@lang('lang.ref_number')</th>
                                    <th class="currencies">@lang('lang.received_currency')</th>
                                    <th class="sum">@lang('lang.grand_total')</th>
                                    <th class="sum">@lang('lang.paid')</th>
                                    <th class="sum">@lang('lang.due_sale_list')</th>
                                    <th>@lang('lang.payment_date')</th>
                                    <th>@lang('lang.cashier_man')</th>
                                    <th>@lang('lang.commission')</th>
                                    <th>@lang('lang.products')</th>
                                    <th>@lang('lang.sale_note')</th>
                                    <th>@lang('lang.files')</th>
                                    <th class="notexport">@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sell_lines as $index => $line)
                                    <tr>
                                        <td>
                                            {{$line->transaction_date ?? ''}}
                                        </td>
                                        <td>
                                            {{$line->invoice_no ?? '' }}
                                        </td>
                                        <td>
                                            {{$line->store->name ?? '' }}
                                        </td>
                                        <td>
                                            {{$line->customer->name ?? '' }}
                                        </td>
                                        <td>
                                            {{$line->customer->phone ?? '' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-success">{{$line->status ?? '' }}</span>
                                        </td>
                                        <td>{{$line->payment_status}}</td>
                                        <td>
                                            @foreach($line->transaction_payments as $payment)
                                                {{__('lang.'.$payment->method)}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($line->transaction_payments as $payment)
                                                {{$payment->ref_no ?? ''}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($line->transaction_payments as $payment)
                                                {{$payment->received_currency_relation->symbol ?? ''}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{number_format($line->final_total,2)}}
                                        </td>
                                        <td>
                                            {{$line->transaction_payments->sum('amount')}}
                                        </td>
                                        <td>
                                            {{$line->final_total - $line->transaction_payments->sum('amount')}}
                                        </td>
                                        <td>
                                            {{$line->transaction_payments->last()->paid_on ?? ''}}
                                        </td>
                                        <td>
                                            {{$line->created_by_user->name}}
                                        </td>
                                        <td></td>
                                        <td>
                                            @foreach($line->transaction_sell_lines as $sell_line)
                                                @if(!empty($sell_line->product))
                                                    {{$sell_line->product->name ?? ' ' }} -
                                                    {{ $sell_line->product->sku ?? ' ' }}<br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($line->transaction_payments as $payment)
                                                {{$payment->received_currency_relation->payment_note ?? ''}}<br>
                                            @endforeach
                                        </td>
                                        <td></td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                                <li>
                                                    <a href="{{route('sell.return',$line->id)}}" class="btn"><i class="fa fa-undo"></i>@lang('lang.return') </a>
                                                </li>
                                                <li class="divider"></li>

                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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

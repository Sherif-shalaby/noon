@extends('layouts.app')
@section('title', __('lang.customer_report'))
@section('breadcrumbbar')
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">@lang('lang.customer_report')</h5>
                </div>
                <div class="card-body">
                    @include('reports.employee-sales.filters')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>@lang('lang.date')</th>
                                            <th>@lang('lang.reference')</th>
                                            <th>@lang('lang.employee')</th>
                                            <th class="currencies">@lang('lang.currency')</th>
                                            <th class="sum">@lang('lang.commission')</th>
                                            <th class="sum">@lang('lang.paid')</th>
                                            <th>متأخرات</th>
                                            <th class="sum">@lang('lang.due')</th>
                                            <th>@lang('lang.payment_type')</th>
                                            <th>@lang('lang.payment_status')</th>
                                            <th class="notexport">@lang('lang.action')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($sales as $key => $sale)
                                            <tr>
                                                <td>{{ @format_date($sale->created_at->format('Y-m-d')) }}</td>
                                                <td>
                                                    @php
                                                        $ref_numbers = '';
                                                        if (!empty($request->method)) {
                                                            $payments = $sale->transaction_payments->where('method', $request->method);
                                                        } else {
                                                            $payments = $sale->transaction_payments;
                                                        }
                                                    
                                                    foreach ($payments as $payment) {
                                                        if (!empty($payment->ref_number)) {
                                                            $ref_numbers .= $payment->ref_number . '<br>';
                                                        }
                                                    }
                                                    @endphp
                                                    {{$ref_numbers}}
                                                </td>
                                                <td>{{$sale->employee->name??''}}</td>
                                                <td>
                                                    @php
                                                    $default_currency = \App\Models\Currency::find($default_currency_id);
                                                    @endphp
                                                    {{$sale->paying_currency_symbol ?? $default_currency->symbol}}
                                                </td>
                                                <td>

                                                </td>
                                                <td>
                                                    @php
                                                        $amount_paid =  $sale->transaction_payments->sum('amount');
                                                        $paying_currency_id = $sale->paying_currency_id ?? $default_currency_id;
                                                    @endphp
                                                    <span data-currency_id="{{$paying_currency_id }}"> {{ $amount_paid }}</span>
                                                </td>
                                                <td>  
                                                    @php  
                                                    $due =  $sale->final_total - $sale->transaction_payments->sum('amount');
                                                    $paying_currency_id = $sale->paying_currency_id ?? $default_currency_id;
                                                    @endphp
                                                    <span data-currency_id="$paying_currency_id ">{{$due}}</span>
                                                </td>
                                                <td>{{@format_datetime($sale->paid_on)}}</td>
                                                <td>
                                                    @foreach ($sale->transaction_payments as $payment) 
                                                        @if (!empty($payment->method)) 
                                                            {{$payment_types[$payment->method]}} <br>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if($sale->payment_status == 'pending') 
                                                        <span class="label label-success">{{__('lang.pay_later') }}</span>
                                                    @else 
                                                        <span class="label label-danger">{{ ucfirst($sale->status)}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">خيارات <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu" x-placement="bottom-end"
                                                            style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                            <li>
                                                                <a data-href="{{route('show_payment', $sale->id)}}" data-container=".view_modal" class="btn btn-modal">
                                                                    <i class="fa fa-money"></i>
                                                                    @lang('lang.view_payments')
                                                                </a>
                                                            </li>
                                                            @if ($sale->status != 'draft' && $sale->payment_status != 'paid' && $sale->status != 'canceled') 
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{route('add_payment', $sale->id)}}" data-container=".view_modal" class="btn btn-modal">
                                                                    <i class="fa fa-plus"></i>
                                                                    @lang('lang.add_payments')
                                                                </a>
                                                            </li>
                                                            @endif
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{route('pos.show', $sale->id)}}" data-container=".view_modal" class="btn btn-modal">
                                                                    <i class="fa fa-eye"></i>
                                                                    @lang('lang.view')
                                                                </a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{ route('pos.destroy', $sale->id) }}"
                                                                    class="btn text-red delete_item">
                                                                    <i class="fa fa-trash"></i>
                                                                    @lang('lang.delete')
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <th style="text-align: right">@lang('lang.total')</th>
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
    
    <div class="view_modal no-print" >

    </div>
@endsection
@section('content')

@endsection

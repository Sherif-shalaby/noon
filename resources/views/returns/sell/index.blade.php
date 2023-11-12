@extends('layouts.app')
@section('title', __('lang.sells_return'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.sells_return')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.sells_return')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">

            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.sells_return')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
{{--                                <div class="container-fluid">--}}
{{--                                    @include('products.filters')--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="date">@lang('lang.date')</th>
                                        <th>@lang('lang.reference')</th>
                                        <th>@lang('lang.customer')</th>
                                        <th>@lang('lang.payment_status')</th>
                                        <th>@lang('lang.payment_type')</th>
                                        <th class="currencies">@lang('lang.paying_currency')</th>
                                        <th class="sum">@lang('lang.grand_total')</th>
                                        <th class="sum">@lang('lang.paid')</th>
                                        <th class="sum">@lang('lang.due')</th>
                                        <th>@lang('lang.notes')</th>
                                        <th>@lang('lang.files')</th>
                                        <th class="notexport">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($sell_returns as $return)
                                    <tr>
                                        <td>
                                            {{$return->transaction_date}}
                                        </td>
                                        <td>
                                            {{$return->invoice_no}}
                                        </td>
                                        <td>
                                            {{$return->customer->name}}
                                        </td>
                                        <td>
                                            {{__('lang.'.$return->payment_status)}}
                                        </td>
                                        <td>
                                            @foreach($return->transaction_payments as $payment)
                                                {{__('lang.'.$payment->method)}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($return->transaction_payments as $payment)
                                                {{$payment->received_currency_relation->symbol ?? ''}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{number_format($return->final_total,2)}}
                                        </td>
                                        <td>
                                            {{$return->transaction_payments->sum('amount')}}
                                        </td>
                                        <td>
                                            {{$return->transaction_payments->last()->paid_on ?? ''}}
                                        </td>
                                        <td>
                                            {{$return->notes}}
                                        </td>
                                        <td></td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
{{--                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">--}}
{{--                                                <li>--}}
{{--                                                    <a href="{{route('sell.return',$line->id)}}" class="btn"><i class="fa fa-undo"></i>@lang('lang.return') </a>--}}
{{--                                                </li>--}}
{{--                                                <li class="divider"></li>--}}

{{--                                            </ul>--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="view_modal no-print" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- This will be printed -->
   {{-- <section class="invoice print_section print-only" id="receipt_section"> </section> --}}
@endsection

@section('javascript')
@endsection

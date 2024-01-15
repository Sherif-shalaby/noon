@extends('layouts.app')
@section('title', __('lang.customers'))
@section('breadcrumbbar')
    {{-- +++++++++++++++ Style : checkboxes and labels inside selectbox +++++++++++++++ --}}
    <style>
        .selectBox {
            position: relative;
        }

        /* selectbox style */
        .selectBox select
        {
            width: 100%;
            padding: 0 !important;
            padding-left: 4px;
            padding-right: 4px;
            color: #fff;
            border: 1px solid #596fd7;
            background-color: #596fd7;
            height: 39px !important;
        }

        .overSelect {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }

        #checkboxes {
            display: none;
            border: 1px #dadada solid;
            height: 125px;
            overflow: auto;
            padding-top: 10px;
            /* text-align: end;  */
        }

        #checkboxes label {
            display: block;
            padding: 5px;

        }

        #checkboxes label:hover {
            background-color: #ddd;
        }
        #checkboxes label span
        {
            font-weight: normal;
        }
    </style>

    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.customers')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="{{route('customers.index')}}">@lang('lang.customers')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.customer_invoices')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
{{--                <div class="widgetbar">--}}
{{--                    <a href="{{route('customers.create')}}" class="btn btn-primary">--}}
{{--                        @lang('lang.add_customers')--}}
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
                        <h5 class="card-title">@lang('lang.customer_invoices')</h5>
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
                                    <th>@lang('lang.cashier_man')</th>
                                    <th>@lang('lang.products')</th>
                                    <th>@lang('lang.receipts')</th>
                                    <th class="notexport">@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $index => $line)
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
                                            {{$line->created_by_user->name}}
                                        </td>
                                        <td>
                                            @foreach($line->transaction_sell_lines as $sell_line)
                                                @if(!empty($sell_line->product))
                                                    {{$sell_line->product->name ?? ' ' }} -
                                                    {{ $sell_line->product->sku ?? ' ' }}<br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @if(count($line->receipts) > 0)
                                                <a data-href=" {{route('show_receipt', $line->id)}}"
                                                   data-container=".view_modal"  data-dismiss="modal"
                                                   class="btn btn-default btn-modal"> {{__('lang.view')}}
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                                <li>
                                                    <a data-href=" {{route('pos.show', $line->id)}}" data-container=".view_modal" data-dismiss="modal"
                                                       class="btn btn-modal show-invoice"><i class="fa fa-eye"></i>{{ __('lang.view') }}
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href=" {{route('upload_receipt', $line->id)}}" data-container=".view_modal" data-dismiss="modal"
                                                       class="btn btn-modal"><i class="fa fa-plus"></i>{{ __('lang.upload_receipt') }}
                                                    </a>
                                                </li>
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
    <div class="view_modal no-print" ></div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

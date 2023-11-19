@extends('layouts.app')
@section('title', __('lang.supplier_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.supplier_report')
                </h4>
                <div class="breadcrumb-list">
                    <ul style=" list-style: none;"
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                @lang('lang.dashboard')</a>
                        </li>
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                            aria-current="page">/ @lang('lang.reports')</li>
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                            aria-current="page">@lang('lang.supplier_report')</li>
                    </ul>
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
                        <h5 class="card-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            @lang('lang.supplier_report')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    {{-- @include('products.filters')  --}}
                                </div>
                            </div>
                        </div>
                        {{-- ================================ Tabs Header ================================ --}}
                        {{-- <div> --}}
                        <ul class="nav nav-pills">
                            {{-- ####### Tab 1 ####### --}}
                            <li class="nav-item">
                                <a class="nav-link active pt-2 pb-2" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                    role="tab" aria-controls="nav-home" aria-selected="true">
                                    شراء
                                </a>
                            </li>
                            {{-- ####### Tab 2 ####### --}}
                            <li class="nav-item">
                                <a class="nav-link pt-2 pb-2" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                    role="tab" aria-controls="nav-profile" aria-selected="false">
                                    امر شراء
                                </a>
                            </li>
                            {{-- ####### Tab 3 ####### --}}
                            <li class="nav-item">
                                <a class="nav-link pt-2 pb-2" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                                    role="tab" aria-controls="nav-contact" aria-selected="false">
                                    المدفوعات
                                </a>
                            </li>
                        </ul>
                        {{-- </div> --}}
                        <br /><br />
                        {{-- ================================ Tabs Body ================================ --}}
                        <div class="tab-content" id="nav-tabContent">
                            {{-- +++++++++++++++++++++ Table 1 +++++++++++++++++++++ --}}
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered table-button-wrapper @if (app()->isLocale('ar')) dir-rtl @endif">
                                    <thead>
                                        <tr>
                                            <th>@lang('lang.date')</th>
                                            <th>@lang('lang.reference_no')</th>
                                            <th>@lang('lang.supplier')</th>
                                            <th>@lang('lang.product')</th>
                                            <th class="sum">@lang('lang.grand_total')</th>
                                            <th class="sum">@lang('lang.paid')</th>
                                            <th class="sum">@lang('lang.duePaid')</th>
                                            <th>@lang('lang.status')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($add_stocks as $add_stock)
                                        <tr>
                                            {{-- @foreach ($add_stocks->transaction as $line) --}}
                                            <td>{{ @format_date($add_stock->transaction->transaction_date) }}</td>
                                            <td>{{ $add_stock->transaction->invoice_no }}</td>
                                            <td>
                                                @if (!empty($add_stock->transaction->supplier))
                                                    {{ $add_stock->transaction->supplier->name }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($add_stock->product))
                                                    {{ $add_stock->product->name }}
                                                @endif
                                            </td>
                                            <td>{{ @num_format($add_stock->transaction->final_total) }}</td>
                                            <td>{{ @num_format($add_stock->transaction->transaction_payments->sum('amount')) }}
                                            </td>
                                            <td>{{ @num_format($add_stock->transaction->final_total - $add_stock->transaction->transaction_payments->sum('amount')) }}
                                            </td>
                                            <td>{{ $add_stock->transaction->payment_status }}</td>
                                            {{-- @endforeach --}}
                                        </tr>
                                        @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{-- +++++++++++++++++++++ Table 2 +++++++++++++++++++++ --}}
                            <div class="tab-pane fade"id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <table id="datatable-buttons" class="table table-button-wrapper table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>@lang('lang.date')</th>
                                            <th>@lang('lang.reference_no')</th>
                                            <th>@lang('lang.supplier_name')</th>
                                            <th>@lang('lang.product_name')</th>
                                            <th>@lang('lang.quantity')</th>
                                            <th>@lang('lang.paid')</th>
                                            <th>@lang('lang.duePaid')</th>
                                            <th>@lang('lang.status')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($supplier_purchase_orders as $purchase_order)
                                            <tr>
                                                <td>{{ @format_date($purchase_order->transaction->transaction_date) }}</td>
                                                <td>{{ $purchase_order->transaction->po_no }}</td>
                                                <td>
                                                    @if (!empty($purchase_order->transaction->supplier))
                                                        {{ $purchase_order->transaction->supplier->name }}
                                                    @endif
                                                </td>
                                                <td>{{ $purchase_order->product->name }}</td>
                                                <td> {{ @num_format($purchase_order->quantity) }} </td>
                                                <td></td>
                                                {{-- <td>{{ $purchase_order->transaction->final_total }}</td> --}}
                                                {{-- <td>{{@num_format($purchase_order->transaction_payments->sum('amount'))}}</td> --}}
                                                <td></td>
                                                <td></td>
                                                {{-- <td>{{@num_format($purchase_order->final_total - $purchase_order->transaction_payments->sum('amount'))}}</td> --}}
                                                <td>
                                                    @if ($purchase_order->status == 'final')
                                                        <span class="badge badge-success">@lang('lang.completed')</span>
                                                    @elseif($purchase_order->status == 'sent_admin')
                                                        Sent Admin
                                                    @else
                                                        {{ ucfirst($purchase_order->status) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- +++++++++++++++++++++ Table 2 +++++++++++++++++++++ --}}
                            <div class="tab-pane fade"id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <table id="datatable-buttons" class="table table-striped table-button-wrapper table-bordered">
                                    <thead>
                                        <tr>
                                            <th>@lang('lang.date')</th>
                                            <th>@lang('lang.payment_ref')</th>
                                            <th>@lang('lang.sale_ref')</th>
                                            <th>@lang('lang.purchase_ref')</th>
                                            <th>@lang('lang.paid')</th>
                                            <th class="sum">@lang('lang.amount')</th>
                                            <th>@lang('lang.created_by')</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>


                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        {{-- <div class="table-responsive">

                            <div class="view_modal no-print" >

                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
@endsection

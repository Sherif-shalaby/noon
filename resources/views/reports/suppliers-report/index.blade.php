@extends('layouts.app')
@section('title', __('lang.supplier_report'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.supplier_report')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">/ @lang('lang.reports')</li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
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
    </div>
@endsection
@section('content')
    <div class="animate-in-page">

        <!-- Start Contentbar -->
        <div class="contentbar mb-0 pb-0">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h5 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
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
                            <ul class="nav nav-pills mb-3">
                                {{-- ####### Tab 1 ####### --}}
                                <li class="nav-item">
                                    <a class="nav-link active pt-2 pb-2" id="nav-home-tab" data-toggle="tab"
                                        href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
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

                            {{-- ================================ Tabs Body ================================ --}}
                            <div class="tab-content" id="nav-tabContent">
                                {{-- +++++++++++++++++++++ Table 1 +++++++++++++++++++++ --}}
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                        <div class="div1"></div>
                                    </div>
                                    <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                        <div class="div2 table-scroll-wrapper">
                                            <!-- content goes here -->
                                            <div style="min-width: 1800px;max-height: 90vh;overflow: auto">
                                                <table id="datatable-buttons"
                                                    class="table dataTable table-hover table-bordered ">
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
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.date')">
                                                                    {{ @format_date($add_stock->transaction->transaction_date) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.reference_no')">
                                                                    {{ $add_stock->transaction->invoice_no }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.supplier')">

                                                                    @if (!empty($add_stock->transaction->supplier))
                                                                        {{ $add_stock->transaction->supplier->name }}
                                                                    @endif
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.product')">

                                                                    @if (!empty($add_stock->product))
                                                                        {{ $add_stock->product->name }}
                                                                    @endif
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.grand_total')">

                                                                    {{ @num_format($add_stock->transaction->final_total) }}
                                                            </td>
                                                            </span>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.paid')">

                                                                    {{ @num_format($add_stock->transaction->transaction_payments->sum('amount')) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.duePaid')">

                                                                    {{ @num_format($add_stock->transaction->final_total - $add_stock->transaction->transaction_payments->sum('amount')) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.status')">
                                                                    {{ $add_stock->transaction->payment_status }}
                                                                </span>
                                                            </td>
                                                            {{-- @endforeach --}}
                                                        </tr>
                                                        @endforeach
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                {{-- +++++++++++++++++++++ Table 2 +++++++++++++++++++++ --}}
                                <div class="tab-pane fade"id="nav-profile" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                        <div class="div1"></div>
                                    </div>
                                    <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                        <div class="div2 table-scroll-wrapper">
                                            <!-- content goes here -->
                                            <div style="min-width: 1800px;max-height: 90vh;overflow: auto">
                                                <table id="datatable-buttons"
                                                    class="table dataTable table-hover table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th>@lang('lang.date')</th>
                                                            <th>@lang('lang.reference_no')</th>
                                                            <th>@lang('lang.supplier_name')</th>
                                                            {{-- <th>@lang('lang.product_name')</th> --}}
                                                            <th>@lang('lang.quantity')</th>
                                                            <th>@lang('lang.paid')</th>
                                                            <th>@lang('lang.duePaid')</th>
                                                            <th>@lang('lang.status')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($supplier_purchase_orders as $purchase_order)
                                                            <tr>
                                                                <td>
                                                                    <span
                                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                        style="font-size: 12px;font-weight: 600"
                                                                        data-tooltip="@lang('lang.date')">

                                                                        {{ @format_date($purchase_order->transaction->transaction_date) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                        style="font-size: 12px;font-weight: 600"
                                                                        data-tooltip="@lang('lang.reference_no')">

                                                                        {{ $purchase_order->transaction->po_no }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                        style="font-size: 12px;font-weight: 600"
                                                                        data-tooltip="@lang('lang.supplier_name')">
                                                                        @if (!empty($purchase_order->transaction->supplier))
                                                                            {{ $purchase_order->transaction->supplier->name }}
                                                                        @endif
                                                                    </span>
                                                                </td>
                                                                {{-- <td>{{$purchase_order->product->name}}</td> --}}
                                                                <td>
                                                                    <span
                                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                        style="font-size: 12px;font-weight: 600"
                                                                        data-tooltip="@lang('lang.quantity')">
                                                                        {{ @num_format($purchase_order->quantity) }}
                                                                    </span>
                                                                </td>
                                                                <td></td>
                                                                {{-- <td>{{ $purchase_order->transaction->final_total }}</td> --}}
                                                                {{-- <td>{{@num_format($purchase_order->transaction_payments->sum('amount'))}}</td> --}}
                                                                <td></td>
                                                                <td></td>
                                                                {{-- <td>{{@num_format($purchase_order->final_total - $purchase_order->transaction_payments->sum('amount'))}}</td> --}}
                                                                <td>
                                                                    <span
                                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                        style="font-size: 12px;font-weight: 600"
                                                                        data-tooltip="@lang('lang.status')">

                                                                        @if ($purchase_order->status == 'final')
                                                                            <span
                                                                                class="badge badge-success">@lang('lang.completed')</span>
                                                                        @elseif($purchase_order->status == 'sent_admin')
                                                                            Sent Admin
                                                                        @else
                                                                            {{ ucfirst($purchase_order->status) }}
                                                                        @endif
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                {{-- +++++++++++++++++++++ Table 3 +++++++++++++++++++++ --}}
                                <div class="tab-pane fade"id="nav-contact" role="tabpanel"
                                    aria-labelledby="nav-contact-tab">
                                    <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                        <div class="div1"></div>
                                    </div>
                                    <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                        <div class="div2 table-scroll-wrapper">
                                            <!-- content goes here -->
                                            <div style="min-width: 1800px;max-height: 90vh;overflow: auto">
                                                <table id="datatable-buttons" class="table table-striped table-bordered">
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
                                    </div>
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
    </div>
    <!-- End Contentbar -->
@endsection

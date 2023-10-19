@extends('layouts.app')
@section('title', __('lang.customer_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.customer_report')
                </h4>
                <div class="breadcrumb-list">
                    <ul style=" list-style: none;"
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                @lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                            aria-current="page">/ @lang('lang.reports')</li>
                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                            aria-current="page">@lang('lang.customer_report')</li>
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
                            @lang('lang.customer_report')</h5>
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
                                    المبيعات
                                </a>
                            </li>
                            {{-- ####### Tab 2 ####### --}}
                            <li class="nav-item">
                                <a class="nav-link pt-2 pb-2" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                    role="tab" aria-controls="nav-profile" aria-selected="false">
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
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>التاريخ</th>
                                            <th>رقم المرجع</th>
                                            <th>عميل</th>
                                            <th>منتج</th>
                                            <th>المبلغ الاجمالي</th>
                                            <th>دفٌعت</th>
                                            <th>متأخرات</th>
                                            <th>حالة المبيعات</th>
                                            <th>حالة السداد</th>
                                            {{-- <th>@lang('lang.action')</th>  --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer_transactions_sell_lines as $key => $customer_transactions_sell_line)
                                            <tr>
                                                <td>{{ $customer_transactions_sell_line->created_at->format('Y-m-d') }}</td>
                                                <td>{{ $customer_transactions_sell_line->invoice_no }}</td>
                                                <td>{{ $customer_transactions_sell_line->customer->name }}</td>
                                                {{-- Get All_sell_lines of transaction Then Get "product name" --}}
                                                <td>
                                                    <ul>
                                                        @foreach ($customer_transactions_sell_line->transaction_sell_lines as $transaction_sell_lines)
                                                            <li>{{ $transaction_sell_lines->product->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>{{ number_format($customer_transactions_sell_line->final_total, 2) }}
                                                </td>
                                                {{-- Get All_Payments of transaction Then Get "payment amount" --}}
                                                <td>{{ number_format($customer_transactions_sell_line->transaction_payments->sum('amount'), 2) }}
                                                </td>
                                                {{-- متاخرات --}}
                                                <td>
                                                    {{ number_format($customer_transactions_sell_line->transaction_payments->sum('amount') - $customer_transactions_sell_line->final_total, 2) }}
                                                </td>
                                                {{-- sells status --}}
                                                <td>{{ $customer_transactions_sell_line->status }}</td>
                                                {{-- payment status --}}
                                                <td>{{ $customer_transactions_sell_line->payment_status }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- +++++++++++++++++++++ Table 2 +++++++++++++++++++++ --}}
                            <div class="tab-pane fade"id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>التاريخ</th>
                                            <th>اسم العميل</th>
                                            <th>مرجع البيع</th>
                                            <th>مدفوعة</th>
                                            <th>المبلغ</th>
                                            <th>انشئ بواسطة</th>
                                            {{-- <th>@lang('lang.action')</th>  --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer_transactions_sell_line->transaction_payments as $key => $transaction_payment)
                                            <tr>
                                                <td>{{ $transaction_payment->created_at->format('Y-m-d') }}</td>
                                                <td>{{ $customer_transactions_sell_line->customer->name }}</td>
                                                <td>{{ $customer_transactions_sell_line->invoice_no }}</td>
                                                <td>{{ $transaction_payment->method }}</td>
                                                {{-- Get All_Payments of transaction Then Get sum of "payment amounts" --}}
                                                <td>{{ number_format($transaction_payment->sum('amount'), 2) }}</td>
                                                {{-- Created_by --}}
                                                <td>{{ $transaction_payment->created_by_user->name }}</td>
                                            </tr>
                                        @endforeach
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

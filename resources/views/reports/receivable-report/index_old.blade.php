@extends('layouts.app')
@section('title', __('lang.receivable_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.receivable_report')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.reports')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.receivable_report')</li>
                    </ol>
                </div>
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    @include('reports.receivable-report.filters')
                                </div>
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>تاريخ</th>
                                        <th>المرجعي</th>
                                        <th>عميل</th>
                                        <th>حالة المبيعات</th>
                                        <th>حالة السداد</th>
                                        {{-- <th>العملة المٌستلمة</th> --}}
                                        <th>المبلغ الاجمالي</th>
                                        {{-- <th>@lang('lang.action')</th>  --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $transaction_sell_lines as $key => $transaction_sell_line )
                                        <tr>
                                            <td>{{ $transaction_sell_line->created_at->format('Y-m-d') ?? ''}} </td>
                                            <td>{{ $transaction_sell_line->invoice_no ?? ''}}</td>
                                            <td>{{ $transaction_sell_line->customer->name ?? ''}}</td>
                                            <td>{{ $transaction_sell_line->status ?? ''}}</td>
                                            <td>{{ $transaction_sell_line->payment_status ?? ''}}</td>
                                            {{-- <td>{{ $transaction_sell_line->transaction_currency_relationship->symbol ?? ''}}</td> --}}
                                            <td>{{ $transaction_sell_line->final_total ?? ''}}</td>
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
    <!-- End Contentbar -->
@endsection



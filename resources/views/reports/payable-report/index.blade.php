@extends('layouts.app')
@section('title', __('lang.payable_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.payable_report')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.reports')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.payable_report')</li>
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
                                    {{-- @include('products.filters')  --}}
                                </div>
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>رقم الفاتورة</th>
                                        <th>التاريخ و الوقت</th>
                                        <th>المورد</th>
                                        <th>العملة المدفوعة</th>
                                        <th>المبلغ الاجمالي</th>
                                        <th>انشئ بواسطة</th>
                                        {{-- <th>@lang('lang.action')</th>  --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions_stock_lines as $key => $transactions_stock_line)
                                        <tr>
                                            <td>{{ $transactions_stock_line->invoice_no ?? '' }}</td>
                                            <td>{{ $transactions_stock_line->created_at ?? '' }}</td>
                                            <td>{{ $transactions_stock_line->supplier->name ?? '' }}</td>
                                            <td>{{ $transactions_stock_line->paying_currency_relationship->symbol ?? '' }}
                                            </td>
                                            <td>{{ $transactions_stock_line->final_total ?? '' }}</td>
                                            <td>{{ $transactions_stock_line->created_by_relationship->name ?? '' }}</td>
                                        </tr>
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

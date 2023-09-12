@extends('layouts.app')
@section('title', __('lang.reports'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.reports')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="font-weight-bold text-decoration-none text-dark font-18" href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.reports')</li>
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
                        <h5 class="card-title">@lang('lang.reports')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <ul>
                                <li>
                                    <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('purchases-report.index')}}">
                                        {{__('lang.purchases_report')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ sales report +++++++++++ --}}
                                <li>
                                    <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('sales-report.index')}}">
                                        {{__('lang.sales_report')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ receivable report +++++++++++ --}}
                                <li>
                                    <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('receivable-report.index')}}">
                                        {{__('lang.receivable_report')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ receivable report +++++++++++ --}}
                                <li>
                                    <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('payable-report.index')}}">
                                        {{__('lang.payable_report')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ customers report +++++++++++ --}}
                                <li>
                                    <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('customers-report.index')}}">
                                        {{__('lang.customers_report')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ Daily Report Summary +++++++++++ --}}
                                <li>
                                    <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('daily-report-summary.index')}}">
                                        {{__('lang.daily_report_summary')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ Get Due Report +++++++++++ --}}
                                <li>
                                    <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('get-due-report.index')}}">
                                        {{__('lang.get_due_report')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ Supplier Report +++++++++++ --}}
                                <li>
                                    <a class="font-weight-bold text-decoration-none text-dark font-18" href="{{route('get-supplier-report.index')}}">
                                        {{__('lang.supplier_report')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
@endsection

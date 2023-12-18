@extends('layouts.app')
@section('title', __('lang.daily_report_summary'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.daily_report_summary')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">/ @lang('lang.reports')</li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.daily_report_summary')</li>
                        </ul>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
@section('content')

    <!-- Start Contentbar -->
    <div class="contentbar mb-0 pb-0">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card mb-0">
                    <div class="card-header">
                        <h5 class="card-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            @lang('lang.daily_report_summary')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    {{-- @include('products.filters')  --}}
                                </div>
                            </div>
                        </div>
                        {{-- ================================ Tabs Body ================================ --}}
                        <div class="col-md-12">
                            <table
                                class="table table-striped table-hover table-bordered mb-0 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <tbody>
                                    @php
                                        // ///////////////////// التدفقات النقدية الخارجة /////////////////////
                                        $purchase_final_total_dinar = !empty($transactions_stock_lines->sum('final_total')) ? $transactions_stock_lines->sum('final_total') : '';
                                        $purchase_final_total_dollar = !empty($transactions_stock_lines->sum('dollar_final_total')) ? $transactions_stock_lines->sum('dollar_final_total') : '';
                                        // ///////////////////// التدفقات النقدية الداخلة /////////////////////
                                        $sell_final_total_dinar = !empty($transactions_sell_lines->sum('final_total')) ? $transactions_sell_lines->sum('final_total') : '';
                                        $sell_final_total_dollar = !empty($transactions_sell_lines->sum('dollar_final_total')) ? $transactions_sell_lines->sum('dollar_final_total') : '';
                                        // ///////////////////// مرتبات الموظفين /////////////////////
                                        $wages_employees_total = $employees_wage->sum('final_total');
                                    @endphp
                                    {{-- +++++++++ Row 1 : التدفقات النقدية الخارجة +++++++++ --}}
                                    <tr>
                                        <td>
                                            <b>التدفقات النقدية الخارجة</b>
                                        </td>
                                        <td>
                                            {{-- ============== Dinar Only ============== --}}
                                            @if (!empty($purchase_final_total_dinar) && empty($purchase_final_total_dollar))
                                                {{ $purchase_final_total_dinar + $wages_employees_total }} <b>Dollar</b>
                                                {{-- ============== Dollar Only ============== --}}
                                            @elseif(!empty($purchase_final_total_dollar) && empty($purchase_final_total_dinar))
                                                <span class="dollar-cell">
                                                    {{ $purchase_final_total_dinar + $wages_employees_total }} <b>Dinar</b>
                                                </span>
                                                {{-- ============== Dinar And Dollar ============== --}}
                                            @else
                                                <span class="dollar-cell">
                                                    {{ $purchase_final_total_dollar + $wages_employees_total }}
                                                    <b>dollar</b>
                                                </span> <br />
                                                {{ $purchase_final_total_dinar + $wages_employees_total }} <b>dinar</b>
                                            @endif
                                        </td>
                                    </tr>
                                    {{-- +++++++++ Row 2 : التدفقات النقدية الداخلة +++++++++ --}}
                                    <tr>
                                        <td>
                                            <b>التدفقات النقدية الداخلة</b>
                                        </td>
                                        <td>
                                            {{-- ============== Dinar Only ============== --}}
                                            @if (!empty($sell_final_total_dinar) && empty($sell_final_total_dollar))
                                                {{ $sell_final_total_dinar }} <b>dinar</b>
                                                {{-- ============== Dollar Only ============== --}}
                                            @elseif(!empty($sell_final_total_dollar) && empty($purchase_final_total_dinar))
                                                <span class="dollar-cell">
                                                    {{ $sell_final_total_dollar }} <b>dollar</b>
                                                </span>
                                                {{-- ============== Dinar And Dollar ============== --}}
                                            @else
                                                <span class="dollar-cell">
                                                    {{ $sell_final_total_dollar }} <b>dollar</b> <br />
                                                </span>
                                                {{ $sell_final_total_dinar }} <b>dinar</b>
                                            @endif
                                        </td>
                                    </tr>
                                    {{-- +++++++++ Row 3 :المبيعات +++++++++ --}}
                                    <tr>
                                        <td>
                                            <b>المبيعات</b>
                                        </td>
                                        <td>
                                            {{-- ============== Dinar Only ============== --}}
                                            @if (!empty($sell_final_total_dinar) && empty($sell_final_total_dollar))
                                                {{ $sell_final_total_dinar }} <b>dollar</b>
                                                {{-- ============== Dollar Only ============== --}}
                                            @elseif(!empty($sell_final_total_dollar) && empty($purchase_final_total_dinar))
                                                <span class="dollar-cell">
                                                    {{ $sell_final_total_dollar }} <b>dinar</b>
                                                </span>
                                                {{-- ============== Dinar And Dollar ============== --}}
                                            @else
                                                {{ $sell_final_total_dinar }} <b>dinar</b> <br />
                                                <span class="dollar-cell">
                                                    {{ $sell_final_total_dollar }} <b>dollar</b>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    {{-- +++++++++ Row 4 : مرتبات الموظفين +++++++++ --}}
                                    <tr>
                                        <td>
                                            <b>مرتبات الموظفين</b>
                                        </td>
                                        <td> {{ $wages_employees_total }} <b>dinar</b> </td>
                                    </tr>
                                    {{-- +++++++++ Row 5 : المشتريات +++++++++ --}}
                                    <tr>
                                        <td>
                                            <b>المشتريات</b>
                                        </td>
                                        <td>
                                            {{-- ============== Dinar Only ============== --}}
                                            @if (!empty($purchase_final_total_dinar) && empty($purchase_final_total_dollar))
                                                {{ $purchase_final_total_dinar }} <b>dinar</b>
                                                {{-- ============== Dollar Only ============== --}}
                                            @elseif(!empty($purchase_final_total_dollar) && empty($purchase_final_total_dinar))
                                                <span class="dollar-cell">
                                                    {{ $purchase_final_total_dinar }} <b>dollar</b>
                                                </span>
                                                {{-- ============== Dinar And Dollar ============== --}}
                                            @else
                                                <span class="dollar-cell">
                                                    {{ $purchase_final_total_dollar }} <b>dollar</b><br />
                                                </span>
                                                {{ $purchase_final_total_dinar }} <b>dinar</b>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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

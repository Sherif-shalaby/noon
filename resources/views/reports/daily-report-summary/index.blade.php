@extends('layouts.app')
@section('title', __('lang.daily_report_summary'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.daily_report_summary')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.reports')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.daily_report_summary')</li>
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
                        <h5 class="card-title">@lang('lang.daily_report_summary')</h5>
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
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    @php
                                        // ///////////////////// التدفقات النقدية الخارجة /////////////////////
                                        $purchase_final_total_dinar =( !empty($transactions_stock_lines->sum('final_total')) ?  $transactions_stock_lines->sum('final_total'):'');
                                        $purchase_final_total_dollar=( !empty($transactions_stock_lines->sum('dollar_final_total')) ? $transactions_stock_lines->sum('dollar_final_total'):'');
                                        // ///////////////////// التدفقات النقدية الداخلة /////////////////////
                                        $sell_final_total_dinar  = ( !empty($transactions_sell_lines->sum('final_total')) ?  $transactions_sell_lines->sum('final_total'):'');
                                        $sell_final_total_dollar = ( !empty($transactions_sell_lines->sum('dollar_final_total')) ?  $transactions_sell_lines->sum('dollar_final_total'):'');
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
                                            @if( !empty($purchase_final_total_dinar) && empty($purchase_final_total_dollar) )
                                                {{ $purchase_final_total_dinar + $wages_employees_total }} <b>Dollar</b>
                                            {{-- ============== Dollar Only ============== --}}
                                            @elseif( !empty($purchase_final_total_dollar) && empty($purchase_final_total_dinar) )
                                                {{ $purchase_final_total_dinar + $wages_employees_total }} <b>Dinar</b>
                                            {{-- ============== Dinar And Dollar ============== --}}
                                            @else
                                                {{ $purchase_final_total_dinar + $wages_employees_total }} <b>dollar</b> <br/>
                                                {{ $purchase_final_total_dollar + $wages_employees_total }} <b>dinar</b>
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
                                            @if( !empty($sell_final_total_dinar) && empty($sell_final_total_dollar) )
                                                {{ $sell_final_total_dinar }} <b>dollar</b>
                                            {{-- ============== Dollar Only ============== --}}
                                            @elseif( !empty($sell_final_total_dollar) && empty($purchase_final_total_dinar) )
                                                {{ $sell_final_total_dollar }} <b>dinar</b>
                                            {{-- ============== Dinar And Dollar ============== --}}
                                            @else
                                                {{ $sell_final_total_dinar }} <b>dollar</b> <br/>
                                                {{ $sell_final_total_dollar }} <b>dinar</b>
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
                                            @if( !empty($sell_final_total_dinar) && empty($sell_final_total_dollar) )
                                                {{ $sell_final_total_dinar }} <b>dollar</b>
                                            {{-- ============== Dollar Only ============== --}}
                                            @elseif( !empty($sell_final_total_dollar) && empty($purchase_final_total_dinar) )
                                                {{ $sell_final_total_dollar }} <b>dinar</b>
                                            {{-- ============== Dinar And Dollar ============== --}}
                                            @else
                                                {{ $sell_final_total_dinar }} <b>dollar</b> <br/>
                                                {{ $sell_final_total_dollar }} <b>dinar</b>
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
                                            @if( !empty($purchase_final_total_dinar) && empty($purchase_final_total_dollar) )
                                                {{ $purchase_final_total_dinar }} <b>dinar</b>
                                            {{-- ============== Dollar Only ============== --}}
                                            @elseif( !empty($purchase_final_total_dollar) && empty($purchase_final_total_dinar) )
                                                {{ $purchase_final_total_dinar }} <b>dollar</b>
                                            {{-- ============== Dinar And Dollar ============== --}}
                                            @else
                                                {{ $purchase_final_total_dinar }} <b>dinar</b> <br/>
                                                {{ $purchase_final_total_dollar }} <b>dollar</b>
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


@extends('layouts.app')
@section('title', __('lang.payable_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.payable_report')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.reports')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.payable_report')</li>
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
                                    @include('reports.payable-report.filters')
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>@lang('lang.total_paid')</th>
                                        <th>@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // ///////////////////// الرواتب/////////////////////
                                        $wage_transactions_final_total =( !empty($wage_transactions->sum('final_total')) ?  $wage_transactions->sum('final_total'):'');
                                        // ///////////////////// المشتريات /////////////////////
                                        $stock_transactions_final_total = ( !empty($stock_transactions->sum('final_total')) ?  $stock_transactions->sum('final_total'):'');
                                    @endphp

                                    {{-- ++++++++++++++++++ Row 1 : الرواتب ++++++++++++++++++ --}}
                                    <tr>
                                        {{-- ====== column header ====== --}}
                                        <td>
                                            <b>@lang('lang.wages')</b>
                                        </td>
                                        {{-- ====== wage_transactions_final_total ====== --}}
                                        <td>
                                            @if( !empty($wage_transactions_final_total) )
                                                {{ $wage_transactions_final_total }}
                                            @endif
                                        </td>
                                        {{-- ====== Actions button ====== --}}
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                                <li>
                                                    <a href="{{route('wages.index')}}" class="btn" target="_blank">
                                                        <i  class="fa fa-eye"></i>
                                                        @lang('lang.view') </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    {{-- +++++++++ Row 2 : المشتريات +++++++++ --}}
                                    <tr>
                                        {{-- ====== column header ====== --}}
                                        <td>
                                            <b>@lang('lang.stock')</b>
                                        </td>
                                        {{-- ====== stock_transactions_final_total ====== --}}
                                        <td>
                                            @if( !empty($stock_transactions_final_total) )
                                                {{ $stock_transactions_final_total }}
                                            @endif
                                        </td>
                                        {{-- ====== Actions button ====== --}}
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                                <li>
                                                    <a href="{{route('stocks.index')}}" class="btn"  target="_blank">
                                                        <i class="fa fa-eye"></i>
                                                        @lang('lang.view')
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    {{-- +++++++++ Row 3 : مجموع الرواتب و المشتريات  +++++++++ --}}
                                    <tr>
                                        {{-- ====== column header ====== --}}
                                        <td>
                                            <b>@lang('lang.total')</b>
                                        </td>
                                        {{-- ====== sum of stock_transactions and wage_transactions final_total ====== --}}
                                        <td>
                                            @if( !empty($wage_transactions_final_total) && !empty($stock_transactions_final_total)  )
                                                {{ $wage_transactions_final_total + $stock_transactions_final_total }}
                                            @endif
                                        </td>
                                        {{-- ====== Actions button ====== --}}
                                        <td>

                                        </td>
                                    </tr>
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



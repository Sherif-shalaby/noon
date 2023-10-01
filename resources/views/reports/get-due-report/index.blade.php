@extends('layouts.app')
@section('title', __('lang.get_due_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.get_due_report')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.reports')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.get_due_report')</li>
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
                                    <th>#</th>
                                    <th>@lang('lang.date')</th>
                                    <th>@lang('lang.reference')</th>
                                    <th>@lang('lang.customer')</th>
                                    <th>@lang('lang.amount')</th>
                                    <th>@lang('lang.paid')</th>
                                    <th>@lang('lang.duePaid')</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1 ;
                                        $total_paid = 0;
                                        $total_due = 0;
                                    @endphp
                                    @foreach ($dues as $due)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{@format_date($due->transaction_date)}}</td>
                                        <td> {{$due->invoice_no}}</td>
                                        <td> {{$due->customer->name ?? ''}}</td>
                                        <td> {{@num_format($due->final_total)}}</td>
                                        <td> {{@num_format($due->transaction_payments->sum('amount'))}}</td>
                                        <td> {{@num_format($due->final_total - $due->transaction_payments->sum('amount'))}}</td>
                                    </tr>
                                    @php
                                        $i++ ;
                                        $total_paid += $due->transaction_payments->sum('amount');
                                        $total_due += $due->final_total - $due->transaction_payments->sum('amount');
                                    @endphp
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



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
                                        <th>{{ __('lang.date') }}</th>
                                        <th>{{ __('lang.reciever') }}</th>
                                        <th>{{ __('lang.received_amount') }}</th>
                                        <th>{{ __('lang.paid_by') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cash_register_transactions as $key => $cash_register_transaction)
                                        <tr>
                                            <td>{{ $cash_register_transaction->created_at->format('Y-m-d') ?? '' }}</td>

                                            <!-- Accessing the cash_register relationship to get the user's cash_register_id -->
                                            <td>{{ $cash_register_transaction->cash_register->cashier->name ?? '' }}</td>

                                            <td>{{ $cash_register_transaction->amount ?? '' }}</td>

                                            <!-- Accessing the cash_register relationship to get the user_id -->
                                            <td>{{ $cash_register_transaction->cash_register->store_pos->name ?? '' }}</td>
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



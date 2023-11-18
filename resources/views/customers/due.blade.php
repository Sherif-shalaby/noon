@extends('layouts.app')
@section('title', __('lang.dues'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.dues')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.due')</li>
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
                        <h5 class="card-title">@lang('lang.due')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    <form action="{{route('dues')}}" method="get">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                    {{-- <label for="date">@lang('lang.date')</label> --}}
                                                    <input type="date" class="form-control" name="date"
                                                        id="date" placeholder="@lang('lang.date')">
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="form-group">
                                                    <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                                                        <i class="fa fa-eye"></i> {{ __('Search') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
                                    <th>@lang('lang.actions')</th>
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
                                        <td class="col18">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات                                            <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <li>
                                                        <a data-href="{{route('customers.pay_due_view', ['id' => $due->id])}}"   data-container=".view_modal" class="btn btn-modal" ><i class="dripicons-document-edit"></i> @lang('lang.pay_due')</a>
                                                    </li>
                                                    {{-- <li class="divider"></li>
                                                        <li>
                                                            <a data-href="{{route('customers.destroy', $customer->id)}}"
                                                                class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                                @lang('lang.delete')</a>
                                                    </li> --}}
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $i++ ;
                                        $total_paid += $due->transaction_payments->sum('amount');
                                        $total_due += $due->final_total - $due->transaction_payments->sum('amount');
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
    <div class="view_modal no-print" >

    </div>
@endsection
<script>

</script>



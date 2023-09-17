@extends('layouts.app')
@section('title', __('lang.customers'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.customers')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.customers')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('customers.create')}}" class="btn btn-primary">
                        @lang('lang.add_customers')
                      </a>
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
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.customers')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    {{-- @include('customers.filters') --}}
                                </div>
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('lang.name')</th>
                                    <th>@lang('lang.customer_type')</th>
                                    <th>@lang('lang.email')</th>
                                    <th>@lang('lang.phone')</th>
                                    <th>@lang('lang.min_amount_in_dinar')</th>
                                    <th>@lang('lang.max_amount_in_dinar')</th>
                                    <th>@lang('lang.min_amount_in_dollar')</th>
                                    <th>@lang('lang.max_amount_in_dollar')</th>
                                    <th>@lang('lang.balance_in_dinar')</th>
                                    <th>@lang('lang.balance_in_dollar')</th>
                                    <th>@lang('lang.balance')</th>
                                    <th>@lang('lang.purchases')</th>
                                    <th>@lang('lang.discount')</th>
                                    <th>@lang('lang.points')</th>
                                    <th>@lang('updated_by')</th>
                                    <th>@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $index=>$customer)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                   <td>{{$customer->name}}</td>
                                   <td>{{$customer->customer_type->name}}</td>
                                    <td>{{$customer->email}}</td>
                                    <td>{{$customer->phone}}</td>
                                    <td>{{ $customer->min_amount_in_dinar }}</td>
                                    <td>{{ $customer->max_amount_in_dinar }}</td>
                                    <td>{{ $customer->min_amount_in_dollar }}</td>
                                    <td>{{ $customer->max_amount_in_dollar }}</td>
                                    <td>{{ $customer->balance_in_dinar }}</td>
                                    <td>{{ $customer->balance_in_dollar }}</td>
                                    <td>{{$customer->added_balance}}</td>
                                    <td>{{$customer->added_balance}}</td>
                                    <td>{{$customer->added_balance}}</td>
                                    <td>
                                        @if ($customer->created_by  > 0 and $customer->created_by != null)
                                            {{ $customer->created_at->diffForHumans() }} <br>
                                            {{ $customer->created_at->format('Y-m-d') }}
                                            ({{ $customer->created_at->format('h:i') }})
                                            {{ ($customer->created_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                            {{ $customer->createBy?->name }}
                                        @else
                                        {{ __('no_update') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($customer->updated_by  > 0 and $customer->updated_by != null)
                                            {{ $customer->updated_at->diffForHumans() }} <br>
                                            {{ $customer->updated_at->format('Y-m-d') }}
                                            ({{ $customer->updated_at->format('h:i') }})
                                            {{ ($customer->updated_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                            {{ $customer->updateBy?->name }}
                                        @else
                                           {{ __('no_update') }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات                                            <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <li>
                                                    <a href="{{route('customers.edit', $customer->id)}}" class="btn" target="_blank"><i class="dripicons-document-edit"></i> @lang('lang.update')</a>
                                                </li>
                                                <li class="divider"></li>
                                                    <li>
                                                        <a data-href="{{route('customers.destroy', $customer->id)}}"
                                                            class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                            @lang('lang.delete')</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
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
@endsection

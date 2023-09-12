@extends('layouts.app')
@section('title', __('lang.wages'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.wages')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.wages')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('wages.create')}}" class="btn btn-primary">
                        @lang('lang.add_wages')
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
                        <h5 class="card-title">@lang('lang.wages')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    {{-- @include('wages.filters') --}}
                                </div>
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('lang.date_of_creation')</th>
                                    <th>@lang('lang.name')</th>
                                    <th>@lang('lang.account_period')</th>
                                    <th>@lang('lang.job_title')</th>
                                    <th>@lang('lang.amount_paid')</th>
                                    <th>@lang('lang.type_of_payment')</th>
                                    <th>@lang('lang.date_of_payment')</th>
                                    <th>@lang('lang.paid_by')</th>
                                    <th>@lang('lang.status')</th>
                                    <th>@lang('added_by')</th>
                                    <th>@lang('updated_by')</th>
                                    <th>@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($wages as $index=>$wage)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{$wage->date_of_creation}}</td>
                                   <td>{{$wage->employee->employee_name}}</td>
                                   <td>
                                        @if ($wage->payment_type == 'salary')
                                        {{ \Carbon\Carbon::parse($wage->account_period)->format('F') }}
                                        @else
                                            @if (!empty($wage->acount_period_start_date))
                                                {{ @format_date($wage->acount_period_start_date) }}
                                            @endif
                                            -
                                            @if (!empty($wage->acount_period_end_date))
                                                {{ @format_date($wage->acount_period_end_date) }}
                                            @endif
                                        @endif
                                   </td>
                                   <td></td>
                                    {{-- <td>{{$wage->employee->job_type->title}}</td> --}}
                                    <td>
                                        {{-- {{ $settings['currency'] }} --}}
                                        {{ @num_format($wage->net_amount) }}
                                    </td>
                                    <td>
                                        @if (!empty($payment_types[$wage->payment_type]))
                                        {{ $payment_types[$wage->payment_type] }}
                                        @endif
                                    </td>
                                    <td>{{ @format_date($wage->payment_date) }}</td>
                                    <td>
                                        @if (!empty($wage->wage_transaction))
                                        {{ $wage->wage_transaction->source->name }}
                                        @endif
                                    </td>
                                    <td>{{ ucfirst($wage->status) }}</td>
                                    <td>
                                        @if ($wage->created_by  > 0 and $wage->created_by != null)
                                            {{ $wage->created_at->diffForHumans() }} <br>
                                            {{ $wage->created_at->format('Y-m-d') }}
                                            ({{ $wage->created_at->format('h:i') }})
                                            {{ ($wage->created_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                            {{ $wage->createBy?->name }}
                                        @else
                                        {{ __('no_update') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($wage->updated_by  > 0 and $wage->updated_by != null)
                                            {{ $wage->updated_at->diffForHumans() }} <br>
                                            {{ $wage->updated_at->format('Y-m-d') }}
                                            ({{ $wage->updated_at->format('h:i') }})
                                            {{ ($wage->updated_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                            {{ $wage->updateBy?->name }}
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
                                                    <a href="{{route('wages.edit', $wage->id)}}" class="btn" target="_blank"><i class="dripicons-document-edit"></i> @lang('lang.update')</a>
                                                </li>
                                                <li class="divider"></li>
                                                    <li>
                                                        <a data-href="{{route('wages.destroy', $wage->id)}}"
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

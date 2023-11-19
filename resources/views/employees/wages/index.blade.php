@extends('layouts.app')
@section('title', __('lang.wages'))
@section('breadcrumbbar')
    <div class="animate-in-page">


        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.wages')
                    </h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.wages')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <a href="{{ route('wages.create') }}" class="btn btn-primary">
                            @lang('lang.add_wages')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">

        <!-- Start Contentbar -->
        <div class="contentbar">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.wages')</h5>
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
                            <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered table-button-wrapper">
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
                                        @foreach ($wages as $index => $wage)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <span class="custom-tooltip" data-tooltip="@lang('lang.date_of_creation')">
                                                        {{ $wage->date_of_creation }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="custom-tooltip" data-tooltip="@lang('lang.name')">
                                                        {{ $wage->employee->employee_name }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="custom-tooltip" data-tooltip="@lang('lang.account_period')">

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
                                                    </span>
                                                </td>
                                                <td></td>
                                                {{-- <td>{{$wage->employee->job_type->title}}</td> --}}
                                                <td>
                                                    {{-- {{ $settings['currency'] }} --}}
                                                    <span class="custom-tooltip" data-tooltip="@lang('lang.amount_paid')">
                                                        {{ @num_format($wage->net_amount) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="custom-tooltip" data-tooltip="@lang('lang.type_of_payment')">

                                                        @if (!empty($payment_types[$wage->payment_type]))
                                                            {{ $payment_types[$wage->payment_type] }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="custom-tooltip" data-tooltip="@lang('lang.date_of_payment')">
                                                        {{ @format_date($wage->payment_date) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="custom-tooltip" data-tooltip="@lang('lang.paid_by')">
                                                        @if (!empty($wage->wage_transaction))
                                                            {{ $wage->wage_transaction->source->name }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="custom-tooltip" data-tooltip="@lang('lang.status')">
                                                        {{ ucfirst($wage->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="custom-tooltip" data-tooltip="@lang('added_by')">

                                                        @if ($wage->created_by > 0 and $wage->created_by != null)
                                                            {{ $wage->created_at->diffForHumans() }} <br>
                                                            {{ $wage->created_at->format('Y-m-d') }}
                                                            ({{ $wage->created_at->format('h:i') }})
                                                            {{ $wage->created_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                            <br>
                                                            {{ $wage->createBy?->name }}
                                                        @else
                                                            {{ __('no_update') }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="custom-tooltip" data-tooltip="@lang('updated_by')">
                                                        @if ($wage->updated_by > 0 and $wage->updated_by != null)
                                                            {{ $wage->updated_at->diffForHumans() }} <br>
                                                            {{ $wage->updated_at->format('Y-m-d') }}
                                                            ({{ $wage->updated_at->format('h:i') }})
                                                            {{ $wage->updated_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                            <br>
                                                            {{ $wage->updateBy?->name }}
                                                        @else
                                                            {{ __('no_update') }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">خيارات <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu" x-placement="bottom-end"
                                                            style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                            <li>
                                                                <a href="{{ route('wages.edit', $wage->id) }}"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                                    target="_blank"><i class="dripicons-document-edit"></i>
                                                                    @lang('lang.update')</a>
                                                            </li>

                                                            <li>
                                                                <a data-href="{{ route('wages.destroy', $wage->id) }}"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif text-red delete_item"><i
                                                                        class="fa fa-trash"></i>
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
    </div>
@endsection

@extends('layouts.app')
@section('title', __('lang.employees'))

@push('css')
    <style>
        .table-top-head {
            top: 35px;
        }

        .wrapper1 {
            margin-top: 35px;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 125px;
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.employees')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.employees')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a class="btn btn-primary" href="{{ route('employees.create') }}">@lang('lang.add_employee')</a>
    </div>
@endsection

@section('content')
    <div class="animate-in-page">

        <div class="container-fluid">
            <div class="col-md-12  no-print">
                <div class="card mt-1">
                    <div
                        class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                        <h6 class="print-title">
                            @lang('lang.employees')</h6>
                    </div>
                    <div class="card-body">
                        <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div1"></div>
                        </div>
                        <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div2 table-scroll-wrapper">
                                <!-- content goes here -->
                                <div style="min-width: 1300px;max-height: 90vh;overflow: auto">
                                    <table id="datatable-buttons" class="table dataTable">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.profile_photo')</th>
                                                <th>@lang('lang.employee_name')</th>
                                                <th>@lang('lang.email')</th>
                                                <th>@lang('lang.phone_number')</th>
                                                <th>@lang('lang.job_title')</th>
                                                <th class="sum">@lang('lang.wage')</th>
                                                {{--                                <th>@lang('lang.annual_leave_balance')</th> --}}
                                                <th>@lang('lang.age')</th>
                                                <th>@lang('lang.date_of_start_working')</th>
                                                <th>@lang('lang.stores')</th>
                                                {{--                                <th>@lang('lang.current_status')</th> --}}
                                                <th>@lang('lang.pos')</th>
                                                <th>@lang('lang.commission')</th>
                                                <th>@lang('lang.total_paid')</th>
                                                <th>@lang('lang.pending')</th>
                                                <th class="notexport">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($employees as $key => $employee)
                                                <tr>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.profile_photo')">
                                                            @if (!empty($employee->photo))
                                                                <div style="width: 50px;height: 50px;">
                                                                    <img src="{{ '/uploads/' . $employee->photo }}"
                                                                        alt="photo" style="width: 100%;height: 100$;">
                                                                </div>
                                                            @else
                                                                <div style="width: 50px;height: 50px;">
                                                                    <img src="{{ '/uploads/' . session('logo') }}"
                                                                        alt="photo" style="width: 100%;height: 100$;">
                                                                </div>
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.employee_name')">

                                                            {{ !empty($employee->user) ? $employee->user->name : '' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.email')">

                                                            {{ !empty($employee->user) ? $employee->user->email : '' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.phone_number')">

                                                            {{ $employee->mobile }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.job_title')">

                                                            {{ !empty($employee->job_type) ? $employee->job_type->title : '' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.wage')">

                                                            {{ $employee->fixed_wage_value }}
                                                        </span>
                                                    </td>
                                                    {{--                                        <td></td> --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.age')">

                                                            {{ \Carbon\Carbon::parse($employee->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.date_of_start_working')">

                                                            {{ $employee->date_of_start_working }}
                                                        </span>
                                                    </td>
                                                    <td>

                                                        @foreach ($employee->stores()->get() as $store)
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.stores')">
                                                                {{ $store->name }}
                                                            </span>
                                                        @endforeach
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-default btn-sm dropdown-toggle d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            @lang('lang.action')
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu">
                                                            <li>
                                                                <a href="{{ route('employees.show', $employee->id) }}"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                        class="fa fa-eye"></i>
                                                                    @lang('lang.view') </a>
                                                            </li>


                                                            <li>
                                                                <a href="{{ route('employees.edit', $employee->id) }}"
                                                                    target="_blank"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif edit_employee"><i
                                                                        class="fa fa-pencil-square-o"></i>
                                                                    @lang('lang.edit')</a>
                                                            </li>

                                                            <li>
                                                                <a data-href="{{ route('employees.destroy', $employee->id) }}"
                                                                    {{--                                                       data-check_password="{{action('UserController@checkPassword', Auth::user()->id) }}" --}}
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif delete_item text-red delete_item"><i
                                                                        class="fa fa-trash"></i>
                                                                    @lang('lang.delete')</a>
                                                            </li>
                                                            @if (!empty($employee->job_type) && $employee->job_type->title == 'Representative')
                                                                <li>
                                                                    <a href="{{ route('employees.add_points') }}"
                                                                        class="btn add_point"><i class="fa fa-plus"></i>
                                                                        @lang('lang.add_points')
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

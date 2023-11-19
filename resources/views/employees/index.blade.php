@extends('layouts.app')
@section('title', __('lang.employees'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.employees')
                    </h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a>
                            </li>
                            {{--                        <li class="breadcrumb-item active"><a href="#">@lang('lang.employees')</a></li> --}}
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.employees')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <a class="btn btn-primary" href="{{ route('employees.create') }}">@lang('lang.add_employee')</a>
                        {{--                    <a style="color: white" href="{{ action('EmployeeController@create') }}" class="btn btn-info"><i --}}
                        {{--                            class="dripicons-plus"></i> --}}
                        {{--                        @lang('lang.add_new_employee')</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">

        <div class="container-fluid">
            <div class="col-md-12  no-print">
                <div class="card mt-3">
                    <div
                        class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                        <h4 class="print-title">
                            @lang('lang.employees')</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                            <table id="datatable-buttons" class="table dataTable table-button-wrapper">
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
                                                            <img src="{{ '/uploads/' . $employee->photo }}" alt="photo"
                                                                style="width: 100%;height: 100$;">
                                                        </div>
                                                    @else
                                                        <div style="width: 50px;height: 50px;">
                                                            <img src="{{ '/uploads/' . session('logo') }}" alt="photo"
                                                                style="width: 100%;height: 100$;">
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
                                                    user="menu">';
                                                    <li>
                                                        <a href="{{ route('employees.show', $employee->id) }}"
                                                            class="btn"><i class="fa fa-eye"></i>
                                                            @lang('lang.view') </a>
                                                    </li>
                                                    <li class="divider"></li>

                                                    <li>
                                                        <a href="{{ route('employees.edit', $employee->id) }}"
                                                            target="_blank" class="btn edit_employee"><i
                                                                class="fa fa-pencil-square-o"></i>
                                                            @lang('lang.edit')</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a data-href="{{ route('employees.destroy', $employee->id) }}"
                                                            {{--                                                       data-check_password="{{action('UserController@checkPassword', Auth::user()->id) }}" --}}
                                                            class="btn delete_item text-red delete_item"><i
                                                                class="fa fa-trash"></i>
                                                            @lang('lang.delete')</a>
                                                    </li>
                                                    @if (!empty($employee->job_type) && $employee->job_type->title == 'Representative')
                                                        <li class="divider"></li>
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


@endsection

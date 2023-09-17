@extends('layouts.app')
@section('title', __('lang.employees'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.employees')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        {{--                        <li class="breadcrumb-item active"><a href="#">@lang('lang.employees')</a></li>--}}
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.employees')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a  class="btn btn-primary" href="{{route('employees.create')}}">@lang('lang.add_employee')</a>
                    {{--                    <a style="color: white" href="{{ action('EmployeeController@create') }}" class="btn btn-info"><i--}}
                    {{--                            class="dripicons-plus"></i>--}}
                    {{--                        @lang('lang.add_new_employee')</a>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="col-md-12  no-print">
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center">
                    <h4 class="print-title">@lang('lang.employees')</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                            <tr>
                                <th>@lang('lang.profile_photo')</th>
                                <th>@lang('lang.employee_name')</th>
                                <th>@lang('lang.email')</th>
                                <th>@lang('lang.phone_number')</th>
                                <th>@lang('lang.job_title')</th>
                                <th class="sum">@lang('lang.wage')</th>
{{--                                <th>@lang('lang.annual_leave_balance')</th>--}}
                                <th>@lang('lang.age')</th>
                                <th>@lang('lang.date_of_start_working')</th>
                                <th>@lang('lang.stores')</th>
{{--                                <th>@lang('lang.current_status')</th>--}}
                                <th>@lang('lang.pos')</th>
                                <th>@lang('lang.commission')</th>
                                <th>@lang('lang.total_paid')</th>
                                <th>@lang('lang.pending')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                            </thead>
                            <tbody>

                                @foreach($employees as $key => $employee)
                                    <tr>
                                        <td>
                                            @if (!empty($employee->photo))
                                                <img src="{{"/uploads/". $employee->photo}}" alt="photo" width="50" height="50">
                                            @else
                                                <img src="{{"/uploads/". session('logo')}}" alt="photo" width="50" height="50">
                                            @endif
                                        </td>
                                        <td>
                                            {{!empty($employee->user) ? $employee->user->name : ''}}
                                        </td>
                                        <td>
                                            {{!empty($employee->user) ? $employee->user->email : ''}}
                                        </td>
                                        <td>
                                            {{$employee->mobile}}
                                        </td>
                                        <td>
                                            {{!empty($employee->job_type) ? $employee->job_type->title : '' }}
                                        </td>
                                        <td>
                                            {{$employee->fixed_wage_value}}
                                        </td>
{{--                                        <td></td>--}}
                                        <td>
                                            {{\Carbon\Carbon::parse($employee->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y')}}
                                        </td>
                                        <td>
                                            {{$employee->date_of_start_working}}
                                        </td>
                                        <td>
                                            @foreach($employee->stores()->get() as $store)
                                                {{$store->name}}
                                            @endforeach
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                             <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                     aria-haspopup="true" aria-expanded="false">
                                                 @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">';
                                                <li>
                                                    <a href="{{route('employees.show', $employee->id)}}"
                                                       class="btn"><i
                                                            class="fa fa-eye"></i>
                                                         @lang('lang.view') </a>
                                                </li>
                                                <li class="divider"></li>

                                                <li>
                                                    <a href="{{route('employees.edit', $employee->id)}}"
                                                       class="btn edit_employee"><i
                                                            class="fa fa-pencil-square-o"></i>
                                                        @lang('lang.edit')</a>
                                                </li>
                                               <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{route('employees.destroy', $employee->id)}}"
{{--                                                       data-check_password="{{action('UserController@checkPassword', Auth::user()->id) }}"--}}
                                                       class="btn delete_item text-red delete_item"><i
                                                            class="fa fa-trash"></i>
                                                        @lang('lang.delete')</a>
                                                </li>
                                                @if(!empty($employee->job_type) && $employee->job_type->title == 'Representative')
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{route('employees.add_points')}}"
                                                           class="btn add_point"><i
                                                                class="fa fa-plus"></i>
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


@endsection


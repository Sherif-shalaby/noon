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
                                <th>@lang('lang.age')</th>
                                <th>@lang('lang.date_of_start_working')</th>
                                <th>@lang('lang.stores')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                            </thead>
                            <tbody>

                                @foreach($employees as $key => $employee)
                                    <tr>
                                        <td></td>
                                        <td>
                                            {{$employee->user()->get()[0]->name}}
                                        </td>
                                        <td>
                                            {{$employee->user()->get()[0]->email}}
                                        </td>
                                        <td>
                                            {{$employee->mobile}}
                                        </td>
                                        <td>
                                            {{$employee->job_type()->get()[0]->title}}
                                        </td>
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

@section('javascript')
@endsection

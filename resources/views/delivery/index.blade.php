@extends('layouts.app')
@section('title', __('lang.delivery'))
@section('breadcrumbbar')
    <div class="animate-n-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.delivery')</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            {{--                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"><a href="#">@lang('lang.employees')</a></li> --}}
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.delivery')</li>
                        </ul>
                    </div>
                </div>
                {{-- <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a  class="btn btn-primary" href="{{route('employees.create')}}">@lang('lang.add_employee')</a>
                    {{--                    <a style="color: white" href="{{ action('EmployeeController@create') }}" class="btn btn-info"><i --}}
                {{--                            class="dripicons-plus"></i> --}}
                {{--                        @lang('lang.add_new_employee')</a> --}}
                {{-- </div>
            </div> --}}
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
                        class="card-header d-flex align-items-center  @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                        <h4 class="print-title">@lang('lang.delivery')</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                            <table id="datatable-buttons" class="table dataTable">
                                <thead>
                                    <tr>
                                        <th>@lang('lang.profile_photo')</th>
                                        <th>@lang('lang.employee_name')</th>
                                        <th>@lang('lang.email')</th>
                                        <th>@lang('lang.phone_number')</th>
                                        <th>@lang('lang.stores')</th>
                                        <th class="notexport">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($delivery_men as $key => $employee)
                                        <tr>
                                            <td>
                                                @if (!empty($employee->photo))
                                                    <img src="{{ '/uploads/' . $employee->photo }}" alt="photo"
                                                        width="50" height="50">
                                                @else
                                                    <img src="{{ '/uploads/' . session('logo') }}" alt="photo"
                                                        width="50" height="50">
                                                @endif
                                            </td>
                                            <td>
                                                {{ !empty($employee->user) ? $employee->user->name : '' }}
                                            </td>
                                            <td>
                                                {{ !empty($employee->user) ? $employee->user->email : '' }}
                                            </td>
                                            <td>
                                                {{ $employee->mobile }}
                                            </td>
                                            <td>
                                                @foreach ($employee->stores()->get() as $store)
                                                    {{ $store->name }}
                                                @endforeach
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    @lang('lang.action')
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                    user="menu">
                                                    <li>
                                                        <a href="{{ route('delivery.create', $employee->id) }}"
                                                            class="btn"><i class="fa fa-pencil-square-o"></i>
                                                            @lang('lang.add_plan') </a>
                                                    </li>
                                                    <li class="divider"></li>

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

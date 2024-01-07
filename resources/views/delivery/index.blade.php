@extends('layouts.app')
@section('title', __('lang.plans'))
@section('breadcrumbbar')
    <style>
        .table-top-head {
            top: 85px;
        }
    </style>
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.plans')</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            @if (request()->segment(2) . '/' . request()->segment(3) == 'representative/plan')
                                <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active">
                                    <a style="text-decoration: none;color: #596fd7"
                                        href="{{ route('representatives.index') }}">/ @lang('lang.representatives')</a>
                                </li>
                            @else
                                <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active">
                                    <a style="text-decoration: none;color: #596fd7" href="#">@lang('lang.delivery')</a>
                                </li>
                            @endif
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.plans')</li>
                        </ul>
                    </div>
                </div>
                <div class="widgetbar">
                    @if (request()->segment(2) . '/' . request()->segment(3) == 'representative/plan')
                        <a class="btn btn-primary" href="{{ route('representatives.plansList') }}">@lang('lang.show_plans')</a>
                    @else
                        <a class="btn btn-primary" href="{{ route('delivery_plan.plansList') }}">@lang('lang.show_plans')</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">
        <div class="container-fluid">
            <div class="col-md-12  no-print">
                <div class="card mt-1">
                    <div
                        class="card-header d-flex align-items-center  @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                        <h6 class="print-title">@lang('lang.delivery')</h6>
                    </div>
                    <div class="card-body">
                        <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif" style="margin-top:55px ">
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
                                                <th>@lang('lang.stores')</th>
                                                <th class="notexport">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($delivery_men as $key => $employee)
                                                <tr>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.profile_photo')">

                                                            @if (!empty($employee->photo))
                                                                <img src="{{ '/uploads/' . $employee->photo }}"
                                                                    alt="photo" width="50" height="50">
                                                            @else
                                                                <img src="{{ '/uploads/' . session('logo') }}"
                                                                    alt="photo" width="50" height="50">
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
                                                            data-tooltip="@lang('lang.stores')">

                                                            @foreach ($employee->stores()->get() as $store)
                                                                {{ $store->name }}
                                                            @endforeach
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" style="font-size: 12px;font-weight: 600">
                                                            @lang('lang.action')
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu">
                                                            <li>
                                                                <a href="{{ route('delivery.create', $employee->id) }}"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                        class="fa fa-pencil-square-o"></i>
                                                                    @lang('lang.add_plan') </a>
                                                            </li>


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

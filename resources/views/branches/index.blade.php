@extends('layouts.app')
@section('title', __('lang.jobs'))
@section('breadcrumbbar')
    <style>
        .table-top-head {
            top: 85px;
        }

        .wrapper1 {
            margin-top: 70px;
        }

        @media(max-width:768px) {
            .wrapper1 {
                margin-top: 140px
            }
        }
    </style>
    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.branches')</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.branches')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <a data-href="{{ route('branches.create') }}" data-container=".view_modal"
                            class="btn btn-primary btn-modal text-white edit_job">
                            @lang('lang.add_branch')
                        </a>
                        {{--                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-job">@lang('lang.add_branch')</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    --}}{{--     create job modal      --}}
    {{--    @include('jobs.create') --}}
@endsection
@section('content')
    <div class="animate-in-page">
        <div class="container-fluid">
            <div class="col-md-12  no-print">
                <div class="card mt-1">
                    <div
                        class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                        <h6 class="print-title">@lang('lang.branches')</h6>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="multiselect col-md-6">
                            <div class="selectBox" onclick="showCheckboxes()">
                                <select class="form-select form-control form-control-lg">
                                    <option>@lang('lang.show_hide_columns')</option>
                                </select>
                                <div class="overSelect"></div>
                            </div>
                            <div id="checkboxes">
                                {{-- +++++++++++++++++ checkbox1 : branch_name +++++++++++++++++ --}}
                                <label for="col1_id">
                                    <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                    <span>@lang('lang.branch_name')</span> &nbsp;
                                </label>
                                {{-- +++++++++++++++++ checkbox2 : stores +++++++++++++++++ --}}
                                <label for="col2_id">
                                    <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                    <span>@lang('lang.stores')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox3 : date_of_creation +++++++++++++++++ --}}
                                <label for="col3_id">
                                    <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                    <span>@lang('lang.date_of_creation')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox4 : created_by +++++++++++++++++ --}}
                                <label for="col4_id">
                                    <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                    <span>@lang('lang.created_by')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox5 : updated_by +++++++++++++++++ --}}
                                <label for="col5_id">
                                    <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                    <span>@lang('lang.updated_by')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox6 : action +++++++++++++++++ --}}
                                <label for="col6_id">
                                    <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                    <span>@lang('lang.action')</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div1"></div>
                        </div>
                        <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div2 table-scroll-wrapper">
                                <!-- content goes here -->
                                <div style="min-width:1300px;max-height: 90vh;overflow: auto">
                                    <table id="datatable-buttons" class="table dataTable">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.branch_name')</th>
                                                <th>@lang('lang.stores')</th>
                                                <th>@lang('lang.date_of_creation')</th>
                                                <th>@lang('lang.created_by')</th>
                                                <th>@lang('lang.updated_by')</th>
                                                <th class="notexport">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($branches as $branch)
                                                <tr>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.branch_name')">
                                                            {{ $branch->name }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.stores')">
                                                            @foreach ($branch->stores as $store)
                                                                - {{ $store->name }}
                                                            @endforeach
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.date_of_creation')">
                                                            {{ @format_date($branch->created_at) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.created_by')">

                                                            {{ $branch->created_by_user->name }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.updated_by')">

                                                            @if (isset($job->updated_by))
                                                                {{ $job->updated_by_user->name }}
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a data-href="{{ route('branches.edit', $branch->id) }}"
                                                            data-container=".view_modal"
                                                            class="btn btn-primary btn-modal text-white edit_job">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </a>
                                                        <a data-href="{{ route('branches.destroy', $branch->id) }}"
                                                            class="btn btn-danger text-white delete_item">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
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
<div class="view_modal no-print"></div>

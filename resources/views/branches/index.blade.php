@extends('layouts.app')
@section('title', __('lang.jobs'))

@push('css')
    <style>
        .table-top-head {
            top: 33px !important;
        }


        .rightbar {
            z-index: 2;
        }

        .wrapper1 {
            margin-top: 35px;
        }

        @media(max-width:768px) {
            .wrapper1 {
                margin-top: 140px
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.branches')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.branches')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a data-href="{{ route('branches.create') }}" data-container=".view_modal"
            class="btn btn-primary btn-modal text-white edit_job">
            @lang('lang.add_branch')
        </a>

    </div>
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

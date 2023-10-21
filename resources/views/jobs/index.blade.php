@extends('layouts.app')
@section('title', __('lang.jobs'))
@section('breadcrumbbar')
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.jobs')
                </h4>
                <div class="breadcrumb-list">
                    <ul style=" list-style: none;"
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                @lang('lang.dashboard')</a>
                        </li>
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                style="text-decoration: none;color: #596fd7" href="#">/ @lang('lang.employees')</a></li>
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                            aria-current="page">@lang('lang.jobs')</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div
                    class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target=".add-job">@lang('lang.add_job')</button>
                </div>
            </div>
        </div>
    </div>
    {{--     create job modal      --}}
    @include('jobs.create')
@endsection
@section('content')

    <div class="container-fluid">
        <div class="col-md-12  no-print">
            <div class="card mt-3">
                <div
                    class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                    <h4 class="print-title ">
                        @lang('lang.jobs')</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                                <tr>
                                    <th>@lang('lang.job_title')</th>
                                    <th>@lang('lang.date_of_creation')</th>
                                    <th>@lang('lang.created_by')</th>
                                    <th>@lang('lang.updated_by')</th>
                                    <th class="notexport">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobs as $job)
                                    <tr>
                                        <td>
                                            {{ $job->title }}
                                        </td>
                                        <td>
                                            {{ @format_date($job->date_of_creation) }}
                                        </td>
                                        <td>
                                            {{ $job->created_by()->get()[0]->name }}
                                        </td>
                                        <td>
                                            @if (isset($job->updated_by))
                                                {{ $job->updated_by()->get()[0]->name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!in_array($job->title, ['Cashier', 'Deliveryman', 'Representative']))
                                                <a data-href="{{ route('jobs.edit', $job->id) }}"
                                                    data-container=".view_modal"
                                                    class="btn btn-primary btn-modal text-white edit_job"><i
                                                        class="fa fa-pencil-square-o"></i></a>
                                                <a data-href="{{ route('jobs.destroy', $job->id) }}"
                                                    class="btn btn-danger text-white delete_item"><i
                                                        class="fa fa-trash"></i></a>
                                            @endif

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
<div class="view_modal no-print"></div>

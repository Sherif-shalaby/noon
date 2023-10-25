@extends('layouts.app')
@section('title', __('lang.jobs'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.branches')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.branches')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a data-href="{{route('branches.create')}}"
                       data-container=".view_modal"
                       class="btn btn-primary btn-modal text-white edit_job">
                        @lang('lang.add_branch')
                    </a>
{{--                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-job">@lang('lang.add_branch')</button>--}}
                </div>
            </div>
        </div>
    </div>
{{--    --}}{{--     create job modal      --}}
{{--    @include('jobs.create')--}}
@endsection
@section('content')

    <div class="container-fluid">
        <div class="col-md-12  no-print">
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center">
                    <h4 class="print-title">@lang('lang.branches')</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
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
                            @foreach($branches as $branch)
                                <tr>
                                    <td>
                                        {{ $branch->name }}
                                    </td>
                                    <td>
                                        @foreach($branch->stores as $store)
                                           - {{ $store->name }}
                                        @endforeach
                                    </td>
                                    <td>
                                        {{@format_date($branch->created_at)}}
                                    </td>
                                    <td>
                                        {{$branch->created_by_user->name}}
                                    </td>
                                    <td>
                                        @if(isset($job->updated_by))
                                            {{$job->updated_by_user->name}}
                                        @endif
                                    </td>
                                    <td>
                                        <a data-href="{{route('branches.edit', $branch->id)}}"
                                           data-container=".view_modal"
                                           class="btn btn-primary btn-modal text-white edit_job">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <a data-href="{{route('branches.destroy', $branch->id)}}"
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

@endsection
<div class="view_modal no-print" ></div>


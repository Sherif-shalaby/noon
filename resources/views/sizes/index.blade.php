@extends('layouts.app')
@section('title', __('sizes.sizes'))
@section('breadcrumbbar')
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('sizes.sizes')
                </h4>
                <div class="breadcrumb-list">
                    <ul style=" list-style: none;"
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">@lang('lang.dashboard')</a>
                        </li>
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                            aria-current="page">@lang('sizes.sizes')</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div
                    class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
                        <i class="fa fa-plus"></i> {{ __('Add') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('sizes.create')
@endsection
@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            @lang('sizes.sizes')</h5>
                    </div>
                    <div class="card-body">
                        @if (@isset($sizes) && !@empty($sizes) && count($sizes) > 0)
                            <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('sizes.sizename')</th>
                                            <th>@lang('added_by')</th>
                                            <th>@lang('updated_by')</th>
                                            <th>@lang('action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sizes as $index => $size)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $size->name }}</td>
                                                <td>
                                                    @if ($size->user_id > 0 and $size->user_id != null)
                                                        {{ $size->created_at->diffForHumans() }} <br>
                                                        {{ $size->created_at->format('Y-m-d') }}
                                                        ({{ $size->created_at->format('h:i') }})
                                                        {{ $size->created_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                        <br>
                                                        {{ $size->createBy?->name }}
                                                    @else
                                                        {{ __('no_update') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($size->last_update > 0 and $size->last_update != null)
                                                        {{ $size->updated_at->diffForHumans() }} <br>
                                                        {{ $size->updated_at->format('Y-m-d') }}
                                                        ({{ $size->updated_at->format('h:i') }})
                                                        {{ $size->updated_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                        <br>
                                                        {{ $size->updateBy?->name }}
                                                    @else
                                                        {{ __('no_update') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @include('sizes.action')
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <tfoot>
                                    <tr>
                                        <th colspan="12">
                                            <div class="float-right">
                                                {!! $sizes->appends(request()->all())->links() !!}
                                            </div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                {{ __('categories.data_no_found') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

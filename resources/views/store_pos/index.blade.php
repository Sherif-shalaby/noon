@extends('layouts.app')
@section('title', __('lang.store_pos'))
@section('breadcrumbbar')
    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.store_pos')
                    </h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="">/ @lang('lang.settings')</a></li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.store_pos')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <a data-href="{{ route('store-pos.create') }}" data-container=".view_modal"
                            class="btn btn-modal btn-primary text-white" data-toggle="modal">
                            @lang('lang.add_store_pos')
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">

        <!-- Start Contentbar -->
        <div class="contentbar">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.store_pos')</h5>
                        </div>
                        <div class="card-body">
                            {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                            <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            {{-- <th>@lang('lang.store')</th> --}}
                                            <th>@lang('lang.name')</th>
                                            <th>@lang('lang.user')</th>
                                            <th>@lang('lang.email')</th>
                                            <th>@lang('lang.date_and_time')</th>
                                            <th class="notexport">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($store_poses as $key => $store_pos)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                {{-- <td>{{ $store_pos->store->name ?? '' }}</td> --}}
                                                <td>{{ $store_pos->name }}</td>
                                                <td>{{ $store_pos->user->name }}</td>
                                                <td>{{ $store_pos->user->email }}</td>
                                                <td>{{ @format_datetime($store_pos->created_at) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">@lang('lang.action')
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu">
                                                            <li>
                                                                <a data-href="{{ route('store-pos.edit', $store_pos->id) }}"
                                                                    data-container=".view_modal" class="btn btn-modal"><i
                                                                        class="dripicons-document-edit"></i>
                                                                    @lang('lang.edit')</a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{ route('store-pos.destroy', $store_pos->id) }}"
                                                                    data-check_password=""
                                                                    class="btn text-red delete_item"><i
                                                                        class="fa fa-trash"></i>
                                                                    @lang('lang.delete')</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End Contentbar -->
        </div>
    </div>

@endsection
<div class="view_modal no-print"></div>

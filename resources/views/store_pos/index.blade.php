@extends('layouts.app')
@section('title', __('lang.store_pos'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.store_pos')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="">@lang('lang.settings')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.store_pos')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a data-href="{{route('store-pos.create')}}" data-container=".view_modal" class="btn btn-modal btn-primary text-white" data-toggle="modal">
                        @lang('lang.add_store_pos')
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.store_pos')</h5>
                    </div>
                    <div class="card-body">
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
{{--                                    <th>@lang('lang.store')</th>--}}
                                    <th>@lang('lang.name')</th>
                                    <th>@lang('lang.user')</th>
                                    <th>@lang('lang.email')</th>
                                    <th>@lang('lang.date_and_time')</th>
                                    <th class="notexport">@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($store_poses as $key => $store_pos)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
{{--                                        <td>{{$store_pos->store->name ?? ''}}</td>--}}
                                        <td>{{$store_pos->name}}</td>
                                        <td>{{$store_pos->user->name}}</td>
                                        <td>{{$store_pos->user->email}}</td>
                                        <td>{{@format_datetime($store_pos->created_at)}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">@lang('lang.action')
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                                        <li>
                                                            <a data-href="{{route('store-pos.edit', $store_pos->id)}}"
                                                               data-container=".view_modal" class="btn btn-modal"><i
                                                                    class="dripicons-document-edit"></i> @lang('lang.edit')</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a data-href="{{route('store-pos.destroy', $store_pos->id)}}"
                                                               data-check_password=""
                                                               class="btn text-red delete_item"><i class="fa fa-trash"></i>
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
@endsection
<div class="view_modal no-print" ></div>

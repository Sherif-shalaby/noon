@extends('layouts.app')
@section('title', __('lang.stores'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.stores')
                    </h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="#">/ @lang('lang.settings')</a></li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                                aria-current="page">@lang('lang.stores')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-store"
                            href="{{ route('store.create') }}">@lang('lang.add_store')</button>
                    </div>
                </div>
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
                        <h4 class="print-title">
                            @lang('lang.stores')</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                            <table id="datatable-buttons" class="table dataTable table-button-wrapper">
                                <thead>
                                    <tr>
                                        <th>@lang('lang.name')</th>
                                        <th>@lang('lang.branch')</th>
                                        <th>@lang('lang.phone_number')</th>
                                        <th>@lang('lang.email')</th>
                                        <th>@lang('lang.manager_name')</th>
                                        <th>@lang('lang.manager_mobile_number')</th>
                                        <th class="notexport">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stores as $store)
                                        <tr>
                                            <td>{{ $store->name }}</td>
                                            <td>{{ !empty($store->branch) ? $store->branch->name : '' }}</td>
                                            <td>{{ $store->phone_number }}</td>
                                            <td>{{ $store->email }}</td>
                                            <td>{{ $store->manager_name }}</td>
                                            <td>{{ $store->manager_mobile_number }}</td>
                                            <td class="no-print">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">خيارات
                                                        <span class="caret"></span></button>
                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                        user="menu" x-placement="bottom-end"
                                                        style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <li>
                                                            <a data-href="{{ route('store.edit', $store->id) }}"
                                                                data-container=".view_modal"
                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"><i
                                                                    class="dripicons-document-edit"></i>
                                                                @lang('lang.edit')</a>
                                                        </li>

                                                        <li>
                                                            <a data-href="{{ route('store.destroy', $store->id) }}"
                                                                {{--                                                       data-check_password="{{action('UserController@checkPassword', Auth::user()->id) }}" --}}
                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif delete_item text-red delete_item"><i
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
        </div>
    </div>

    @include('store.create')

@endsection
<div class="view_modal no-print"></div>

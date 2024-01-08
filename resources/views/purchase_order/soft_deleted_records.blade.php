@extends('layouts.app')
@section('title', __('lang.show_recycle_bin'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
<style>
    .table-top-head {
        top: 10px !important;
    }

    .table-scroll-wrapper {
        width: fit-content;
    }

    @media(min-width:1900px) {
        .table-scroll-wrapper {
            width: 100%;
        }
    }
</style>

@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.show_recycle_bin')</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7"
                                    href="{{ route('purchase_order.index') }}">/ @lang('lang.purchase_order')</a>
                            </li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.show_recycle_bin')</li>
                        </ul>
                    </div>
                    <br />
                </div>
                <div
                    class="col-md-4 d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                    <div class="widgetbar">
                        <a href="{{ route('purchase_order.create') }}" class="btn btn-primary">
                            @lang('lang.create_purchase_order')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-0">
                    {{-- ++++++++++++++ Filters ++++++++++++++ --}}
                    {{-- <div class="col-lg-12">
                        <div class="container-fluid">
                            @include('purchase_order.partials.filters')
                        </div>
                    </div> --}}
                    {{-- ++++++++++++++ Table ++++++++++ --}}
                    <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif" style="margin-top:55px ">
                        <div class="div1"></div>
                    </div>
                    <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                        <div class="div2 table-scroll-wrapper">
                            <!-- content goes here -->
                            <div style="min-width: 1300px;max-height: 90vh;overflow: auto">

                                <table id="datatable-buttons" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>@lang('lang.po_ref_no')</th>
                                            <th>@lang('lang.date')</th>
                                            <th>@lang('lang.created_by')</th>
                                            <th>@lang('lang.supplier')</th>
                                            <th class="sum">@lang('lang.value')</th>
                                            <th>@lang('lang.status')</th>
                                            <th>@lang('lang.deleted_at')</th>
                                            <th>@lang('lang.deleted_by')</th>
                                            <th>@lang('lang.action')</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($softDeletedRecords as $softDeletedRecord)
                                            <tr>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.po_ref_no')">

                                                        {{ $softDeletedRecord->po_no }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.date')">

                                                        {{ @format_date($softDeletedRecord->transaction_date) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.created_by')">

                                                        {{ App\Models\User::where('id', $softDeletedRecord->created_by)->first()->name }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.supplier')">

                                                        @if (!empty($softDeletedRecord->supplier))
                                                            {{ $softDeletedRecord->supplier->name }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.value')">

                                                        {{ @num_format($softDeletedRecord->final_total) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.status')">

                                                        {{ $softDeletedRecord->status }}
                                                    </span>
                                                </td>
                                                {{-- +++++++++++++ deleted_at column +++++++++++++ --}}
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.deleted_at')">

                                                        {{ $softDeletedRecord->deleted_at }}
                                                    </span>
                                                </td>
                                                {{-- +++++++++++++ deleted_by column +++++++++++++ --}}
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.deleted_by')">

                                                        {{ App\Models\User::where('id', $softDeletedRecord->deleted_by)->first()->name }}
                                                    </span>
                                                </td>
                                                <!-- +++++++++++++ Restore , ForceDelete Button +++++++++++++ -->
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            style="font-size: 12px;font-weight: 600" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            @lang('lang.action')
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu">
                                                            <!-- +++++++++++++ Restore Button +++++++++++++ -->
                                                            <li>
                                                                <a href="{{ route('purchase_order.restore', $softDeletedRecord->id) }}"
                                                                    title="@lang('lang.restore')" class="btn text-red"
                                                                    style="color:green;">
                                                                    <i class="fa fa-trash-restore fa-lg text-red"></i>
                                                                    @lang('lang.restore')
                                                                </a>
                                                            </li>
                                                            <!-- +++++++++++++ ForceDelete Button +++++++++++++ -->
                                                            <li>
                                                                <a href="{{ route('purchase_order.forceDelete', $softDeletedRecord->id) }}"
                                                                    title="@lang('lang.forceDelete')" class="btn text-red"
                                                                    style="color:red;">
                                                                    <i class="fa fa-trash-restore fa-lg text-red"></i>
                                                                    @lang('lang.forceDelete')
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                            </tr>
                                        @endforeach
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

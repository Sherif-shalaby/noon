@extends('layouts.app')
@section('title', __('lang.show_recycle_bin'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.show_recycle_bin')</h4> <br/>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('purchase_order.index')}}">@lang('lang.purchase_order')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.show_recycle_bin')</li>
                    </ol>
                </div>
                <br/>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('purchase_order.create')}}" class="btn btn-primary">
                        @lang('lang.create_purchase_order')
                      </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    {{-- ++++++++++++++ Filters ++++++++++++++ --}}
                    {{-- <div class="col-lg-12">
                        <div class="container-fluid">
                            @include('purchase_order.partials.filters')
                        </div>
                    </div> --}}
                    {{-- ++++++++++++++ Table ++++++++++ --}}
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
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
                                        <td title="@lang('lang.po_ref_no')">{{$softDeletedRecord->po_no}}</td>
                                        <td title="@lang('lang.date')"> {{@format_date($softDeletedRecord->transaction_date)}}</td>

                                        <td title="@lang('lang.created_by')">{{ App\Models\User::where('id', $softDeletedRecord->created_by)->first()->name }}</td>

                                        <td title="@lang('lang.supplier')">
                                            @if(!empty($softDeletedRecord->supplier)){{$softDeletedRecord->supplier->name}}@endif
                                        </td>
                                        <td title="@lang('lang.value')">
                                            {{@num_format($softDeletedRecord->final_total)}}
                                        </td>
                                        <td title="@lang('lang.status')">
                                            {{ $softDeletedRecord->status }}
                                        </td>
                                        {{-- +++++++++++++ deleted_at column +++++++++++++ --}}
                                        <td title="@lang('lang.deleted_at')">
                                            {{ $softDeletedRecord->deleted_at }}
                                        </td>
                                        {{-- +++++++++++++ deleted_by column +++++++++++++ --}}
                                        <td title="@lang('lang.deleted_by')">
                                            {{ App\Models\User::where('id', $softDeletedRecord->deleted_by)->first()->name }}
                                        </td>
                                        <!-- +++++++++++++ Restore , ForceDelete Button +++++++++++++ -->
                                        <td title="@lang('lang.action')">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    @lang('lang.action')
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                                    <!-- +++++++++++++ Restore Button +++++++++++++ -->
                                                    <li>
                                                        <a href="{{route('purchase_order.restore', $softDeletedRecord->id)}}" title="@lang('lang.restore')"
                                                            class="btn text-red" style="color:green;">
                                                            <i class="fa fa-trash-restore fa-lg text-red"></i>
                                                            @lang('lang.restore')
                                                        </a>
                                                    </li>
                                                    <!-- +++++++++++++ ForceDelete Button +++++++++++++ -->
                                                    <li>
                                                        <a href="{{route('purchase_order.forceDelete', $softDeletedRecord->id)}}" title="@lang('lang.forceDelete')"
                                                            class="btn text-red" style="color:red;">
                                                            <i class="fa fa-trash-restore fa-lg text-red"></i>
                                                            @lang('lang.forceDelete')
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
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
@endsection

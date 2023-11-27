@extends('layouts.app')
@section('title', __('lang.show_purchase_order'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.show_purchase_order')</h4> <br/>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('purchase_order.index')}}">@lang('lang.purchase_order')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.show_purchase_order')</li>
                    </ol>
                </div>
                <br/>
            </div>
            {{-- +++++++++++++++++++ "انشاء امر شراء" , "عرض سلة المحذوفات" +++++++++++++++++++ --}}
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    {{-- ++++++++++++++++++++ show Recycle_Bin ++++++++++++ --}}
                    <a href="{{route('purchase_order.show_soft_deleted_records')}}" class="btn btn-success">
                        @lang('lang.show_recycle_bin')
                    </a>
                    {{-- ++++++++++++++++++++ create purchase_order ++++++++++++ --}}
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
                    <div class="col-lg-12">
                        <div class="container-fluid">
                            @include('purchase_order.partials.filters')
                        </div>
                    </div>
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
                                    <th class="notexport">@lang('lang.action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($purchaseOrders as $purchase_order)
                                    <tr>
                                        <td title="@lang('lang.po_ref_no')">{{$purchase_order->po_no}}</td>
                                        <td title="@lang('lang.date')"> {{@format_date($purchase_order->transaction_date)}}</td>

                                        <td title="@lang('lang.created_by')">{{ App\Models\User::where('id', $purchase_order->created_by)->first()->name }}</td>

                                        <td title="@lang('lang.supplier')">
                                            @if(!empty($purchase_order->supplier)){{$purchase_order->supplier->name}}@endif
                                        </td>
                                        <td title="@lang('lang.value')">
                                            {{@num_format($purchase_order->final_total)}}
                                        </td>
                                        <td title="@lang('lang.status')">
                                            {{ $purchase_order->status }}
                                        </td>
                                        {{-- =========================== Actions =========================== --}}
                                        <td title="@lang('lang.action')">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    @lang('lang.action')
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                                    {{-- +++++++++++++++++++ show button +++++++++++++++++++ --}}
                                                    <li>
                                                        <a href="{{route('purchase_order.show', $purchase_order->id)}}" target="_blank" style="color:#000;">
                                                            <i class="fa fa-eye btn"></i>
                                                            @lang('lang.view')
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    {{-- +++++++++++++++++++++ edit button +++++++++++++++++ --}}
                                                    <li>
                                                        <a href="{{route('purchase_order.edit', $purchase_order->id)}}" style="color:#000;" class="btn">
                                                            <i class="fa fa-edit"></i>
                                                            @lang('lang.edit') </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    {{-- +++++++++++++++++++++ delete button +++++++++++++++++ --}}
                                                    <li>
                                                        <a href="{{route('purchase_order.destroy', $purchase_order->id)}}"
                                                           class="btn text-red"><i
                                                                class="fa fa-trash"></i>
                                                            @lang('lang.delete')</a>
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

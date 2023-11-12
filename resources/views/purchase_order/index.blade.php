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
                @foreach ($purchase_orders as $purchase_order)
                <tr>
                    <td>{{$purchase_order->transaction->po_no}}</td>
                    <td> {{@format_date($purchase_order->transaction->transaction_date)}}</td>

                    <td>{{ App\Models\User::where('id', $purchase_order->transaction->created_by)->first()->name }}</td>

                    <td>
                        @if(!empty($purchase_order->transaction->supplier)){{$purchase_order->transaction->supplier->name}}@endif
                    </td>
                    <td>
                        {{@num_format($purchase_order->transaction->final_total)}}
                    </td>
                    <td>
                        {{ $purchase_order->transaction->status }}
                    </td>
                    {{-- =========================== Actions =========================== --}}
                    <td>
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
                                {{-- @endcan
                                @can('purchase_order.purchase_order.create_and_edit') --}}
                                <li>
                                    {{--  href="{{action('PurchaseOrderController@edit', $purchase_order->id)}}" --}}
                                    <a  href="#" style="color:#000;">
                                        <i class="dripicons-document-edit btn"></i>@lang('lang.edit')
                                    </a>
                                </li>
                                <li class="divider"></li>
                                {{-- @endcan
                                @can('purchase_order.purchase_order.delete') --}}
                                <li>
                                    {{--    data-href="{{action('PurchaseOrderController@destroy', $purchase_order->id)}}"
                                            data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                    --}}
                                    <a data-href="#"
                                        data-check_password="#"
                                        class="btn text-red delete_item" style="color:#000;"><i class="fa fa-trash"></i>
                                        @lang('lang.delete')</a>
                                </li>
                                {{-- @endcan --}}
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
@endsection

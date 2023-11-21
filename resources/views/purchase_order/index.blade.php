@extends('layouts.app')
@section('title', __('lang.show_purchase_order'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <style>
        th {
            position: sticky;
            top: 0;
        }
    </style>
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.show_purchase_order')</h4> <br />
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7"
                                    href="{{ route('purchase_order.index') }}">/ @lang('lang.purchase_order')</a>
                            </li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                                aria-current="page">@lang('lang.show_purchase_order')</li>
                        </ul>
                    </div>
                    <br />
                </div>
                <div
                    class="col-md-4  d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
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
    <div class="animate-in-page">
        <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif"
            style="height: 90vh;overflow: scroll">
            <table id="datatable-buttons"
                class="table dataTable table-hover table-striped table-bordered table-button-wrapper">
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
                            <td>
                                <span class="custom-tooltip  d-flex justify-content-center align-items-center"
                                    style="font-size: 12px;font-weight: 600" data-tooltip="@lang('lang.po_ref_no')">
                                    {{ $purchase_order->po_no }}
                                </span>
                            </td>
                            <td>
                                <span class="custom-tooltip  d-flex justify-content-center align-items-center"
                                    style="font-size: 12px;font-weight: 600" data-tooltip="@lang('lang.date')">

                                </span>
                                {{ @format_date($purchase_order->transaction_date) }}
                            </td>

                            <td>
                                <span class="custom-tooltip  d-flex justify-content-center align-items-center"
                                    style="font-size: 12px;font-weight: 600" data-tooltip="@lang('lang.created_by')">
                                    {{ App\Models\User::where('id', $purchase_order->created_by)->first()->name }}
                                </span>
                            </td>

                            <td>
                                <span class="custom-tooltip  d-flex justify-content-center align-items-center"
                                    style="font-size: 12px;font-weight: 600" data-tooltip="@lang('lang.supplier')">

                                    @if (!empty($purchase_order->supplier))
                                        {{ $purchase_order->supplier->name }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="custom-tooltip  d-flex justify-content-center align-items-center"
                                    style="font-size: 12px;font-weight: 600" data-tooltip="@lang('lang.value')">
                                    {{ @num_format($purchase_order->final_total) }}
                                </span>
                            </td>
                            <td>
                                <span class="custom-tooltip  d-flex justify-content-center align-items-center"
                                    style="font-size: 12px;font-weight: 600" data-tooltip="@lang('lang.status')">
                                    {{ $purchase_order->status }}
                                </span>
                            </td>
                            {{-- =========================== Actions =========================== --}}
                            <td>
                                <div class="btn-group">
                                    <button type="button"
                                        class="btn btn-default btn-sm dropdown-toggle  d-flex justify-content-center align-items-center"
                                        style="font-size: 12px;font-weight: 600" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        @lang('lang.action')
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                        user="menu">
                                        {{-- +++++++++++++++++++ show button +++++++++++++++++++ --}}
                                        <li>
                                            <a class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                href="{{ route('purchase_order.show', $purchase_order->id) }}"
                                                target="_blank">
                                                <i class="fa fa-eye"></i>
                                                @lang('lang.view')
                                            </a>
                                        </li>

                                        {{-- @endcan
                                @can('purchase_order.purchase_order.create_and_edit') --}}
                                        <li>
                                            {{-- <a  href="{{route('purchase_order.edit', $purchase_order->id)}}">
                                        <i class="dripicons-document-edit btn"></i>@lang('lang.edit')
                                    </a> --}}
                                            <a class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                href="{{ route('purchase_order.edit', $purchase_order->id) }}"
                                                class="btn">
                                                <i class="fa fa-edit"></i>
                                                @lang('lang.edit') </a>
                                        </li>

                                        {{-- @endcan
                                @can('purchase_order.purchase_order.delete') --}}
                                        <li>
                                            {{--    data-href="{{action('PurchaseOrderController@destroy', $purchase_order->id)}}"
                                            data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                    --}}
                                            <a class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                data-href="#" data-check_password="#" class="btn text-red delete_item"><i
                                                    class="fa fa-trash"></i>
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
    </div>

@endsection

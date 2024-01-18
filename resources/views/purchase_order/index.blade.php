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

        .table-top-head {
            top: 55px;
        }

        .wrapper1 {
            margin-top: 30px;
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 192px !important
            }

            .wrapper1 {
                margin-top: 115px !important;
            }
        }

        /* +++++++++++++++ Style : checkboxes and labels inside selectbox +++++++++++++++  */

        .selectBox {
            position: relative;
        }

        /* selectbox style */
        .selectBox select {
            width: 100%;
            padding: 0 !important;
            padding-left: 4px;
            padding-right: 4px;
            color: #000;
            border: 1px solid #ccc;
            background-color: #dedede;
            /* height: 39px !important; */
        }

        .overSelect {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }

        #checkboxes {
            display: none;
            border: 1px #dadada solid;
            height: 125px;
            overflow: auto;
            padding-top: 10px;
            /* text-align: end;  */
        }

        #checkboxes label {
            display: block;
            padding: 5px;
        }

        #checkboxes label:hover {
            background-color: #ddd;
        }

        #checkboxes label span {
            font-weight: normal;
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
                        {{-- ++++++++++++++++++++ show Recycle_Bin ++++++++++++ --}}
                        <a href="{{ route('purchase_order.show_soft_deleted_records') }}" class="btn btn-danger">
                            @lang('lang.show_recycle_bin')
                        </a>
                        {{-- ++++++++++++++++++++ create purchase_order ++++++++++++ --}}
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
                        {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}

                        <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif" style="margin-top:25px ">
                            <div class="div1"></div>
                        </div>
                        <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div2 table-scroll-wrapper">
                                <!-- content goes here -->
                                <div style="min-width: 1300px;max-height: 90vh;overflow: auto">
                                    <table id="datatable-buttons"
                                        class="table dataTable table-hover table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="col1">@lang('lang.po_ref_no')</th>
                                                <th class="col2">@lang('lang.date')</th>
                                                <th class="col3">@lang('lang.created_by')</th>
                                                <th class="col4">@lang('lang.supplier')</th>
                                                <th class="sum col5">@lang('lang.value')</th>
                                                <th class="col6">@lang('lang.status')</th>
                                                <th class="notexport col7">@lang('lang.action')</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($purchaseOrders as $purchase_order)
                                                <tr>
                                                    <td class="col1">
                                                        <span
                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.po_ref_no')">
                                                            {{ $purchase_order->po_no }}
                                                        </span>
                                                    </td>
                                                    <td class="col2">
                                                        <span
                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.date')">

                                                        </span>
                                                        {{ @format_date($purchase_order->transaction_date) }}
                                                    </td>

                                                    <td class="col3">
                                                        <span
                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.created_by')">
                                                            {{ App\Models\User::where('id', $purchase_order->created_by)->first()->name }}
                                                        </span>
                                                    </td>

                                                    <td class="col4">
                                                        <span
                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.supplier')">

                                                            @if (!empty($purchase_order->supplier))
                                                                {{ $purchase_order->supplier->name }}
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td class="col5">
                                                        <span
                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.value')">
                                                            {{ @num_format($purchase_order->final_total) }}
                                                        </span>
                                                    </td>
                                                    <td class="col6">
                                                        <span
                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.status')">
                                                            {{ $purchase_order->status }}
                                                        </span>
                                                    </td>
                                                    {{-- =========================== Actions =========================== --}}
                                                    <td class="col7">
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                class="btn btn-default btn-sm dropdown-toggle  d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-toggle="dropdown" aria-haspopup="true"
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


                                                                <li>
                                                                    <a class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                                        href="{{ route('purchase_order.destroy', $purchase_order->id) }}"><i
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
                                                <th class="table_totals" style="text-align: right">@lang('lang.totals')</th>
                                                <td>{{ @num_format($final_total_sum) }} </td>
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
    </div>
    <script>
        // +++++++++++++++++ Checkboxs and label inside selectbox ++++++++++++++
        $("input:checkbox:not(:checked)").each(function() {
            var column = "table ." + $(this).attr("name");
            $(column).hide();
        });
        $("input:checkbox").click(function() {
            var column = "table ." + $(this).attr("name");
            $(column).toggle();
        });
        // +++++++++++++++++ Checkboxs and label inside selectbox : showCheckboxes() method ++++++++++++++
        var expanded = false;

        function showCheckboxes() {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }
    </script>
@endsection

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
    {{-- +++++++++++++++ Style : checkboxes and labels inside selectbox +++++++++++++++ --}}
    <style>
        .selectBox {
        position: relative;
        }

        /* selectbox style */
        .selectBox select
        {
            width: 100%;
            padding: 0 !important;
            padding-left: 4px;
            padding-right: 4px;
            color: #fff;
            border: 1px solid #596fd7;
            background-color: #596fd7;
            height: 39px !important;
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
        #checkboxes label span
        {
            font-weight: normal;
        }
    </style>
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
                        {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                        <div class="col-md-3 col-lg-3">
                            <div class="multiselect col-md-6">
                                <div class="selectBox" onclick="showCheckboxes()">
                                    <select class="form-select form-control form-control-lg">
                                        <option>@lang('lang.show_hide_columns')</option>
                                    </select>
                                    <div class="overSelect"></div>
                                </div>
                                <div id="checkboxes">
                                    {{-- +++++++++++++++++ checkbox1 : reference_no +++++++++++++++++ --}}
                                    <label for="col1_id">
                                        <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                        <span>@lang('lang.reference_no')</span> &nbsp;
                                    </label>
                                    {{-- +++++++++++++++++ checkbox2 : date +++++++++++++++++ --}}
                                    <label for="col2_id">
                                        <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                        <span>@lang('lang.date')</span>
                                    </label>
                                    {{-- +++++++++++++++++ checkbox3 : created_by +++++++++++++++++ --}}
                                    <label for="col3_id">
                                        <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                        <span>@lang('lang.created_by')</span>
                                    </label>
                                    {{-- +++++++++++++++++ checkbox4 : supplier +++++++++++++++++ --}}
                                    <label for="col4_id">
                                        <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                        <span>@lang('lang.supplier')</span>
                                    </label>
                                    {{-- +++++++++++++++++ checkbox5 : value +++++++++++++++++ --}}
                                    <label for="col5_id">
                                        <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                        <span>@lang('lang.value')</span>
                                    </label>
                                    {{-- +++++++++++++++++ checkbox6 : status +++++++++++++++++ --}}
                                    <label for="col6_id">
                                        <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                        <span>@lang('lang.status')</span>
                                    </label>
                                    {{-- +++++++++++++++++ checkbox7 : action +++++++++++++++++ --}}
                                    <label for="col7_id">
                                        <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                        <span>@lang('lang.action')</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <br/><br/>
                        <table id="datatable-buttons" class="table dataTable">
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
                                        <td class="col1" title="@lang('lang.po_ref_no')">{{$purchase_order->po_no}}</td>
                                        <td class="col2" title="@lang('lang.date')"> {{@format_date($purchase_order->transaction_date)}}</td>

                                        <td class="col3" title="@lang('lang.created_by')">{{ App\Models\User::where('id', $purchase_order->created_by)->first()->name }}</td>

                                        <td class="col4" title="@lang('lang.supplier')">
                                            @if(!empty($purchase_order->supplier)){{$purchase_order->supplier->name}}@endif
                                        </td>
                                        <td class="col5" title="@lang('lang.value')">
                                            {{@num_format($purchase_order->final_total)}}
                                        </td>
                                        <td class="col6" title="@lang('lang.status')">
                                            {{ $purchase_order->status }}
                                        </td>
                                        {{-- =========================== Actions =========================== --}}
                                        <td class="col7" title="@lang('lang.action')">
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
                        </table>

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

        $("input:checkbox").click(function(){
            var column = "table ." + $(this).attr("name");
            $(column).toggle();
        });
        // +++++++++++++++++ Checkboxs and label inside selectbox : showCheckboxes() method ++++++++++++++
        var expanded = false;
        function showCheckboxes()
        {
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

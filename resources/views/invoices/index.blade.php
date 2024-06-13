@extends('layouts.app')
@section('title', __('lang.sells'))
{{-- +++++++++++++++ Style : checkboxes and labels inside selectbox +++++++++++++++ --}}
<style>
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
        background-color: #fff;
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

    #checkboxes label span {
        font-weight: normal;
    }
</style>
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.sells')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.sells')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start Contentbar -->
    <div class="contentbar no-print">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.sells')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    {{-- @include('customers.filters') --}}
                                    {{-- +++++++++++++ Filters +++++++++++++++++ --}}
                                    {{-- <div class="col-md-12"> --}}
                                    @include('livewire.invoices.partials.filters')
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <div class="row ml-5">

                                {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                                <div class="col-md-3 col-lg-3">
                                    <div class="multiselect col-md-12">
                                        <div class="selectBox" onclick="showCheckboxes()">
                                            <select class="form-select form-control form-control-lg">
                                                <option>@lang('lang.show_hide_columns')</option>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>
                                        {{-- ///////////////// checkboxes ///////////////// --}}
                                        <div id="checkboxes">
                                            {{-- +++++++++++++++++ checkbox1 : date_and_time +++++++++++++++++ --}}
                                            <label for="col1_id">
                                                <input type="checkbox" id="col1_id" name="col1" class="checkbox_class2"
                                                    checked="checked" />
                                                <span>@lang('lang.date_and_time')</span> &nbsp;
                                            </label>
                                            {{-- +++++++++++++++++ checkbox2 : reference +++++++++++++++++ --}}
                                            <label for="col2_id">
                                                <input type="checkbox" id="col2_id" name="col2" class="checkbox_class2"
                                                    checked="checked" />
                                                <span>@lang('lang.reference')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox3 : store +++++++++++++++++ --}}
                                            <label for="col3_id">
                                                <input type="checkbox" id="col3_id" name="col3" class="checkbox_class2"
                                                    checked="checked" />
                                                <span>@lang('lang.store')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox4 : select_to_delete +++++++++++++++++ --}}
                                            <label for="col4_id">
                                                <input type="checkbox" id="col4_id" name="col4" class="checkbox_class2"
                                                    checked="checked" />
                                                <span>@lang('lang.select_to_delete')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox5 : customer +++++++++++++++++ --}}
                                            <label for="col5_id">
                                                <input type="checkbox" id="col5_id" name="col5" class="checkbox_class2"
                                                    checked="checked" />
                                                <span>@lang('lang.customer')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox6 : phone +++++++++++++++++ --}}
                                            <label for="col6_id">
                                                <input type="checkbox" id="col6_id" name="col6" class="checkbox_class2"
                                                    checked="checked" />
                                                <span>@lang('lang.phone')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox7 : sale_status +++++++++++++++++ --}}
                                            <label for="col7_id">
                                                <input type="checkbox" id="col7_id" name="col7" class="checkbox_class2"
                                                    checked="checked" />
                                                <span>@lang('lang.sale_status')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox8 : payment_status +++++++++++++++++ --}}
                                            <label for="col8_id">
                                                <input type="checkbox" id="col8_id" name="col8" class="checkbox_class2"
                                                    checked="checked" />
                                                <span>@lang('lang.payment_status')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox9 : payment_type +++++++++++++++++ --}}
                                            <label for="col9_id">
                                                <input type="checkbox" id="col9_id" name="col9" class="checkbox_class2"
                                                    checked="checked" />
                                                <span>@lang('lang.payment_type')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox10 : ref_number +++++++++++++++++ --}}
                                            <label for="col10_id">
                                                <input type="checkbox" id="col10_id" name="col10" class="checkbox_class2"
                                                    checked="checked" />
                                                <span>@lang('lang.ref_number')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox11 : received_currency +++++++++++++++++ --}}
                                            <label for="col11_id">
                                                <input type="checkbox" id="col11_id" name="col11" class="checkbox_class2"
                                                    checked="checked" />
                                                <span>@lang('lang.received_currency')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox12 : grand_total +++++++++++++++++ --}}
                                            <label for="col12_id">
                                                <input type="checkbox" id="col12_id" name="col12" class="checkbox_class2"
                                                    checked="checked" />
                                                <span>@lang('lang.grand_total')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox13 : paid +++++++++++++++++ --}}
                                            <label for="col13_id">
                                                <input type="checkbox" id="col13_id" name="col13"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.paid')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox14 : due_sale_list +++++++++++++++++ --}}
                                            <label for="col14_id">
                                                <input type="checkbox" id="col14_id" name="col14"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.due_sale_list')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox15 : due_date +++++++++++++++++ --}}
                                            <label for="col15_id">
                                                <input type="checkbox" id="col15_id" name="col15"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.due_date')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox16 : payment_date +++++++++++++++++ --}}
                                            <label for="col16_id">
                                                <input type="checkbox" id="col16_id" name="col16"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.payment_date')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox17 : cashier_man +++++++++++++++++ --}}
                                            <label for="col17_id">
                                                <input type="checkbox" id="col17_id" name="col17"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.cashier_man')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox17 : representative +++++++++++++++++ --}}
                                            <label for="col23_id">
                                                <input type="checkbox" id="col23_id" name="col23"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.representative')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox18 : commission +++++++++++++++++ --}}
                                            <label for="col18_id">
                                                <input type="checkbox" id="col18_id" name="col18"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.commission')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox19 : products +++++++++++++++++ --}}
                                            <label for="col19_id">
                                                <input type="checkbox" id="col19_id" name="col19"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.products')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox20 : sale_note +++++++++++++++++ --}}
                                            <label for="col20_id">
                                                <input type="checkbox" id="col20_id" name="col20"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.sale_note')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox21 : receipts +++++++++++++++++ --}}
                                            <label for="col21_id">
                                                <input type="checkbox" id="col21_id" name="col21"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.receipts')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox22 : action +++++++++++++++++ --}}
                                            <label for="col22_id">
                                                <input type="checkbox" id="col22_id" name="col22"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.action')</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                {{-- +++++++++ delete_all button ++++++++ --}}
                                <div class="col-md-3 col-lg-3">
                                    <button id="btn_delete_all" class="btn btn-danger text-white delete_all">
                                        <i class="fa fa-trash"></i>@lang('lang.delete_all')
                                    </button>
                                </div>
                            </div>
                            <br />
                            {{-- ++++++++++++++++++ Table Columns ++++++++++++++++++ --}}
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col1">@lang('lang.date_and_time')</th>
                                        <th class="col2">@lang('lang.reference')</th>
                                        <th class="col3">@lang('lang.store')</th>
                                        {{-- ///// check_all selectbox ///// --}}
                                        <th class="col4">
                                            @lang('lang.select_to_delete')
                                            <input type="checkbox" name="select_all" id="example-select-all"
                                                onclick="(CheckAll('box1',this))">
                                        </th>
                                        <th class="col5">@lang('lang.customer')</th>
                                        <th class="col6">@lang('lang.phone')</th>
                                        {{-- <th class="col7">@lang('lang.sale_status')</th> --}}
                                        <th class="col8">@lang('lang.payment_status')</th>
                                        <th class="col9">@lang('lang.payment_type')</th>
                                        <th class="col10">@lang('lang.ref_number')</th>
                                        {{-- <th class="col11 currencies">@lang('lang.received_currency')</th> --}}
                                        <th class="col12 sum">@lang('lang.grand_total') @lang('lang.dinar_c')</th>
                                        <th class="col13 sum">@lang('lang.paid') @lang('lang.dinar_c')</th>
                                        <th class="col14 sum">@lang('lang.due_sale_list') @lang('lang.dinar_c')</th>

                                        <th class="col12 sum">@lang('lang.grand_total') @lang('lang.dollar_c')</th>
                                        <th class="col13 sum">@lang('lang.paid') @lang('lang.dollar_c')</th>
                                        <th class="col14 sum">@lang('lang.due_sale_list') @lang('lang.dollar_c')</th>
                                        <th class="col15">@lang('lang.due_date')</th>
                                        <th class="col16">@lang('lang.payment_date')</th>
                                        <th class="col17">@lang('lang.cashier_man')</th>
                                        <th class="col17">@lang('lang.representative')</th>
                                        <th class="col18">@lang('lang.commission')</th>
                                        <th class="col19">@lang('lang.products')</th>
                                        <th class="col20">@lang('lang.sale_note')</th>
                                        <th class="col21">@lang('lang.receipts')</th>
                                        <th class="col22 notexport">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sell_lines as $index => $line)
                                        @if (isset($toggle_dollar) &&
                                                $toggle_dollar == 1 &&
                                                ($line->dollar_final_total != 0 || $line->transaction_payments->sum('dollar_amount') != 0))
                                            @continue
                                        @else
                                            <tr>
                                                <td class="col1">
                                                    {{ $line->transaction_date ?? '' }}
                                                </td>
                                                <td class="col2">
                                                    {{ $line->invoice_no ?? '' }}

                                                    @if (!empty($line->return_parent_id))
                                                        <a data-href="{{ route('sell_return.show', $line->id) }}"
                                                            data-container=".view_modal" class="btn btn-modal"
                                                            data-toggle="modal" style="color: #007bff;">R</a>
                                                    @endif
                                                    @if (!empty($line->payment_status == 'pending'))
                                                        <a data-href="{{ route('sell_return.show', $line->id) }}"
                                                            data-container=".view_modal" class="btn btn-modal"
                                                            data-toggle="modal" style="color: #007bff;">P</a>
                                                    @endif
                                                </td>
                                                <td class="col3">
                                                    {{ $line->store->name ?? '' }}
                                                </td>
                                                {{-- ++++++++ checkbox +++++++++ --}}
                                                <td class="col4">
                                                    <input type="checkbox" name="invoice_selected_delete" class="box1"
                                                        value="{{ $line->id }}" />
                                                </td>
                                                <td class="col5">
                                                    {{ $line->customer->name ?? '' }}
                                                </td>
                                                <td class="col6">
                                                    {{ $line->customer->phone ?? '' }}
                                                </td>
                                                <td class="col8">{{ $line->payment_status }}</td>
                                                <td class="col9">
                                                    @foreach ($line->transaction_payments as $payment)
                                                        {{ __('lang.' . $payment->method) }}<br>
                                                    @endforeach
                                                </td>
                                                <td class="col10">
                                                    @foreach ($line->transaction_payments as $payment)
                                                        {{ $payment->ref_no ?? '' }}<br>
                                                    @endforeach
                                                </td>
                                                <td class="col11">
                                                    {{ number_format($line->final_total, num_of_digital_numbers()) }}
                                                </td>
                                                <td class="col12">
                                                    {{ $line->transaction_payments->sum('amount') }}
                                                </td>
                                                <td class="col13">
                                                    {{ $line->dinar_remaining }}
                                                </td>
                                                <td class="col14">
                                                    {{ number_format($line->dollar_final_total, num_of_digital_numbers()) }}

                                                </td>
                                                <td class="col15">
                                                    {{ $line->transaction_payments->sum('dollar_amount') }}
                                                </td>

                                                <td class="col16">
                                                    {{ $line->dollar_remaining }}
                                                </td>
                                                <td class="col17">
                                                    {{ $line->transaction_payments->last()->due_date ?? '' }}
                                                </td>
                                                <td class="col18">
                                                    {{ $line->transaction_payments->last()->paid_on ?? '' }}
                                                </td>
                                                <td class="col19">
                                                    {{ $line->store_pos->name }}
                                                </td>
                                                <td class="col20"> {{ $line->representative->employee_name ?? '' }} </td>
                                                <td class="col21">
                                                </td>
                                                <td class="col22">
                                                    @foreach ($line->transaction_sell_lines as $sell_line)
                                                        @if (!empty($sell_line->product))
                                                            {{ $sell_line->product->name ?? ' ' }} -
                                                            {{ $sell_line->product->sku ?? ' ' }}<br>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="col23">
                                                    @foreach ($line->transaction_payments as $payment)
                                                        {{ $payment->received_currency_relation->payment_note ?? '' }}<br>
                                                    @endforeach
                                                </td>
                                                <td class="col24">
                                                    @if (count($line->receipts) > 0)
                                                        <a data-href=" {{ route('show_receipt', $line->id) }}"
                                                            data-container=".view_modal"
                                                            class="btn btn-default btn-modal"> {{ __('lang.view') }}
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="col25">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        @lang('lang.action')
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                        user="menu">
                                                        <li>
                                                            <a data-href="{{ route('print_invoice', $line->id) }}"
                                                                class="btn print-invoice"><i class="dripicons-print"></i>
                                                                {{ __('lang.generate_invoice') }}</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a data-href=" {{ route('pos.show', $line->id) }}"
                                                                data-container=".view_modal" class="btn btn-modal"><i
                                                                    class="fa fa-eye"></i>{{ __('lang.view') }}
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        @if ($line->dinar_remaining > 0 || $line->dollar_remaining > 0)
                                                            <li>
                                                                <a data-href="{{ route('add_payment', $line->id) }}"
                                                                    data-container=".view_modal" class="btn btn-modal"><i
                                                                        class="fa fa-plus"></i>
                                                                    {{ __('lang.add_payment') }} </a>
                                                            </li>
                                                            <li class="divider"></li>
                                                        @endif
                                                        <li>
                                                            <a target="_blank"
                                                                href="{{ route('sell.return', $line->id) }}"
                                                                class="btn"><i
                                                                    class="fa fa-undo"></i>@lang('lang.return') </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a data-href="{{ route('show_payment', $line->id) }}"
                                                                data-container=".view_modal" class="btn btn-modal"><i
                                                                    class="fa fa-money"></i>
                                                                {{ __('lang.view_payments') }}
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        {{-- +++++++++ edit button +++++++++++ --}}
                                                        <li>
                                                            <a target="_blank"
                                                                href="{{ route('invoices.edit', $line->id) }}"
                                                                class="btn">
                                                                <i class="dripicons-document-edit"></i>
                                                                {{ __('lang.edit') }}
                                                            </a>
                                                        </li>

                                                        <li class="divider"></li>
                                                        <li>
                                                            <a data-href=" {{ route('upload_receipt', $line->id) }}"
                                                                data-container=".view_modal" data-dismiss="modal"
                                                                class="btn btn-modal"><i
                                                                    class="fa fa-plus"></i>{{ __('lang.upload_receipt') }}
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a data-href="{{ route('pos.destroy', $line->id) }}"
                                                                class="btn text-red delete_item"><i
                                                                    class="fa fa-trash"></i>
                                                                {{ __('lang.delete') }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <td colspan="9" style="text-align: right">@lang('lang.total')</td>
                                    <td id="sum1"></td>
                                    <td id="sum2"></td>
                                    <td id="sum3"></td>
                                    <td id="sum4"></td>
                                    <td id="sum5"></td>
                                    <td id="sum6"></td>
                                    <td colspan="9"></td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->

        {{-- ++++++++++++++++++++++++++++++++++ "delete_all" Modal Form ++++++++++++++++++++++++++++++++++ --}}
        <!-- حذف مجموعة صفوف -->
        <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                            {{ trans('lang.delete_all') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- "Deleted_Selected_Checkboxes" Form --}}
                    <form action="{{ route('pos.multiDeleteRow') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            {{ trans('lang.are_you_want_delete_all') }}
                            <input class="text" type="hidden" id="delete_all_id" name="delete_all_id"
                                value=''>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ trans('lang.close') }}</button>
                            <button type="submit" class="btn btn-danger">{{ trans('lang.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contentbar -->
    {{-- @include() --}}
    <div class="view_modal no-print"></div>
    <section class="invoice print_section print-only" id="receipt_section"> </section>
@endsection
@push('javascripts')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: "<'row'<'col-md-3 'l><'col-md-5 text-center 'B><'col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4'i><'col-sm-4'p>>",
                lengthMenu: [10, 25, 50, 75, 100, 200, 300, 400],
                pageLength: 10,
                buttons: ['copy', 'csv', 'excel', 'pdf',
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ":visible:not(.notexport)"
                        }
                    }
                    // ,'colvis'
                ],
                "fnDrawCallback": function(row, data, start, end, display) {
                    var api = this.api();

                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // Total over all pages
                    total1 = api.rows({
                        'page': 'current'
                    }).nodes().to$().find('td:eq(9)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    total2 = api.rows({
                        'page': 'current'
                    }).nodes().to$().find('td:eq(10)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    total3 = api.rows({
                        'page': 'current'
                    }).nodes().to$().find('td:eq(11)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    total4 = api.rows({
                        'page': 'current'
                    }).nodes().to$().find('td:eq(12)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    total5 = api.rows({
                        'page': 'current'
                    }).nodes().to$().find('td:eq(13)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    total6 = api.rows({
                        'page': 'current'
                    }).nodes().to$().find('td:eq(14)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);

                    // Update status DIV
                    $('#sum1').html('<span>' + total1 + '<span/>');
                    $('#sum2').html('<span>' + total2 + '<span/>');
                    $('#sum3').html('<span>' + total3 + '<span/>');
                    $('#sum4').html('<span>' + total4 + '<span/>');
                    $('#sum5').html('<span>' + total5 + '<span/>');
                    $('#sum6').html('<span>' + total6 + '<span/>');
                }
            });
        });


        document.addEventListener('livewire:load', function() {
            Livewire.on('printInvoice', function(htmlContent) {
                // Set the generated HTML content
                $("#receipt_section").html(htmlContent);
                // Trigger the print action
                window.print("#receipt_section");
            });
        });
        $(document).on("click", ".print-invoice", function() {
            // $(".modal").modal("hide");
            $.ajax({
                method: "get",
                url: $(this).data("href"),
                data: {},
                success: function(result) {
                    if (result.success) {
                        Livewire.emit('printInvoice', result.html_content);
                    }
                },
            });
        });
    </script>
    <script>
        // +++++++++++++++++ Checkboxs and label inside selectbox ++++++++++++++
        $(".checkbox_class2:not(:checked)").each(function() {
            var column = "table ." + $(this).attr("name");
            $(column).hide();
        });

        $(".checkbox_class2").click(function() {
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
    <script>
        // +++++++++++++ select all "checkboxes" +++++++++++++++
        function CheckAll(className, elem) {
            var elements = document.getElementsByClassName(className);
            var l = elements.length;
            if (elem.checked) {
                for (var i = 0; i < l; i++) {
                    elements[i].checked = true;
                }
            } else {
                for (var i = 0; i < l; i++) {
                    elements[i].checked = false;
                }
            }
        }
        // ++++++++++ When click on "delete_all selected" , get "all selected rows" and delete them ++++++++++++
        $("#btn_delete_all").click(function() {
            console.log("+++++++++++ Delete All Btn ++++++++++++++++++++++");
            var selected = new Array();
            $("#datatable-buttons input[type=checkbox]:checked").each(function() {
                selected.push(this.value);
            });
            if (selected.length > 0) {
                $('#delete_all').modal('show')
                $('input[id="delete_all_id"]').val(selected);
            }
        });
    </script>
@endpush

{{--    @livewire('invoices.index') --}}

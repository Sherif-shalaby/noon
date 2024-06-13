@extends('layouts.app')
@section('title', __('lang.stock'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.stock')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('stocks.create') }}">@lang('lang.add-stock')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.stock')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a type="button" class="btn btn-primary" href="{{ route('stocks.create') }}">@lang('lang.add-stock')</a>
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
        .selectBox select {
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

        #checkboxes label span {
            font-weight: normal;
        }
    </style>
@endsection
@section('content')
    {{-- @livewire('add-stock.add-payment') --}}
    <section class="">
        <div class="col-md-22">
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center">
                    <h3 class="print-title">@lang('lang.stock')</h3>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="container-fluid">
                            @include('add-stock.partials.filters')
                        </div>
                    </div>
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
                                {{-- +++++++++++++++++ checkbox1 : po_ref_no +++++++++++++++++ --}}
                                <label for="col1_id">
                                    <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                    <span>{{ __('lang.po_ref_no') }}</span> &nbsp;
                                </label>
                                {{-- +++++++++++++++++ checkbox2 : invoice_no +++++++++++++++++ --}}
                                <label for="col2_id">
                                    <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                    <span>@lang('lang.invoice_no')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox3 : date_and_time +++++++++++++++++ --}}
                                <label for="col3_id">
                                    <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                    <span>@lang('lang.date_and_time')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox4 : invoice_date +++++++++++++++++ --}}
                                <label for="col4_id">
                                    <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                    <span>@lang('lang.invoice_date')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox5 : supplier +++++++++++++++++ --}}
                                <label for="col5_id">
                                    <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                    <span>@lang('lang.supplier')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox6 : products +++++++++++++++++ --}}
                                <label for="col6_id">
                                    <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                    <span>@lang('lang.products')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox7 : created_by +++++++++++++++++ --}}
                                <label for="col7_id">
                                    <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                    <span>@lang('lang.created_by')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox8 : value +++++++++++++++++ --}}
                                <label for="col8_id">
                                    <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                    <span>@lang('lang.value')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox9 : paid_amount +++++++++++++++++ --}}
                                <label for="col9_id">
                                    <input type="checkbox" id="col9_id" name="col9" checked="checked" />
                                    <span>@lang('lang.paid_amount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox10 : pending_amount +++++++++++++++++ --}}
                                <label for="col10_id">
                                    <input type="checkbox" id="col10_id" name="col10" checked="checked" />
                                    <span>@lang('lang.pending_amount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox11 : due_date +++++++++++++++++ --}}
                                <label for="col11_id">
                                    <input type="checkbox" id="col11_id" name="col11" checked="checked" />
                                    <span>@lang('lang.due_date')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox12 : invoice_discount +++++++++++++++++ --}}
                                <label for="col12_id">
                                    <input type="checkbox" id="col12_id" name="col12" checked="checked" />
                                    <span>@lang('lang.invoice_discount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox13 : product_discount +++++++++++++++++ --}}
                                <label for="col13_id">
                                    <input type="checkbox" id="col13_id" name="col13" checked="checked" />
                                    <span>@lang('lang.product_discount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox14 : product_discount_percent +++++++++++++++++ --}}
                                <label for="col14_id">
                                    <input type="checkbox" id="col14_id" name="col14" checked="checked" />
                                    <span>@lang('lang.product_discount_percent')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox15 : cash_discount +++++++++++++++++ --}}
                                <label for="col15_id">
                                    <input type="checkbox" id="col15_id" name="col15" checked="checked" />
                                    <span>@lang('lang.cash_discount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox16 : seasonal_discount +++++++++++++++++ --}}
                                <label for="col16_id">
                                    <input type="checkbox" id="col16_id" name="col16" checked="checked" />
                                    <span>@lang('lang.seasonal_discount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox17 : annual_discount +++++++++++++++++ --}}
                                <label for="col17_id">
                                    <input type="checkbox" id="col17_id" name="col17" checked="checked" />
                                    <span>@lang('lang.annual_discount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox18 : notes +++++++++++++++++ --}}
                                <label for="col18_id">
                                    <input type="checkbox" id="col18_id" name="col18" checked="checked" />
                                    <span>@lang('lang.notes')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox19 : action +++++++++++++++++ --}}
                                <label for="col19_id">
                                    <input type="checkbox" id="col19_id" name="col19" checked="checked" />
                                    <span>@lang('lang.action')</span>
                                </label>
                            </div>
                        </div>
                    </div> <br />
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table dataTable">
                            <thead>
                                <tr>
                                    <th class="col1">@lang('lang.po_ref_no')</th>
                                    <th class="col2">@lang('lang.invoice_no')</th>
                                    <th class="col3">@lang('lang.date_and_time')</th>
                                    <th class="col4">@lang('lang.invoice_date')</th>
                                    <th class="col5">@lang('lang.supplier')</th>
                                    <th class="col6">@lang('lang.products')</th>
                                    <th class="col7">@lang('lang.created_by')</th>
                                    <th class="sum col8">@lang('lang.value')</th>
                                    <th class="sum col9">@lang('lang.paid_amount')</th>
                                    <th class="sum col10">@lang('lang.pending_amount')</th>
                                    <th class="col11">@lang('lang.due_date')</th>
                                    <th class="col12">@lang('lang.invoice_discount')</th>
                                    <th class="col13">@lang('lang.product_discount')</th>
                                    <th class="col14">@lang('lang.product_discount_percent')</th>
                                    <th class="col15">@lang('lang.cash_discount')</th>
                                    <th class="col16">@lang('lang.seasonal_discount')</th>
                                    <th class="col17">@lang('lang.annual_discount')</th>
                                    <th class="col18">@lang('lang.notes')</th>
                                    <th class="notexport col19">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stocks as $index => $stock)
                                    <tr>
                                        <td class="col1">{{ $stock->po_no ?? '' }}</td>
                                        <td class="col2">{{ $stock->invoice_no ?? '' }}</td>
                                        <td class="col3">{{ $stock->created_at }}</td>
                                        <td class="col4">{{ $stock->transaction_date }}</td>
                                        <td class="col5">{{ $stock->supplier->name ?? '' }}</td>
                                        <td class="col6">
                                            @if (!empty($stock->add_stock_lines))
                                                @foreach ($stock->add_stock_lines as $stock_line)
                                                    {{ $stock_line->product->name ?? '' }}<br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="col7">{{ $stock->created_by_relationship->first()->name }}</td>
                                        @if ($stock->transaction_currency == 2)
                                            <td class="col8">{{ @num_format($stock->dollar_final_total) }}</td>
                                        @else
                                            <td class="col8">{{ @num_format($stock->final_total) }}</td>
                                        @endif
                                        @php
                                            $final_total = 0;
                                            $paid = 0;
                                            $payments = $stock->transaction_payments;
                                            if ($stock->transaction_currency == 2) {
                                                $final_total = $stock->dollar_final_total;
                                                foreach ($payments as $payment) {
                                                    if ($payment->paying_currency == 2) {
                                                        $paid += $payment->amount;
                                                    } else {
                                                        $paid += $payment->amount / $payment->exchange_rate;
                                                    }
                                                }
                                            } else {
                                                $final_total = $stock->final_total;
                                                foreach ($payments as $payment) {
                                                    if ($payment->paying_currency == 2) {
                                                        $paid += $payment->amount * $payment->exchange_rate;
                                                    } else {
                                                        $paid += $payment->amount;
                                                    }
                                                }
                                            }
                                        @endphp
                                        <td class="col9">
                                            {{ @num_format($paid) }}
                                        </td>
                                        @php
                                            $final_total = 0;
                                            $pending = 0;
                                            $amount = 0;
                                            $payments = $stock->transaction_payments;
                                            if ($stock->transaction_currency == 2) {
                                                $final_total = $stock->dollar_final_total;
                                                foreach ($payments as $payment) {
                                                    if ($payment->paying_currency == 2) {
                                                        $amount += $payment->amount;
                                                        $pending = $final_total - $amount;
                                                    } else {
                                                        $amount += $payment->amount / $payment->exchange_rate;
                                                        $pending = $final_total - $amount;
                                                    }
                                                }
                                            } else {
                                                $final_total = $stock->final_total;
                                                foreach ($payments as $payment) {
                                                    if ($payment->paying_currency == 2) {
                                                        $amount += $payment->amount * $payment->exchange_rate;
                                                        $pending = $final_total - $amount;
                                                    } else {
                                                        $amount += $payment->amount;
                                                        $pending = $final_total - $amount;
                                                    }
                                                }
                                            }
                                        @endphp
                                        <td class="col10">
                                            {{ @num_format($pending) }}
                                        </td>
                                        <td class="col11">{{ $stock->due_date ?? '' }}</td>
                                        <td class="col12">{{ $stock->discount_amount }}</td>
                                        <td class="col13">
                                            @if (!empty($stock->add_stock_lines) && $stock->add_stock_lines->count() > 0)
                                                {{ $stock->add_stock_lines->where('used_currency', '!=', 2)->sum('discount') }}
                                                <span>
                                                    {{ $stock->add_stock_lines->where('used_currency', 2)->sum('discount') }}</span>
                                                $
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td class="col14">
                                            @if (!empty($stock->add_stock_lines) && $stock->add_stock_lines->count() > 0)
                                                {{ $stock->add_stock_lines->where('used_currency', '!=', 2)->sum('discount_percent') }}
                                                %
                                                <span>
                                                    {{ $stock->add_stock_lines->where('used_currency', 2)->sum('discount_percent') }}</span>
                                                $
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td class="col15">
                                            @if (!empty($stock->add_stock_lines) && $stock->add_stock_lines->count() > 0)
                                                {{ $stock->add_stock_lines->where('used_currency', '!=', 2)->sum('cash_discount') }}
                                                <span>
                                                    {{ $stock->add_stock_lines->where('used_currency', 2)->sum('cash_discount') }}</span>
                                                $
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td class="col16">
                                            @if (!empty($stock->add_stock_lines) && $stock->add_stock_lines->count() > 0)
                                                {{ $stock->add_stock_lines->where('used_currency', '!=', 2)->sum('seasonal_discount') }}
                                                %
                                                <span>
                                                    {{ $stock->add_stock_lines->where('used_currency', 2)->sum('seasonal_discount') }}</span>$
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td class="col17">
                                            @if (!empty($stock->add_stock_lines) && $stock->add_stock_lines->count() > 0)
                                                {{ $stock->add_stock_lines->where('used_currency', '!=', 2)->sum('annual_discount') }}
                                                %
                                                <span>
                                                    {{ $stock->add_stock_lines->where('used_currency', 2)->sum('annual_discount') }}</span>$
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td class="col18">{{ $stock->notes ?? '' }}</td>
                                        <td class="col19">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                user="menu">
                                                <li>
                                                    <a href="{{ route('stocks.show', $stock->id) }}" class="btn"><i
                                                            class="fa fa-eye"></i>
                                                        @lang('lang.view') </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{ route('stocks.edit', $stock->id) }}" class="btn"><i
                                                            class="fa fa-edit"></i>
                                                        @lang('lang.edit') </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{ route('stocks.delete', $stock->id) }}"
                                                        {{-- data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}" --}} class="btn text-red delete_item"><i
                                                            class="fa fa-trash"></i>
                                                        @lang('lang.delete')</a>
                                                </li>
                                                @if ($stock->add_stock_lines->sum('seasonal_discount') > 0 || $stock->add_stock_lines->sum('annual_discount') > 0)
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a data-href="{{ route('stocks.receive_discount_view', $stock->id) }}"
                                                            data-container=".view_modal" class="btn btn-modal">
                                                            <i class="fa fa-money"></i>
                                                            @lang('lang.receive_discount')
                                                        </a>
                                                    </li>
                                                @endif
                                                @if ($stock->payment_status != 'paid')
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a data-href="{{ route('stocks.addPayment', $stock->id) }}"
                                                            data-container=".view_modal" class="btn btn-modal">
                                                            <i class="fa fa-money"></i>
                                                            @lang('lang.pay')
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td colspan="7" style="text-align: right">@lang('lang.total')</td>
                                <td id="sum1"></td>
                                <td id="sum2"></td>
                                <td id="sum3"></td>
                                <td colspan="1"></td>
                                <td id="sum4"></td>
                                <td colspan=""></td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- add Payment Modal -->
        {{--    @include('add-stock.partials.add-payment') --}}

    </section>
    <div class="view_modal no-print"></div>
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
                        }).nodes().to$().find('td:eq(7)').map(function() {
                            return intVal($(this).text());
                        }).get().reduce(function(a, b) {
                            return a + b;
                        }, 0);
                        total2 = api.rows({
                            'page': 'current'
                        }).nodes().to$().find('td:eq(8)').map(function() {
                            return intVal($(this).text());
                        }).get().reduce(function(a, b) {
                            return a + b;
                        }, 0);
                        total3 = api.rows({
                            'page': 'current'
                        }).nodes().to$().find('td:eq(9)').map(function() {
                            return intVal($(this).text());
                        }).get().reduce(function(a, b) {
                            return a + b;
                        }, 0);
                        total4 = api.rows({
                            'page': 'current'
                        }).nodes().to$().find('td:eq(11)').map(function() {
                            return intVal($(this).text());
                        }).get().reduce(function(a, b) {
                            return a + b;
                        }, 0);

                        // Update status DIV
                        $('#sum1').html('<span>' + total1 + '<span/>');
                        $('#sum2').html('<span>' + total2 + '<span/>');
                        $('#sum3').html('<span>' + total3 + '<span/>');
                        $('#sum4').html('<span>' + total4 + '<span/>');
               
                    }
                });
            });
            window.addEventListener('openAddPaymentModal', event => {
                $("#addPayment").modal('show');
            })

            window.addEventListener('closeAddPaymentModal', event => {
                $("#addPayment").modal('hide');
            })
        </script>
        {{-- +++++++++++++++++ Checkboxs and label inside selectbox ++++++++++++++ --}}
        <script>
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
    @endpush

@endsection

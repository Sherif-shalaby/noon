@extends('layouts.app')
@section('title', __('lang.representatives_requests'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.representatives')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        {{--                        <li class="breadcrumb-item active"><a href="#">@lang('lang.employees')</a></li> --}}
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.representatives')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                {{-- <div class="widgetbar"> --}}
                    {{-- <a class="btn btn-primary" href="{{ route('employees.create') }}">@lang('lang.add_employee')</a> --}}
                    {{--                    <a style="color: white" href="{{ action('EmployeeController@create') }}" class="btn btn-info"><i --}}
                    {{--                            class="dripicons-plus"></i> --}}
                    {{--                        @lang('lang.add_new_employee')</a> --}}
                {{-- </div> --}}
            </div>
        </div>
    </div>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="col-md-12  no-print">
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center">
                    <h4 class="print-title">@lang('lang.employees')</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="container-fluid">
                                @include('employees.representatives.filters')
                            </div>
                        </div>
                    </div>
                    {{-- +++++++++++++++ Style : checkboxes and labels inside selectbox +++++++++++++++ --}}
                    <style>
                        .selectBox
                        {
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

                        .overSelect
                        {
                            position: absolute;
                            left: 0;
                            right: 0;
                            top: 0;
                            bottom: 0;
                        }

                        #checkboxes
                        {
                            display: none;
                            border: 1px #dadada solid;
                            height: 125px;
                            overflow: auto;
                            padding-top: 10px;
                            /* text-align: end;  */
                        }

                        #checkboxes label
                        {
                            display: block;
                            padding: 5px;

                        }

                        #checkboxes label:hover
                        {
                            background-color: #ddd;
                        }
                        #checkboxes label span
                        {
                            font-weight: normal;
                        }
                    </style>
                    {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                    <div class="col-md-4 col-lg-4">
                        <div class="multiselect col-md-6">
                            <div class="selectBox" onclick="showCheckboxes()">
                                <select class="form-select form-control form-control-lg">
                                    <option>@lang('lang.show_hide_columns')</option>
                                </select>
                                <div class="overSelect"></div>
                            </div>
                            <div id="checkboxes">
                                {{-- +++++++++++++++++ checkbox1 : invoice_no +++++++++++++++++ --}}
                                <label for="col1_id">
                                    <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                    <span>@lang('lang.invoice_no')</span> &nbsp;
                                </label>
                                {{-- +++++++++++++++++ checkbox2 : employee_name +++++++++++++++++ --}}
                                <label for="col2_id">
                                    <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                    <span>@lang('lang.employee_name')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox3 : location +++++++++++++++++ --}}
                                <label for="col3_id">
                                    <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                    <span>@lang('lang.location')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox4 : stores +++++++++++++++++ --}}
                                <label for="col4_id">
                                    <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                    <span>@lang('lang.stores')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox5 : pos +++++++++++++++++ --}}
                                <label for="col5_id">
                                    <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                    <span>@lang('lang.pos')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox6 : customers +++++++++++++++++ --}}
                                <label for="col6_id">
                                    <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                    <span>@lang('lang.customers')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox7 : date +++++++++++++++++ --}}
                                <label for="col7_id">
                                    <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                    <span>@lang('lang.date')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox8 : amount +++++++++++++++++ --}}
                                <label for="col8_id">
                                    <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                    <span>@lang('lang.amount')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox9 : remaining +++++++++++++++++ --}}
                                <label for="col9_id">
                                    <input type="checkbox" id="col9_id" name="col9" checked="checked" />
                                    <span>@lang('lang.remaining')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox10 : product +++++++++++++++++ --}}
                                <label for="col10_id">
                                    <input type="checkbox" id="col10_id" name="col10" checked="checked" />
                                    <span>@lang('lang.product')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox11 : quantity +++++++++++++++++ --}}
                                <label for="col11_id">
                                    <input type="checkbox" id="col11_id" name="col11" checked="checked" />
                                    <span>@lang('lang.quantity')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox12 : unit +++++++++++++++++ --}}
                                <label for="col12_id">
                                    <input type="checkbox" id="col12_id" name="col12" checked="checked" />
                                    <span>@lang('lang.unit')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox13 : purchase_price +++++++++++++++++ --}}
                                <label for="col13_id">
                                    <input type="checkbox" id="col13_id" name="col13" checked="checked" />
                                    <span>@lang('lang.purchase_price')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox14 : sell_price +++++++++++++++++ --}}
                                <label for="col14_id">
                                    <input type="checkbox" id="col14_id" name="col14" checked="checked" />
                                    <span>@lang('lang.sell_price')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox15 : action +++++++++++++++++ --}}
                                <label for="col15_id">
                                    <input type="checkbox" id="col15_id" name="col15" checked="checked" />
                                    <span>@lang('lang.action')</span>
                                </label>
                            </div>
                        </div>
                    </div> <br/>
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                                <tr>
                                    <th class="col1">@lang('lang.invoice_no')</th>
                                    <th class="col2">@lang('lang.employee_name')</th>
                                    <th class="col3">@lang('lang.location')</th>
                                    <th class="col4">@lang('lang.stores')</th>
                                    <th class="col5">@lang('lang.pos')</th>
                                    <th class="col6">@lang('lang.customers')</th>
                                    <th class="col7">@lang('lang.date')</th>
                                    <th class="col8">@lang('lang.amount')</th>
                                    <th class="col9">@lang('lang.remaining')</th>
                                    <th class="col10">@lang('lang.product')</th>
                                    <th class="col11">@lang('lang.quantity')</th>
                                    <th class="col12">@lang('lang.unit')</th>
                                    <th class="col13">@lang('lang.purchase_price')  </th>
                                    <th class="col14">@lang('lang.sell_price')  </th>
                                    <th class="col15 notexport">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $key => $transaction)
                                    <tr>
                                        <td class="col1">{{ $transaction->invoice_no }}</td>
                                        <td class="col2">
                                            {{ !empty($transaction->employee->user) ? $transaction->employee->user->name : '' }}
                                        </td>
                                        <td class="col3">
                                            {{App\Models\DeliveryLocation::where('delivery_id',$transaction->employee_id)->latest()->first()->city->name}}
                                            {{-- {{ !empty($transaction->employee->delivery_locations) ? $transaction->employee->delivery_locations : '' }} --}}
                                        </td>
                                        <td class="col4">
                                            {{ !empty($transaction->store) ? $transaction->store->name : '' }}
                                        </td>
                                        <td class="col5">
                                            {{ !empty($transaction->store_pos) ? $transaction->store_pos->name : '' }}
                                        </td>
                                        <td class="col6">
                                            {{ !empty($transaction->customer) ? $transaction->customer->name : '' }}
                                        </td>
                                        <td class="col7">
                                            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d') }}
                                        </td>
                                        <td class="col8">{{ @number_format($transaction->final_total) }} <br>
                                            {{ @number_format($transaction->dollar_final_total) }} $</td>
                                        <td class="col9">{{ @number_format($transaction->dinar_remaining) }} <br>
                                            {{ @number_format($transaction->dollar_remaining) }} $</td>
                                        <td class="col10">
                                            @if ($transaction->transaction_sell_lines)
                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                    {{ $sellLine->product->name ?? '' }} <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="col11">{{ $transaction->quantity??0 }}</td>
                                        <td class="col12">
                                            @if ($transaction->transaction_sell_lines)
                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                    {{ $sellLine->variation->unit->name ?? '' }} <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="col13">
                                            @if ($transaction->transaction_sell_lines)
                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                    {{ $sellLine->purchase_price ?? 0 }} , {{ $sellLine->dollar_purchase_price ?? 0 }} $  <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="col14">
                                            @if ($transaction->transaction_sell_lines)
                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                    {{ $sellLine->sell_price ?? 0 }},{{ $sellLine->dollar_sell_price ?? 0 }}$  <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="col15">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                user="menu">';
                                                <li>
                                                    <a href="{{ route('employees.show', $transaction->id) }}"
                                                        class="btn"><i class="fa fa-eye"></i>
                                                        @lang('lang.view') </a>
                                                </li>
                                                <li class="divider"></li>

                                                {{-- <li>
                                                    <a href="{{ route('employees.edit', $transaction->id) }}"
                                                        target="_blank" class="btn edit_employee"><i
                                                            class="fa fa-pencil-square-o"></i>
                                                        @lang('lang.edit')</a>
                                                </li>--}}
                                                <li>
                                                    <a data-href="{{ route('representatives.destroy', $transaction->id) }}"
                                                        class="btn delete_item text-red delete_item"><i
                                                            class="fa fa-trash"></i>
                                                        @lang('lang.delete')</a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{ route('representatives.print_representative_invoice', $transaction->id) }}"
                                                        class="btn text-red print_representative_invoice"><i
                                                            class="fa fa-print"></i>
                                                        @lang('lang.print')</a>
                                                </li>
                                                @if(empty($transaction->transaction_payments->first()))
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{ route('representatives.pay', $transaction->id) }}"
                                                            class="btn text-red"><i
                                                                class="fa fa-money"></i>
                                                            @lang('lang.pay')</a>
                                                    </li>
                                                @endif
                                                {{-- @if (!empty($transaction->job_type) && $transaction->job_type->title == 'Representative')
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{ route('employees.add_points') }}"
                                                            class="btn add_point"><i class="fa fa-plus"></i>
                                                            @lang('lang.add_points')
                                                        </a>
                                                    </li>
                                                @endif --}}
                                            </ul>
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
<!-- This will be printed -->
<section class="invoice print_section print-only" id="receipt_section"> </section>

@endsection
@push('javascripts')
    <script>
        $(document).on('click','.print_representative_invoice',function(){
            $.ajax({
                method: "get",
                url: $(this).data('href'),
                success: function (response) {
                    console.log(response)
                    if(response!==''){
                    pos_print(response);
                    }
                }
            });
        });
        function pos_print(receipt) {
        $("#receipt_section").html(receipt);
        const sectionToPrint = document.getElementById('receipt_section');
        __print_receipt(sectionToPrint);
        }
        function __print_receipt(section= null) {
            setTimeout(function () {
                section.style.display = 'block';
                window.print();
                section.style.display = 'none';

            }, 1000);
        }
    </script>
    {{-- +++++++++++++++ Show/Hide checkboxes +++++++++++++++ --}}
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
@endpush

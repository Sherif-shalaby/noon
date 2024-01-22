@extends('layouts.app')
@section('title', 'تقرير المبيعات لكل موظف')
@section('breadcrumbbar')
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30 mt-3">
                <div class="card-header">
                    <h5 class="card-title">تقرير المبيعات لكل موظف</h5>
                </div>
                <div class="card-body">
                    @include('reports.employee-sales.filters')
                    <br/>
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
                                {{-- +++++++++++++++++ checkbox1 : date +++++++++++++++++ --}}
                                <label for="col1_id">
                                    <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                    <span>@lang('lang.date')</span> &nbsp;
                                </label>
                                {{-- +++++++++++++++++ checkbox2 : reference +++++++++++++++++ --}}
                                <label for="col2_id">
                                    <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                    <span>@lang('lang.reference')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox3 : employee +++++++++++++++++ --}}
                                <label for="col3_id">
                                    <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                    <span>@lang('lang.employee')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox4 : currency +++++++++++++++++ --}}
                                <label for="col4_id">
                                    <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                    <span>@lang('lang.currency')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox5 : commission +++++++++++++++++ --}}
                                <label for="col5_id">
                                    <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                    <span>@lang('lang.commission')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox6 : paid +++++++++++++++++ --}}
                                <label for="col6_id">
                                    <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                    <span>@lang('lang.paid')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox7 : متأخرات +++++++++++++++++ --}}
                                <label for="col7_id">
                                    <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                    <span>متأخرات</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox8 : due +++++++++++++++++ --}}
                                <label for="col8_id">
                                    <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                    <span>@lang('lang.due')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox9 : payment_type +++++++++++++++++ --}}
                                <label for="col9_id">
                                    <input type="checkbox" id="col9_id" name="col9" checked="checked" />
                                    <span>@lang('lang.payment_type')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox10 : payment_status +++++++++++++++++ --}}
                                <label for="col10_id">
                                    <input type="checkbox" id="col10_id" name="col10" checked="checked" />
                                    <span>@lang('lang.payment_status')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox11 : action +++++++++++++++++ --}}
                                <label for="col11_id">
                                    <input type="checkbox" id="col11_id" name="col11" checked="checked" />
                                    <span>@lang('lang.action')</span>
                                </label>
                            </div>
                        </div>
                    </div> <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="col1">@lang('lang.date')</th>
                                            <th class="col2">@lang('lang.reference')</th>
                                            <th class="col3">@lang('lang.employee')</th>
                                            <th class="col4 currencies">@lang('lang.currency')</th>
                                            <th class="col5 sum">@lang('lang.commission')</th>
                                            <th class="col6 sum">@lang('lang.paid')</th>
                                            <th class="col7">متأخرات</th>
                                            <th class="col8 sum">@lang('lang.due')</th>
                                            <th class="col9">@lang('lang.payment_type')</th>
                                            <th class="col10">@lang('lang.payment_status')</th>
                                            <th class="col11 notexport">@lang('lang.action')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($sales as $key => $sale)
                                            <tr>
                                                <td class="col1">{{ @format_date($sale->created_at->format('Y-m-d')) }}</td>
                                                <td class="col2">
                                                    @php
                                                        $ref_numbers = '';
                                                        if (!empty($request->method)) {
                                                            $payments = $sale->transaction_payments->where('method', $request->method);
                                                        } else {
                                                            $payments = $sale->transaction_payments;
                                                        }

                                                    foreach ($payments as $payment) {
                                                        if (!empty($payment->ref_number)) {
                                                            $ref_numbers .= $payment->ref_number . '<br>';
                                                        }
                                                    }
                                                    @endphp
                                                    {{$ref_numbers}}
                                                </td>
                                                <td class="col3">{{$sale->employee->name??''}}</td>
                                                <td class="col4">
                                                    @php
                                                    $default_currency = \App\Models\Currency::find($default_currency_id);
                                                    @endphp
                                                    {{$sale->paying_currency_symbol ?? $default_currency->symbol}}
                                                </td>
                                                <td class="col5">

                                                </td>
                                                <td class="col6">
                                                    @php
                                                        $amount_paid =  $sale->transaction_payments->sum('amount');
                                                        $paying_currency_id = $sale->paying_currency_id ?? $default_currency_id;
                                                    @endphp
                                                    <span data-currency_id="{{$paying_currency_id }}"> {{ $amount_paid }}</span>
                                                </td>
                                                <td class="col7">
                                                    @php
                                                    $due =  $sale->final_total - $sale->transaction_payments->sum('amount');
                                                    $paying_currency_id = $sale->paying_currency_id ?? $default_currency_id;
                                                    @endphp
                                                    <span data-currency_id="$paying_currency_id ">{{$due}}</span>
                                                </td>
                                                <td class="col8">{{@format_datetime($sale->paid_on)}}</td>
                                                <td class="col9">
                                                    @foreach ($sale->transaction_payments as $payment)
                                                        @if (!empty($payment->method))
                                                            {{$payment_types[$payment->method]}} <br>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="col10">
                                                    @if($sale->payment_status == 'pending')
                                                        <span class="label label-success">{{__('lang.pay_later') }}</span>
                                                    @else
                                                        <span class="label label-danger">{{ ucfirst($sale->status)}}</span>
                                                    @endif
                                                </td>
                                                <td class="col11">
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">خيارات <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu" x-placement="bottom-end"
                                                            style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                            <li>
                                                                <a data-href="{{route('show_payment', $sale->id)}}" data-container=".view_modal" class="btn btn-modal">
                                                                    <i class="fa fa-money"></i>
                                                                    @lang('lang.view_payments')
                                                                </a>
                                                            </li>
                                                            @if ($sale->status != 'draft' && $sale->payment_status != 'paid' && $sale->status != 'canceled')
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{route('add_payment', $sale->id)}}" data-container=".view_modal" class="btn btn-modal">
                                                                    <i class="fa fa-plus"></i>
                                                                    @lang('lang.add_payments')
                                                                </a>
                                                            </li>
                                                            @endif
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{route('pos.show', $sale->id)}}" data-container=".view_modal" class="btn btn-modal">
                                                                    <i class="fa fa-eye"></i>
                                                                    @lang('lang.view')
                                                                </a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{ route('pos.destroy', $sale->id) }}"
                                                                    class="btn text-red delete_item">
                                                                    <i class="fa fa-trash"></i>
                                                                    @lang('lang.delete')
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <th style="text-align: right">@lang('lang.total')</th>
                                            <td></td>
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
        </div>
    </div>

    <div class="view_modal no-print" >

    </div>
@endsection
@section('content')

@endsection
@section('javascript')
    {{-- +++++++++++++++ Show/Hide checkboxes +++++++++++++++ --}}
    <script>
        // ++++++++ Checkboxs and label inside selectbox ++++++++
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

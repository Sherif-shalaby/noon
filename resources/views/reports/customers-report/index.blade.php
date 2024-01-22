@extends('layouts.app')
@section('title', __('lang.customer_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.customer_report')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.reports')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.customer_report')</li>
                    </ol>
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

        #checkboxes ,
        #checkboxes2 {
        display: none;
        border: 1px #dadada solid;
        height: 125px;
        overflow: auto;
        padding-top: 10px;
        /* text-align: end;  */
        }

        #checkboxes label ,
        #checkboxes2 label
        {
        display: block;
        padding: 5px;

        }

        #checkboxes label:hover ,
        #checkboxes2 label:hover {
        background-color: #ddd;
        }
        #checkboxes label span ,
        #checkboxes2 label span
        {
            font-weight: normal;
        }
    </style>
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
                        <h5 class="card-title">@lang('lang.customer_report')</h5>
                    </div>
                    <div class="card-body">
                        @include('reports.customers-report.filters')
                        {{-- ================================ Tabs Header ================================ --}}
                        {{-- <div> --}}
                        <ul class="nav nav-pills">
                            {{-- ####### Tab 1 ####### --}}
                            <li class="nav-item">
                                <a class="nav-link active pt-2 pb-2" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                    role="tab" aria-controls="nav-home" aria-selected="true">
                                    المبيعات
                                </a>
                            </li>
                            {{-- ####### Tab 2 ####### --}}
                            <li class="nav-item">
                                <a class="nav-link pt-2 pb-2" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                    role="tab" aria-controls="nav-profile" aria-selected="false">
                                    المدفوعات
                                </a>
                            </li>
                        </ul>
                        {{-- </div> --}}
                        <br /><br />
                        {{-- ================================ Tabs Body ================================ --}}
                        <div class="tab-content" id="nav-tabContent">
                            {{-- +++++++++++++++++++++ Table 1 +++++++++++++++++++++ --}}
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                                <div class="col-md-4 col-lg-4">
                                    <div class="multiselect col-md-6">
                                        <div class="selectBox" onclick="showCheckboxes(1)">
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
                                            {{-- +++++++++++++++++ checkbox2 : reference_no +++++++++++++++++ --}}
                                            <label for="col2_id">
                                                <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                                <span>@lang('lang.reference_no')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox3 : customer +++++++++++++++++ --}}
                                            <label for="col3_id">
                                                <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                                <span>@lang('lang.customer')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox4 : product +++++++++++++++++ --}}
                                            <label for="col4_id">
                                                <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                                <span>@lang('lang.product')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox5 : المبلغ الاجمالي +++++++++++++++++ --}}
                                            <label for="col5_id">
                                                <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                                <span>المبلغ الاجمالي</span>
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
                                            {{-- +++++++++++++++++ checkbox8 : حالة المبيعات +++++++++++++++++ --}}
                                            <label for="col8_id">
                                                <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                                <span>حالة المبيعات</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox9 : payment_status +++++++++++++++++ --}}
                                            <label for="col9_id">
                                                <input type="checkbox" id="col9_id" name="col9" checked="checked" />
                                                <span>@lang('lang.payment_status')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox10 : action +++++++++++++++++ --}}
                                            <label for="col10_id">
                                                <input type="checkbox" id="col10_id" name="col10" checked="checked" />
                                                <span>@lang('lang.action')</span>
                                            </label>
                                        </div>
                                    </div>
                                </div> <br/>
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="col1">التاريخ</th>
                                            <th class="col2">رقم المرجع</th>
                                            <th class="col3">عميل</th>
                                            <th class="col4">منتج</th>
                                            <th class="col5">المبلغ الاجمالي</th>
                                            <th class="col6">دفٌعت</th>
                                            <th class="col7">متأخرات</th>
                                            <th class="col8">حالة المبيعات</th>
                                            <th class="col9">حالة السداد</th>
                                            <th class="col10">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer_transactions_sell_lines as $key => $customer_transactions_sell_line)
                                            <tr>
                                                <td class="col1">{{ $customer_transactions_sell_line->created_at->format('Y-m-d') }}</td>
                                                <td class="col2">{{ $customer_transactions_sell_line->invoice_no ?? '' }}</td>
                                                <td class="col3">{{ $customer_transactions_sell_line->customer->name ?? '' }}</td>
                                                {{-- Get All_sell_lines of transaction Then Get "product name" --}}
                                                <td class="col4">
                                                    <ul>
                                                        @foreach ($customer_transactions_sell_line->transaction_sell_lines as $transaction_sell_lines)
                                                            <li>{{ $transaction_sell_lines->product->name ?? '' }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td class="col5">{{ number_format($customer_transactions_sell_line->final_total, 2) }}
                                                </td>
                                                {{-- Get All_Payments of transaction Then Get "payment amount" --}}
                                                <td class="col6">{{ number_format($customer_transactions_sell_line->transaction_payments->sum('amount'), 2) }}
                                                </td>
                                                {{-- متاخرات --}}
                                                <td class="col7">
                                                    {{ @num_format($customer_transactions_sell_line->transaction_payments->sum('amount') - $customer_transactions_sell_line->final_total) ?? '' }}
                                                </td>
                                                {{-- sells status --}}
                                                <td class="col8">{{ $customer_transactions_sell_line->status ?? '' }}</td>
                                                {{-- payment status --}}
                                                <td class="col9">{{ $customer_transactions_sell_line->payment_status }}</td>
                                                <td class="col10">
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
                                                                <a data-href="{{ route('show_payment', $customer_transactions_sell_line->id) }}"
                                                                    data-container=".view_modal" class="btn btn-modal">
                                                                    <i class="fa fa-money"></i>
                                                                    @lang('lang.view_payments')
                                                                </a>
                                                            </li>
                                                            @if (
                                                                $customer_transactions_sell_line->status != 'draft' &&
                                                                    $customer_transactions_sell_line->payment_status != 'paid' &&
                                                                    $customer_transactions_sell_line->status != 'canceled')
                                                                <li class="divider"></li>
                                                                <li>
                                                                    <a data-href="{{ route('add_payment', $customer_transactions_sell_line->id) }}"
                                                                        data-container=".view_modal" class="btn btn-modal">
                                                                        <i class="fa fa-plus"></i>
                                                                        @lang('lang.add_payments')
                                                                    </a>
                                                                </li>
                                                            @endif
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{ route('pos.show', $customer_transactions_sell_line->id) }}"
                                                                    data-container=".view_modal" class="btn btn-modal">
                                                                    <i class="fa fa-eye"></i>
                                                                    @lang('lang.view')
                                                                </a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{ route('print_invoice', $customer_transactions_sell_line->id) }}"
                                                                    class="btn print-invoice"><i class="fa fa-print"></i>
                                                                    @lang('lang.print_invoice')
                                                                </a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a href="{{ route('sell.return', $customer_transactions_sell_line->id) }}"
                                                                    class="btn" target="_blank">
                                                                    <i class="fa fa-undo"></i>
                                                                    @lang('lang.sale_return')
                                                                </a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{ route('customers-report.destroy', $customer_transactions_sell_line->id) }}"
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
                                </table>
                            </div>
                            {{-- +++++++++++++++++++++ Table 2 +++++++++++++++++++++ --}}
                            <div class="tab-pane fade"id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                                <div class="col-md-4 col-lg-4">
                                    <div class="multiselect col-md-6">
                                        <div class="selectBox" onclick="showCheckboxes(2)">
                                            <select class="form-select form-control form-control-lg">
                                                <option>@lang('lang.show_hide_columns')</option>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>
                                        <div id="checkboxes2">
                                            {{-- +++++++++++++++++ checkbox11 : date +++++++++++++++++ --}}
                                            <label for="col11_id">
                                                <input type="checkbox" id="col11_id" name="col11" checked="checked" />
                                                <span>@lang('lang.date')</span> &nbsp;
                                            </label>
                                            {{-- +++++++++++++++++ checkbox12 : customer_name +++++++++++++++++ --}}
                                            <label for="col12_id">
                                                <input type="checkbox" id="col12_id" name="col12" checked="checked" />
                                                <span>@lang('lang.customer_name')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox13 : sale_ref +++++++++++++++++ --}}
                                            <label for="col13_id">
                                                <input type="checkbox" id="col13_id" name="col13" checked="checked" />
                                                <span>@lang('lang.sale_ref')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox14 : مدفوعة +++++++++++++++++ --}}
                                            <label for="col14_id">
                                                <input type="checkbox" id="col14_id" name="col14" checked="checked" />
                                                <span>مدفوعة</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox15 : amount +++++++++++++++++ --}}
                                            <label for="col15_id">
                                                <input type="checkbox" id="col15_id" name="col15" checked="checked" />
                                                <span>@lang('lang.amount')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox16 : created_by +++++++++++++++++ --}}
                                            <label for="col16_id">
                                                <input type="checkbox" id="col16_id" name="col16" checked="checked" />
                                                <span>@lang('lang.created_by')</span>
                                            </label>
                                        </div>
                                    </div>
                                </div> <br/>
                                <table  id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="col11">التاريخ</th>
                                            <th class="col12">اسم العميل</th>
                                            <th class="col13">مرجع البيع</th>
                                            <th class="col14">مدفوعة</th>
                                            <th class="col15">المبلغ</th>
                                            <th class="col16">انشئ بواسطة</th>
                                            {{-- <th>@lang('lang.action')</th>  --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer_transactions_sell_lines as $key => $transaction_payment)
                                            <tr>
                                                <td class="col11">{{ $transaction_payment->created_at->format('Y-m-d') }}</td>
                                                <td class="col12">{{ $transaction_payment->customer->name }}</td>
                                                <td class="col13">{{ $transaction_payment->invoice_no }}</td>
                                                <td class="col14">{{ $transaction_payment->method }}</td>
                                                {{-- Get All_Payments of transaction Then Get sum of "payment amounts" --}}
                                                <td class="col15">{{ number_format($transaction_payment->transaction_payments->sum('amount'), 2) }}
                                                </td>
                                                {{-- Created_by --}}
                                                <td class="col16">{{ !empty($transaction_payment->transaction_payments->first()) ? $transaction_payment->transaction_payments->first()->created_by_user->name ?? '' : '' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        {{-- {{-- <div class="table-responsive"> --}}

                        <div class="view_modal no-print">

                        </div>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <section class="invoice print_section print-only" id="receipt_section"> </section>

    <!-- End Contentbar -->
@endsection
@section('javascript')
    <script>
        $(document).on('click', '.print-invoice', function() {
            $.ajax({
                method: 'get',
                url: $(this).data('href'),
                data: {},
                success: function(result) {
                    if (result.success) {
                        pos_print(result.html_content);
                    }
                },
            });
        });

        function pos_print(receipt) {
            $("#receipt_section").html(receipt);
            const sectionToPrint = document.getElementById('receipt_section');
            __print_receipt(sectionToPrint);
        }

        function __print_receipt(section = null) {
            setTimeout(function() {
                section.style.display = 'block';
                window.print();
                section.style.display = 'none';

            }, 1000);
        }
    </script>
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
        function showCheckboxes(num)
        {
            var checkboxes = document.getElementById("checkboxes");
            var checkboxes2 = document.getElementById("checkboxes2");
            if( num == 1 )
            {
                if (!expanded) {
                    checkboxes.style.display = "block";
                    expanded = true;
                } else {
                    checkboxes.style.display = "none";
                    expanded = false;
                }
            }
            else if( num == 2 )
            {
                if (!expanded) {
                    checkboxes2.style.display = "block";
                    expanded = true;
                } else {
                    checkboxes2.style.display = "none";
                    expanded = false;
                }
            }
        }
    </script>
@endsection

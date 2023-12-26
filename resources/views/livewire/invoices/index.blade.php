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
            background-color: #dadada;
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
            background-color: white
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

        .table-top-head {
            top: 105px !important;
        }

        .table-scroll-wrapper {
            width: fit-content;
        }

        @media(min-width:1900px) {
            .table-scroll-wrapper {
                width: 100%;
            }
        }



        @media(max-width:991px) {
            .table-top-head {
                top: 105px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 400px !important
            }
        }

        .wrapper1 {
            margin-top: 35px;
        }

        .input-wrapper {
            width: 100% !important;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 90px;
            }

            .input-wrapper {
                width: 60%
            }
        }
    </style>
    <div class="animate-in-page">


        <!-- Start Contentbar -->
        <div class="contentbar mb-0 pb-0 no-print">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div
                            class="card-header  d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                            <h5 class="card-title">@lang('lang.sells')</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="container-fluid">
                                        {{-- @include('customers.filters') --}}
                                    </div>
                                </div>
                            </div>
                            {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}

                            <div class="row ml-4">
                                {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                                <div class="col-md-3 col-lg-3" style="position: relative;z-index: 9;">
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
                                                <input type="checkbox" id="col1_id" name="col1"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.date_and_time')</span> &nbsp;
                                            </label>
                                            {{-- +++++++++++++++++ checkbox2 : reference +++++++++++++++++ --}}
                                            <label for="col2_id">
                                                <input type="checkbox" id="col2_id" name="col2"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.reference')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox3 : store +++++++++++++++++ --}}
                                            <label for="col3_id">
                                                <input type="checkbox" id="col3_id" name="col3"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.store')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox4 : select_to_delete +++++++++++++++++ --}}
                                            <label for="col4_id">
                                                <input type="checkbox" id="col4_id" name="col4"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.select_to_delete')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox5 : customer +++++++++++++++++ --}}
                                            <label for="col5_id">
                                                <input type="checkbox" id="col5_id" name="col5"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.customer')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox6 : phone +++++++++++++++++ --}}
                                            <label for="col6_id">
                                                <input type="checkbox" id="col6_id" name="col6"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.phone')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox7 : sale_status +++++++++++++++++ --}}
                                            <label for="col7_id">
                                                <input type="checkbox" id="col7_id" name="col7"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.sale_status')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox8 : payment_status +++++++++++++++++ --}}
                                            <label for="col8_id">
                                                <input type="checkbox" id="col8_id" name="col8"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.payment_status')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox9 : payment_type +++++++++++++++++ --}}
                                            <label for="col9_id">
                                                <input type="checkbox" id="col9_id" name="col9"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.payment_type')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox10 : ref_number +++++++++++++++++ --}}
                                            <label for="col10_id">
                                                <input type="checkbox" id="col10_id" name="col10"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.ref_number')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox11 : received_currency +++++++++++++++++ --}}
                                            <label for="col11_id">
                                                <input type="checkbox" id="col11_id" name="col11"
                                                    class="checkbox_class2" checked="checked" />
                                                <span>@lang('lang.received_currency')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox12 : grand_total +++++++++++++++++ --}}
                                            <label for="col12_id">
                                                <input type="checkbox" id="col12_id" name="col12"
                                                    class="checkbox_class2" checked="checked" />
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

                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2 table-scroll-wrapper">
                                    <!-- content goes here -->
                                    <div style="min-width: 1800px;max-height: 90vh;overflow: auto;">
                                        {{-- ++++++++++++++++++ Table Columns ++++++++++++++++++ --}}
                                        <table id="datatable-buttons" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="col1">@lang('lang.date_and_time')</th>
                                                    <th class="col2">@lang('lang.reference')</th>
                                                    <th class="col3">@lang('lang.store')</th>
                                                    {{-- ///// check_all selectbox ///// --}}
                                                    <th class="col4">
                                                        @lang('lang.select_to_delete')
                                                        <input type="checkbox" name="select_all"
                                                            id="example-select-all" onclick="(CheckAll('box1',this))">
                                                    </th>
                                                    <th class="col5">@lang('lang.customer')</th>
                                                    <th class="col6">@lang('lang.phone')</th>
                                                    <th class="col7">@lang('lang.sale_status')</th>
                                                    <th class="col8">@lang('lang.payment_status')</th>
                                                    <th class="col9">@lang('lang.payment_type')</th>
                                                    <th class="col10">@lang('lang.ref_number')</th>
                                                    <th class="col11 currencies">@lang('lang.received_currency')</th>
                                                    <th class="col12 sum">@lang('lang.grand_total')</th>
                                                    <th class="col13 sum">@lang('lang.paid')</th>
                                                    <th class="col14 sum">@lang('lang.due_sale_list')</th>
                                                    <th class="col15">@lang('lang.due_date')</th>
                                                    <th class="col16">@lang('lang.payment_date')</th>
                                                    <th class="col17">@lang('lang.cashier_man')</th>
                                                    <th class="col18">@lang('lang.commission')</th>
                                                    <th class="col19">@lang('lang.products')</th>
                                                    <th class="col20">@lang('lang.sale_note')</th>
                                                    <th class="col21">@lang('lang.receipts')</th>
                                                    <th class="col22 notexport">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                @endphp
                                                @foreach ($sell_lines as $index => $line)
                                                    <tr>
                                                        <td class="col1">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.date_and_time')">

                                                                {{ $line->transaction_date ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td class="col2">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.reference')">
                                                                {{ $line->invoice_no ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td class="col3">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.store')">
                                                                {{ $line->store->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        {{-- ++++++++ checkbox +++++++++ --}}
                                                        <td class="col4">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.select_to_delete')">
                                                                <input type="checkbox" name="invoice_selected_delete"
                                                                    class="box1" value="{{ $line->id }}" />
                                                            </span>
                                                        </td>
                                                        <td class="col5">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.customer')">
                                                                {{ $line->customer->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td class="col6">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.phone')">
                                                                {{ $line->customer->phone ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td class="col7">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.sale_status')">
                                                                <span
                                                                    class="badge badge-success">{{ $line->status ?? '' }}</span>
                                                            </span>
                                                        </td>
                                                        <td class="col8">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.payment_status')">
                                                                {{ $line->payment_status }}
                                                            </span>
                                                        </td>
                                                        <td class="col9">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.payment_type')">
                                                                @foreach ($line->transaction_payments as $payment)
                                                                    {{ __('lang.' . $payment->method) }}<br>
                                                                @endforeach
                                                            </span>
                                                        </td>
                                                        <td class="col10">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.ref_number')">
                                                                @foreach ($line->transaction_payments as $payment)
                                                                    {{ $payment->ref_no ?? '' }}<br>
                                                                @endforeach
                                                            </span>
                                                        </td>
                                                        <td class="col11">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.received_currency')">
                                                                @foreach ($line->transaction_payments as $payment)
                                                                    {{ $payment->received_currency_relation->symbol ?? '' }}<br>
                                                                @endforeach
                                                            </span>
                                                        </td>
                                                        <td class="col12">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.grand_total')">

                                                                {{ number_format($line->final_total, 2) }}
                                                            </span>
                                                        </td>
                                                        <td class="col13">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.paid')">
                                                                {{ $line->transaction_payments->sum('amount') }}
                                                            </span>
                                                        </td>
                                                        <td class="col14">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.due_sale_list')">
                                                                {{ $line->final_total - $line->transaction_payments->sum('amount') }}
                                                            </span>
                                                        </td>
                                                        <td class="col15">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.due_date')">
                                                                {{ $line->transaction_payments->last()->due_date ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td class="col16">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.payment_date')">
                                                                {{ $line->transaction_payments->last()->paid_on ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td class="col17">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.cashier_man')">
                                                                {{ $line->created_by_user->name }}
                                                            </span>
                                                        </td>
                                                        <td class="col18">
                                                        </td>
                                                        <td class="col19">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.products')">

                                                                @foreach ($line->transaction_sell_lines as $sell_line)
                                                                    @if (!empty($sell_line->product))
                                                                        {{ $sell_line->product->name ?? ' ' }} -
                                                                        {{ $sell_line->product->sku ?? ' ' }}<br>
                                                                    @endif
                                                                @endforeach
                                                            </span>
                                                        </td>
                                                        <td class="col20">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.sale_note')">
                                                                @foreach ($line->transaction_payments as $payment)
                                                                    {{ $payment->received_currency_relation->payment_note ?? '' }}<br>
                                                                @endforeach
                                                            </span>
                                                        </td>
                                                        <td class="col21">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.receipts')">

                                                                @if (count($line->receipts) > 0)
                                                                    <a data-href=" {{ route('show_receipt', $line->id) }}"
                                                                        data-container=".view_modal"
                                                                        class="btn btn-default btn-modal">
                                                                        {{ __('lang.view') }}
                                                                    </a>
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td class="col22">
                                                            <button type="button"
                                                                style="font-size: 12px;font-weight: 600"
                                                                class="btn btn-default btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                @lang('lang.action')
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                user="menu">
                                                                <li>
                                                                    <a data-href="{{ route('print_invoice', $line->id) }}"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif print-invoice"><i
                                                                            class="dripicons-print"></i>
                                                                        {{ __('lang.generate_invoice') }}</a>
                                                                </li>

                                                                <li>
                                                                    <a data-href=" {{ route('pos.show', $line->id) }}"
                                                                        data-container=".view_modal"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"><i
                                                                            class="fa fa-eye"></i>{{ __('lang.view') }}
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="{{ route('sell.return', $line->id) }}"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                            class="fa fa-undo"></i>@lang('lang.return')
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a data-href="{{ route('show_payment', $line->id) }}"
                                                                        data-container=".view_modal"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"><i
                                                                            class="fa fa-money"></i>
                                                                        {{ __('lang.view_payments') }}
                                                                    </a>
                                                                </li>

                                                                {{-- +++++++++ edit button +++++++++++ --}}
                                                                <li>
                                                                    <a href="{{ route('invoices.edit', $line->id) }}"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                                        <i class="dripicons-document-edit"></i>
                                                                        {{ __('lang.edit') }}
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a data-href=" {{ route('upload_receipt', $line->id) }}"
                                                                        data-container=".view_modal"
                                                                        data-dismiss="modal"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"><i
                                                                            class="fa fa-plus"></i>{{ __('lang.upload_receipt') }}
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a data-href="{{ route('pos.destroy', $line->id) }}"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif text-red delete_item"><i
                                                                            class="fa fa-trash"></i>
                                                                        {{ __('lang.delete') }}
                                                                    </a>
                                                                </li>
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
                </div>
            </div>

            <!-- End col -->

            <!-- End row -->

            {{-- ++++++++++++++++++++++++++++++++++ "delete_all" Modal Form ++++++++++++++++++++++++++++++++++ --}}
            <!-- حذف مجموعة صفوف -->
            <div class="modal fade" id="delete_all" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    </div>
    <!-- End Contentbar -->
    <div class="view_modal no-print"></div>
    <section class="invoice print_section print-only" id="receipt_section"> </section>

    @push('javascripts')
        <script>
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

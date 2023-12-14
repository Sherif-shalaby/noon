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
                                </div>
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
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
                                            <input type="checkbox" id="col1_id" name="col1" class="checkbox_class2" checked="checked" />
                                            <span>@lang('lang.date_and_time')</span> &nbsp;
                                        </label>
                                        {{-- +++++++++++++++++ checkbox2 : reference +++++++++++++++++ --}}
                                        <label for="col2_id">
                                            <input type="checkbox" id="col2_id" name="col2" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.reference')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox3 : store +++++++++++++++++ --}}
                                        <label for="col3_id">
                                            <input type="checkbox" id="col3_id" name="col3" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.store')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox4 : customer +++++++++++++++++ --}}
                                        <label for="col4_id">
                                            <input type="checkbox" id="col4_id" name="col4" class="checkbox_class2" checked="checked" />
                                            <span>@lang('lang.customer')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox5 : phone +++++++++++++++++ --}}
                                        <label for="col5_id">
                                            <input type="checkbox" id="col5_id" name="col5"  class="checkbox_class2" checked="checked" />
                                            <span>@lang('lang.phone')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox6 : sale_status +++++++++++++++++ --}}
                                        <label for="col6_id">
                                            <input type="checkbox" id="col6_id" name="col6" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.sale_status')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox7 : payment_status +++++++++++++++++ --}}
                                        <label for="col7_id">
                                            <input type="checkbox" id="col7_id" name="col7" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.payment_status')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox8 : payment_type +++++++++++++++++ --}}
                                        <label for="col8_id">
                                            <input type="checkbox" id="col8_id" name="col8" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.payment_type')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox9 : ref_number +++++++++++++++++ --}}
                                        <label for="col9_id">
                                            <input type="checkbox" id="col9_id" name="col9"  class="checkbox_class2" checked="checked" />
                                            <span>@lang('lang.ref_number')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox10 : received_currency +++++++++++++++++ --}}
                                        <label for="col10_id">
                                            <input type="checkbox" id="col10_id" name="col10" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.received_currency')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox11 : grand_total +++++++++++++++++ --}}
                                        <label for="col11_id">
                                            <input type="checkbox" id="col11_id" name="col11" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.grand_total')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox12 : paid +++++++++++++++++ --}}
                                        <label for="col12_id">
                                            <input type="checkbox" id="col12_id" name="col12" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.paid')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox13 : due_sale_list +++++++++++++++++ --}}
                                        <label for="col13_id">
                                            <input type="checkbox" id="col13_id" name="col13" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.due_sale_list')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox14 : due_date +++++++++++++++++ --}}
                                        <label for="col14_id">
                                            <input type="checkbox" id="col14_id" name="col14" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.due_date')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox15 : payment_date +++++++++++++++++ --}}
                                        <label for="col15_id">
                                            <input type="checkbox" id="col15_id" name="col15" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.payment_date')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox16 : cashier_man +++++++++++++++++ --}}
                                        <label for="col16_id">
                                            <input type="checkbox" id="col16_id" name="col16" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.cashier_man')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox17 : commission +++++++++++++++++ --}}
                                        <label for="col17_id">
                                            <input type="checkbox" id="col17_id" name="col17" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.commission')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox18 : products +++++++++++++++++ --}}
                                        <label for="col18_id">
                                            <input type="checkbox" id="col18_id" name="col18" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.products')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox19 : sale_note +++++++++++++++++ --}}
                                        <label for="col19_id">
                                            <input type="checkbox" id="col19_id" name="col19" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.sale_note')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox20 : receipts +++++++++++++++++ --}}
                                        <label for="col20_id">
                                            <input type="checkbox" id="col20_id" name="col20" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.receipts')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox21 : action +++++++++++++++++ --}}
                                        <label for="col21_id">
                                            <input type="checkbox" id="col21_id" name="col21" class="checkbox_class2"  checked="checked" />
                                            <span>@lang('lang.action')</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br/><br/>
                            {{-- ++++++++++++++++++ Table Columns ++++++++++++++++++ --}}
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="col1">@lang('lang.date_and_time')</th>
                                    <th class="col2">@lang('lang.reference')</th>
                                    <th class="col3">@lang('lang.store')</th>
                                    <th class="col4">@lang('lang.customer')</th>
                                    <th class="col5">@lang('lang.phone')</th>
                                    <th class="col6">@lang('lang.sale_status')</th>
                                    <th class="col7">@lang('lang.payment_status')</th>
                                    <th class="col8">@lang('lang.payment_type')</th>
                                    <th class="col9">@lang('lang.ref_number')</th>
                                    <th class="col10 currencies">@lang('lang.received_currency')</th>
                                    <th class="col11 sum">@lang('lang.grand_total')</th>
                                    <th class="col12 sum">@lang('lang.paid')</th>
                                    <th class="col13 sum">@lang('lang.due_sale_list')</th>
                                    <th class="col14">@lang('lang.due_date')</th>
                                    <th class="col15">@lang('lang.payment_date')</th>
                                    <th class="col16">@lang('lang.cashier_man')</th>
                                    <th class="col17">@lang('lang.commission')</th>
                                    <th class="col18">@lang('lang.products')</th>
                                    <th class="col19">@lang('lang.sale_note')</th>
                                    <th class="col20">@lang('lang.receipts')</th>
                                    <th class="col21 notexport">@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                @endphp
                                @foreach($sell_lines as $index => $line)
                                    <tr>
                                        <td class="col1">
                                            {{$line->transaction_date ?? ''}}
                                        </td>
                                        <td class="col2">
                                            {{$line->invoice_no ?? '' }}
                                        </td>
                                        <td class="col3">
                                            {{$line->store->name ?? '' }}
                                        </td>
                                        <td class="col4">
                                            {{$line->customer->name ?? '' }}
                                        </td>
                                        <td class="col5">
                                            {{$line->customer->phone ?? '' }}
                                        </td>
                                        <td class="col6">
                                            <span class="badge badge-success">{{$line->status ?? '' }}</span>
                                        </td>
                                        <td class="col7">{{$line->payment_status}}</td>
                                        <td class="col8">
                                            @foreach($line->transaction_payments as $payment)
                                                {{__('lang.'.$payment->method)}}<br>
                                            @endforeach
                                        </td>
                                        <td class="col9">
                                            @foreach($line->transaction_payments as $payment)
                                                {{$payment->ref_no ?? ''}}<br>
                                            @endforeach
                                        </td>
                                        <td class="col10">
                                            @foreach($line->transaction_payments as $payment)
                                                {{$payment->received_currency_relation->symbol ?? ''}}<br>
                                            @endforeach
                                        </td>
                                        <td class="col11">
                                            {{number_format($line->final_total,2)}}
                                        </td>
                                        <td class="col12">
                                            {{$line->transaction_payments->sum('amount')}}
                                        </td>
                                        <td class="col13">
                                            {{$line->final_total - $line->transaction_payments->sum('amount')}}
                                        </td>
                                        <td class="col14">
                                            {{$line->transaction_payments->last()->due_date ?? ''}}
                                        </td>
                                        <td class="col15">
                                            {{$line->transaction_payments->last()->paid_on ?? ''}}
                                        </td>
                                        <td class="col16">
                                            {{$line->created_by_user->name}}
                                        </td>
                                        <td class="col17">
                                        </td>
                                        <td class="col18">
                                            @foreach($line->transaction_sell_lines as $sell_line)
                                                @if(!empty($sell_line->product))
                                                    {{$sell_line->product->name ?? ' ' }} -
                                                    {{ $sell_line->product->sku ?? ' ' }}<br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="col19">
                                            @foreach($line->transaction_payments as $payment)
                                                {{$payment->received_currency_relation->payment_note ?? ''}}<br>
                                            @endforeach
                                        </td>
                                        <td class="col20">
                                            @if(count($line->receipts) > 0)
                                                <a data-href=" {{route('show_receipt', $line->id)}}"
                                                   data-container=".view_modal"
                                                   class="btn btn-default btn-modal"> {{__('lang.view')}}
                                                </a>
                                            @endif
                                        </td>
                                        <td class="col21">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                                <li>
                                                    <a data-href="{{route('print_invoice', $line->id)}}"
                                                       class="btn print-invoice"><i class="dripicons-print"></i>
                                                        {{ __('lang.generate_invoice') }}</a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href=" {{route('pos.show', $line->id)}}" data-container=".view_modal"
                                                       class="btn btn-modal"><i class="fa fa-eye"></i>{{ __('lang.view') }}
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{route('sell.return',$line->id)}}" class="btn"><i class="fa fa-undo"></i>@lang('lang.return') </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{ route('show_payment', $line->id) }}"
                                                       data-container=".view_modal" class="btn btn-modal"><i class="fa fa-money"></i>
                                                        {{ __('lang.view_payments') }}
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{ route('invoices.edit', $line->id) }}" class="btn"><i
                                                            class="dripicons-document-edit"></i> {{ __('lang.edit') }}</a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href=" {{route('upload_receipt', $line->id)}}" data-container=".view_modal" data-dismiss="modal"
                                                       class="btn btn-modal"><i class="fa fa-plus"></i>{{ __('lang.upload_receipt') }}
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{ route('pos.destroy', $line->id) }}"
                                                       class="btn text-red delete_item"><i class="fa fa-trash"></i>
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
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
    <div class="view_modal no-print" ></div>
    <section class="invoice print_section print-only" id="receipt_section"> </section>

@push('javascripts')
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('printInvoice', function (htmlContent) {
                // Set the generated HTML content
                $("#receipt_section").html(htmlContent);
                // Trigger the print action
                window.print("#receipt_section");
            });
        });
        $(document).on("click", ".print-invoice", function () {
            // $(".modal").modal("hide");
            $.ajax({
                method: "get",
                url: $(this).data("href"),
                data: {},
                success: function (result) {
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

        $(".checkbox_class2").click(function(){
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

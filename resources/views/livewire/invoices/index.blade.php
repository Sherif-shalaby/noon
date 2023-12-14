    <style>
        .table-scroll-wrapper {
            width: fit-content;
        }

        @media(min-width:1900px) {
            .table-scroll-wrapper {
                width: 100%;
            }
        }
    </style>
    <!-- Start Contentbar -->
    <div class="contentbar mb-0 py-0 no-print">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card mb-0">
                    <div class="card-header">
                        <h5 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            @lang('lang.sells')</h5>
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
                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif"
                                style="margin-top: 45px">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2 table-scroll-wrapper">

                                    <div style="min-width: 1800px;max-height: 90vh;overflow: auto">

                                        <!-- content goes here -->
                                        <table id="datatable-buttons"
                                            class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>@lang('lang.date_and_time')</th>
                                                    <th>@lang('lang.reference')</th>
                                                    <th>@lang('lang.store')</th>
                                                    <th>@lang('lang.customer')</th>
                                                    <th>@lang('lang.phone')</th>
                                                    <th>@lang('lang.sale_status')</th>
                                                    <th>@lang('lang.payment_status')</th>
                                                    <th>@lang('lang.payment_type')</th>
                                                    <th>@lang('lang.ref_number')</th>
                                                    <th class="currencies">@lang('lang.received_currency')</th>
                                                    <th class="sum">@lang('lang.grand_total')</th>
                                                    <th class="sum">@lang('lang.paid')</th>
                                                    <th class="sum">@lang('lang.due_sale_list')</th>
                                                    <th>@lang('lang.due_date')</th>
                                                    <th>@lang('lang.payment_date')</th>
                                                    <th>@lang('lang.cashier_man')</th>
                                                    <th>@lang('lang.commission')</th>
                                                    <th>@lang('lang.products')</th>
                                                    <th>@lang('lang.sale_note')</th>
                                                    <th>@lang('lang.receipts')</th>
                                                    <th class="notexport">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sell_lines as $index => $line)
                                                    <tr>
                                                        <td>
                                                            <span data-tooltip="@lang('lang.date_and_time')"
                                                                class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ $line->transaction_date ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span data-tooltip="@lang('lang.reference')"
                                                                class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ $line->invoice_no ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span data-tooltip="@lang('lang.store')"
                                                                class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                style="font-size: 12px;font-weight: 600">

                                                                {{ $line->store->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span data-tooltip="@lang('lang.customer')"
                                                                class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ $line->customer->name ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span data-tooltip="@lang('lang.phone')"
                                                                class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ $line->customer->phone ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span data-tooltip="@lang('lang.sale_status')"
                                                                class="custom-tooltip
                                                            badge badge-success d-flex justify-content-center align-items-center text-center"
                                                                style="font-size: 12px;font-weight: 600">{{ $line->status ?? '' }}</span>
                                                        </td>
                                                        <td>
                                                            <span data-tooltip="@lang('lang.payment_status')"
                                                                class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ $line->payment_status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @foreach ($line->transaction_payments as $payment)
                                                                <span data-tooltip="@lang('lang.payment_type')"
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                    style="font-size: 12px;font-weight: 600">
                                                                    {{ __('lang.' . $payment->method) }}<br>
                                                                </span>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ($line->transaction_payments as $payment)
                                                                <span data-tooltip="@lang('lang.ref_number')"
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                    style="font-size: 12px;font-weight: 600">
                                                                    {{ $payment->ref_no ?? '' }}<br>
                                                                </span>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ($line->transaction_payments as $payment)
                                                                <span data-tooltip="@lang('lang.received_currency')"
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                    style="font-size: 12px;font-weight: 600">
                                                                    {{ $payment->received_currency_relation->symbol ?? '' }}<br>
                                                                </span>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <span data-tooltip="@lang('lang.grand_total')"
                                                                class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ number_format($line->final_total, 2) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span data-tooltip="@lang('lang.paid')"
                                                                class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ $line->transaction_payments->sum('amount') }}

                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span data-tooltip="@lang('lang.due_sale_list')"
                                                                class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ $line->final_total - $line->transaction_payments->sum('amount') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span data-tooltip="@lang('lang.due_date')"
                                                                class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ $line->transaction_payments->last()->due_date ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span data-tooltip="@lang('lang.payment_date')"
                                                                class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ $line->transaction_payments->last()->paid_on ?? '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span data-tooltip="@lang('lang.cashier_man')"
                                                                class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                style="font-size: 12px;font-weight: 600">
                                                                {{ $line->created_by_user->name }}
                                                            </span>
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            @foreach ($line->transaction_sell_lines as $sell_line)
                                                                @if (!empty($sell_line->product))
                                                                    <span data-tooltip="@lang('lang.products')"
                                                                        class="custom-tooltip d-flex justify-content-center align-items-center text-center mb-2"
                                                                        style="font-size: 10px;font-weight: 600">
                                                                        {{ $sell_line->product->name ?? ' ' }} -
                                                                        {{ $sell_line->product->sku ?? ' ' }}<br>
                                                                    </span>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ($line->transaction_payments as $payment)
                                                                <span data-tooltip="@lang('lang.sale_note')"
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                    style="font-size: 12px;font-weight: 600">
                                                                    {{ $payment->received_currency_relation->payment_note ?? '' }}<br>
                                                                </span>
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @if (count($line->receipts) > 0)
                                                                <span data-tooltip="@lang('lang.receipts')"
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center text-center"
                                                                    style="font-size: 12px;font-weight: 600">>
                                                                    <a data-href=" {{ route('show_receipt', $line->id) }}"
                                                                        data-container=".view_modal"
                                                                        class="btn btn-default btn-modal">
                                                                        {{ __('lang.view') }}
                                                                    </a>
                                                                </span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-default btn-sm dropdown-toggle d-flex justify-content-center align-items-center text-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                @lang('lang.action')
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                user="menu">

                                                                <li>
                                                                    <a data-href="{{ route('print_invoice', $line->id) }}"
                                                                        class="btn print-invoice drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                                                        <i class="dripicons-print"></i>
                                                                        {{ __('lang.generate_invoice') }}
                                                                    </a>
                                                                </li>


                                                                <li>
                                                                    <a data-href=" {{ route('pos.show', $line->id) }}"
                                                                        data-container=".view_modal"
                                                                        class="btn btn-modal drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
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
                                                                        class="btn btn-modal drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                            class="fa fa-money"></i>
                                                                        {{ __('lang.view_payments') }}
                                                                    </a>
                                                                </li>


                                                                <li>
                                                                    <a href="{{ route('invoices.edit', $line->id) }}"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                            class="dripicons-document-edit"></i>
                                                                        {{ __('lang.edit') }}</a>
                                                                </li>


                                                                <li>
                                                                    <a data-href=" {{ route('upload_receipt', $line->id) }}"
                                                                        data-container=".view_modal"
                                                                        data-dismiss="modal"
                                                                        class="btn btn-modal drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                            class="fa fa-plus"></i>{{ __('lang.upload_receipt') }}
                                                                    </a>
                                                                </li>


                                                                <li>
                                                                    <a data-href="{{ route('pos.destroy', $line->id) }}"
                                                                        {{--                                                       data-check_password="{{ action('UserController@checkPassword', Auth::user()->id) }} " --}}
                                                                        class="btn text-red delete_item drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
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
        </div>
        <!-- End row -->
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
    @endpush

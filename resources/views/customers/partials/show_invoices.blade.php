<!-- Modal -->
<div class="modal fade show_invoice_modal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit">@lang('lang.show_invoices')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered table-button-wrapper">
                        <thead>
                            <tr>
                                <th>@lang('lang.date_and_time')</th>
                                <th>@lang('lang.reference')</th>
                                <th>@lang('lang.store')</th>
                                <th>@lang('lang.customer')</th>
                                <th>@lang('lang.phone')</th>
                                <th>@lang('lang.cashier_man')</th>
                                <th>@lang('lang.products')</th>
                                <th>@lang('lang.receipts')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $index => $line)
                                {{--                            @dd($Line) --}}
                                <tr>
                                    <td>
                                        {{ $line->transaction_date ?? '' }}
                                    </td>
                                    <td>
                                        {{ $line->invoice_no ?? '' }}
                                    </td>
                                    <td>
                                        {{ $line->store->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $line->customer->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $line->customer->phone ?? '' }}
                                    </td>
                                    <td>
                                        {{ $line->created_by_user->name }}
                                    </td>
                                    <td>
                                        @foreach ($line->transaction_sell_lines as $sell_line)
                                            @if (!empty($sell_line->product))
                                                {{ $sell_line->product->name ?? ' ' }} -
                                                {{ $sell_line->product->sku ?? ' ' }}<br>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if (count($line->receipts) > 0)
                                            <a data-href=" {{ route('show_receipt', $line->id) }}"
                                                data-container=".view_modal" data-dismiss="modal"
                                                class="btn btn-default btn-modal"> {{ __('lang.view') }}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @lang('lang.action')
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                            user="menu">
                                            <li>
                                                <a data-href=" {{ route('pos.show', $line->id) }}"
                                                    data-container=".view_modal" data-dismiss="modal"
                                                    class="btn btn-modal show-invoice"><i
                                                        class="fa fa-eye"></i>{{ __('lang.view') }}
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
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#datatable-buttons').DataTable({

        "order": [],
        // lengthChange: false,
        // responsive: true,
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
    });
</script>

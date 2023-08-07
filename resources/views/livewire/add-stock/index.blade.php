<section class="">
    <div class="col-md-22">
        <div class="card mt-3">
            <div class="card-header d-flex align-items-center">
                <h3 class="print-title">@lang('lang.stock')</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="add_stock_table">
                        <thead>

                        <tr>
                            <th>@lang('lang.po_ref_no')</th>
                            <th>@lang('lang.invoice_no')</th>
                            <th>@lang('lang.date_and_time')</th>
                            <th>@lang('lang.invoice_date')</th>
                            <th>@lang('lang.supplier')</th>
                            <th>@lang('lang.created_by')</th>
                            <th class="currencies">@lang('lang.paying_currency')</th>
                            <th class="sum">@lang('lang.value')</th>
                            <th class="sum">@lang('lang.paid_amount')</th>
                            <th class="sum">@lang('lang.pending_amount')</th>
                            <th>@lang('lang.due_date')</th>
                            <th>@lang('lang.notes')</th>
                            <th class="notexport">@lang('lang.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stocks as $index => $stock)
                            <tr>
                                <td>{{$stock->po_no ?? ''}}</td>
                                <td>{{$stock->invoice_no ?? ''}}</td>
                                <td>{{$stock->created_at }}</td>
                                <td>{{$stock->transaction_date }}</td>
                                <td>{{$stock->supplier->name}}</td>
                                <td>{{$stock->created_by()->first()->name}}</td>
                                <td>{{$stock->paying_currency()->first()->currency}}</td>
                                <td>{{$stock->final_total}}</td>
                                <td>{{$stock->transaction_payments->sum('amount')}}</td>
                                <td>{{$stock->final_total - $stock->transaction_payments->sum('amount')}}</td>
                                <td>{{$stock->due_date ?? ''}}</td>
                                <td>{{$stock->notes ?? ''}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <th class="table_totals" style="text-align: right">@lang('lang.total')</th>
                            <td></td>
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

</section>

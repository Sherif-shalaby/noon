 <!-- draft transaction modal -->
    <div id="draftTransaction" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
         class="modal text-left">

        <div class="modal-dialog" role="document" style="max-width: 50%" wire:ignore>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('lang.draft_transactions')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="draft_table" class="table">
                                <thead>
                                <tr>
                                    <th>@lang('lang.date')</th>
                                    <th>@lang('lang.invoice_no')</th>
                                    <th>@lang('lang.value')</th>
                                    <th>@lang('lang.value') $</th>
                                    <th>@lang('lang.customer_type')</th>
                                    <th>@lang('lang.customer_name')</th>
                                    <th>@lang('lang.phone')</th>
                                    {{-- <th>@lang('lang.payment_type')</th> --}}
                                    <th>@lang('lang.status')</th>
                                    <th>@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($draft_transactions))
                                    @foreach($draft_transactions as $key => $transaction)
                                        <tr>
                                            <td>
                                                {{\Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d')}}
                                            </td>
                                            <td>
                                                {{$transaction->invoice_no}}
                                            </td>
                                            <td>
                                                {{$transaction->final_total}}
                                            </td>
                                            <td>
                                                {{$transaction->dollar_final_total}}
                                            </td>
                                            <td>
                                                {{$transaction->customer->customer_type->name}}
                                            </td>
                                            <td>
                                                {{$transaction->customer->name}}
                                            </td>
                                            <td>
                                                {{$transaction->customer->phone}}
                                            </td>
                                            {{-- <td>
                                                {{!empty($transaction->transaction_payments[0]) ?$transaction->transaction_payments[0]->method : ''}}
                                            </td> --}}
                                            <td>
                                                <span class="badge text-white" style="background-color: #6e81dc !important;">{{__('lang.'.$transaction->status)}}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a data-href="{{route('print_invoice', $transaction->id)}}"
                                                       class="btn btn-danger text-white print-invoice rounded-3">
                                                        <i title=" {{__('lang.print')}}" data-toggle="tooltip" class="dripicons-print"></i>
                                                    </a>
                                                    <a target="_blank" href="{{route('invoices.edit', $transaction->id)}}" class="btn btn-success draft_pay rounded-3"><i
                                                            title=" {{__('lang.edit') }}" data-toggle="tooltip"
                                                            class="dripicons-document-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">@lang('lang.close')</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>



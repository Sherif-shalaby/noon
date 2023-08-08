<section class="">
    <div class="col-md-22">
        <div class="card mt-3">
            <div class="card-header d-flex align-items-center">
                <h3 class="print-title">@lang('lang.stock')</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table dataTable">
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
                                <td>{{$stock->paying_currency()->first()->symbol}}</td>
                                <td>{{number_format($stock->final_total,2)}}</td>
                                <td>{{number_format($stock->transaction_payments->sum('amount'),2)}}</td>
                                <td>{{number_format($stock->final_total - $stock->transaction_payments->sum('amount'),2)}}</td>
                                <td>{{$stock->due_date ?? ''}}</td>
                                <td>{{$stock->notes ?? ''}}</td>
                                <td>
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        @lang('lang.action')
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                        <li>
                                            <a href="{{route('stocks.show', $stock->id)}}"
                                               class="btn"><i
                                                    class="fa fa-eye"></i>
                                                @lang('lang.view') </a>
                                        </li>
                                        <li class="divider"></li>
                                        @if ($stock->payment_status != 'paid')
                                       <li>
                                            <a data-href="{{route('stocks.add_payment',  $stock->id) }}"
                                               data-container=".view_modal" class="btn btn-modal"><i class="fa fa-money"></i>
                                                @lang('lang.pay') </a>
                                        </li>
                                        @endif
{{--                                        <li class="divider"></li>--}}

{{--                                        <li>--}}
{{--                                            <a href="{{route('employees.edit', $employee->id)}}"--}}
{{--                                               class="btn edit_employee"><i--}}
{{--                                                    class="fa fa-pencil-square-o"></i>--}}
{{--                                                @lang('lang.edit')</a>--}}
{{--                                        </li>--}}
{{--                                        <li class="divider"></li>--}}
{{--                                        <li>--}}
{{--                                            <a data-href="{{route('employees.destroy', $employee->id)}}"--}}
{{--                                               --}}{{--                                                       data-check_password="{{action('UserController@checkPassword', Auth::user()->id) }}"--}}
{{--                                               class="btn delete_item text-red delete_item"><i--}}
{{--                                                    class="fa fa-trash"></i>--}}
{{--                                                @lang('lang.delete')</a>--}}
{{--                                        </li>--}}
                                    </ul>
                                </td>

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
<div class="view_modal no-print" ></div>

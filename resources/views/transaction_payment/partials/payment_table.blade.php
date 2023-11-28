<div class="row text-center">
    <div class="col-md-12">
        <h5>@lang('lang.payment_details')</h5>
    </div>

</div>
<div class="col-md-12">
    <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
        <table class="table table-bordered table-hover table-striped table-condensed">
            <thead>
                <tr>
                    <th>@lang('lang.amount')</th>
                    <th>@lang('lang.payment_date')</th>
                    <th>@lang('lang.payment_type')</th>
                    {{--                @if (!empty($show_action)) --}}
                    {{--                    <th>@lang('lang.action')</th> --}}
                    {{--                @endif --}}
                </tr>
            </thead>

            @foreach ($payments as $payment)
                <tr>
                    <td style="font-size: 12px;font-weight: 600">{{ $payment->amount }}</td>
                    <td style="font-size: 12px;font-weight: 600">{{ @format_date($payment->paid_on) }}</td>
                    <td style="font-size: 12px;font-weight: 600">{{ $payment_type_array[$payment->method] }}</td>

                    {{--                    @if (!empty($show_action)) --}}
                    {{--                        <td> --}}
                    {{--                            <div class="btn-group"> --}}
                    {{--                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" --}}
                    {{--                                        aria-haspopup="true" aria-expanded="false">@lang('lang.action') --}}
                    {{--                                    <span class="caret"></span> --}}
                    {{--                                    <span class="sr-only">Toggle Dropdown</span> --}}
                    {{--                                </button> --}}
                    {{--                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu"> --}}
                    {{--                                    @can('sale.pay.create_and_edit') --}}
                    {{--                                        <li> --}}
                    {{--                                            <a data-href="{{action('TransactionPaymentController@edit', $payment->id)}}" --}}
                    {{--                                               data-container=".view_modal" class="btn btn-modal"><i --}}
                    {{--                                                    class="dripicons-document-edit"></i> @lang('lang.edit')</a> --}}
                    {{--                                        </li> --}}
                    {{--                                    @endcan --}}
                    {{--                                    @can('sale.pay.delete') --}}
                    {{--                                        <li> --}}
                    {{--                                            <a data-href="{{action('TransactionPaymentController@destroy', $payment->id)}}" --}}
                    {{--                                               data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}" --}}
                    {{--                                               class="btn text-red delete_item"><i class="fa fa-trash"></i> --}}
                    {{--                                                @lang('lang.delete')</a> --}}
                    {{--                                        </li> --}}
                    {{--                                    @endcan --}}
                    {{--                                </ul> --}}
                    {{--                            </div> --}}
                    {{--                        </td> --}}
                    {{--                    @endif --}}
                </tr>
            @endforeach
        </table>
    </div>
</div>

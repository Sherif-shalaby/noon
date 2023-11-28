<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content  @if (app()->isLocale('ar')) text-end @else text-start @endif">
            <div
                class="modal-header d-flex justify-content-between py-1 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h4 class="modal-title">@lang('lang.sale')</h4>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <h6 class="d-flex flex-row-reverse">
                                <span class="mx-1">
                                    @lang('lang.invoice_no')
                                </span> :
                                <span class="mx-1">
                                    {{ $sell_line->invoice_no }} @if (!empty($sell_line->return_parent))
                                        <a data-href="{{ action('SellReturnController@show', $sell_line->id) }}"
                                            data-container=".view_modal" class="btn btn-modal"
                                            style="color: #007bff;">R</a>
                                    @endif
                                </span>
                            </h6>
                        </div>
                        <div class="col-md-12">
                            <h6>
                                <span class="mx-1">@lang('lang.date')</span>:
                                <span class="mx-1">{{ @format_datetime($sell_line->transaction_date) }}</span>
                            </h6>
                        </div>
                        <div class="col-md-12">
                            <h6>
                                <span class="mx-1">@lang('lang.store')</span>:
                                <span class="mx-1">{{ $sell_line->store->name ?? '' }}</span>
                            </h6>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex flex-wrap">
                        <div class="col-md-6 d-flex flex-row-reverse">
                            {!! Form::label('supplier_name', __('lang.customer_name'), []) !!}:
                            <b>{{ $sell_line->customer->name ?? '' }}</b>
                        </div>
                        <div class="col-md-6 d-flex flex-row-reverse">
                            {!! Form::label('email', __('lang.email'), []) !!}: <b>{{ $sell_line->customer->email ?? '' }}</b>
                        </div>
                        <div class="col-md-6 d-flex flex-row-reverse">
                            {!! Form::label('mobile_number', __('lang.mobile_number'), []) !!}:
                            <b>{{ $sell_line->customer->mobile_number ?? '' }}</b>
                        </div>
                        <div class="col-md-6 d-flex flex-row-reverse">
                            {!! Form::label('address', __('lang.address'), []) !!}: <b>{{ $sell_line->customer->address ?? '' }}</b>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <table
                            class="table @if (app()->isLocale('ar')) dir-rtl @endif table-hover table-bordered table-striped table-condensed"
                            id="product_sale_table">
                            <thead class="bg-success" style="color: white">
                                <tr>
                                    <th style="width: 25%" class="col-sm-8">@lang('lang.image')</th>
                                    <th style="width: 25%" class="col-sm-8">@lang('lang.products')</th>
                                    <th style="width: 25%" class="col-sm-4">@lang('lang.sku')</th>
                                    <th style="width: 25%" class="col-sm-4">@lang('lang.quantity')</th>
                                    <th style="width: 12%" class="col-sm-4">@lang('lang.sell_price')</th>
                                    <th style="width: 12%" class="col-sm-4">@lang('lang.discount')</th>
                                    <th style="width: 12%" class="col-sm-4">@lang('lang.sub_total')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sell_line->transaction_sell_lines as $line)
                                    <tr>

                                        <td><img src="{{ !empty($line->product) && !empty($line->product->image) ? '/uploads/products/' . $line->product->image : '/uploads/' . $settings['logo'] }}"
                                                style="width: 50px; height: 50px;"
                                                alt="{{ !empty($line->product) ? $line->product->name : '' }}"
                                                alt="photo" width="50" height="50"></td>

                                        <td style="font-size: 12px;font-weight: 600">
                                            {{ $line->product->name ?? '' }}
                                            @if (!empty($line->variation))
                                                @if ($line->variation->name != 'Default')
                                                    <b>{{ $line->variation->name }}</b>
                                                @endif
                                            @endif
                                            @if (empty($line->variation) && empty($line->product))
                                                <span class="text-red">@lang('lang.deleted')</span>
                                            @endif

                                        </td>
                                        <td style="font-size: 12px;font-weight: 600">
                                            @if (!empty($line->variation))
                                                @if ($line->variation->name != 'Default')
                                                    {{ $line->variation->sku }}
                                                @else
                                                    {{ $line->product->sku ?? '' }}
                                                @endif
                                            @else
                                                {{ $line->product->sku ?? '' }}
                                            @endif
                                        </td>
                                        <td style="font-size: 12px;font-weight: 600">
                                            @if (isset($line->quantity))
                                                {{ $line->quantity }}@else{{ 1 }}
                                            @endif
                                        </td>
                                        <td style="font-size: 12px;font-weight: 600">
                                            @if (isset($line->sell_price))
                                                {{ @num_format($line->sell_price) }}@else{{ 0 }}
                                            @endif
                                        </td>
                                        <td style="font-size: 12px;font-weight: 600">
                                            @if ($line->product_discount_type != 'surplus')
                                                @if (isset($line->product_discount_amount))
                                                    {{ @num_format($line->product_discount_amount) }}@else{{ 0 }}
                                                @endif
                                            @else
                                                {{ @num_format(0) }}
                                            @endif
                                        </td>
                                        <td style="font-size: 12px;font-weight: 600">
                                            {{ preg_match('/\.\d*[1-9]+/', (string) $line->sub_total) ? @num_format($line->sub_total) : @num_format($line->sub_total) }}
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
                                    <th style="text-align: right"> @lang('lang.total')</th>
                                    <td style="font-size: 12px;font-weight: 600">
                                        {{ $sell_line->transaction_sell_lines->where('product_discount_type', '!=', 'surplus')->sum('product_discount_amount') }}
                                    </td>
                                    <td style="font-size: 12px;font-weight: 600">
                                        {{ @num_format($sell_line->grand_total) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                @include('transaction_payment.partials.payment_table', [
                    'payments' => $sell_line->transaction_payments,
                ])


                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12 d-flex flex-row-reverse">
                            <h6 class="mx-1">@lang('lang.sale_note')</h6>:
                            <p>{{ $sell_line->sale_note }}</p>
                        </div>
                        <div class="col-md-12 d-flex flex-row-reverse">
                            <h6 class="mx-1">@lang('lang.staff_note')</h6>:
                            <p>{{ $sell_line->staff_note }}</p>
                        </div>
                        <div class="col-md-12 d-flex flex-row-reverse">
                            <h6 class="mx-1">@lang('lang.payment_note')</h6>:
                            @foreach ($sell_line->transaction_payments as $payment)
                                @if (isset($payment->payment_note))
                                    <p> - {{ $payment->payment_note }}</p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <table
                            class="table table-bordered  @if (app()->isLocale('ar')) dir-rtl @endif table-hover">
                            {{--                            <tr> --}}
                            {{--                                <th>@lang('lang.total_tax'):</th> --}}
                            {{--                                <td>{{ @num_format($sell_line->total_tax + $sell_line->total_item_tax) }}</td> --}}
                            {{--                            </tr> --}}
                            @if ($sell_line->transaction_sell_lines->where('product_discount_type', '!=', 'surplus')->sum('product_discount_amount') > 0)
                                <tr>
                                    <th>@lang('lang.discount')</th>
                                    <td style="font-size: 12px;font-weight: 600">
                                        {{ @num_format($sell_line->transaction_sell_lines->where('product_discount_type', '!=', 'surplus')->sum('product_discount_amount')) }}
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th>@lang('lang.order_discount'):</th>
                                <td style="font-size: 12px;font-weight: 600">
                                    {{ @num_format($sell_line->discount_amount) }}</td>
                            </tr>
                            @if (!empty($sell_line->rp_earned))
                                <tr>
                                    <th>@lang('lang.point_earned'):</th>
                                    <td style="font-size: 12px;font-weight: 600">
                                        {{ @num_format($sell_line->rp_earned) }}</td>
                                </tr>
                            @endif
                            @if (!empty($sell_line->rp_redeemed_value))
                                <tr>
                                    <th>@lang('lang.redeemed_point_value'):</th>
                                    <td style="font-size: 12px;font-weight: 600">
                                        {{ @num_format($sell_line->rp_redeemed_value) }}</td>
                                </tr>
                            @endif
                            @if ($sell_line->total_coupon_discount > 0)
                                <tr>
                                    <th>@lang('lang.coupon_discount')</th>
                                    <td style="font-size: 12px;font-weight: 600">
                                        {{ @num_format($sell_line->total_coupon_discount) }}</td>
                                </tr>
                            @endif
                            @if ($sell_line->delivery_cost > 0)
                                <tr>
                                    <th>@lang('lang.delivery_cost')</th>
                                    <td style="font-size: 12px;font-weight: 600">
                                        {{ @num_format($sell_line->delivery_cost) }}</td>
                                </tr>
                            @endif
                            @if ($sell_line->service_fee_value > 0)
                                <tr>
                                    <th>@lang('lang.service')</th>
                                    <td style="font-size: 12px;font-weight: 600">
                                        {{ @num_format($sell_line->service_fee_value) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>@lang('lang.grand_total'):</th>
                                <td style="font-size: 12px;font-weight: 600">{{ @num_format($sell_line->final_total) }}
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('lang.paid_amount'):</th>
                                <td style="font-size: 12px;font-weight: 600">
                                    {{ @num_format($sell_line->transaction_payments->sum('amount')) }}</td>
                            </tr>
                            <tr>
                                <th>@lang('lang.due'):</th>
                                <td style="font-size: 12px;font-weight: 600">
                                    {{ @num_format($sell_line->final_total - $sell_line->transaction_payments->sum('amount')) }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12 d-flex flex-row-reverse">
                        <b class="mx-1">@lang('lang.terms_and_conditions')</b>:
                        @if (!empty($sell_line->terms_and_conditions))
                            {!! $sell_line->terms_and_conditions->description !!}
                        @endif
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <a data-href="{{ route('print_invoice', $sell_line->id) }}"
                    class="btn btn-primary text-white print-invoice"><i class="dripicons-print"></i>
                    @lang('lang.print')</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('lang.close')</button>
            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
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

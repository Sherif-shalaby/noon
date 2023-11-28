<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card m-b-30 mt-4">
                <div
                    class="card-header d-flex align-items-center  @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                    <h4>@lang('lang.return_sell')</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(['method' => 'post', 'files' => true, 'class' => 'pos-form', 'id' => 'sell_return_form']) !!}
                    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div
                            class="col-md-4 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('store_id', __('lang.store'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">

                                {!! Form::select('store_id', $stores, $store, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('lang.all'),
                                    'data-live-search' => 'true',
                                    'wire:model' => 'store',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-4 flex-row-reverse d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="font-size: 14px;font-weight: 500;">
                            <span class="mx-1">
                                @lang('lang.invoice_no')
                            </span>
                            :
                            <span>
                                {{ $sale->invoice_no }}
                            </span>
                        </div>
                        <div class="col-md-4 flex-row-reverse d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="font-size: 14px;font-weight: 500;">
                            <span class="mx-1">
                                @lang('lang.customer')
                            </span>
                            :
                            <span>
                                {{ $sale->customer->name ?? '' }}
                            </span>
                        </div>

                        <input type="hidden" name="default_customer_id" id="default_customer_id"
                            value="@if (!empty($walk_in_customer)) {{ $walk_in_customer->id }} @endif">
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12" style="margin-top: 20px ">
                                <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                                    <table id="product_table" style="width: 100% " class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 30%">{{ __('lang.product') }}</th>
                                                <th style="width: 20%">{{ __('lang.product_code') }}</th>
                                                <th style="width: 15%">{{ __('lang.quantity') }}</th>
                                                <th style="width: 15%">{{ __('lang.returned_quantity') }}</th>
                                                <th style="width: 15%">{{ __('lang.price') }}</th>
                                                <th style="width: 15%">{{ __('lang.discount') }}</th>
                                                <th style="width: 10%">{{ __('lang.sub_total') }}</th>
                                                <th style="width: 20%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @include('returns.partials.product_row', [
                                                'products' => $sale->transaction_sell_lines,
                                            ])
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <th style="text-align: right">@lang('lang.total')</th>
                                                <th><span class="grand_total_span">{{ number_format($amount) }}</span>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row" style="display: none;">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="hidden" id="transaction_id" name="transaction_id"
                                            value="{{ $sale->id }}" />
                                        <input type="hidden" id="final_total" name="final_total"
                                            value="{{ 0 }}" />
                                        <input type="hidden" id="grand_total" name="grand_total"
                                            value="{{ 0 }}" />
                                        <input type="hidden" id="store_pos_id" name="store_pos_id"
                                            value="{{ $sale->store_pos_id }}" />
                                        <input type="hidden" id="customer_id" name="customer_id"
                                            value="{{ $sale->customer_id }}" />
                                        <input type="hidden" id="gift_card_id" name="gift_card_id"
                                            value="{{ $sale->gift_card_id }}" />
                                        <input type="hidden" id="gift_card_amount" name="gift_card_amount"
                                            value="{{ $sale->transaction_payments->where('method', 'gift_card')->sum('amount') }}" />

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{--                        <div class="row"> --}}
                    {{--                            <div class="col-md-4 @if ($sale->delivery_cost_given_to_deliveryman) d-none @endif"> --}}
                    {{--                                {!! Form::label('delivery_cost_actual', __('lang.The_actual_delivery_cost'), []) !!} --}}
                    {{--                                {!! Form::text('delivery_cost_actual', @num_format($sale->delivery_cost), ['class' => 'form-control', 'readonly']) !!} --}}
                    {{--                            </div> --}}
                    {{--                            <div class="col-md-5 @if ($sale->delivery_cost_given_to_deliveryman) d-none  @endif"> --}}
                    {{--                                {!! Form::label('delivery_cost', __('lang.Discount_from_the_cost_of_delivery'), []) !!} --}}
                    {{--                                {!! Form::text('delivery_cost', @num_format($returns->delivery_cost??0), ['class' => 'form-control','max'=>@num_format($sale->delivery_cost)]) !!} --}}
                    {{--                            </div> --}}
                    {{--                            <div class="@if ($sale->delivery_cost_given_to_deliveryman) col-md-6 @else col-md-2 @endif"> --}}
                    {{--                                {!! Form::hidden('discount_type', $sale->discount_type, ['class' => 'form-control', 'id' => 'discount_type']) !!} --}}
                    {{--                                {!! Form::hidden('discount_value', $sale->discount_value, ['class' => 'form-control', 'id' => 'discount_value']) !!} --}}

                    {{--                                {!! Form::label('discount_amount', __('lang.discount'), []) !!} --}}
                    {{--                                {!! Form::text('discount_amount', !empty($returns->discount_amount) ? @num_format($returns->discount_amount) : @num_format($sale->discount_amount), ['class' => 'form-control']) !!} --}}
                    {{--                            </div> --}}
                    {{--                            <div class="@if ($sale->delivery_cost_given_to_deliveryman) col-md-6 @else col-md-1 @endif"> --}}
                    {{--                                {!! Form::label('total_tax', __('lang.tax'), []) !!} --}}
                    {{--                                {!! Form::text('total_tax', !empty($returns->total_tax) ? @num_format($returns->total_tax) : @num_format($sale->total_tax), ['class' => 'form-control']) !!} --}}
                    {{--                                <input type="hidden" name="tax_method" id="tax_method" --}}
                    {{--                                       value="{{ $sale->tax_method }}"> --}}
                    {{--                                <input type="hidden" name="tax_rate" id="tax_rate" value="{{ $sale->tax_rate }}"> --}}
                    {{--                                <input type="hidden" name="tax_type" id="tax_type" value="{{ $sale->tax_type }}"> --}}
                    {{--                            </div> --}}
                    {{--                        </div> --}}
                    <br>
                    <input type="hidden" name="total_amount_paid" id="total_amount_paid"
                        value="{{ $sale->transaction_payments->sum('amount') }}">
                    <div class="row">
                        <div class="col-md-12">
                            @if (!empty($sell_return))
                                @if ($sell_return->transaction_payments->count() > 0)
                                    @include('transaction_payment.partials.payment_form', [
                                        'payment' => $sell_return->transaction_payments->first(),
                                    ])
                                @else
                                    @include('transaction_payment.partials.payment_form')
                                @endif
                            @else
                                @include('transaction_payment.partials.payment_form')
                            @endif
                        </div>
                    </div>
                    <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div
                            class="col-md-9 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse my-2 @else flex-row @endif">
                            <label style="font-size: 12px;font-weight: 500;">@lang('lang.notes')</label>
                            <textarea rows="3" class="form-control initial-balance-input width-full" name="notes" id="notes"
                                wire:model = 'notes'>{{ !empty($sell_return) ? $sell_return->notes : '' }}</textarea>
                        </div>
                        <div
                            class="col-md-3 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('files', __('lang.files'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">
                                <input class="initial-balance-input width-full" type="file" name="files[]"
                                    id="files" multiple>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" wire:click ='store()'
                                class="btn btn-primary save-btn">@lang('lang.save')</button>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- This will be printed -->
<section class="invoice print_section print-only" id="receipt_section"> </section>

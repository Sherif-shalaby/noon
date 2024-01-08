<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-0 mt-1">
                <div
                    class="card-header d-flex align-items-center  @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                    <h6>@lang('lang.return_sell')</h6>
                </div>
                <div class="card-body">
                    {!! Form::open(['method' => 'post', 'files' => true, 'class' => 'pos-form', 'id' => 'sell_return_form']) !!}
                    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                        {{-- +++++++++++++++++ stores filter +++++++++++++++++ --}}
                        <div
                            class="mb-2 col-md-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
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

                        {{-- +++++++++++++++++ branches filter +++++++++++++++++ --}}
                        <div
                            class="mb-2 col-md-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                            {!! Form::label('branch_id', __('lang.branch'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">
                                {!! Form::select('branch_id', $branches, $branch_id, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('lang.all'),
                                    'data-live-search' => 'true',
                                    'wire:model' => 'branch_id',
                                ]) !!}
                            </div>
                        </div>
                        {{-- +++++++++++++++++ sale_points filter +++++++++++++++++ --}}
                        {{-- <div
                            class="col-md-4 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('pos_id', __('lang.pos'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">
                                {!! Form::select(
                                    'pos_id',
                                    $store_pos,
                                    [],
                                    [
                                        'class' => 'form-control select2 sale_filter',
                                        'placeholder' => __('lang.all'),
                                    ],
                                ) !!}
                            </div>
                        </div> --}}

                        <div
                            class="mb-2 col-md-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                            {!! Form::label('pos_id', __('lang.pos'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">
                                {!! Form::select('pos_id', $store_pos, $store_pos_id, [
                                    'class' => 'form-control select2 sale_filter',
                                    'placeholder' => __('lang.all'),
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-3 flex-row-reverse d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="font-size: 14px;font-weight: 500;">
                            <span class="mx-1">
                                @lang('lang.invoice_no')
                            </span>
                            :
                            <span>
                                {{ $sale->invoice_no }}
                            </span>
                        </div>


                        <div class="col-md-3 flex-row-reverse d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
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
                            <div class="col-md-12">
                                <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                                    <table id="product_table" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('lang.product') }}</th>
                                                <th>{{ __('lang.product_code') }}</th>
                                                <th>{{ __('lang.quantity') }}</th>
                                                <th>{{ __('lang.returned_quantity') }}</th>
                                                <th>{{ __('lang.price') }}</th>
                                                <th>{{ __('lang.discount') }}</th>
                                                <th>{{ __('lang.sub_total') }}</th>
                                                <th></th>
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

                    <input type="hidden" name="total_amount_paid" id="total_amount_paid"
                        value="{{ $sale->transaction_payments->sum('amount') }}">
                    <div class="row" style="position:relative;z-index:999999">
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
                            class="mb-2 col-md-9 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                            <label class="mb-0">@lang('lang.notes')</label>
                            <textarea rows="3" class="form-control initial-balance-input width-full" name="notes" id="notes"
                                wire:model = 'notes'>{{ !empty($sell_return) ? $sell_return->notes : '' }}</textarea>
                        </div>
                        <div
                            class="mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
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

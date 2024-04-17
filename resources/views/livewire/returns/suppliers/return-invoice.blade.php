<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card m-b-30 mt-4">
                <div class="card-header d-flex align-items-center">
                    <h4>@lang('lang.return_invoice')</h4>
                </div>
                <div class="card-body">
                    {!! Form::open([ 'method' => 'post', 'files' => true, 'class' => 'pos-form', 'id' => 'sell_return_form']) !!}
                        {{-- ++++++++++++++++ invoice_no , supplier_name , store_name ++++++++++++++++ --}}
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    @lang('lang.invoice_no'): {{ $stock->invoice_no }}
                                </div>
                                <div class="col-md-4">
                                    @lang('lang.supplier'): {{ $stock->supplier->name ?? '' }}
                                </div>
                                <div class="col-md-4">
                                    @lang('lang.store'): {{ $stock->store->name ?? '' }}
                                </div>
                            </div>
                        </div>
                        {{-- ++++++++++++++++ Products Table ++++++++++++++++ --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12" style="margin-top: 20px ">
                                    <div class="table-responsive">
                                        <table id="product_table" style="width: 100% " class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th style="width: 20%">{{ __('lang.product') }}</th>
                                                <th style="width: 20%">{{ __('lang.product_code') }}</th>
                                                <th style="width: 15%">{{ __('lang.quantity') }}</th>
                                                <th style="width: 15%">{{ __('lang.returned_quantity') }}</th>
                                                <th style="width: 15%">{{ __('lang.price') }}</th>
                                                <th style="width: 15%">{{ __('lang.sub_total') }}</th>
                                                <th style="width: 15%"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @include('suppliers.returns.partials.product_row',['products' => $stock->transaction_stock_lines])
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th style="text-align: right">@lang('lang.total')</th>
                                                {{-- <th><span class="grand_total_span">{{ number_format($amount) }}</span> --}}
                                                <td> {{ $sellPriceTotal }} </td>
                                                <td> {{ $finalPriceTotal }} </td>
                                                {{-- <th><span class="grand_total_span">{{ number_format($amount) }}</span></th> --}}
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    {{-- ============================ payments ============================ --}}
                                    <div class="row">
                                        {{-- ++++++++++++++++++ payment_status : تاريخ السداد ++++++++++++++++++ --}}
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-3" wire:ignore>
                                                    <div class="form-group">
                                                        {!! Form::label('payment_status', __('lang.payment_status'), []) !!}
                                                        {!! Form::select('payment_status', $payment_status_array, false,
                                                        [   'class' => 'form-control','id'=>'payment_status',
                                                            'placeholder' => __('lang.please_select'), 'required',
                                                            'wire:model' => 'paymentStatus',
                                                            'wire:change' => 'updatePaymentStatus'
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- +++++++++++++++ payment methods : طرق الدفع  +++++++++++++++ --}}
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if(!empty($stock_return))
                                                    @include('livewire.returns.suppliers.partials.payment_form', ['payment' =>$payment_type_array])
                                                @else
                                                    @include('livewire.returns.suppliers.partials.payment_form')
                                                @endif
                                            </div>
                                        </div>
                                        {{-- +++++++++++++++ due_date : تاريخ الاستحقاق +++++++++++++++ --}}
                                        <div class="col-md-3 due_fields hide" wire:ignore>
                                            <div class="form-group">
                                                {!! Form::label('due_date', __('lang.due_date'). ':', []) !!} <br>
                                                {!! Form::text('due_date', null, ['class' =>
                                                    'form-control datepicker', 'readonly',
                                                    'placeholder' => __('lang.due_date'),
                                                    'wire:model' => 'due_date'
                                                ]) !!}
                                            </div>
                                        </div>
                                        {{-- +++++++++++++++ notify_before_days : اخطار قبل ايام +++++++++++++++ --}}
                                        <div class="col-md-3 due_fields hide" wire:ignore>
                                            <div class="form-group">
                                                {!! Form::label('notify_before_days', __('lang.notify_before_days'). ':', []) !!} <br>
                                                {!! Form::text('notify_before_days', null,
                                                    ['class' =>'form-control',
                                                    'placeholder' => __('lang.notify_before_days'),
                                                    'wire:model' => 'notify_before_days',
                                                    ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++ notes : الملاحظات ++++++++++++++++++ --}}
                                    {{-- <div class="col-md-12" wire:ignore>
                                        <div class="form-group">
                                            {!! Form::label('notes', __('lang.notes') . ':', []) !!} <br>
                                            {!! Form::textarea(
                                                'notes', null , ['class' => 'form-control', 'rows' => 3 ,
                                                'wire:model'=>'notes'] ,
                                            ) !!}
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <br>
                    <br>
                    {{-- ++++++++++++++ submit button ++++++++++++++ --}}
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button"  wire:click ='store()' class="btn btn-primary save-btn">@lang('lang.save')</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // ++++++++++++++++ Payment_Status ++++++++++++++++
    document.addEventListener('livewire:load', function ()
    {
        // +++++++++++ المدفوعة جزئياً +++++++++++
        Livewire.on('togglePaymentFields', (flag) => {
            $(".payment_fields").toggleClass("hide", !flag);
            $(".not_cash_fields").toggleClass("hide", flag);
        });
        // +++++++++++ دفعت +++++++++++
        Livewire.on('toggleDueFields', (flag) => {
            $(".due_fields").toggleClass("hide", !flag);
        });
        // +++++++++++ ادفع لاحقاً +++++++++++
        Livewire.on('updateRequiredAttributes', (flag) => {
            $("#method").prop("required", flag);
            // $(".not_cash").prop("required", flag);
            $(".not_cash_fields").toggleClass("hide", !flag);
        });
    });
    // $("#payment_status").change(function () {
    //     var payment_status = $(this).val();
    //     console.log("payment_status = " + payment_status);
    //     // ++++++++++++++ payment_status == "paid" ++++++++++++++
    //     if (payment_status === "paid" || payment_status === "partial")
    //     {
    //         $(".not_cash_fields").addClass("hide");
    //         $("#method").change();
    //         $(".payment_fields").removeClass("hide");
    //     }
    //     else {
    //         $(".payment_fields").addClass("hide");
    //     }
    //     // ++++++++++++++ payment_status == "pending" ++++++++++++++
    //     if (payment_status === "pending" || payment_status === "partial") {
    //         $(".due_fields").removeClass("hide");
    //     } else {
    //         $(".due_fields").addClass("hide");
    //     }
    //     // ++++++++++++++ payment_status == "pending" ++++++++++++++
    //     if (payment_status === "pending")
    //     {
    //         $(".not_cash_fields").addClass("hide");
    //         $("#method").attr("required", false);
    //         $(".not_cash").attr("required", false);
    //     }
    //     // ++++++++++++++ payment_status == "paid" ++++++++++++++
    //     if (payment_status === "paid") {
    //         $(".due_fields").addClass("hide");
    //     }
    // });
</script>

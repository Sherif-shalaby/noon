<div class="col-md-12">
    @if(!empty($payment))
        <input type="hidden" name="transaction_payment_id" value="{{$payment->id}} ">
    @endif
    <div class="row {{ in_array($paymentStatus, ['paid', 'partial', 'pending']) ? '' : 'hide' }}">
        {{-- +++++++++++++++++++ amount inputField +++++++++++++++++++ --}}
        <div class="col-md-3 payment_fields" wire:ignore>
            <div class="form-group">
                {!! Form::label('amount', __('lang.amount'). ':*', []) !!} <br>
                {!! Form::text('amount', null ,
                    ['class' => 'form-control', 'placeholder' => __('lang.amount'),
                    'wire:model'=>'amount']) !!}
            </div>
        </div>
        {{-- +++++++++++++++++++ payment_method dropdown +++++++++++++++++++ --}}
        <div class="col-md-3 payment_fields" wire:ignore>
            <div class="form-group">
                {!! Form::label('method', __('lang.payment_type'). ':*', []) !!}
                {!! Form::select('method', $payment_type_array , __('lang.payment_type') ,
                    ['class' => 'select2 form-control','data-live-search'=>"true", 'required',
                    'placeholder' => __('lang.please_select'),
                     'wire:model' => 'method'
                    ]) !!}
            </div>
        </div>
        {{-- +++++++++++++++++++ payment_date inputField +++++++++++++++++++ --}}
        <div class="col-md-3 payment_fields" wire:ignore>
            <div class="form-group">
                {!! Form::label('paid_on', __('lang.payment_date'). ':', []) !!} <br>
                {!! Form::text('paid_on',@format_date(date('Y-m-d')), ['class' => 'form-control datepicker',
                    'placeholder' => __('lang.payment_date'),
                    'wire:model'=>'paid_on']) !!}
            </div>
        </div>
        {{-- +++++++++++++++++++ upload_documents file +++++++++++++++++++ --}}
        {{-- <div class="col-md-3 payment_fields" wire:ignore>
            <div class="form-group">
                {!! Form::label('upload_documents', __('lang.upload_documents'). ':', []) !!} <br>
                <input type="file" name="upload_documents[]" id="upload_documents" wire:model="upload_documents" multiple>
            </div>
        </div> --}}

        {{-- +++++++++++++++++++ ref_number inputField +++++++++++++++++++ --}}
        <div class="col-md-2 not_cash_fields" wire:ignore>
            <div class="form-group">
                {!! Form::label('ref_number', __('lang.ref_number'). ':*', []) !!} <br>
                {!! Form::text('ref_number', null,
                    ['class' => 'form-control not_cash','placeholder' => __('lang.ref_number'),
                    'wire:model' => 'ref_number']) !!}
            </div>
        </div>
        {{-- +++++++++++++++++++ bank_deposit_date inputField +++++++++++++++++++ --}}
        <div class="col-md-2 not_cash_fields" wire:ignore>
            <div class="form-group">
                {!! Form::label('bank_deposit_date', __('lang.bank_deposit_date'). ':*', []) !!} <br>
                {!! Form::text('bank_deposit_date', null ,
                ['class' => 'form-control not_cash datepicker',
                'placeholder' => __('lang.bank_deposit_date') ,
                'wire:model' => 'bank_deposit_date']) !!}
            </div>
        </div>
        {{-- +++++++++++++++++++ bank_name inputField +++++++++++++++++++ --}}
        <div class="col-md-3 not_cash_fields" wire:ignore>
            <div class="form-group">
                {!! Form::label('bank_name', __('lang.bank_name'). ':*', []) !!} <br>
                {!! Form::text('bank_name', null ,
                    ['class' => 'form-control not_cash','placeholder' => __('lang.bank_name'),
                    'wire:model' => 'bank_name']) !!}
            </div>
        </div>
    </div>
</div>

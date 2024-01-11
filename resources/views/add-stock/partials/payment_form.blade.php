<div class="col-md-12">
    <div class="row">

        <div class="col-md-2 payment_fields hide {{$show_payment==1?'d-none':''}}">
            <div class="form-group">
                {!! Form::label('amount', __('lang.amount'), []) !!} <br>
                <input type="number" placeholder="{{__('lang.amount')}}" class="form-control"  wire:model="total_amount" wire:change="changeReceivedDinar()">
                @if($dinar_remaining > 0)
                     <span wire:model="dinar_remaining">Change: {{$dinar_remaining}}</span>
                @endif

                @error('amount')
                <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-2 payment_fields hide {{$show_payment==1?'d-none':''}}">
            <div class="form-group">
                {!! Form::label('amount', __('lang.amount'), []) !!} $<br>
                <input type="number" placeholder="{{__('lang.amount')}}$" class="form-control"  wire:model="total_amount_dollar" wire:change="changeReceivedDollar()">
                @if($dollar_remaining > 0)
                    <span wire:model="dollar_remaining">Change: {{$dollar_remaining}}</span>
                    <button wire:click= "convertRemainingDollar()"><i class="fa-solid fa-retweet"></i></button>
                @endif
                @error('amount')
                <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>



        {{-- <div class="col-md-2">
            <label for="paying_currency">@lang('lang.paying_currency') </label>
            {!! Form::select('paying_currency', $selected_currencies, $paying_currency,
            ['class' => 'form-control select2','placeholder' => __('lang.please_select'), 'data-live-search' => 'true', 'required',
            'data-name' => 'paying_currency', 'wire:model' => 'paying_currency' ,'wire:change'=>'changeTotalAmount()']) !!}
            @error('paying_currency')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div> --}}
        <div class="col-md-3 payment_fields hide {{$show_payment==1?'d-none':''}}">
            <div class="form-group">
                {!! Form::label('paid_on', __('lang.payment_date'). ':', []) !!} <br>
                {!! Form::date('paid_on', $paid_on,
                ['class' => 'form-control',
                'placeholder' => __('lang.payment_date'), 'wire:model' => 'paid_on']) !!}
            </div>
        </div>

        <div class="col-md-3 payment_fields hide {{$show_payment==1?'d-none':''}}">
            <div class="form-group">
                {!! Form::label('upload_documents', __('lang.upload_documents'). ':', []) !!} <br>
                <input type="file" name="upload_documents[]" id="upload_documents" wire:model="upload_documents">
            </div>
        </div>
        @if(isset( $method) && $method != 'cash')
            <div class="col-md-3 not_cash_fields  {{$show_payment==1?'d-none':''}}">
                <div class="form-group">
                    {!! Form::label('ref_number', __('lang.ref_number'). ':*', []) !!} <br>
                    {!! Form::text('ref_number', !empty($transaction_payment)&&!empty($transaction_payment->ref_number)?$transaction_payment->ref_number:(!empty($payment) ? $payment->ref_number : null), ['class' => 'form-control
                    not_cash',
                    'placeholder' => __('lang.ref_number'), 'wire:model' => 'ref_number']) !!}
                </div>
                @error('ref_number')
                <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-3 not_cash_fields {{$show_payment==1?'d-none':''}}">
                <div class="form-group">
                    {!! Form::label('bank_deposit_date', __('lang.bank_deposit_date'). ':*', []) !!} <br>
                    {!! Form::date('bank_deposit_date', $bank_deposit_date,
                    ['class' => 'form-control not_cash datepicker',
                    'placeholder' => __('lang.bank_deposit_date'), 'wire:model' => 'bank_deposit_date']) !!}
                </div>
                @error('bank_deposit_date')
                <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-3 not_cash_fields {{$show_payment==1?'d-none':''}}">
                <div class="form-group">
                    {!! Form::label('bank_name', __('lang.bank_name'). ':*', []) !!} <br>
                    {!! Form::text('bank_name', !empty($transaction_payment)&&!empty($transaction_payment->bank_name)?$transaction_payment->bank_name:(!empty($payment) ? $payment->bank_name : null), ['class' => 'form-control
                    not_cash',
                    'placeholder' => __('lang.bank_name'), 'wire:model' => 'bank_name']) !!}
                </div>
                @error('bank_name')
                <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endif
</div>


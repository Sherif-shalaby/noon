
<div class="col-md-12">
    <div class="row">

        <div class="col-md-2 payment_fields hide">
            <div class="form-group">
                {!! Form::label('amount', __('lang.amount'). ':*', []) !!} <br>
                <input type="number" placeholder="{{__('lang.amount')}}" class="form-control"  wire:model = "amount">
                @error('amount')
                <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-2 payment_fields hide">
            <div class="form-group">
                {{$method}}
                {!! Form::label('method', __('lang.payment_type'). ':*', []) !!}
                {!! Form::select('method', $payment_type_array,
                !empty($transaction_payment)&&!empty($transaction_payment->method)?$transaction_payment->method:(!empty($payment) ? $payment->method : 'Please Select'), ['class' => 'select form-control',
                'data-live-search'=>"true", 'required', 'placeholder' => __('lang.please_select'), 'wire:model' => 'method' ]) !!}
                @error('method')
                <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-2">
            <label for="paying_currency">@lang('lang.paying_currency') :*</label>
            {!! Form::select('paying_currency', $selected_currencies, null, ['class' => 'form-control select','placeholder' => __('lang.please_select'), 'data-live-search' => 'true', 'required', 'wire:model' => 'paying_currency']) !!}
            @error('paying_currency')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3 payment_fields hide">
            <div class="form-group">
                {!! Form::label('paid_on', __('lang.payment_date'). ':', []) !!} <br>
                {!! Form::date('paid_on', !empty($transaction_payment)&&!empty($transaction_payment->paid_on)?@format_date($transaction_payment->paid_on):(!empty($payment) ? @format_date($payment->paid_on) :
                @format_date(date('Y-m-d'))), ['class' => 'form-control',
                'placeholder' => __('lang.payment_date'), 'wire:model' => 'paid_on']) !!}
            </div>
        </div>

        <div class="col-md-3 payment_fields hide">
            <div class="form-group">
                {!! Form::label('upload_documents', __('lang.upload_documents'). ':', []) !!} <br>
                <input type="file" name="upload_documents[]" id="upload_documents" multiple>
            </div>
        </div>
    </div>
</div>

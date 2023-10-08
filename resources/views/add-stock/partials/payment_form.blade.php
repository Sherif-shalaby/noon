
<div class="col-md-12">
    <div class="row">

        <div class="col-md-2 payment_fields hide">
            <div class="form-group">
                {!! Form::label('amount', __('lang.amount'), []) !!} <br>
                <input type="number" placeholder="{{__('lang.amount')}}" class="form-control"  wire:model="amount">
                @error('amount')
                <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-2 payment_fields hide">
            <div class="form-group">
                {!! Form::label('method', __('lang.payment_type'), []) !!}
                {!! Form::select('method', $payment_type_array, $method,
                ['class' => 'form-control select2','data-live-search'=>"true", 'required', 'placeholder' => __('lang.please_select'),
                'data-name' => 'method', 'wire:model' => 'method' ]) !!}
                @error('method')
                <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-2">
            <label for="paying_currency">@lang('lang.paying_currency') </label>
            {!! Form::select('paying_currency', $selected_currencies, $paying_currency,
            ['class' => 'form-control select2','placeholder' => __('lang.please_select'), 'data-live-search' => 'true', 'required',
            'data-name' => 'paying_currency', 'wire:model' => 'paying_currency']) !!}
            @error('paying_currency')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3 payment_fields hide">
            <div class="form-group">
                {!! Form::label('paid_on', __('lang.payment_date'). ':', []) !!} <br>
                {!! Form::date('paid_on', $paid_on,
                ['class' => 'form-control',
                'placeholder' => __('lang.payment_date'), 'wire:model' => 'paid_on']) !!}
            </div>
        </div>

        <div class="col-md-3 payment_fields hide">
            <div class="form-group">
                {!! Form::label('upload_documents', __('lang.upload_documents'). ':', []) !!} <br>
                <input type="file" name="upload_documents[]" id="upload_documents" wire:model="upload_documents">
            </div>
        </div>
    </div>
</div>

<div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
    @if (!empty($payment))
        <input type="hidden" name="transaction_payment_id" value="{{ $payment->id }}">
    @endif
    <div
        class="mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">

        {!! Form::label('amount', __('lang.amount') . '*', [
            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
            'style' => 'font-size: 12px;font-weight: 500;',
        ]) !!}
        <div class="input-wrapper">

            {!! Form::text('amount', !empty($payment) ? @num_format($payment->amount) : null, [
                'class' => 'form-control initial-balance-input width-full',
                'placeholder' => __('lang.amount'),
                'wire:model' => 'amount',
            ]) !!}
        </div>
    </div>
    <div
        class="dollar-cell mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
        {!! Form::label('amount', __('lang.amount') . '$ :*', [
            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
            'style' => 'font-size: 12px;font-weight: 500;',
        ]) !!}
        <div class="input-wrapper">
            {!! Form::text('dollar_amount', !empty($payment) ? @num_format($payment->dollar_amount) : null, [
                'class' => 'form-control initial-balance-input width-full',
                'placeholder' => __('lang.amount') . '$',
                'wire:model' => 'dollar_amount',
            ]) !!}
        </div>
    </div>

    <div class="mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
        style="position:relative;z-index:5">
        {!! Form::label('method', __('lang.payment_type') . '*', [
            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
            'style' => 'font-size: 12px;font-weight: 500;',
        ]) !!}
        <div class="input-wrapper">

            {!! Form::select('method', $payment_type_array, $method, [
                'class' => 'select form-control',
                'data-live-search' => 'true',
                'required',
                'placeholder' => __('lang.please_select'),
                'wire:model' => 'method',
            ]) !!}
        </div>
    </div>

    <div
        class="mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
        {!! Form::label('paid_on', __('lang.payment_date'), [
            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
            'style' => 'font-size: 12px;font-weight: 500;',
        ]) !!}
        <div class="input-wrapper">

            {!! Form::date('paid_on', !empty($payment) ? @format_date($payment->paid_on) : @format_date(date('Y-m-d')), [
                'class' => 'form-control datepicker initial-balance-input width-full',
                'placeholder' => __('lang.payment_date'),
                'wire:model' => 'paid_on',
            ]) !!}
        </div>
    </div>

    <div
        class="mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
        {!! Form::label('upload_documents', __('lang.upload_documents'), [
            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
            'style' => 'font-size: 12px;font-weight: 500;',
        ]) !!}
        <div class="input-wrapper">
            {!! Form::file('upload_documents[]', null, ['class' => 'initial-balance-input width-full']) !!}
        </div>
    </div>
    {{--    <div class="col-md-3 not_cash_fields hide"> --}}
    {{--        <div class="form-group"> --}}
    {{--            {!! Form::label('ref_number', __('lang.ref_number'). ':', []) !!} <br> --}}
    {{--            {!! Form::text('ref_number', !empty($payment) ? $payment->ref_number : null, ['class' => 'form-control --}}
    {{--            not_cash', --}}
    {{--            'placeholder' => __('lang.ref_number')]) !!} --}}
    {{--        </div> --}}
    {{--    </div> --}}
    {{--    <div class="col-md-4 not_cash_fields hide"> --}}
    {{--        <div class="form-group"> --}}
    {{--            {!! Form::label('bank_deposit_date', __('lang.bank_deposit_date'). ':', []) !!} <br> --}}
    {{--            {!! Form::text('bank_deposit_date', null, ['class' => 'form-control not_cash datepicker', --}}

    {{--            'placeholder' => __('lang.bank_deposit_date')]) !!} --}}
    {{--        </div> --}}
    {{--    </div> --}}
    {{--    <div class="col-md-4 not_cash_fields hide"> --}}
    {{--        <div class="form-group"> --}}
    {{--            {!! Form::label('bank_name', __('lang.bank_name'). ':', []) !!} <br> --}}
    {{--            {!! Form::text('bank_name', !empty($payment) ? $payment->bank_name : null, ['class' => 'form-control --}}
    {{--            not_cash', --}}
    {{--            'placeholder' => __('lang.bank_name')]) !!} --}}
    {{--        </div> --}}
    {{--    </div> --}}
    {{--    <div class="col-md-4 card_field hide"> --}}
    {{--        <label>@lang('lang.card_number') *</label> --}}
    {{--        <input type="text" name="card_number" class="form-control"> --}}
    {{--    </div> --}}
    {{--    <div class="col-md-2 card_field hide"> --}}
    {{--        <label>@lang('lang.month')</label> --}}
    {{--        <input type="text" name="card_month" class="form-control"> --}}
    {{--    </div> --}}
    {{--    <div class="col-md-2 card_field hide"> --}}
    {{--        <label>@lang('lang.year')</label> --}}
    {{--        <input type="text" name="card_year" class="form-control"> --}}
    {{--    </div> --}}

</div>

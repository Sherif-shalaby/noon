<div class="row">
    {{--    {{dd($customer_types)}} --}}
    <div
        class="col-md-6 mb-2 d-flex  align-items-end align-items-md-center @if (app()->isLocale('ar')) flex-md-row-reverse @else flex-md-row @endif ">
        {!! Form::label('customer_type_id', __('lang.customer_type') . '*', [
            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
            'style' => 'font-size: 12px;font-weight: 500;',
        ]) !!}
        <div class="input-wrapper">
            {!! Form::select('customer_type_id', $customer_types, null, [
                'class' => 'form-control select',
                'required',
                'placeholder' => __('lang.please_select'),
                'wire:model' => 'add_customer.customer_type_id',
            ]) !!}
            @error('customer_type_id')
                <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>
    </div>
    <div
        class="col-md-6 mb-2 d-flex  align-items-end align-items-md-center @if (app()->isLocale('ar')) flex-md-row-reverse @else flex-md-row @endif ">
        {!! Form::label('name', __('lang.name'), [
            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
            'style' => 'font-size: 12px;font-weight: 500;',
        ]) !!}
        <div class="input-wrapper">
            {!! Form::text('name', null, [
                'class' => 'form-control  initial-balance-input m-auto width-full required',
                'wire:model' => 'add_customer.name',
            ]) !!}
            @error('name')
                <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>
    </div>
    <div
        class="col-md-6 mb-2 d-flex  align-items-end align-items-md-center @if (app()->isLocale('ar')) flex-md-row-reverse @else flex-md-row @endif ">
        {!! Form::label('phone', __('lang.phone'), [
            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
            'style' => 'font-size: 12px;font-weight: 500;',
        ]) !!}
        <div class="input-wrapper">
            {!! Form::text('phone', null, [
                'class' => 'form-control  initial-balance-input m-auto width-full required',
                'wire:model' => 'add_customer.phone',
            ]) !!}
            @error('phone')
                <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>
    </div>

    <div
        class="col-md-6 mb-2 d-flex  align-items-end align-items-md-center @if (app()->isLocale('ar')) flex-md-row-reverse @else flex-md-row @endif ">
        {!! Form::label('email', __('lang.email'), [
            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
            'style' => 'font-size: 12px;font-weight: 500;',
        ]) !!}
        <div class="input-wrapper">
            {!! Form::email('email', null, [
                'class' => 'form-control  initial-balance-input m-auto width-full',
                'wire:model' => 'add_customer.email',
            ]) !!}
            @error('email')
                <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>
    </div>

    <div
        class="col-md-12 mb-2 d-flex  align-items-end align-items-md-center @if (app()->isLocale('ar')) flex-md-row-reverse @else flex-md-row @endif ">
        {!! Form::label('address', __('lang.address'), [
            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
            'style' => 'font-size: 12px;font-weight: 500;',
        ]) !!}
        <div class="input-wrapper">
            {!! Form::textarea('address', null, [
                'class' => 'form-control  initial-balance-input m-auto width-full',
                'wire:model' => 'add_customer.address',
                'rows' => '1',
            ]) !!}
            @error('address')
                <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>
    </div>
    {{--    <input type="hidden" name="quick_add" value="{{ $quick_add }}"> --}}
</div>

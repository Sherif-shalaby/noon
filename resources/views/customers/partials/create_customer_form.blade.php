<div class="row pt-5">
{{--    {{dd($customer_types)}}--}}
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('customer_type_id', __('lang.customer_type') . ':*') !!}
            {!! Form::select('customer_type_id', $customer_types, null, [
                'class' => 'form-control select',
                'required',
                'placeholder' => __('lang.please_select'),
                'wire:model' => 'add_customer.customer_type_id'
            ]) !!}
            @error('customer_type_id')
            <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('name', __('lang.name')) !!}
            {!! Form::text('name', null, [
                'class' => 'form-control required',
                'wire:model' => 'add_customer.name'
            ]) !!}
            @error('name')
            <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('phone', __('lang.phone')) !!}
            {!! Form::text('phone', null, [
                'class' => 'form-control required',
                'wire:model' =>'add_customer.phone'
            ]) !!}
            @error('phone')
            <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('email', __('lang.email')) !!}
            {!! Form::email('email', null, [
                'class' => 'form-control',
                'wire:model' => 'add_customer.email'
            ]) !!}
            @error('email')
            <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('address', __('lang.address')) !!}
            {!! Form::textarea('address', null, [
                'class' => 'form-control',
                'wire:model' =>'add_customer.address'
            ]) !!}
            @error('address')
            <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>
    </div>
{{--    <input type="hidden" name="quick_add" value="{{ $quick_add }}">--}}
</div>

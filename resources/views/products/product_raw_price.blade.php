{{-- 
@if(isset($price))
    <tr>
        <td>
            {!! Form::select('price_type['.$row_id.']',['fixed'=>__('lang.fixed'),'percentage'=>__('lang.percentage')], $price->price_type, ['class' => 'clear_input_form form-control select2']) !!}
        </td>
        <td>
            <input type="hidden" name="price_ids[]" value="{{$price->id}}">
            {!! Form::text('price_category['.$row_id.']', $price->price_category, ['class' => 'clear_input_form form-control','maxlength'=>"6" ]) !!}
        </td>
        <td>
            {!! Form::text('price['.$row_id.']',  $price->price, ['class' => 'clear_input_form form-control', 'placeholder' => __('lang.price')]) !!}
        </td>
        <td>
            {!! Form::text('quantity['.$row_id.']',$price->quantity, ['class' => 'clear_input_form form-control', 'placeholder' => __('lang.quantity')]) !!}
        </td>
        <td>
            {!! Form::text('bonus_quantity['.$row_id.']',$price->bonus_quantity, ['class' => 'clear_input_form form-control', 'placeholder' => __('lang.b_qty')]) !!}
        </td> --}}
        {{-- <td>
            <span class="i-checks d-flex justify-content-center">
                <input class="is_price_permenant" name="is_price_permenant[{{$row_id}}]" @if($price->is_price_permenant) checked @endif type="checkbox" class="form-control text-primary backgroud-primary" style="width:20px">
                &nbsp;
                <label for="is_price_permenant "><strong class="">
                            @lang('lang.permenant')
                    </strong></label>
            </span>
        </td> --}}
        {{-- <td>
            {!! Form::text('price_start_date['.$row_id.']',!empty($price->price_start_date)? @format_date($price->price_start_date) :null, ['class' => 'clear_input_form form-control datepicker price_start_date', 'placeholder' => __('lang.price_start_date'),$price->is_price_permenant?'disabled':'']) !!}
        </td>
        <td>
            {!! Form::text('price_end_date['.$row_id.']', !empty($price->price_start_date)? @format_date($price->price_end_date)  :null, ['class' => 'clear_input_form form-control datepicker price_end_date', 'placeholder' => __('lang.price_end_date'),$price->is_price_permenant?'disabled':'']) !!}
        </td> --}}
        {{-- <td>
            {!! Form::select('price_customer_types'.$row_id.'[]', $customer_types,  $price->price_customer_types , ['class' => 'js-example-basic-multiple','multiple'=>'multiple','placeholder'=>__('lang.please_select')]) !!}
        </td>
        <td><button type="button" class="btn btn-xs btn-danger remove_row remove_price_btn"><i class="fa fa-times"></i></button></td>
    </tr>
@else --}}
    <tr>
        <td>
            {{$index+1}}
        </td>
        <td>
            <select wire:model="priceRow.{{ $index }}.price_type" data-name='price_type' data-index="{{$index}}" required class="form-control select2" style="width: 100px;">
                <option value="">{{__('lang.please_select')}}</option>
                    <option value="fixed">{{__('lang.fixed')}}</option>
                    <option value="percentage">{{__('lang.percentage')}}</option>
            </select>
            {{-- <input type="text" class="form-control sku" wire:model="priceRow.{{ $index }}.price_type" style="width: 150px;" required > --}}
            @error('priceRow.'.$index.'.price_type')
            <br>
                <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </td>
        {{-- <td>
            {!! Form::select('price_type['.$row_id.']',['fixed'=>__('lang.fixed'),'percentage'=>__('lang.percentage')], null, ['class' => 'clear_input_form form-control select2']) !!}
        </td> --}}
        <td>
            <input type="text" class="form-control price_category" wire:model="priceRow.{{ $index }}.price_category" maxlength="6" >

            {{-- {!! Form::text('price_category['.$row_id.']', null, ['class' => 'clear_input_form form-control', 'maxlength'=>"6"]) !!} --}}
        </td>
        <td>
            <input type="text" class="form-control price" wire:model="priceRow.{{ $index }}.price" placeholder = "{{__('lang.price')}}" >

            {{-- {!! Form::text('price['.$row_id.']',null, ['class' => 'clear_input_form form-control', 'placeholder' => __('lang.price')]) !!} --}}
        </td>
        <td>
            <input type="text" class="form-control quantity" wire:model="priceRow.{{ $index }}.quantity" placeholder = "{{__('lang.quantity')}}" >

            {{-- {!! Form::text('quantity['.$row_id.']',null, ['class' => 'clear_input_form form-control', 'placeholder' => __('lang.quantity')]) !!} --}}
        </td>
        <td>
            <input type="text" class="form-control bonus_quantity" wire:model="priceRow.{{ $index }}.bonus_quantity" placeholder = "{{__('lang.bonus_quantity')}}" >

            {{-- {!! Form::text('bonus_quantity['.$row_id.']',null, ['class' => 'clear_input_form form-control', 'placeholder' => __('lang.b_qty')]) !!} --}}
        </td>
        <td>
            <select wire:model="priceRow.{{ $index }}.price_customer_types" data-name='price_customer_types' data-index="{{$index}}" class="form-control js-example-basic-multiple" multiple='multiple' placeholder="{{__('lang.please_select')}}">
                <option value="">{{__('lang.please_select')}}</option>
                @foreach($customer_types as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                @endforeach
            </select>
            {{-- {!! Form::select('price_customer_types'.$row_id.'[]', $customer_types, [], ['class' => 'js-example-basic-multiple','multiple'=>'multiple','placeholder'=>__('lang.please_select')]) !!} --}}
        </td>
        <td>
            <div class="btn btn-sm btn-danger py-0 px-1 " wire:click="delete_price_raw({{$index}})">
                <i class="fa fa-trash"></i>
            </div>
        </td>

    </tr>

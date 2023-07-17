
@if(isset($price))
    <tr>
        <td>
            <input type="hidden" name="price_ids[]" value="{{$price->id}}">
            {!! Form::text('price_category['.$row_id.']', $price->price_category, ['class' => 'clear_input_form form-control','maxlength'=>"6" ]) !!}
        </td>
        <td>
            {!! Form::text('price['.$row_id.']',  $price->price, ['class' => 'clear_input_form form-control', 'placeholder' => __('lang.price')]) !!}
        </td>
        <td>
            <span class="i-checks d-flex justify-content-center">
                <input id="is_price_permenant" name="is_price_permenant[{{$row_id}}]" @if($price->is_price_permenant) checked @endif type="checkbox" checked class="form-control text-primary backgroud-primary" style="width:20px">
                &nbsp;
                <label for="is_price_permenant "><strong class="">
                            @lang('lang.permenant')
                    </strong></label>
            </span>
        </td>
        <td>
            {!! Form::text('price_start_date['.$row_id.']',!empty($price->price_start_date)? @format_date($price->price_start_date) :null, ['class' => 'clear_input_form form-control datepicker price_start_date', 'placeholder' => __('lang.price_start_date'),$price->is_price_permenant?'disabled':'']) !!}
        </td>
        <td>
            {!! Form::text('price_end_date['.$row_id.']', !empty($price->price_start_date)? @format_date($price->price_end_date)  :null, ['class' => 'clear_input_form form-control datepicker price_end_date', 'placeholder' => __('lang.price_end_date'),$price->is_price_permenant?'disabled':'']) !!}
        </td>
        <td>
            {!! Form::select('price_customer_types['.$row_id.']', $customer_types,  $price->price_customer_types , ['class' => ' select2 form-control js-example-basic-multiple-limit', 'style' => 'width: 80%', 'id' => 'price_customer_types','placeholder'=>__('lang.please_select')]) !!}
        </td>
        <td><button type="button" class="btn btn-xs btn-danger remove_row remove_price_btn"><i class="fa fa-times"></i></button></td>
    </tr>
@elseif(isset($price_product))
<tr>
    <td>
        {!! Form::text('price_category['.$row_id.']', $price_product->price_category , ['class' => 'clear_input_form form-control', 'maxlength'=>"6" ]) !!}
    </td>
    <td>
        {!! Form::text('price['.$row_id.']', @num_format($price_product->price) , ['class' => 'clear_input_form form-control', 'placeholder' => __('lang.price')]) !!}
    </td>
    <td>
        <span class="i-checks">
            <input id="is_price_permenant" name="is_price_permenant[{{$row_id}}]" type="checkbox" checked class="form-control">
            <label for="is_price_permenant"><strong>
                        @lang('lang.permenant')

                </strong></label>
        </span>
    </td>
    <td>
      <input id="is_price_permenant" name="is_price_permenant" type="checkbox" checked class="form-control-custom">
        {!! Form::text('price_start_date['.$row_id.']',  !empty($price_product->price_start_date) ? @format_date($price_product->price_start_date) : null, ['class' => 'clear_input_form form-control datepicker', 'placeholder' => __('lang.price_start_date')]) !!}
    </td>
    <td>
        {!! Form::text('price_end_date['.$row_id.']', !empty($price_product->price_end_date) ? @format_date($price_product->price_end_date) : null , ['class' => 'clear_input_form form-control datepicker', 'placeholder' => __('lang.price_end_date')]) !!}
    </td>
    <td>
        {!! Form::select('price_customer_types['.$row_id.']', $price_customer_types, !empty($price_product) ? $price_product->price_customer_types : false, ['class' => 'clear_input_form selectpicker form-control', 'data-live-search' => 'true', 'style' => 'width: 80%', 'multiple', 'data-actions-box' => 'true', 'id' => 'price_customer_types']) !!}
    </td>
    <td><button type="button" class="btn btn-xs btn-danger remove_row remove_price_btn"><i class="fa fa-times"></i></button></td>

</tr>
@else
    <tr>
        <td>
            {!! Form::text('price_category['.$row_id.']', !empty($recent_product) ? $recent_product->price_category : null, ['class' => 'clear_input_form form-control', 'maxlength'=>"6"]) !!}
        </td>
        <td>
            {!! Form::text('price['.$row_id.']', !empty($recent_product) ? @num_format($recent_product->price) : null, ['class' => 'clear_input_form form-control', 'placeholder' => __('lang.price')]) !!}
        </td>
        <td>
            <span class="i-checks d-flex justify-content-center">
                <input id="is_price_permenant" name="is_price_permenant[{{$row_id}}]" type="checkbox" checked class="form-control text-primary backgroud-primary" style="width:20px">
                &nbsp;
                <label for="is_price_permenant "><strong class="">
                            @lang('lang.permenant')
                    </strong></label>
            </span>
        </td>
        <td>   
            {!! Form::text('price_start_date['.$row_id.']', !empty($recent_product) && !empty($recent_product->price_start_date) ? @format_date($recent_product->price_start_date) : null, ['class' => 'clear_input_form form-control datepicker price_start_date', 'disabled','placeholder' => __('lang.price_start_date')]) !!}
        </td>
        <td>
            {!! Form::text('price_end_date['.$row_id.']', !empty($recent_product) && !empty($recent_product->price_end_date) ? @format_date($recent_product->price_end_date) : null, ['class' => 'clear_input_form form-control datepicker price_end_date','disabled','placeholder' => __('lang.price_end_date')]) !!}
        </td>
        <td>
            {!! Form::select('customer_types['.$row_id.']', $customer_types, !empty($recent_product) ? $recent_product->price_customer_types : false, ['class' => ' select2 form-control js-example-basic-multiple-limit', 'style' => 'width: 80%', 'id' => 'price_customer_types','placeholder'=>__('lang.please_select')]) !!}
        </td>
        <td><button type="button" class="btn btn-xs btn-danger remove_row remove_price_btn"><i class="fa fa-times"></i></button></td>

    </tr>
@endif

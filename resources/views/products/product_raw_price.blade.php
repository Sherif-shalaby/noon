
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
                <input class="is_price_permenant" name="is_price_permenant[{{$row_id}}]" @if($price->is_price_permenant) checked @endif type="checkbox" checked class="form-control text-primary backgroud-primary" style="width:20px">
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
            {!! Form::select('price_customer_types'.$row_id.'[]', $customer_types,  $price->price_customer_types , ['class' => 'js-example-basic-multiple','multiple'=>'multiple','placeholder'=>__('lang.please_select')]) !!}
        </td>
        <td><button type="button" class="btn btn-xs btn-danger remove_row remove_price_btn"><i class="fa fa-times"></i></button></td>
    </tr>
@else
    <tr>
        <td>
            {!! Form::text('price_category['.$row_id.']', null, ['class' => 'clear_input_form form-control', 'maxlength'=>"6"]) !!}
        </td>
        <td>
            {!! Form::text('price['.$row_id.']',null, ['class' => 'clear_input_form form-control', 'placeholder' => __('lang.price')]) !!}
        </td>
        <td>
            <span class="i-checks d-flex justify-content-center">
                <input class="is_price_permenant" name="is_price_permenant[{{$row_id}}]" type="checkbox" checked class="form-control text-primary backgroud-primary" style="width:20px">
                &nbsp;
                <label for="is_price_permenant "><strong class="">
                            @lang('lang.permenant')
                    </strong></label>
            </span>
        </td>
        <td>   
            {!! Form::text('price_start_date['.$row_id.']', null, ['class' => 'clear_input_form form-control datepicker price_start_date', 'disabled','placeholder' => __('lang.price_start_date')]) !!}
        </td>
        <td>
            {!! Form::text('price_end_date['.$row_id.']', null, ['class' => 'clear_input_form form-control datepicker price_end_date','disabled','placeholder' => __('lang.price_end_date')]) !!}
        </td>
        <td>
            {!! Form::select('price_customer_types'.$row_id.'[]', $customer_types, [], ['class' => 'js-example-basic-multiple','multiple'=>'multiple','placeholder'=>__('lang.please_select')]) !!}
        </td>
        <td><button type="button" class="btn btn-xs btn-danger remove_row remove_price_btn"><i class="fa fa-times"></i></button></td>

    </tr>
@endif
<script>
$(document).ready(function() {
        $('.js-example-basic-multiple').select2({
                placeholder: "{{__('lang.please_select')}}",
                multiple:true
        });
        $(function() {
            $( ".datepicker" ).datepicker({
            });
        });
});
</script>
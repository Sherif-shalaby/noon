<tr>
    <td>
{{--        <input type="hidden" name="selectedProductData" value="{{ json_encode($selectedProductData) }}">--}}
        {{$index+1}}
    </td>
{{--    <td>--}}
{{--        <img src="@if(!empty($product->image)){{asset('uploads/products/'.$product->image)}}@else{{asset('/uploads/'.session('logo'))}}@endif"--}}
{{--             alt="photo" width="50" height="50">--}}
{{--    </td>--}}

    <td>
        @if($product['show_product_data'])
            {{ $product['product']['name'] }}
        @endif
    </td>
    <td>
        @if($product['show_product_data'])
            {{ $product['product']['sku'] }}
        @endif
    </td>
    <td>
        <input type="text" class="form-control quantity" style="width: 61px;" required
               wire:model="items.{{ $index }}.quantity" wire:change="changeCurrentStock({{ $index }})">
        @error('items.{{ $index }}.quantity')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td>
{{--        {{$product['variation_id'] ?? 0}}--}}
        <select name="items.{{$index}}.variation_id" id="unit_name" class="form-control select" style="width: 130px" wire:model="items.{{ $index }}.variation_id" wire:change="getVariationData({{ $index }})">
            <option value="" selected>{{__('lang.please_select')}}</option>

            @foreach($product['variations'] as $variant)
                <option value="{{$variant['id']}}">{{$variant['unit']['name']}}</option>
            @endforeach
        </select>
        <button type="button" class="btn btn-primary btn-sm mt-2" wire:click="add_product({{$product['product']['id']}},'unit')">
            <i class="fa fa-plus"></i>
        </button>
{{--        {{__('lang.add_a_new_batch')}}--}}
    </td>
    <td>
        <span>{{$product['base_unit_multiplier']}}</span>
    </td>
    <td>
        <span>{{$product['unit']}}</span>
    </td>
    <td>
        <div class="d-flex justify-content-between">
            <select class="custom-select " style="width:55px;" wire:model="items.{{ $index }}.fill_type" wire:change="changeFilling({{$index}})">
                <option selected value="fixed">-</option>
                <option  value="percent">%</option>
            </select>
            <div class="input-group-prepend">
                <input type="text" class="form-control" wire:model="items.{{ $index }}.fill_quantity" wire:change="changeFilling({{$index}})" style="width: 100px;" required>
            </div>

        </div>
    </td>

{{--    <td>--}}
{{--        <span class="total_quantity">--}}
{{--            {{$this->total_quantity($index)}}--}}
{{--        </span>--}}
{{--    </td>--}}
{{--    @if ($showColumn)--}}
        <td>
            <input type="text" class="form-control" style="width: 61px;" required
                   wire:model="items.{{ $index }}.dollar_purchase_price">
            @error('purchase_price')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </td>
        <td>
            <input type="text" class="form-control " wire:model="items.{{ $index }}.dollar_selling_price" style="width: 61px;" required>
            @error('selling_price')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </td>
        <td>
            @if(isset($product['quantity']) &&  (isset($product['dollar_purchase_price']) || isset($product['purchase_price'])))
                <span class="sub_total_span" >
                    {{$this->dollar_sub_total($index)}}
                </span>
            @endif
        </td>
{{--    @endif--}}
    <td>
        <input type="text" class="form-control" wire:model="items.{{ $index }}.purchase_price" style="width: 61px;"  required>
        @error('purchase_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td>
        <input type="text" class="form-control " wire:model="items.{{ $index }}.selling_price" style="width: 61px;" required>
        @error('selling_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td>
        @if(isset($product['quantity']) && (isset($product['purchase_price']) || isset($product['dollar_purchase_price'])))
            <span class="sub_total_span" >
                {{$this->sub_total($index)}}
            </span>
        @endif
    </td>
    <td>
        <span class="size">
            {{ $product['size'] }}
        </span>
    </td>
    <td>
       @if(isset($product['quantity']))
            <span class="total_size">
                {{$this->total_size($index) }}
            </span>
        @else
           {{0.00}}
        @endif
    </td>
    <td>
        <span class="weight">
            {{ $product['weight'] }}
        </span>
    </td>
    <td>
       @if(isset($product['quantity']))
            <span class="total_weight">
                {{$this->total_weight($index) }}
            </span>
        @else
           {{0.00}}
        @endif
    </td>
{{--    @if ($showColumn)--}}
        <td>
            @if(isset($product['quantity']) &&( isset($product['dollar_purchase_price']) || isset($product['purchase_price'])))
                <span class="dollar_cost">
                    {{ $this->dollar_cost($index) }}
                </span>
            @else
                {{0.00}}
            @endif
        </td>
        <td>
            @if(isset($product['quantity']) &&( isset($product['dollar_purchase_price']) || isset($product['purchase_price'])))
                <span class="dollar_total_cost">
                    {{$this->dollar_total_cost($index) }}
                </span>
            @else
                {{0.00}}
            @endif
        </td>
{{--    @endif--}}
    <td>
        @if(isset($product['quantity']) &&( isset($product['purchase_price']) ||  isset($product['dollar_purchase_price'])))
            <span class="cost">
                {{$this->cost($index) }}
            </span>
        @else
            {{0.00}}
        @endif
    </td>
    <td>
        @if(isset($product['quantity']) &&( isset($product['purchase_price']) ||  isset($product['dollar_purchase_price'])))
            <span class="total_cost">
                {{$this->total_cost($index) }}
            </span>
        @else
            {{0.00}}
        @endif
    </td>
    <td>
        <span class="current_stock_text">
            {{$product['total_stock'] }}
        </span>
    </td>
    <td>
       <input type="checkbox" name="change_price"  wire:model="items.{{ $index }}.change_price_stock">
    </td>
    <td  class="text-center">
        <div class="btn btn-sm btn-danger py-0 px-1"
             wire:click="delete_product({{ $index }})">
            <i class="fa fa-trash"></i>
        </div>
    </td>
</tr>
@foreach( $product['prices'] as $key => $price)
    <tr>
        <td></td>
        <td>
            {!! Form::select('price_type', ['fixed'=>__('lang.fixed'),'percentage'=>__('lang.percentage')], null, [
                // 'id' => 'price_type',
                'class' => ' form-control select2 price_type',
                'data-name' => 'price_type',
                'data-index' =>$index,
                'placeholder' => __('lang.please_select'),
                'wire:model' => 'items.'.$index.'.prices.'.$index.'.price_type',
            ]) !!}
            @error('items.'.$index.'.prices.'.$index.'.price_type')
            <br>
            <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </td>
        <td>
            <input type="text" class="form-control price_category" wire:model="items.{{$index}}.prices.{{$key}}.price_category" maxlength="6" >
        </td>
        <td>
            <input type="text" class="form-control price" wire:model="items.{{$index}}.prices.{{$key}}.price" placeholder = "{{__('lang.price')}}" >
        </td>
        <td>
            <input type="text" class="form-control discount_quantity" wire:model="iitems.{{$index}}.prices.{{$key}}.discount_quantity" placeholder = "{{__('lang.quantity')}}" >

        </td>
        <td>
            <input type="text" class="form-control bonus_quantity" wire:model="items.{{$index}}.prices.{{$key}}.bonus_quantity" placeholder = "{{__('lang.b_qty')}}" >

        </td>
        <td>
            <select wire:model="items.{{$index}}.prices.{{$key}}.price_customer_types" data-name='price_customer_types' data-index="{{$key}}" class="form-control js-example-basic-multiple" multiple='multiple' placeholder="{{__('lang.please_select')}}">
                @foreach($customer_types as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                @endforeach
            </select>
        </td>
         <td>
            <button type="button" class="btn btn-sm btn-primary" wire:click="addPriceRow({{ $index }})">
                <i class="fa fa-plus"></i>
            </button>
            @if($key > 0)
                <div class="btn btn-sm btn-danger py-0 px-1 " wire:click="delete_price_raw({{ $index }},{{ $key }})">
                    <i class="fa fa-trash"></i>
                </div>
            @endif
        </td>



    </tr>

@endforeach

<tr>
    <td></td>
    <td > {!! Form::label('', __('lang.expiry_date'), []) !!}<br>
        {!! Form::date('add_stock_lines['.$index.'][expiry_date]', null, ['class' => 'form-control datepicker expiry_date', 'wire:model' => 'items.' . $index . '.expiry_date']) !!}
    </td>
    <td> {!! Form::label('', __('lang.days_before_the_expiry_date'), []) !!}<br>
        {!! Form::text('add_stock_lines['.$index.'][expiry_warning]', null, ['class' => 'form-control days_before_the_expiry_date', 'wire:model' => 'items.' . $index . '.expiry_warning']) !!}
    </td>
    <td> {!! Form::label('', __('lang.convert_status_expire'), []) !!}<br>
        {!! Form::text('add_stock_lines['.$index.'][convert_status_expire]', null, ['class' => 'form-control', 'wire:model' => 'items.' . $index . '.convert_status_expire']) !!}
    </td>
    <td>

    </td>
</tr>

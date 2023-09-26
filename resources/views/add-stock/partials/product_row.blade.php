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
        {{ $product['product']['name'] }}
    </td>
    <td>
        {{ $product['product']['sku'] }}
    </td>
    <td>
        <input type="text" class="form-control quantity" style="width: 61px;" required
               wire:model="items.{{ $index }}.quantity" wire:change="changeCurrentStock({{ $index }})">
        @error('items.{{ $index }}.quantity')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td>
        {{$product['unit_name']}}
    </td>
    <td>
        {{$product['base_unit_multiplier']}}
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

{{--<tr>--}}
{{--    <td></td>--}}
{{--    <td>--}}
{{--        {!! Form::label('unit', __('lang.unit'), []) !!} <br>--}}
{{--<select name="" id=""></select>    </td>--}}
{{--</tr>--}}

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

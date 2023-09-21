<tr>
    <td>
        <input type="hidden" name="selectedProductData" value="{{ json_encode($selectedProductData) }}">
        {{$index+1}}
    </td>
{{--    <td>--}}
{{--        <img src="@if(!empty($product->image)){{asset('uploads/products/'.$product->image)}}@else{{asset('/uploads/'.session('logo'))}}@endif"--}}
{{--             alt="photo" width="50" height="50">--}}
{{--    </td>--}}
    <td>
        {{ $product['name'] }}
    </td>
    <td>
        {{ $product['sku'] }}
    </td>
    <td>
        <input type="text" class="form-control quantity"  wire:model="quantity.{{ $index }}" style="width: 61px;" required >
        @error('quantity')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td>
        @php
        $unit=[];
        if(isset($product['unit_id'])){
        $unit = \App\Models\Unit::find($product['unit_id'])->first();
        }
        @endphp
        @if(!empty($unit))
            {{$unit->name??''}}
        @endif
    </td>
    <td>
        @if(!empty($unit))
            <span>
                {{$unit->base_unit_multiplier}}
            </span>
        @endif
    </td>
    <td>
        @if(isset($quantity[$index]))
            <span class="total_quantity">
                {{$this->total_quantity($index) ?? 0}}
            </span>
        @endif
    </td>
    @if ($showColumn)
        <td>
            <input type="text" class="form-control" wire:model="dollar_purchase_price.{{ $index }}" style="width: 61px;" required>
            @error('purchase_price')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </td>
        <td>
            <input type="text" class="form-control " wire:model="dollar_selling_price.{{ $index }}" style="width: 61px;" required>
            @error('selling_price')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </td>
        <td>
            @if(isset($quantity[$index]) &&  (isset($dollar_purchase_price[$index]) || isset($purchase_price[$index])))
                <span class="sub_total_span" >
                    {{$this->dollar_sub_total($index)}}
                </span>
            @endif
        </td>
    @endif
    <td>
        <input type="text" class="form-control" wire:model="purchase_price.{{ $index }}" style="width: 61px;"  required>
        @error('purchase_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td>
        <input type="text" class="form-control " wire:model="selling_price.{{ $index }}" style="width: 61px;" required>
        @error('selling_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td>
        @if(isset($quantity[$index]) && (isset($purchase_price[$index]) || isset($dollar_purchase_price)))
            <span class="sub_total_span" >
                {{$this->sub_total($index)}}
            </span>
        @endif
    </td>
    <td>
        <span class="size">
            @if($product['size'])
                {{$product['size']}}
            @else
                {{0.00}}
            @endif
        </span>
    </td>
    <td>
       @if(isset($quantity[$index]) && isset($product->size))
            <span class="total_size">
                {{$this->total_size($index) }}
            </span>
        @else
           {{0.00}}
        @endif
    </td>
    <td>
        <span class="weight">
            @if($product['weight'])
                {{$product['weight']}}
            @else
                {{0.00}}
            @endif
        </span>
    </td>
    <td>
       @if(isset($quantity[$index]) && isset($product->weight))
            <span class="total_weight">
                {{$this->total_weight($index) }}
            </span>
        @else
           {{0.00}}
        @endif
    </td>
    @if ($showColumn)
        <td>
            @if(isset($quantity[$index]) &&( isset($dollar_purchase_price[$index]) || isset($purchase_price[$index])))
                <span class="dollar_cost">
                    {{ $this->dollar_cost($index) }}
                </span>
            @else
                {{0.00}}
            @endif
        </td>
        <td>
            @if(isset($quantity[$index]) && (isset($dollar_purchase_price[$index]) || isset($purchase_price[$index])))
                <span class="dollar_total_cost">
                    {{$this->dollar_total_cost($index) }}
                </span>
            @else
                {{0.00}}
            @endif
        </td>
    @endif
    <td>
        @if(isset($quantity[$index]) && (isset($purchase_price[$index]) || isset($dollar_purchase_price[$index])))
            <span class="cost">
                {{$this->cost($index) }}
            </span>
        @else
            {{0.00}}
        @endif
    </td>
    <td>
        @if(isset($quantity[$index]) && (isset($purchase_price[$index]) || isset($dollar_purchase_price[$index])))
            <span class="total_cost">
                {{$this->total_cost($index) }}
            </span>
        @else
            {{0.00}}
        @endif
    </td>
    <td>
        <span class="current_stock_text">
            {{$quantity[$index] ?? 0}}
        </span>
    </td>
    <td>
       <input type="checkbox" name="change_price"  wire:model="change_price_stock.{{ $index }}">
    </td>
    <td  class="text-center">
        <div class="btn btn-sm btn-danger py-0 px-1"
             wire:click="delete_product({{ $index }})">
            <i class="fa fa-trash"></i>
        </div>
    </td>
</tr>

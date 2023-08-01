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
        {{ $product->name }}
    </td>
    <td>
        {{ $product->sku }}

    </td>
    <td>
        <input type="text" class="form-control quantity" data-val="0" wire:model="quantity.{{ $index }}" required >
    </td>
    <td>
        @if(!empty($product->unit))
            {{$product->unit->name}}
        @endif
    </td>
    <td>
        @if(!empty($product->unit))
            <span>
                {{$product->unit->base_unit_multiplier}}
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


    <td>
        <input type="text" class="form-control purchase_price" wire:model="purchase_price.{{ $index }}" required>
    </td>
    <td>
        <input type="text" class="form-control selling_price" wire:model="selling_price.{{ $index }}" required>
    </td>
    <td>
        @if(isset($quantity[$index]) && isset($purchase_price[$index]))
            <span class="sub_total_span" >
                {{$this->sub_total($index)}}
            </span>
        @endif
        <input type="hidden" class="form-control sub_total" name="sub_total" value="">
    </td>
    <td>
        <span class="size">
            @if($product->size)
                {{$product->size}}
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
            @if($product->weight)
                {{$product->weight}}
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
    <td>
        @if(isset($quantity[$index]) && isset($purchase_price[$index]))
            <span class="cost">
                {{$this->cost($index) }}
            </span>
        @else
            {{0.00}}
        @endif
    </td>
    <td>
        @if(isset($quantity[$index]) && isset($purchase_price[$index]))
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
{{--       <input id="active" type="checkbox"  checked  wire:model = "change_price_stock.{{ $index }}">--}}
{{--        {{$change_price_stock[$index] ?? 0}}--}}
    </td>
    <td class="text-center">
        <div class="btn btn-sm btn-danger py-0 px-1"
             wire:click="delete_product({{ $index }})">
            <i class="fa fa-trash"></i>
        </div>
    </td>
</tr>

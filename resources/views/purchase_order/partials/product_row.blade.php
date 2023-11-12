<tr>
    {{-- ++++++++++++++ column 1 : index  ++++++++++++++ --}}
    <td>
        {{$index+1}}
    </td>
    {{-- ++++++++++++++ column 2 : product_name ++++++++++++++ --}}
    <td>
        {{-- @if($product['show_product_data']) --}}
            {{ $product['product']['name'] }}
            <input type="hidden" name="product_id" wire:model="product_id" value="{{ $product['product']['id'] }}" />
        {{-- @endif --}}
    </td>
    {{-- +++++++++++++++++++++ column 3 : quantity +++++++++++++++++++++ --}}
    <td>
        <input type="text" class="form-control quantity" style="width: 61px;" required
               wire:model="items.{{ $index }}.quantity">
        @error('items.{{ $index }}.quantity')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    {{-- +++++++++++++++++++++ column 4 : سعر الشراء بالدولار  +++++++++++++++++++++ --}}
    <td>
        <input type="text" class="form-control" style="width: 61px;" required
                wire:model="items.{{ $index }}.dollar_purchasing_price"
                wire:keyup="convert_dinar_price({{ $index }})" >
        @error('purchase_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>

    {{-- +++++++++++++++++++++ column 7 : سعر الشراء بالدينار +++++++++++++++++++++ --}}
    <td>
        <input type="text" class="form-control"
                wire:model="items.{{ $index }}.purchasing_price"
                wire:keyup="convert_dollar_price({{ $index }})"
                style="width: 61px;"  required>
        @error('purchase_price')
            <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    {{-- ++++++++++++++++++++ Task : اجمالي التكاليف بالدولار  ++++++++++++++++++++++ --}}
    <td>
        @if(isset($product['quantity']) &&( isset($product['dollar_purchasing_price']) ))
            <span class="dollar_total_cost">
                {{$this->dollar_total_cost($index) }}
            </span>

            <input type="hidden" class="form-control" style="width: 61px;"
                    value="{{ $this->dollar_total_cost($index) }}" >
        @else
            {{0.00}}
        @endif
    </td>
    {{-- ++++++++++++++++++++ Task : اجمالي التكاليف بالدينار  ++++++++++++++++++++++ --}}
    <td>
        @if(isset($product['quantity']) &&( isset($product['purchasing_price']) ))
            <span class="cost">
                {{$this->total_cost($index) }}
            </span>
            <input type="hidden" class="form-control" style="width: 61px;"
                    value="{{ $this->total_cost($index) }}" >
        @else
            {{0.00}}
        @endif
    </td>
    {{-- +++++++++++++++++++++ column 4 : current_stock +++++++++++++++++++++ --}}
    <td>
        <input type="text" class="form-control current_stock" style="width: 65px;" required disabled
            wire:model="items.{{ $index }}.current_stock" >
    </td>
    {{-- +++++++++++++++++ delete button +++++++++++++++++ --}}
    <td  class="text-center">
        <div class="btn btn-sm btn-danger py-0 px-1"
             wire:click="delete_product({{ $index }})">
            <i class="fa fa-trash"></i>
        </div>
    </td>
</tr>


<tr>
    {{-- ++++++++++++++ column 1 : index  ++++++++++++++ --}}
    <td>
        {{$index+1}}
    </td>
    {{-- ++++++++++++++ column 2 : product_name ++++++++++++++ --}}
    <td>
        @if($product['show_product_data'])
            {{ $product['product']['name'] }}
            {{-- <input type="hidden" class="form-control quantity" style="width: 61px;" required
               wire:model="items.{{ $index }}.product_id" > --}}
        @endif
    </td>
    {{-- +++++++++++++++++++++ column 3 : quantity +++++++++++++++++++++ --}}
    <td>
        <input type="text" class="form-control quantity" style="width: 61px;" required
               wire:model="items.{{ $index }}.quantity" wire:change="changeCurrentStock({{ $index }})">
        @error('items.{{ $index }}.quantity')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    {{-- +++++++++++++++++++++ column 4 : سعر الشراء بالدولار  +++++++++++++++++++++ --}}
    {{-- <td>
        <input type="text" class="form-control" style="width: 61px;" value="{{ $stock_lines->purchase_price }}" required
                wire:model="items.{{ $index }}.dollar_purchase_price">
        @error('purchase_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td> --}}
    {{-- +++++++++++++++++++++ column 5 : سعر البيع بالدولار +++++++++++++++++++++ --}}
    <td>
        <input type="text" class="form-control"
                wire:model="items.{{ $index }}.dollar_selling_price" style="width: 100%;"
                wire:keyup="convert_dinar_price({{ $index }})" required>
        @error('selling_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    {{-- +++++++++++++++++++++ column 6 : المجموع الفرعي بالدولار +++++++++++++++++++++ --}}
    {{-- <td>
        @if(isset($product['quantity']) &&  (isset($product['dollar_purchase_price']) || isset($product['purchase_price'])))
            <span class="sub_total_span" >
                {{$this->dollar_sub_total($index)}}
            </span>
        @endif
    </td> --}}
    {{-- +++++++++++++++++++++ column 7 : سعر الشراء  +++++++++++++++++++++ --}}
    {{-- <td>
        <input type="text" class="form-control" value="00000" wire:model="items.{{ $index }}.purchase_price" style="width: 61px;"  required>
        @error('purchase_price')
            <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td> --}}
    {{-- ++++++++++++++++++++ column 8 : سعر البيع بالدينار ++++++++++++++++++++++ --}}
    <td>
        <input type="text" class="form-control" id="items.{{ $index }}.selling_price"
                wire:model="items.{{ $index }}.selling_price"
                wire:keyup="convert_dollar_price({{ $index }})"
                style="width: 100%;"  required>
        @error('selling_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    {{-- <td>
        @if(isset($product['quantity']) &&( isset($product['dollar_selling_price']) || isset($product['selling_price'])))
            <span class="dollar_cost">
                {{ $this->convert_dinar_price($index) }}
            </span>
        @else
            {{0.00}}
        @endif
    </td> --}}
    {{-- ++++++++++++++++++++ column 9 : اجمالي التكاليف بالدينار ++++++++++++++++++++++ --}}
    {{-- <td>
        @if(isset($product['quantity']) && (isset($product['purchase_price']) || isset($product['dollar_purchase_price'])))
            <span class="sub_total_span" >
                {{$this->sub_total($index)}}
            </span>
        @endif
    </td> --}}
    {{-- ++++++++++++++++++++ التكلفة بالدولار ++++++++++++++++++++++ --}}
    {{-- <td>
        @if(isset($product['quantity']) &&( isset($product['dollar_purchase_price']) || isset($product['purchase_price'])))
            <span class="dollar_cost">
                {{ $this->dollar_cost($index) }}
            </span>
        @else
            {{0.00}}
        @endif
    </td> --}}
    {{-- ++++++++++++++++++++ Task : اجمالي التكاليف بالدولار  ++++++++++++++++++++++ --}}
    <td>
        @if(isset($product['quantity']) &&( isset($product['dollar_selling_price']) ))
            <span class="dollar_total_cost">
                {{$this->dollar_total_cost($index) }}
            </span>
        @else
            {{0.00}}
        @endif
    </td>
    {{-- ++++++++++++++++++++ Task : اجمالي التكاليف بالدينار  ++++++++++++++++++++++ --}}
    <td>
        @if(isset($product['quantity']) &&( isset($product['selling_price']) ))
            <span class="cost">
                {{$this->total_cost($index) }}
            </span>
        @else
            {{0.00}}
        @endif
    </td>
    {{-- ++++++++++++++++++++ اجمالي التكاليف بالدينار++++++++++++++++++++++ --}}
    {{-- <td>
        @if(isset($product['quantity']) &&( isset($product['selling_price']) ))
            <span class="total_cost">
                {{$this->total_cost($index) }}
            </span>
        @else
            {{0.00}}
        @endif
    </td> --}}

    {{-- +++++++++++++++++ delete button +++++++++++++++++ --}}
    <td  class="text-center">
        <div class="btn btn-sm btn-danger py-0 px-1"
             wire:click="delete_product({{ $index }})">
            <i class="fa fa-trash"></i>
        </div>
    </td>
</tr>


@foreach ($stocklines as $product)
    <tr class="product_row">
        {{-- ++++++++++++++++ sku : اسم ال ++++++++++++++++ --}}
        <td style="width: 20%">
            <span >{{$product->product->name}}</span>
            <input  type="hidden"
                    name="transaction_stock_line[{{$loop->index}}][transaction_stock_line_id]"
                    class="transaction_stock_line_id" value="{{$product->id}}"
                    wire:model = "transaction_stock_line_id" >

            <input  type="hidden" name="transaction_stock_line[{{$loop->index}}][product_id]"
                    class="product_id" value="{{$product->product_id}}">
        </td>
        {{-- ++++++++++++++++ sku : الباركود ++++++++++++++++ --}}
        <td style="width: 20%" title="{{__('lang.sku')}}">{{$product->variation->sku ?? ''}}</td>
        {{-- ++++++++++++++++ quantity : الكمية ++++++++++++++++ --}}
        <td>@if(isset($product->quantity)){{ preg_match('/\.\d*[1-9]+/', (string)$product->quantity) ? $product->quantity : @num_format($product->quantity)}}@else{{1}}@endif</td>
        {{-- ++++++++++++++++ return_quantity : الكمية المعٌاده ++++++++++++++++ --}}
        <td style="width: 15%">
            <div class="input-group">
                <input type="text" class="form-control return_quantity" required
                       wire:model="return_quantity.{{$loop->index}}"
                       wire:change="calculateTotals({{$loop->index}})" />
            </div>
        </td>
        {{-- ++++++++++++++++ sell_price : السعر ++++++++++++++++ --}}
        <td style="width: 15%">
            <input type="text" class="form-control sell_price"
                   wire:model="stocklines.{{$loop->index}}.sell_price" disabled />
        </td>
        {{-- +++++++++++++++++++++ final_total : المجموع الفرعي	+++++++++++++++++++  --}}
        <td style="width: 15%">
            <div class="input-group">
                <input type="text" class="form-control final_total" required
                       wire:model="final_total.{{$loop->index}}" disabled />
            </div>
        </td>
    </tr>
@endforeach

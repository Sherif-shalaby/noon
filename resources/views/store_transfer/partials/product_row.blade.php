<tr>
    <td>
        {{$index+1}}
    </td>
    <td title="{{__('lang.products')}}">
        {{--        @if($product['show_product_data'])--}}
        {{ $product['product']['name'] }}
        {{--        @endif--}}
    </td>
    <td title="{{__('lang.sku')}}">
        {{--        @if($product['show_product_data'])--}}

        {{ $product['product']['sku'] }}
        {{--        @endif--}}
    </td>
    <td title="{{__('lang.quantity')}}">
        <input type="text" class="form-control quantity" style="width: 61px;" required
               wire:model="items.{{ $index }}.quantity" >
        @error('items.{{ $index }}.quantity')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td title="{{__('lang.unit')}}">
        @if(count($product['variations']) > 0)
            <div class="d-flex justify-content-center">
                <select name="items.{{$index}}.variation_id" id="unit_name" class="form-control select" style="width: 130px"
                        wire:model="items.{{ $index }}.variation_id" wire:change="changeUnit({{ $index }})">
                    <option value="" selected>{{__('lang.please_select')}}</option>
                    @foreach($product['variations'] as $variant)
                        @if(!empty($variant['unit_id']))
                            <option value="{{$variant['id']}}">{{$variant['unit']['name'] ?? ''}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        @else
            <span>@lang('lang.no_units')</span>
        @endif
        @error('items.'.$index.'.variation_id')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td title="{{__('lang.purchase_price')}} $">
        <input type="text" class="form-control" style="width: 61px;" readonly required
               wire:model="items.{{ $index }}.dollar_purchase_price">
        @error('items.'. $index.'.dollar_purchase_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
{{--    <td title="{{__('lang.selling_price')}} $">--}}
{{--        <input type="text" class="form-control"  readonly style="width: 61px;" required--}}
{{--               wire:model="items.{{ $index }}.dollar_selling_price">--}}
{{--        @error('items.'.$index.'.dollar_selling_price')--}}
{{--        <span class="error text-danger">{{ $message }}</span>--}}
{{--        @enderror--}}
{{--    </td>--}}
    <td title="{{__('lang.sub_total')}} $">
        @if(!empty($product['quantity']) &&  (!empty($product['dollar_purchase_price']) || !empty($product['purchase_price'])))
            <span class="sub_total_span" >
{{--                    {{$this->dollar_sub_total($index)}}--}}
                {{$product['dollar_sub_total']}}
                </span>
        @endif
    </td>
    {{--    @endif--}}
    <td title="{{__('lang.purchase_price')}}">
        <input type="text" class="form-control" readonly wire:model="items.{{ $index }}.purchase_price" style="width: 61px;"  required>
        @error('items.'.$index.'.purchase_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
{{--    <td title="{{__('lang.selling_price')}}">--}}
{{--        <input type="text" class="form-control " readonly wire:model="items.{{ $index }}.selling_price" style="width: 61px;" required>--}}
{{--        @error('items.'.$index.'.selling_price')--}}
{{--        <span class="error text-danger">{{ $message }}</span>--}}
{{--        @enderror--}}
{{--    </td>--}}
    <td title="{{__('lang.sub_total')}}">
        @if(!empty($product['quantity']) && (!empty($product['purchase_price']) || !empty($product['dollar_purchase_price'])))
            <span class="sub_total_span" >
{{--                {{$this->sub_total($index)}}--}}
                {{$product['sub_total']}}
            </span>
        @endif
    </td>
    <td title="{{__('lang.new_stock')}}">
        <span class="new_stock">
            {{$product['total_stock'] }}
        </span>
    </td>
    <td title="{{__('lang.current_stock')}}">
        <span class="current_stock">
            {{$product['quantity_available'] }}
        </span>
    </td>
    <td  title="{{__('lang.action')}}" class="text-center">
        <div class="btn btn-sm btn-danger py-0 px-1"
             wire:click="delete_product({{ $index }})">
            <i class="fa fa-trash"></i>
        </div>
    </td>
</tr>

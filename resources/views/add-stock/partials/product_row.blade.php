<tr>
    
    <td>
        {{(float)$index+1}}
    </td>
    <td>
        <div class="col-md-2">
            {{-- <label for="invoice_currency">@lang('lang.invoice_currency') :*</label> --}}
            {!! Form::select('invoice_currency', $selected_currencies, null,
                ['class' => 'form-control select','placeholder' => __('lang.please_select'), 'data-live-search' => 'true',
                    'required', 'wire:model' => 'items.' . $index . '.used_currency',]) !!}
            @error('items.'.$index.'.used_currency')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>
    </td>
    <td title="{{__('lang.products')}}">
{{--        @if($product['show_product_data'])--}}
            {{-- @dd($product['product']) --}}
            {{ $product['product']['name'] }}
            <br>
            <span> {{ $product['product']['sku'] }}</span>
{{--        @endif--}}
    </td>
    <td>
        <div class="col-md-3">
             {!! Form::select('store_id', $stores, $store_id, ['class' => ' form-control select', 'data-live-search' => 'true', 'required', 'placeholder' => __('lang.please_select'),  'wire:model' => 'items.' . $index . '.store_id']) !!}
             @error('store_id')
             <span class="error text-danger">{{ $message }}</span>
             @enderror
         </div>
    </td>
    {{-- <td title="{{__('lang.sku')}}"> --}}
{{--        @if($product['show_product_data'])--}}

            {{-- {{ $product['product']['sku'] }} --}}
{{--        @endif--}}
    {{-- </td> --}}
   
    <td title="{{__('lang.unit')}}">
        @if(isset($product['variations']) && count($product['variations']) > 0)
            <div class="d-flex justify-content-center">
                <select name="items.{{$index}}.variation_id" class="form-control select ." style="width: 130px" wire:model="items.{{ $index }}.variation_id" wire:change="getVariationData({{ $index }})">
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
    <td title="{{__('lang.quantity')}}">
        <input type="text" class="form-control quantity" style="width: 61px;" required
               wire:model="items.{{ $index }}.quantity" wire:change="changeCurrentStock({{ $index }})">
        @error('items.{{ $index }}.quantity')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td title="{{__('lang.bonus_quantity')}}">
        <input type="text" class="form-control bonus_quantity" style="width: 61px;" placeholder="bonus_quantity"
               wire:model="items.{{ $index }}.bonus_quantity" wire:change="changeCurrentStock({{ $index }})">
        @error('items.{{ $index }}.bonus_quantity')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td title="{{__('lang.purchase_price')}}">
        <input type="text" class="form-control" wire:model="items.{{ $index }}.purchase_price" wire:change="convertPurchasePrice({{$index}})" style="width: 61px;"  required>
        {{-- <span>{{ $product['purchase_price_span'] }}</span> --}}
        <span>{{$product['dollar_purchase_price'] }}$</span>
        @error('items.'.$index.'.purchase_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    
    <td title="{{__('lang.sub_total')}}">
        @if(!empty($product['quantity']) && (!empty($product['purchase_price']) || !empty($product['dollar_purchase_price'])))
            <span class="sub_total_span" >
                {{$this->sub_total($index)}}
            </span>
        @endif
    </td>
    
{{--    <td title="{{__('lang.fill')}}">--}}

{{--    </td>--}}
{{--    <td title="{{__('lang.basic_unit')}}">--}}
{{--        <span>{{$product['unit']}}</span>--}}
{{--    </td>--}}
    <td>
        <div class="d-flex justify-content-between">
            <div class="input-group-prepend">
                {{-- <label for="fixed_fill_quantity_{{ $index }}">@lang('lang.fixed')</label> --}}
                <input type="text"  class="form-control" wire:model="items.{{ $index }}.discount_percent" style="width: 100px;"  placeholder="%">
            </div>

            <div class="input-group-prepend">
                {{-- <label for="percent_fill_quantity_{{ $index }}">%</label> --}}
                <input type="text"  class="form-control" wire:model="items.{{ $index }}.discount"  style="width: 100px;" placeholder="discount amount">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" wire:model="items.{{ $index }}.discount_on_bonus_quantity"   style="font-size: 0.75rem"
                            value="0">
                            {{-- wire:change="changePrice({{ $index }}, {{ $key }})"> --}}
                    <label class="custom-control-label" for="discount_from_original_price">@lang('lang.discount_on_bonus_quantity')</label>
                </div>
            </div>
        </div>
    </td>
    <td >
        <div class="d-flex justify-content-between">
            <div class="input-group-prepend">
                {{-- <label for="fixed_fill_quantity_{{ $index }}">@lang('lang.fixed')</label> --}}
                <input type="text"  class="form-control" wire:model="items.{{ $index }}.cash_discount" style="width: 100px;" placeholder="cash discount">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" wire:model="items.{{ $index }}.discount_dependency"   style="font-size: 0.75rem"
                            value="0">
                            {{-- wire:change="changePrice({{ $index }}, {{ $key }})"> --}}
                    <label class="custom-control-label" >@lang('lang.discount_dependency')</label>
                </div>
            </div>

            <div class="input-group-prepend">
                {{-- <label for="percent_fill_quantity_{{ $index }}">%</label> --}}
                <input type="text"  class="form-control" wire:model="items.{{ $index }}.seasonal_discount"  style="width: 100px;" placeholder="seasonal discount">
            </div>

            <div class="input-group-prepend">
                {{-- <label for="percent_fill_quantity_{{ $index }}">%</label> --}}
                <input type="text"  class="form-control" wire:model="items.{{ $index }}.annual_discount"  style="width: 100px;" placeholder="Annual discount">
            </div>
        </div>
    </td>

    <td title="{{__('lang.final_total')}}">
        @if(!empty($product['quantity']) && (!empty($product['purchase_price'])))
            <span class="final_total_span" >
                {{$this->sub_total($index)}}
            </span>
        @endif
    </td>

{{--    @if ($showColumn)--}}
        {{-- <td title="{{__('lang.purchase_price')}} $">
            <input type="text" class="form-control" style="width: 61px;" required
                   wire:model="items.{{ $index }}.dollar_purchase_price" wire:change="changeFilling({{$index}})">
            <span>{{ $product['dollar_purchase_price_span'] }}</span>
            @error('items.'. $index.'.dollar_purchase_price')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </td>
        <td title="{{__('lang.selling_price')}} $">
            <input type="text" class="form-control"  style="width: 61px;" required
                   wire:model="items.{{ $index }}.dollar_selling_price">
            <span>{{ $product['dollar_selling_price_span'] }}</span>
            @error('items.'.$index.'.dollar_selling_price')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </td>
        <td title="{{__('lang.sub_total')}} $">
            @if(!empty($product['quantity']) &&  (!empty($product['dollar_purchase_price']) || !empty($product['purchase_price'])))
                <span class="sub_total_span" >
                    {{$this->dollar_sub_total($index)}}
                </span>
            @endif
        </td> --}}
{{--    @endif--}}
   
    {{-- <td title="{{__('lang.selling_price')}}">
        <input type="text" class="form-control " wire:model="items.{{ $index }}.selling_price" style="width: 61px;" required>
        <span>{{ $product['selling_price_span'] }}</span>
        @error('items.'.$index.'.selling_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td> --}}
 
    {{-- <td title="{{__('lang.size')}} ">
        <span class="size">
            {{ $product['size'] }}
        </span>
    </td>
    <td title="{{__('lang.total_size')}}">
       @if(!empty($product['quantity']))
            <span class="total_size">
                {{$this->total_size($index) }}
            </span>
        @else
           {{0.00}}
        @endif
    </td>
    <td title="{{__('lang.weight')}}">
        <span class="weight">
            {{ $product['weight'] }}
        </span>
    </td>
    <td title="{{__('lang.total_weight')}}">
       @if(!empty($product['quantity']))
            <span class="total_weight">
                {{$this->total_weight($index) }}
            </span>
        @else
           {{0.00}}
        @endif
    </td>
{{--    @if ($showColumn)--}}
        {{-- <td title="{{__('lang.cost')}} $">
            @if(!empty($product['quantity']) &&( !empty($product['dollar_purchase_price']) || !empty($product['purchase_price'])))
                <span class="dollar_cost">
                    {{ $this->dollar_cost($index) }}
                </span>
            @else
                {{0.00}}
            @endif
        </td>
        <td title="{{__('lang.total_cost')}} $">
            @if(!empty($product['quantity']) &&( !empty($product['dollar_purchase_price']) || !empty($product['purchase_price'])))
                <span class="dollar_total_cost">
                    {{$this->dollar_total_cost($index) }}
                </span>
            @else
                {{0.00}}
            @endif
        </td>
{{--    @endif--}}
    {{-- <td title="{{__('lang.cost')}}">
        @if(!empty($product['quantity']) &&( !empty($product['purchase_price']) ||  !empty($product['dollar_purchase_price'])))
            <span class="cost">
                {{$this->cost($index) }}
            </span>
        @else
            {{0.00}}
        @endif
    </td>
    <td title="{{__('lang.total_cost')}}">
        @if(!empty($product['quantity']) &&( !empty($product['purchase_price']) ||  !empty($product['dollar_purchase_price'])))
            <span class="total_cost">
                {{$this->total_cost($index) }}
            </span>
        @else
            {{0.00}}
        @endif
    </td> --}} 
    <td title="{{__('lang.new_stock')}}">
        <span class="current_stock_text">
            {{$product['total_stock'] }}
        </span>
    </td>
    <td title="{{__('lang.change_current_stock')}}">
       <input type="checkbox" name="change_price"  wire:model="items.{{ $index }}.change_price_stock">
    </td>
    <td  title="{{__('lang.action')}}" class="text-center">
        <div class="btn btn-sm btn-danger py-0 px-1"
             wire:click="delete_product({{ $index }})">
            <i class="fa fa-trash"></i>
        </div>
    </td>
    <td>
        <button class="btn btn btn-primary" wire:click="add_product({{$product['product']['id']}},'unit',{{$index}},1)" type="button">
            <i class="fa fa-plus"></i> @lang('lang.add_new_unit')
        </button>
    </td>
</tr>

@foreach( $product['prices'] as $key => $price)
    <tr>
        <td></td>
        <td title="{{__('lang.unit')}}">
            @if(count($product['variations']) > 0)
                <div class="d-flex justify-content-center">
                    <select name="items.{{$index}}.variation_id" class="form-control select ." style="width: 130px" wire:model="items.{{ $index }}.variation_id" wire:change="getVariationData({{ $index }})">
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
        <td>
            {!! Form::label('price' ,__('lang.quantity')) !!}
            <input type="text" class="form-control discount_quantity" wire:model="items.{{$index}}.prices.{{$key}}.discount_quantity" wire:change="changePrice({{ $index }}, {{ $key }})" placeholder = "{{__('lang.quantity')}}" >
        </td>
        <td colspan="2">
            {!! Form::label('price_category' ,__('lang.price_category')) !!}
            <input type="text" class="form-control price_category" name="price_category" wire:model="items.{{$index}}.prices.{{$key}}.price_category" maxlength="6" >
        </td>
        {{-- <td colspan="1">
            {!! Form::label('b_qty',__('lang.b_qty')) !!}
            <input type="text" class="form-control bonus_quantity" wire:model="items.{{$index}}.prices.{{$key}}.bonus_quantity" wire:change="changePrice({{ $index }}, {{ $key }})" placeholder = "{{__('lang.b_qty')}}" >
        </td> --}}
        <td colspan="2">
            {!! Form::label('price_type' ,__('lang.type')) !!}
            {!! Form::select('items.'.$index.'.prices.'.$key.'.price_type', ['fixed'=>__('lang.fixed'),'percentage'=>__('lang.percentage')], null, [
                'class' => ' form-control price_type',
//                'data-index' =>$index,
                'placeholder' => __('lang.please_select'),
                'wire:model' => 'items.'.$index.'.prices.'.$key.'.price_type',
                'wire:change' => 'changePrice(' .$index.','.$key.')',
            ]) !!}
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="discount_from_original_price" id="discount_from_original_price" style="font-size: 0.75rem"
                        @if( !empty($discount_from_original_price) && $discount_from_original_price == '1' ) checked @endif
                        wire:change="changePrice({{ $index }}, {{ $key }})">
                <label class="custom-control-label" for="discount_from_original_price">@lang('lang.discount_from_original_price')</label>
            </div>
            @error('items.'.$index.'.prices.'.$key.'.price_type')
            <br>
            <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </td>
        <td>
            {!! Form::label('price' ,!empty($price['price_type'])&&$price['price_type'] == 'fixed' ? __('lang.amount') : __('lang.percent')) !!}
            <input type="text" name="price" class="form-control price" wire:model="items.{{$index}}.prices.{{$key}}.price" wire:change="changePrice({{ $index }}, {{ $key }})" placeholder = "{{!empty($price['price_type'])&&$price['price_type'] == 'fixed' ? __('lang.amount') : __('lang.percent')}}" >
{{--            <p>--}}
{{--                {{!empty($price['price_type'])&&$price['price_type'] == 'fixed' ? __('lang.amount'): __('lang.percent')}}:{{$this->items[$index]['prices'][$key]['dinar_price']??''}}--}}
{{--            </p>--}}
        </td>
        <td colspan="2">
            {!! Form::label('' ,__('lang.price')) !!}
            <input type="text" name="" class="form-control price" wire:model="items.{{$index}}.prices.{{$key}}.price_after_desc" placeholder = "{{__('lang.price')}}" >
{{--            <p>--}}

{{--                {{__('lang.price')}}:{{$this->items[$index]['prices'][$key]['dinar_price_after_desc']??''}}--}}
{{--            </p>--}}
        </td>
        <td colspan="2">
            {!! Form::label('total_price' , __('lang.total_price')) !!}
            <input type="text" name="total_price" class="form-control total_price" wire:model="items.{{$index}}.prices.{{$key}}.total_price" placeholder = "{{__('lang.total_price')}}" >
{{--            <p>--}}
{{--                {{__('lang.total_price')}}:{{$this->items[$index]['prices'][$key]['dinar_total_price']??''}}--}}
{{--            </p>--}}
        </td>
        <td colspan="2">
            {!! Form::label('piece_price' , __('lang.piece_price')) !!}
            <input type="text" name="piece_price" class="form-control piece_price" wire:model="items.{{$index}}.prices.{{$key}}.piece_price" placeholder = "{{__('lang.total_price')}}" >
{{--            <p>--}}
{{--                {{ __('lang.piece_price')}}:{{$this->items[$index]['prices'][$key]['dinar_piece_price']??''}}--}}
{{--            </p>--}}
        </td>

        <td colspan="2">
            {!! Form::label('customer_type',__('lang.customer_type')) !!}
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
                <button  class="btn btn-sm btn-danger" wire:click="delete_price_raw({{ $index }},{{ $key }})">
                    <i class="fa fa-trash"></i>
                </button>
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

<tr>
    <td>
        {{$index+1}}
    </td>
    <td>
        <input type="text" class="form-control sku" wire:model="rows.{{ $index }}.sku" style="width: 150px;" required >
        @error('rows.'.$index.'.sku')
        <br>
            <label class="text-danger error-msg">{{ $message }}</label>
        @enderror
    </td>
    <td>
        <input type="text" class="form-control quantity" wire:change="calculateTotalQuantity()"  wire:model="rows.{{ $index }}.quantity" style="width: 100px;" required >
        @error('quantity')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td>
        <div class="d-flex justify-content-center">
            <select wire:model="rows.{{ $index }}.unit_id"  data-name='unit_id' data-index="{{$index}}" required class="form-control select2 unit_id{{$index}}" style="width: 100px;">
                <option value="">{{__('lang.please_select')}}</option>
                @foreach($units as $unit)
                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-primary btn-sm ml-2 add_unit_raw" data-toggle="modal" data-index="{{$index}}" data-target=".add-unit" href="{{route('units.create')}}"><i class="fas fa-plus"></i></button>
        </div>
    </td>
    <td>
        <input type="text" class="form-control unit_equal"  wire:model="rows.{{ $index }}.equal" style="width: 100px;" required >
    </td>
    <td class="d-flex justify-content-center">
        <select wire:model="rows.{{ $index }}.basic_unit_id" data-name='basic_unit_id' data-index="{{$index}}" required class="form-control select2 basic_unit_id{{$index}}" style="width: 100px;">
            <option value="">{{__('lang.please_select')}}</option>
            @foreach($units as $unit)
                <option value="{{$unit->id}}">{{$unit->name}}</option>
            @endforeach
        </select>
        <button type="button" class="btn btn-primary btn-sm ml-2 add_unit_raw" data-toggle="modal" data-index="{{$index}}" data-target=".add-unit" data-type="basic_unit" href="{{route('units.create')}}"><i class="fas fa-plus"></i></button>
    </td>
    <td>
        <div class="d-flex justify-content-between">
            <select class="custom-select " style="width:65px;font-size:10px;height:38px;" wire:model="rows.{{ $index }}.fill_type" wire:change="changeFilling({{$index}})">
                <option selected value="fixed">@lang('lang.fixed')</option>
                <option  value="percent">%</option>
            </select>
            <div class="input-group-prepend">
                <input type="text" class="form-control" wire:model="rows.{{ $index }}.fill_quantity" wire:change="changeFilling({{$index}})" style="width: 100px;" required>
            </div>

        </div>
    </td>
        <td>
            <input type="text" class="form-control" wire:model="rows.{{ $index }}.dollar_purchase_price" wire:change="changePurchasePrice({{$index}})" style="width: 100px;" required>
            @error('dollar_purchase_price')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </td>

        <td>
            <input type="text" class="form-control " wire:model="rows.{{ $index }}.dollar_selling_price" wire:change="changeSellingPrice({{$index}})" style="width: 100px;" required>
            @error('dollar_selling_price')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </td>
        <td>
            @if(isset($rows[$index]['quantity']) &&  (isset($rows[$index]['dollar_purchase_price']) || isset($rows[$index]['purchase_price'])))
                <span class="sub_total_span" >
                    {{$this->dollar_sub_total($index)}}
                </span>
            @endif
        </td>
    {{-- @endif --}}
    <td>
        <input type="text" class="form-control" wire:model="rows.{{ $index }}.purchase_price" style="width: 100px;"  required>
        @error('purchase_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td>
        <input type="text" class="form-control " wire:model="rows.{{ $index }}.selling_price" style="width: 100px;" required>
        @error('selling_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td>
        @if(isset($rows[$index]['quantity']) && (isset($rows[$index]['purchase_price']) || isset($dollar_purchase_price)))
            <span class="sub_total_span" >
                {{$this->sub_total($index)}}
            </span>
        @endif
    </td>
    <td>
        <span class="current_stock_text">
            {{$this->total_quantity($index) ?? 0}}
        </span>
    </td>
    <td  class="text-center">
        <div class="btn btn-sm btn-danger py-0 px-1 " wire:click="delete_product({{$index}})">
            <i class="fa fa-trash"></i>
        </div>
    </td>
</tr>
@foreach( $rows[$index]['prices'] as $key => $price)
    <tr>
        <td></td>
        <td>
            {!! Form::label('price_type' ,__('lang.type')) !!}
            {!! Form::select('price_type', ['fixed'=>__('lang.fixed'),'percentage'=>__('lang.percentage')], null, [
                 'id' => 'price_type',
                'class' => ' form-control price_type',
                'data-name' => 'price_type',
//                'data-index' =>$index,
                'placeholder' => __('lang.please_select'),
                'wire:model' => 'rows.'.$index.'.prices.'.$key.'.price_type',
            ]) !!}
            @error('rows.'.$index.'.prices.'.$key.'.price_type')
            <br>
            <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </td>
       <td>
           {!! Form::label('price_category' ,__('lang.price_category'),['style' => 'font-size: 10px;','class'=>'pt-2']) !!}
           <input type="text" class="form-control price_category" name="price_category" wire:model="rows.{{$index}}.prices.{{$key}}.price_category" maxlength="6" >
       </td>
        <td>
            {!! Form::label('price' ,__('lang.percent')) !!}
            <input type="text" name="price" class="form-control price" wire:model="rows.{{$index}}.prices.{{$key}}.price" wire:change="changePrice({{ $index }}, {{ $key }})" placeholder = "{{__('lang.percent')}}" >
        </td>
        <td>
            {!! Form::label('' ,__('lang.price')) !!}
            <input type="text" name="" class="form-control price" wire:model="rows.{{$index}}.prices.{{$key}}.price_after_desc" placeholder = "{{__('lang.price')}}" >
        </td>
        <td>
            {!! Form::label('price' ,__('lang.quantity')) !!}
            <input type="text" class="form-control discount_quantity" wire:model="rows.{{$index}}.prices.{{$key}}.discount_quantity" placeholder = "{{__('lang.quantity')}}" >

        </td>
        <td >
            {!! Form::label('b_qty',__('lang.b_qty')) !!}
            <input type="text" class="form-control bonus_quantity" wire:model="rows.{{$index}}.prices.{{$key}}.bonus_quantity" placeholder = "{{__('lang.b_qty')}}" >

        </td>
        <td colspan="2">
            {!! Form::label('customer_type',__('lang.customer_type')) !!}
            <select wire:model="rows.{{$index}}.prices.{{$key}}.price_customer_types" data-name='price_customer_types' data-index="{{$index}}" data-key="{{$key}}" class="form-control js-example-basic-multiple" multiple='multiple' placeholder="{{__('lang.please_select')}}">
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


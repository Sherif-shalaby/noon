    <tr>
        <td>
            {{$index+1}}
        </td>
        <td>
            <select wire:model="priceRow.{{ $index }}.price_type" data-name='price_type' data-index="{{$index}}" required class="form-control select2" style="width: 100px;">
                <option value="">{{__('lang.please_select')}}</option>
                    <option value="fixed">{{__('lang.fixed')}}</option>
                    <option value="percentage">{{__('lang.percentage')}}</option>
            </select>
            @error('priceRow.'.$index.'.price_type')
            <br>
                <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </td>
        <td>
            <input type="text" class="form-control price_category" wire:model="priceRow.{{ $index }}.price_category" maxlength="6" >

        </td>
        <td>
            <input type="text" class="form-control price" wire:model="priceRow.{{ $index }}.price" placeholder = "{{__('lang.price')}}" >

        </td>
        <td>
            <input type="text" class="form-control quantity" wire:model="priceRow.{{ $index }}.quantity" placeholder = "{{__('lang.quantity')}}" >

        </td>
        <td>
            <input type="text" class="form-control bonus_quantity" wire:model="priceRow.{{ $index }}.bonus_quantity" placeholder = "{{__('lang.bonus_quantity')}}" >

        </td>
        <td>
            <select wire:model="priceRow.{{ $index }}.price_customer_types" data-name='price_customer_types' data-index="{{$index}}" class="form-control js-example-basic-multiple" multiple='multiple' placeholder="{{__('lang.please_select')}}">
                @foreach($customer_types as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                @endforeach
            </select>
        </td>
        <td>
            <div class="btn btn-sm btn-danger py-0 px-1 " wire:click="delete_price_raw({{$index}})">
                <i class="fa fa-trash"></i>
            </div>
        </td>

    </tr>

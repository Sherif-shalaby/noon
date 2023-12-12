<tr>
    <td>
        {{ $index + 1 }}
    </td>
    <td>
        <input type="text" class="form-control sku" wire:model="rows.{{ $index }}.sku" style="width: 150px;"
            required>
        @error('rows.' . $index . '.sku')
            <br>
            <label class="text-danger error-msg">{{ $message }}</label>
        @enderror
    </td>

    <td>
        <div class="d-flex justify-content-center">
            <select wire:model="rows.{{ $index }}.unit_id" data-name='unit_id' data-index="{{ $index }}"
                required class="form-control select2 unit_id{{ $index }}" style="width: 100px;">
                <option value="">{{ $index == 0 ? __('lang.choose_big_unit') : __('lang.choose_small_unit') }}</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" {{ $rows[$index]['unit_id'] == $unit->id ? 'selected' : '' }}>
                        {{ $unit->name }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-primary btn-sm ml-2 add_unit_raw" data-toggle="modal"
                data-index="{{ $index }}" data-target=".add-unit" href="{{ route('units.create') }}"><i
                    class="fas fa-plus"></i></button>
        </div>
    </td>
    <td>
        <div style="width:200px">
            {{-- {!! Form::label('purchase_price', __('lang.purchase_price')) !!} --}}
            <div class="d-flex justify-content-center">
                <input type="text" class="form-control fill {{ $index == 0 ?'d-none':''}}" style="width:90px !important;"
                wire:model="rows.{{ $index }}.fill" placeholder = "{{ __('lang.fill') }}" wire:change="changeFill({{$index}})">
            
                <input type="text" class="form-control purchase_price" style="width:120px !important; "
                    wire:model="rows.{{ $index }}.purchase_price" placeholder = "{{ __('lang.purchase_price') }}">
                @error('rows.' . $index . '.purchase_price')
                    <br>
                    <label class="text-danger error-msg">{{ $message }}</label>
                @enderror
            </div>
        </div>
    </td>
    <td>
        <input type="text" class="form-control quantity" name="quantity"
            wire:model="rows.{{ $index }}.quantity" maxlength="6"
            placeholder="{{ __('lang.quantity') }}">
    </td>
    <td class="text-center">
        <div style="width:100px " class="{{$index=='0'?'d-none':''}}">
            <div class="btn btn-sm btn-danger py-0 px-1 " wire:click="delete_product({{ $index }})">
                <i class="fa fa-trash"></i>
            </div>
        </div>
    </td>
</tr>
@foreach ($rows[$index]['prices'] as $key => $price)
    <tr>
        <td></td>
        <td>
            <input type="text" class="form-control percent" name="percent" wire:change="changePercent({{$index}},{{$key}})"
                wire:model="rows.{{ $index }}.prices.{{ $key }}.percent" maxlength="6"
                placeholder="%">
        </td>
        <td>
            <input type="text" class="form-control dinar_sell_price"
                wire:model="rows.{{ $index }}.prices.{{ $key }}.dinar_increase"
                placeholder = "{{ __('lang.value').' '.$rows[$index]['prices'][$key]['customer_name'] }}" wire:change="changeIncrease({{$index}},{{$key}})">
            <span>{{$rows[$index]['prices'][$key]['dollar_increase']}} $</span>
            @error('rows.' . $index.'prices'. $key . '.dinar_increase')
                <br>
                <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </td>
       
        <td>
            <input type="text" class="form-control dinar_sell_price"
                wire:model="rows.{{ $index }}.prices.{{ $key }}.dinar_sell_price"
                placeholder = "{{ $rows[$index]['prices'][$key]['customer_name'] }}">
            <span>{{$rows[$index]['prices'][$key]['dollar_sell_price']}} $</span>
            @error('rows.' . $index.'prices'. $key . '.dinar_sell_price')
                <br>
                <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </td>
       
        
        
    </tr>
@endforeach

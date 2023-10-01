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
            <select wire:model="rows.{{ $index }}.unit_id" data-name='unit_id' id="unit_id" data-index="{{$index}}" required class="form-control select2" style="width: 100px;">
                <option value="">{{__('lang.please_select')}}</option>
                @foreach($units as $unit)
                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target=".add-unit" href="{{route('units.create')}}"><i class="fas fa-plus"></i></button>
        </div>
    </td>
    <td>
        <input type="text" class="form-control unit_equal"  wire:model="rows.{{ $index }}.equal" style="width: 100px;" required >
    </td>
    <td>
{{--        <div class="d-flex justify-content-center">--}}
            <select wire:model="rows.{{ $index }}.basic_unit_id" data-name='basic_unit_id' id="basic_unit_id" data-index="{{$index}}" required class="form-control select2" style="width: 100px;">
                <option value="">{{__('lang.please_select')}}</option>
                @foreach($units as $unit)
                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                @endforeach
            </select>
{{--            <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target=".add-unit" href="{{route('units.create')}}"><i class="fas fa-plus"></i></button>--}}
{{--        </div>--}}
    </td>
    <td>
        <div class="d-flex justify-content-between">
            <select class="custom-select " style="width:55px;" wire:model="rows.{{ $index }}.fill_type" wire:change="changeFilling({{$index}})">
                <option selected value="fixed">-</option>
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
    {{-- <td>
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitch{{$index}}" wire:model="rows.{{ $index }}.change_price_stock">
            <label class="custom-control-label" for="customSwitch{{$index}}"></label>
        </div>
    </td> --}}
    <td  class="text-center">
        <div class="btn btn-sm btn-danger py-0 px-1 " wire:click="delete_product({{$index}})">
            <i class="fa fa-trash"></i>
        </div>
    </td>
</tr>
<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>

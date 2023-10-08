<div class="d-flex flex-wrap justify-content-between align-items-center py-2 rounded-3 text-center"
    style="background-color: rgba(241, 241, 241, 0.439);">

    <div class=" d-inline-flex justify-content-center align-items-center text-white bg-primary"
        style="width: 30px;height: 30px; border-radius: 50%;">
        {{ $index + 1 }}
    </div>
    <div style="width: 150px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
        class=" px-0 d-flex justify-content-center align-items-center flex-column">

        <span class="mb-2">@lang('lang.sku')</span>

        <input type="text" style="width: 85%" class="mx-auto form-control sku" wire:model="rows.{{ $index }}.sku"
            required>
        @error('rows.' . $index . '.sku')
            <label class="text-danger error-msg">{{ $message }}</label>
        @enderror
    </div>

    <div style="width: 150px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
        class=" px-0 d-flex justify-content-center align-items-center flex-column">
        <span class="mb-2">@lang('lang.quantity')</span>
        <input type="text" class="form-control quantity" wire:change="calculateTotalQuantity()"
            wire:model="rows.{{ $index }}.quantity" style="width: 100px;" required>
        @error('quantity')
            <span class="error text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div style="width: 150px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
        class=" px-0 d-flex justify-content-center align-items-center flex-column">
        <span class="mb-2">@lang('lang.unit')</span>
        <div class="d-flex justify-content-center">
            <select wire:model="rows.{{ $index }}.unit_id" data-name='unit_id' data-index="{{ $index }}"
                required class="form-control select2 unit_id{{ $index }}" style="width: 100px;">
                <option value="">{{ __('lang.please_select') }}</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-primary btn-sm ml-2 add_unit_raw" data-toggle="modal"
                data-index="{{ $index }}" data-target=".add-unit" href="{{ route('units.create') }}"><i
                    class="fas fa-plus"></i></button>
        </div>
    </div>

    <div style="width: 150px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
        class=" px-0 d-flex justify-content-center align-items-center flex-column">
        <span class="mb-2">@lang('lang.fill_from_basic_unit')</span>
        <input type="text" class="form-control unit_equal" wire:model="rows.{{ $index }}.equal"
            style="width: 100px;" required>
    </div>

    <div style="width: 150px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
        class=" px-0 d-flex justify-content-center align-items-center flex-column">
        <span class="mb-2">@lang('lang.basic_unit')</span>
        <div class="d-flex justify-content-between align-items-center">

            <select wire:model="rows.{{ $index }}.basic_unit_id" data-name='basic_unit_id'
                data-index="{{ $index }}" required style=" width: fit-content"
                class="form-control select2 basic_unit_id{{ $index }}" style="">
                <option value="">{{ __('lang.please_select') }}</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-primary btn-sm ml-2 add_unit_raw" data-toggle="modal"
                data-index="{{ $index }}" data-target=".add-unit" data-type="basic_unit"
                href="{{ route('units.create') }}"><i class="fas fa-plus"></i></button>
        </div>
    </div>

    <div style="width: 150px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
        class=" px-0 d-flex justify-content-center align-items-center flex-column">
        <span class="mb-2">@lang('lang.to_get_sell_price')</span>
        <div class="d-flex justify-content-between">
            <select class="custom-select " style="width:55px;" wire:model="rows.{{ $index }}.fill_type"
                wire:change="changeFilling({{ $index }})">
                <option selected value="fixed">>@lang('lang.fixed')</option>
                <option value="percent">%</option>
            </select>
            <div class="input-group-prepend">
                <input type="text" class="form-control" wire:model="rows.{{ $index }}.fill_quantity"
                    wire:change="changeFilling({{ $index }})" style="width: 100px;" required>
            </div>

        </div>
    </div>


    <div style="width: 150px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
        class=" px-0 d-flex justify-content-center align-items-center flex-column">
        <span class="mb-2">@lang('lang.purchase_price')$</span>
        <input type="text" class="form-control" wire:model="rows.{{ $index }}.dollar_purchase_price"
            wire:change="changePurchasePrice({{ $index }})" style="width: 100px;" required>
        @error('dollar_purchase_price')
            <span class="error text-danger">{{ $message }}</span>
        @enderror
    </div>


    <div style="width: 150px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
        class=" px-0 d-flex justify-content-center align-items-center flex-column">
        <span class="mb-2">@lang('lang.selling_price')$</span>
        <input type="text" class="form-control " wire:model="rows.{{ $index }}.dollar_selling_price"
            wire:change="changeSellingPrice({{ $index }})" style="width: 100px;" required>
        @error('dollar_selling_price')
            <span class="error text-danger">{{ $message }}</span>
        @enderror
    </div>


    <div style="width: 150px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
        class=" px-0 d-flex justify-content-center align-items-center flex-column">
        <span class="mb-2">@lang('lang.sub_total') $</span>
        @if (isset($rows[$index]['quantity']) &&
                (isset($rows[$index]['dollar_purchase_price']) || isset($rows[$index]['purchase_price'])))
            <span class="sub_total_span">
                {{ $this->dollar_sub_total($index) }}
            </span>
        @endif
    </div>

    {{-- @endif --}}

    <div style="width: 150px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
        class=" px-0 d-flex justify-content-center align-items-center flex-column">
        <span class="mb-2">@lang('lang.purchase_price')</span>
        <input type="text" class="form-control" wire:model="rows.{{ $index }}.purchase_price"
            style="width: 100px;" required>
        @error('purchase_price')
            <span class="error text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div style="width: 150px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
        class=" px-0 d-flex justify-content-center align-items-center flex-column">
        <span class="mb-2">@lang('lang.selling_price')</span>
        <input type="text" class="form-control " wire:model="rows.{{ $index }}.selling_price"
            style="width: 100px;" required>
        @error('selling_price')
            <span class="error text-danger">{{ $message }}</span>
        @enderror
    </div>


    <div style="width: 150px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
        class=" px-0 d-flex justify-content-center align-items-center flex-column">
        <span class="mb-2">@lang('lang.sub_total')</span>
        @if (isset($rows[$index]['quantity']) && (isset($rows[$index]['purchase_price']) || isset($dollar_purchase_price)))
            <span class="sub_total_span">
                {{ $this->sub_total($index) }}
            </span>
        @endif
    </div>


    <div style="width: 150px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
        class=" px-0 d-flex justify-content-center align-items-center flex-column">
        <span class="mb-2">@lang('lang.new_stock')</span>
        <span class="current_stock_text">
            {{ $this->total_quantity($index) ?? 0 }}
        </span>
    </div>


    <div style="width: 150px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
        class=" px-0 d-flex justify-content-center align-items-center flex-column">
        <div class="btn btn-sm btn-danger py-0 px-1 " wire:click="delete_product({{ $index }})">
            <i class="fa fa-trash"></i>
        </div>
    </div>

    <div style="width: 100%" class="accordion mt-3 p-3" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#panelsStayOpen-collapse{{ $index }}" aria-expanded="true"
                    aria-controls="panelsStayOpen-collapse{{ $index }}"
                    wire:click="stayShow({{ $index }})">
                    Sales
                </button>
            </h2>
            <div id="panelsStayOpen-collapse{{ $index }}"
                class="accordion-collapse collapse @if ($rows[$index]['show_prices']) show @endif">
                @foreach ($rows[$index]['prices'] as $key => $price)
                    <div
                        class="accordion-body d-flex flex-wrap justify-content-between align-items-center py-2 rounded-3 text-center">
                        <div
                            style="width: 120px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px">
                            {!! Form::label('price_type', __('lang.type')) !!}
                            {!! Form::select('price_type', ['fixed' => __('lang.fixed'), 'percentage' => __('lang.percentage')], null, [
                                'id' => 'price_type',
                                'class' => ' form-control price_type',
                                'data-name' => 'price_type',
                                // 'data-index' => $index,
                                'placeholder' => __('lang.please_select'),
                                'wire:model' => 'rows.' . $index . '.prices.' . $key . '.price_type',
                            ]) !!}
                            @error('rows.' . $index . '.prices.' . $key . '.price_type')
                                <br>
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                        </div>


                        <div
                            style="width: 120px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;">
                            {!! Form::label('price_category', __('lang.price_category'), ['style' => 'font-size: 10px;', 'class' => 'pt-2']) !!}
                            <input type="text" class="form-control price_category" name="price_category"
                                wire:model="rows.{{ $index }}.prices.{{ $key }}.price_category"
                                maxlength="6">
                        </div>


                        <div
                            style="width: 120px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;">
                            {!! Form::label('price', __('lang.percent')) !!}
                            <input type="text" name="price" class="form-control price"
                                wire:model="rows.{{ $index }}.prices.{{ $key }}.price"
                                wire:change="changePrice({{ $index }}, {{ $key }})"
                                placeholder="{{ __('lang.percent') }}">
                        </div>

                        <div
                            style="width: 120px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;">
                            {!! Form::label('', __('lang.price')) !!}
                            <input type="text" name="" class="form-control price"
                                wire:model="rows.{{ $index }}.prices.{{ $key }}.price_after_desc"
                                placeholder="{{ __('lang.price') }}">

                        </div>

                        <div
                            style="width: 120px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;">
                            {!! Form::label('price', __('lang.quantity')) !!}
                            <input type="text" class="form-control discount_quantity"
                                wire:model="rows.{{ $index }}.prices.{{ $key }}.discount_quantity"
                                placeholder="{{ __('lang.quantity') }}">

                        </div>

                        <div
                            style="width: 120px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;">
                            {!! Form::label('b_qty', __('lang.b_qty')) !!}
                            <input type="text" class="form-control bonus_quantity"
                                wire:model="rows.{{ $index }}.prices.{{ $key }}.bonus_quantity"
                                placeholder="{{ __('lang.b_qty') }}">


                        </div>


                        <div
                            style="width: 120px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;">
                            {!! Form::label('customer_type', __('lang.customer_type')) !!}
                            <select
                                wire:model="rows.{{ $index }}.prices.{{ $key }}.price_customer_types"
                                data-name='price_customer_types' data-index="{{ $index }}"
                                data-key="{{ $key }}" class="form-control js-example-basic-multiple"
                                multiple='multiple' style="border: 2px solid gray"
                                placeholder="{{ __('lang.please_select') }}">
                                @foreach ($customer_types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div style="width: 120px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;"
                            class="d-flex justify-content-around align-items-center">
                            <button type="button" class="btn btn-sm btn-primary"
                                wire:click="addPriceRow({{ $index }})">
                                <i class="fa fa-plus"></i>
                            </button>
                            @if ($key > 0)
                                <button class="btn btn-sm btn-danger"
                                    wire:click="delete_price_raw({{ $index }},{{ $key }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

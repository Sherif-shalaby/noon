<div class="d-flex justify-content-between align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif @if ($index % 2 == 0) bg-white @else bg-dark-gray @endif"
    style="overflow-x: auto;">

    <div style="width: 20px;height: 20px;background-color: #596fd7;border-radius:50%;color: white"
        class="d-flex justify-content-center align-items-center">
        {{ $i }}
    </div>

    <div class="d-flex">
        <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column justify-content-center align-items-center pl-1 mx-1 mt-1"
            style="width: 40px;">
            {{-- <div title="{{ __('lang.action') }}" class="text-center"> --}}
            <div class="btn btn-sm btn-danger py-0 px-1" wire:click="delete_product({{ $index }})">
                <i class="fa fa-trash"></i>
            </div>
            {{-- </div> --}}
        </div>
        <div
            class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1 mx-1 mt-1">
            <button class="btn btn-primary" style="font-weight: 500;font-size: 12px"
                wire:click="addStoreRow({{ $index }})" type="button">
                <i class="fa fa-plus"></i> @lang('lang.add_new_unit')
            </button>
        </div>
    </div>
</div>


<div class="d-flex justify-content-start align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif @if ($index % 2 == 0) bg-white @else bg-dark-gray @endif"
    style="overflow-x: auto">
    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        {{-- ++++++++++++++++ product name ++++++++++++++++ --}}
        <div class=" animate__animated animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
            style="width: 100px;min-height: 60px">
            <label for="invoice_currency"
                class="mb-0 @if (app()->isLocale('ar')) d-block text-end mx-2 @else  mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.invoice_currency') }}</label>
            {{-- <label for="invoice_currency" class="mb-0">@lang('lang.invoice_currency') *</label> --}}
            <div class="input-wrapper" style="width: 100%">
                {!! Form::select('invoice_currency', $selected_currencies, null, [
                    'class' => 'form-select',
                    'placeholder' => __('lang.choose_currency'),
                    'data-live-search' => 'true',
                    'required',
                    'wire:model' => 'items.' . $index . '.used_currency',
                ]) !!}
            </div>
            @error('items.' . $index . '.used_currency')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="animate__animated  animate__bounceInLeft d-flex flex-column justify-content-center align-items-center mr-1"
            style="font-size: 12px;font-weight: 500;min-height: 60px;min-width: 70px;">
            <span class="text-center">
                {{ $product['product']['name'] }}
            </span>
            <span class="text-center">
                {{ $product['product']['sku'] }}
            </span>

        </div>

        <div class="animate__animated  animate__bounceInLeft d-flex flex-column store_drop_down  @if (app()->isLocale('ar')) align-items-end  @else align-items-start @endif mr-1 "
            style="width: 120px;min-height: 60px">
            <label for="store"
                class="mb-0 @if (app()->isLocale('ar')) d-block text-end mx-2 @else  mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.store') }}</label>
            <div class="input-wrapper" style="width: 100% !important">
                {!! Form::select('store_id', $stores, $store_id, [
                    'class' => ' form-select store_id' . $index,
                    'data-live-search' => 'true',
                    'required',
                    'placeholder' => __('lang.please_select'),
                    'style' => 'width:70% !important',
                    'wire:model' => 'items.' . $index . '.store_id',
                ]) !!}

                <button type="button"
                    class="add-button d-flex justify-content-center align-items-center createStoreModal"
                    data-toggle="modal" data-index="{{ $index }}" data-target="#createStoreModal">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            @error('store_id')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class=" animate__animated  animate__bounceInLeft d-flex flex-column store_drop_down  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
            style="width: 100px;min-height: 60px;">
            <label for="unit"
                class="mb-0 @if (app()->isLocale('ar')) d-block text-end mx-2 @else  mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.unit') }}</label>
            @if (isset($product['variations']) && count($product['variations']) > 0)
                <div class="input-wrapper" style="width: 100%!important">
                    <select name="items.{{ $index }}.variation_id" class="form-select "
                        wire:model="items.{{ $index }}.variation_id"
                        wire:change="getVariationData({{ $index }})">
                        <option value="" selected>{{ __('lang.please_select') }}</option>
                        @foreach ($product['variations'] as $variant)
                            @if (!empty($variant['unit_id']))
                                <option value="{{ $variant['id'] }}">{{ $variant['unit']['name'] ?? '' }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            @else
                <span>@lang('lang.no_units')</span>
            @endif
            @error('items.' . $index . '.variation_id')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>



        <div class="accordion d-flex justify-content-center mr-1 mb-2 align-items-center"
            id="accordionPanelsStayOpenExampleUnits{{ $index }}">
            <div class="accordion-item" style="border: none">
                <h2 class="accordion-header">
                    <button class="accordion-button p-1 btn btn-primary collapsed" style="color: white" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#panelsStayOpen-collapse{{ $index }}unit-details"
                        data-index="{{ $index }}" aria-expanded="true"
                        aria-controls="panelsStayOpen-collapse{{ $index }}unit-details"
                        wire:click="stayShowUnitDetails({{ $index }})">
                        <span class="arrow">
                            @if ($product['show_unit_details'])
                                <i class="fas fa-arrow-right" style="font-size: 0.8rem"></i>
                            @else
                                <i class="fas fa-arrow-left" style="font-size: 0.8rem"></i>
                            @endif
                        </span>
                    </button>
                </h2>
            </div>
        </div>



        <div class="animate__animated   animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
            style="width: 80px;min-height: 60px">

            <label for="quantity"
                class="mb-0 @if (app()->isLocale('ar')) d-block text-end mx-2 @else  mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.quantity') }}</label>

            <input type="text" class="form-control quantity  initial-balance-input width-full" required
                wire:model="items.{{ $index }}.quantity" wire:change="changeCurrentStock({{ $index }})">
            @error('items.{{ $index }}.quantity')
                <span class="error text-danger">{{ $message }}</span>
            @enderror

        </div>

        <div class=" animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
            style="width: 80px;min-height: 60px">
            <label for="bonus_quantity"
                class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.b_qty') }}</label>
            <input type="text" class="form-control bonus_quantity initial-balance-input width-full"
                placeholder="{{ __('lang.b_qty') }}" wire:model="items.{{ $index }}.bonus_quantity"
                wire:change="changeCurrentStock({{ $index }})">
            @error('items.{{ $index }}.bonus_quantity')
                <span class="error text-danger">{{ $message }}</span>
            @enderror

        </div>

        <div id="panelsStayOpen-collapse{{ $index }}unit-details"
            class="accordion-collapse collapse @if ($product['show_unit_details']) show @endif">
            <div
                class="accordion-body p-0 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                @if (isset($units))
                    @foreach ($units as $unitName => $unitValue)
                        <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                            style="width: 80px;min-height: 60px">
                            {{-- Iterate through units and display each unit name and value as a span --}}

                            <label
                                class= "mb-0 @if (app()->isLocale('ar')) d-block text-center width-full @else text-center width-full @endif"
                                style='font-weight:500;font-size:12px!important;color:#888'>{{ $unitValue }}</label>

                            <input type="text" class="form-control quantity initial-balance-input width-full"
                                value="{{ $unitName }}" readonly>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
            style="width: 80px;min-height: 60px">
            <label for="purchase_price"
                class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.purchase_price') }}</label>
            <input type="text" class="form-control initial-balance-input width-full"
                wire:model="items.{{ $index }}.purchase_price"
                wire:change="convertPurchasePrice({{ $index }})" required>
            {{-- <span>{{ $product['purchase_price_span'] }}</span> --}}
            <span class="d-block width-full dollar-cell"
                style='font-weight:500;font-size:10px;color:#888;text-align: center'>{{ $product['dollar_purchase_price'] ?? 0 }}$</span>
            @error('items.' . $index . '.purchase_price')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>

        @if (!empty($product['quantity']) && (!empty($product['purchase_price']) || !empty($product['dollar_purchase_price'])))
            <div class="  animate__animated  animate__bounceInLeft d-flex flex-column justify-content-start @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                style="width: 90px;min-height: 60px">
                <label for="sub_total"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.sub_total') }}</label>
                <span class="sub_total_span mr-2">
                    {{ $this->sub_total($index) }}
                </span>
                <span class="sub_total_span dollar-cell mr-2">
                    {{ $this->dollar_sub_total($index) }}$
                </span>
            </div>
        @endif

        <div class=" animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
            style="width: 50px;min-height: 60px">
            <label for="%"
                class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>%</label>
            <input type="text" class="form-control initial-balance-input width-full mx-0"
                wire:model="items.{{ $index }}.discount_percent"
                wire:change="purchase_final({{ $index }})" placeholder="%">
        </div>

        <div class=" animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
            style="width: 100px;min-height: 60px">
            <label for="discount amount"
                class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>discount amount</label>
            <input type="text" class="form-control initial-balance-input width-full"
                wire:model="items.{{ $index }}.discount" wire:change="purchase_final({{ $index }})"
                placeholder="discount amount">
            <div class="custom-control custom-switch d-flex justify-content-center align-items-center">
                <input type="checkbox" class="custom-control-input" id="discount_on_bonus_quantity"
                    wire:model="items.{{ $index }}.discount_on_bonus_quantity"
                    wire:change="purchase_final({{ $index }})" style="font-size: 0.75rem" value="true">
                {{-- wire:change="changePrice({{ $index }}, {{ $key }})"> --}}
                <label class="custom-control-label"
                    style='font-weight:500;font-size:9px !important;color:#888;max-width: 70px'
                    for="discount_on_bonus_quantity">@lang('lang.discount_on_bonus_quantity')</label>
            </div>
        </div>

        <div class="accordion mr-1 mb-2 d-flex justify-content-center align-items-center"
            id="accordionPanelsStayOpenExampleDiscountDetails{{ $index }}">
            <div class="accordion-item" style="border: none">
                <h2 class="accordion-header">
                    <button class="accordion-button p-1 btn btn-primary collapsed" style="color: white"
                        type="button" data-bs-toggle="collapse"
                        data-bs-target="#panelsStayOpen-collapse{{ $index }}discount-details"
                        data-index="{{ $index }}" aria-expanded="true"
                        aria-controls="panelsStayOpen-collapse{{ $index }}discount-details"
                        wire:click="stayShowshowDiscountDetails({{ $index }})">
                        <span class="arrow">
                            @if ($product['show_discount_details'])
                                <i class="fas fa-arrow-right" style="font-size: 0.8rem"></i>
                            @else
                                <i class="fas fa-arrow-left" style="font-size: 0.8rem"></i>
                            @endif
                        </span>
                    </button>
                </h2>
            </div>
        </div>

        <div id="panelsStayOpen-collapse{{ $index }}discount-details"
            class="accordion-collapse collapse @if ($product['show_discount_details']) show @endif">
            <div
                class="accordion-body p-0 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                <div class=" animate__animated  animate__bounceInLeft d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                    style="width: 100px;min-height: 60px">
                    <label for="discount amount"
                        class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                        style='font-weight:500;font-size:10px;color:#888'>cash discount</label>
                    <input type="text" class="form-control initial-balance-input width-full"
                        wire:model="items.{{ $index }}.cash_discount"
                        wire:change="purchase_final({{ $index }})" placeholder="cash discount">
                    <div class="custom-control custom-switch d-flex justify-content-center align-items-center">
                        <input type="checkbox" class="custom-control-input" id="discount_dependency"
                            wire:model="items.{{ $index }}.discount_dependency"
                            wire:change="purchase_final({{ $index }})" style="font-size: 0.75rem"
                            value="true">
                        {{-- wire:change="changePrice({{ $index }}, {{ $key }})"> --}}
                        <label class="custom-control-label"
                            style='font-weight:500;font-size:9px !important;color:#888;max-width: 70px'
                            for="discount_dependency">@lang('lang.discount_dependency')</label>
                    </div>
                </div>

                <div class=" animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                    style="width: 100px;min-height: 60px">
                    <label for="discount amount"
                        class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                        style='font-weight:500;font-size:10px;color:#888'>seasonal discount</label>
                    <input type="text" class="form-control initial-balance-input width-full mx-0"
                        wire:model="items.{{ $index }}.seasonal_discount"
                        wire:change="purchase_final({{ $index }})" placeholder="seasonal discount">
                </div>

                <div class="animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                    style="width: 100px;min-height: 60px">
                    <label for="discount amount"
                        class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                        style='font-weight:500;font-size:10px;color:#888'>Annual discount</label>
                    <input type="text" class="form-control initial-balance-input width-full mx-0"
                        wire:model="items.{{ $index }}.annual_discount"
                        wire:change="purchase_final({{ $index }})" placeholder="Annual discount">
                </div>

            </div>
        </div>

        @if (!empty($product['quantity']) && !empty($product['purchase_price']))
            <div class=" animate__animated  animate__bounceInLeft d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                style="width: 120px;">
                <span class="final_total_span" aria-placeholder="final purchase">
                    {{ $this->purchase_final($index) }}
                </span>
                <span class="final_total_span" aria-placeholder="final purchase">
                    {{ $this->purchase_final_dollar($index) }} $
                </span>
            </div>
        @endif

        @if (!empty($product['quantity']) && !empty($product['purchase_price']))
            <div class="  animate__animated  animate__bounceInLeft d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                style="width: 120px;">
                <span class="final_total_span" aria-placeholder="final purchase for piece">
                    {{ $this->final_purchase_for_piece($index) }}
                </span>
                <span class="final_total_span" aria-placeholder="final purchase for piece">
                    {{ $this->dollar_final_purchase_for_piece($index) }} $
                </span>
            </div>
        @endif

    </div>
</div>



<div class="d-flex justify-content-start align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif @if ($index % 2 == 0) bg-white @else bg-dark-gray @endif"
    style="overflow-x: auto;">
    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        @foreach ($product['customer_prices'] as $key => $price)
            <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                style="width: 60px;min-height: 40px;">
                <input type="text" class="form-control initial-balance-input width-full mx-0 percent"
                    name="percent" wire:change="changePercent({{ $index }},{{ $key }})"
                    wire:model="items.{{ $index }}.customer_prices.{{ $key }}.percent"
                    maxlength="6" placeholder="%">
            </div>
            <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                style="width: 60px;min-height: 40px">
                <input type="text" class="form-control mb-0 initial-balance-input width-full mx-0 dinar_sell_price"
                    wire:model="items.{{ $index }}.customer_prices.{{ $key }}.dinar_increase"
                    placeholder = "{{ $items[$index]['customer_prices'][$key]['customer_name'] }}"
                    wire:change="changeIncrease({{ $index }},{{ $key }})">
                <span class="dollar-cell"
                    style='font-weight:500;font-size:10px;color:#888'>{{ $items[$index]['customer_prices'][$key]['dollar_increase'] }}
                    $</span>
                @error('items.' . $index . 'customer_prices' . $key . '.dinar_increase')
                    <label class="text-danger error-msg">{{ $message }}</label>
                @enderror
            </div>

            <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                style="width: 60px;min-height: 40px">
                <input type="text" class="form-control mb-0 initial-balance-input width-full mx-0 dinar_sell_price"
                    wire:model="items.{{ $index }}.customer_prices.{{ $key }}.dinar_sell_price"
                    placeholder = "{{ $items[$index]['customer_prices'][$key]['customer_name'] }}">
                <span class="dollar-cell"
                    style='font-weight:500;font-size:10px;color:#888'>{{ $items[$index]['customer_prices'][$key]['dollar_sell_price'] }}
                    $</span>
                @error('items.' . $index . 'customer_prices' . $key . '.dinar_sell_price')
                    <label class="text-danger error-msg">{{ $message }}</label>
                @enderror
            </div>
        @endforeach

        <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column justify-content-center align-items-center mt-1"
            style="width: 85px;background-color: #596fd7;color: white;border-radius: 6px">
            {{-- <div title="{{ __('lang.new_stock') }}"> --}}
            <label for="purchase_price"
                class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                style='font-weight:500;font-size:10px;color:white!important'>{{ __('lang.new_stock') }}</label>
            <span class="current_stock_text" style="font-weight: 600">
                {{ $product['total_stock'] }}
            </span>
            {{-- </div> --}}
        </div>

        <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-row justify-content-center @if (app()->isLocale('ar')) align-items-center @else align-items-start @endif pl-1  mt-1"
            style="width: 100px;">
            <label for="">{{ __('lang.change_current_stock') }}</label>
            {{-- <div title="{{ __('lang.change_current_stock') }}"> --}}
            <input type="checkbox" class="mx-2" name="change_price"
                wire:model="items.{{ $index }}.change_price_stock">
            {{-- </div> --}}
        </div>

    </div>
</div>

@include('add-stock.partials.accordions')


@foreach ($product['stores'] as $i => $store)
    <div class="d-flex justify-content-start align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif @if ($index % 2 == 0) bg-white @else bg-dark-gray @endif"
        style="overflow-x: auto">
        <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <div class="animate__animated  animate__bounceInLeft d-flex flex-column store_drop_down  @if (app()->isLocale('ar')) align-items-end  @else align-items-start @endif mr-1 "
                style="width: 120px;min-height: 60px;">
                <label for="store"
                    class="mb-0 @if (app()->isLocale('ar')) d-block text-end mx-2 @else  mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.store') }}</label>
                <div class="input-wrapper" style="width: 100% !important">
                    {!! Form::select('stores.' . $i . '.store_id', $stores, $store_id, [
                        'class' => 'form-select store_id' . $index . $i,
                        'data-live-search' => 'true',
                        'required',
                        'style' => 'width:70% !important',
                        'placeholder' => __('lang.please_select'),
                        'wire:model' => 'items.' . $index . '.stores.' . $i . '.store_id',
                    ]) !!}
                    <button type="button"
                        class="add-button d-flex justify-content-center align-items-center createStoreModal"
                        data-toggle="modal" data-key="{{ $i }}" data-index="{{ $index }}"
                        data-target="#createStoreModal">
                        <i class="fas fa-plus"></i>
                    </button>
                    @error('items.' . $index . '.stores' . $i . '.store_id')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="animate__animated  animate__bounceInLeft d-flex flex-column store_drop_down  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                style="width: 100px;min-height: 60px;">
                <label for="unit"
                    class="mb-0 @if (app()->isLocale('ar')) d-block text-end mx-2 @else  mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.unit') }}</label>
                @if (isset($store['variations']) && count($store['variations']) > 0)
                    <div class="input-wrapper" style="width: 100%!important">
                        <select name="items.{{ $index }}.stores.{{ $i }}.variation_id"
                            class="form-control select ."
                            wire:model="items.{{ $index }}.stores.{{ $i }}.variation_id"
                            wire:change="getVariationData({{ $index }},'stores',{{ $i }})">
                            <option value="" selected>{{ __('lang.please_select') }}</option>
                            @foreach ($store['variations'] as $variant)
                                @if (!empty($variant['unit_id']))
                                    <option value="{{ $variant['id'] }}">{{ $variant['unit']['name'] ?? '' }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                @else
                    <span>@lang('lang.no_units')</span>
                @endif
                @error('items.' . $index . '.stores' . $i . '.variation_id')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="animate__animated   animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                style="width: 80px;min-height: 60px">
                {!! Form::label('price', __('lang.quantity'), [
                    'style' => 'font-weight:700;font-size: 10px;',
                    'class' => 'mx-2 mb-0 d-block text-end ',
                ]) !!}
                <input type="text" class="form-control initial-balance-input width-full discount_quantity" required
                    wire:model="items.{{ $index }}.stores.{{ $i }}.quantity"
                    wire:change="changeCurrentStock({{ $index }},'stores',{{ $i }})">
                @error('items.{{ $index }}.quantity')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class=" animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                style="width: 80px;min-height: 60px">
                {!! Form::label('b_qty', __('lang.b_qty'), [
                    'style' => 'font-weight:500;font-size:10px;color:#888',
                    'class' => 'mx-2 mb-0 d-block text-end',
                ]) !!}
                <input style="height:30px;font-size:12px;" type="text"
                    class="form-control initial-balance-input width-full bonus_quantity" placeholder="bonus_quantity"
                    wire:model="items.{{ $index }}.stores.{{ $i }}.bonus_quantity"
                    wire:change="changeCurrentStock({{ $index }},'stores',{{ $i }})">
                @error('items.' . $index . '.stores' . $i . '.bonus_quantity')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>

            @if (isset($units))
                @foreach ($units as $unitName => $unitValue)
                    <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                        style="width: 80px;min-height: 60px">
                        {{-- Iterate through units and display each unit name and value as a span --}}

                        <label
                            class= "@if (app()->isLocale('ar')) d-block text-center mt-1  width-full mb-0 @else mt-1 text-center width-full mb-0 @endif"
                            style='font-weight:500;font-size:12px!important;color:#888'>{{ $unitValue }}</label>

                        <input type="text" class="form-control mt-0 quantity initial-balance-input width-full"
                            value="{{ $unitName }}" readonly>
                    </div>
                @endforeach
            @endif

            <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                style="width: 80px;min-height: 60px">
                <label for="purchase_price"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.purchase_price') }}</label>
                <input type="number" class="form-control initial-balance-input width-full mb-0"
                    wire:model="items.{{ $index }}.stores.{{ $i }}.purchase_price" required>
                <span class="d-block width-full dollar-cell"
                    style='font-weight:500;font-size:10px;color:#888;text-align: center'>{{ $items[$index]['stores'][$i]['dollar_purchase_price'] ?? 0 }}$</span>
                @error('items.' . $index . '.stores' . $i . '.purchase_price')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>

            @if (!empty($product['quantity']) && (!empty($product['purchase_price']) || !empty($product['dollar_purchase_price'])))
                <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1  mt-1"
                    style="width: 90px;min-height: 60px">
                    <label for="sub_total"
                        class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                        style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.sub_total') }}</label>
                    <span class="sub_total_span">
                        {{ $this->sub_total($index, 'stores', $i) }}
                    </span>
                    <span class="sub_total_span">
                        {{ $this->dollar_sub_total($index, 'stores', $i) }}$
                    </span>
                </div>
            @endif

            <div class=" animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                style="width: 50px;min-height: 60px">
                <label for="%"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>%</label>
                <input type="text" class="form-control initial-balance-input width-full m-0"
                    wire:model="items.{{ $index }}.stores.{{ $i }}.discount_percent"
                    wire:change="purchase_final({{ $index }},'stores',{{ $i }})"
                    placeholder="%">
            </div>

            <div class=" animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                style="width: 100px;min-height: 60px">
                <label for="discount amount"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>discount amount</label>
                <input type="text"class="form-control initial-balance-input width-full"
                    wire:model="items.{{ $index }}.stores.{{ $i }}.discount"
                    wire:change="purchase_final({{ $index }},'stores',{{ $i }})"
                    placeholder="discount amount">
                <div class="custom-control custom-switch  d-flex justify-content-center align-items-center">
                    <input type="checkbox" class="custom-control-input"
                        id="discount_on_bonus_quantity{{ $i }}"
                        wire:model="items.{{ $index }}.stores.{{ $i }}.discount_on_bonus_quantity"
                        wire:change="purchase_final({{ $index }},'stores',{{ $i }})"
                        style="font-size: 0.75rem" value="true">
                    <label class="custom-control-label"
                        style='font-weight:500;font-size:9px !important;color:#888;max-width: 70px'
                        for="discount_on_bonus_quantity">@lang('lang.discount_on_bonus_quantity')</label>
                </div>
            </div>

            <div class=" animate__animated  animate__bounceInLeft d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                style="width: 100px;min-height: 60px">
                <label for="discount amount"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>cash discount</label>
                <input type="text" class="form-control initial-balance-input width-full "
                    wire:model="items.{{ $index }}.stores.{{ $i }}.cash_discount"
                    wire:change="purchase_final({{ $index }},'stores',{{ $i }})"
                    placeholder="cash discount">
                <div class="custom-control custom-switch d-flex justify-content-center align-items-center">
                    <input type="checkbox" class="custom-control-input" id="discount_dependency{{ $i }}"
                        wire:model="items.{{ $index }}.stores.{{ $i }}.discount_dependency"
                        wire:change="purchase_final({{ $index }},'stores',{{ $i }})"
                        style="font-size: 0.75rem" value="true">
                    <label class="custom-control-label"
                        style='font-weight:500;font-size:9px !important;color:#888;max-width: 70px'
                        for="discount_dependency{{ $i }}">@lang('lang.discount_dependency')</label>
                </div>
            </div>

            <div class=" animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                style="width: 100px;min-height: 60px">
                <label for="discount amount"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>seasonal discount</label>
                <input type="text" class="form-control initial-balance-input width-full mx-0"
                    wire:model="items.{{ $index }}.stores.{{ $i }}.seasonal_discount"
                    wire:change="purchase_final({{ $index }},'stores',{{ $i }})"
                    placeholder="seasonal discount">
            </div>

            <div class="animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                style="width: 100px;min-height: 60px">
                <label for="discount amount"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>Annual discount</label>
                <input type="text" class="form-control initial-balance-input width-full mx-0"
                    wire:model="items.{{ $index }}.stores.{{ $i }}.annual_discount"
                    wire:change="purchase_final({{ $index }},'stores',{{ $i }})"
                    placeholder="Annual discount">
            </div>

            @if (!empty($store['quantity']) && !empty($store['purchase_price']))
                <div class=" animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1  mt-1"
                    style="width: 120px;">
                    <span class="final_total_span" aria-placeholder="final purchase">
                        {{ $this->purchase_final($index, 'stores', $i) }}
                    </span>
                    <span class="final_total_span" aria-placeholder="final purchase">
                        {{ $this->purchase_final_dollar($index, 'stores', $i) }} $
                    </span>
                </div>
            @endif

            @if (!empty($store['quantity']) && !empty($store['purchase_price']))
                <div class="animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1  mt-1"
                    style="width: 120px;">
                    <span class="final_total_span" aria-placeholder="final purchase for piece">
                        {{ $this->final_purchase_for_piece($index, 'stores', $i) }}
                    </span>
                    <span class="final_total_span" aria-placeholder="final purchase for piece">
                        {{ $this->dollar_final_purchase_for_piece($index, 'stores', $i) }} $
                    </span>
                </div>
            @endif

            <div
                class=" animate__animated  animate__bounceInLeft d-flex flex-column align-items-center pl-1 mx-1 mt-1">
                <button class="btn btn-primary" style="font-weight: 500;font-size: 12px"
                    wire:click="addStoreRow({{ $index }})" type="button">
                    <i class="fa fa-plus"></i> @lang('lang.add_new_unit')
                </button>
            </div>
            <div class="  animate__animated  animate__bounceInLeft d-flex flex-column align-items-center pl-1 mx-1 mt-1"
                style="width: 40px;">
                <div class="btn btn-sm btn-danger py-0 px-1"
                    wire:click="delete_product({{ $index }},'stores',{{ $i }})">
                    <i class="fa fa-trash"></i>
                </div>
            </div>
        </div>
    </div>



    <div class="d-flex justify-content-start align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif @if ($index % 2 == 0) bg-white @else bg-dark-gray @endif"
        style="overflow-x: auto;">
        <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            @foreach ($store['customer_prices'] as $key => $price)
                <div class=" mb-2 animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                    style="width: 60px;min-height: 40px;">
                    <input type="text" class="form-control initial-balance-input width-full mx-0 percent"
                        name="percent"
                        wire:change="changePercent({{ $index }},{{ $key }},'stores',{{ $i }})"
                        wire:model="items.{{ $index }}.stores.{{ $i }}.customer_prices.{{ $key }}.percent"
                        maxlength="6" placeholder="%">
                </div>

                <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                    style="width: 60px;min-height: 40px">
                    <input type="text"
                        class="form-control mb-0 initial-balance-input width-full mx-0 dinar_sell_price"
                        wire:model="items.{{ $index }}.stores.{{ $i }}.customer_prices.{{ $key }}.dinar_increase"
                        placeholder = "{{ $items[$index]['stores'][$i]['customer_prices'][$key]['customer_name'] }}"
                        wire:change="changeIncrease({{ $index }},{{ $key }},'stores',{{ $i }})">
                    <span class="dollar-cell"
                        style='font-weight:500;font-size:10px;color:#888'>{{ $items[$index]['stores'][$i]['customer_prices'][$key]['dollar_increase'] }}
                        $</span>
                    @error('items.' . $index . '.stores' . $i . 'customer_prices' . $key . '.dinar_increase')
                        <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>

                <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                    style="width: 60px;min-height: 40px">
                    <input type="text"
                        class="form-control mb-0 initial-balance-input width-full mx-0 dinar_sell_price"
                        wire:model="items.{{ $index }}.stores.{{ $i }}.customer_prices.{{ $key }}.dinar_sell_price"
                        placeholder = "{{ $items[$index]['stores'][$i]['customer_prices'][$key]['customer_name'] }}">
                    <span class="dollar-cell"
                        style='font-weight:500;font-size:10px;color:#888'>{{ $items[$index]['stores'][$i]['customer_prices'][$key]['dollar_sell_price'] }}
                        $</span>
                    @error('items.' . $index . '.stores' . $i . 'customer_prices' . $key . '.dinar_sell_price')
                        <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>
            @endforeach
            <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column justify-content-center align-items-center pl-1 mx-1 mt-1"
                style="width: 100px;background-color: #596fd7;color: white;border-radius: 6px">
                <label for="purchase_price"
                    class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                    style='font-weight:500;font-size:10px;color:white!important'>{{ __('lang.new_stock') }}</label>
                <span class="current_stock_text" style="font-weight: 600">
                    {{ $store['total_stock'] }}
                </span>
            </div>

            <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-row justify-content-center @if (app()->isLocale('ar')) align-items-center @else align-items-start @endif pl-1 mx-1 mt-1"
                style="width: 100px;">
                <label for="">{{ __('lang.change_current_stock') }}</label>
                <input type="checkbox" name="change_price"
                    wire:model="items.{{ $index }}.stores.{{ $i }}.change_price_stock">
            </div>
        </div>
    </div>
@endforeach

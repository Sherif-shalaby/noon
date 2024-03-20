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
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.purchase_currency') }}</label>
            {{-- <label for="invoice_currency" class="mb-0">@lang('lang.invoice_currency') *</label> --}}
            <div class="input-wrapper" style="width: 100%">
                {!! Form::select('invoice_currency', $selected_currencies, null, [
                    'class' => 'form-select',
                    'placeholder' => __('lang.choose_currency'),
                    'data-live-search' => 'true',
                    'required' => 'required',
                    'wire:model' => 'items.' . $index . '.used_currency',
                    'wire:change' => "convertPurchasePrice($index,'','','change_price')",
                ]) !!}
            </div>
            @error('items.' . $index . '.used_currency')
                <span class="error validation-error text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="animate__animated  animate__bounceInLeft d-flex flex-column store_drop_down  @if (app()->isLocale('ar')) align-items-end  @else align-items-start @endif mr-1 "
            style="min-width: max-content;min-height: 60px">
            <label class="mb-0 @if (app()->isLocale('ar')) d-block text-end mx-2 @else  mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.product_n') }}</label>
            <span style='font-weight:700;font-size:14px;color:#333;min-width: 100px'
                class="text-center d-flex justify-content-center py-1 align-items-center initial-balance-input width-full m-0">
                {{ $product['product']['name'] }}
            </span>

        </div>

        @if (!empty($product['product']['sku']))
            <div class="animate__animated  animate__bounceInLeft d-flex flex-column store_drop_down  @if (app()->isLocale('ar')) align-items-end  @else align-items-start @endif mr-1 "
                style="min-width: max-content;min-height: 60px">
                <label class="mb-0 @if (app()->isLocale('ar')) d-block text-end mx-2 @else  mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.sku') }}</label>
                <span style='font-weight:700;font-size:14px;color:#333;min-width: 100px'
                    class="text-center d-flex justify-content-center py-1 align-items-center initial-balance-input width-full m-0">
                    {{ $product['product']['sku'] }}
                </span>
            </div>
        @endif

        <div class="animate__animated  animate__bounceInLeft d-flex flex-column store_drop_down  @if (app()->isLocale('ar')) align-items-end  @else align-items-start @endif mr-1 "
            style="width:fit-content;min-height: 60px">
            <label for="store"
                class="mb-0 @if (app()->isLocale('ar')) d-block text-end mx-2 @else  mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.store') }}</label>
            <div class="input-wrapper  justify-content-between" style="width: 200px !important">
                {!! Form::select('store_id', $stores, $store_id, [
                    'class' => ' form-select store_id' . $index,
                    'data-live-search' => 'true',
                    'required',
                    'placeholder' => __('lang.please_select'),
                    'wire:model' => 'items.' . $index . '.store_id',
                ]) !!}

                <button type="button"
                    class="add-button d-flex justify-content-center align-items-center createStoreModal"
                    data-toggle="modal" data-index="{{ $index }}" data-target="#createStoreModal">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            {{-- @error('items.' . $index . '.store_id')
                <span class="error  validation-error text-danger">{{ $message }}</span>
            @enderror --}}
        </div>

        <div class=" animate__animated  animate__bounceInLeft d-flex flex-column store_drop_down  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
            style="min-width: 100px;min-height: 60px;">
            <label for="unit"
                class="mb-0 @if (app()->isLocale('ar')) d-block text-end mx-2 @else  mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.unit') }}</label>
            @if (isset($product['variations']) && count($product['variations']) > 0)
                <div class="input-wrapper" style="width: 100%!important">
                    <select name="items.{{ $index }}.variation_id" class="form-select "
                        wire:model="items.{{ $index }}.variation_id"
                        wire:input="getVariationData({{ $index }})">
                        <option value="" selected>{{ __('lang.please_select') }}</option>
                        @foreach ($product['variations'] as $variant)
                            @if (!empty($variant['unit_id']))
                                <option value="{{ $variant['id'] }}">{{ $variant['unit']['name'] ?? '' }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            @else
                <span style='font-weight:500;font-size:10px;color:#888'>@lang('lang.no_units')</span>
            @endif
            @error('items.' . $index . '.variation_id')
                <span class="error  validation-error text-danger">{{ $message }}</span>
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
            style="width: max-content;min-height: 60px">
            <label for="quantity"
                class="mb-0 @if (app()->isLocale('ar')) d-block text-end mx-2 @else  mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.quantity') }}</label>

            <input type="text" class="form-control quantity  initial-balance-input" style="width: 80px" required
                wire:model="items.{{ $index }}.quantity" wire:input="changeCurrentStock({{ $index }})">
            @error('items.{{ $index }}.quantity')
                <span class="error  validation-error text-danger">{{ $message }}</span>
            @enderror

        </div>

        <div class=" animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
            style="width: 80px;min-height: 60px">
            <label for="bonus_quantity"
                class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.b_qty') }}</label>
            <input type="text" class="form-control bonus_quantity initial-balance-input width-full"
                placeholder="{{ __('lang.b_qty') }}" wire:model="items.{{ $index }}.bonus_quantity"
                wire:input="changeCurrentStock({{ $index }})">
            @error('items.{{ $index }}.bonus_quantity')
                <span class="error  validation-error text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div id="panelsStayOpen-collapse{{ $index }}unit-details"
            class="accordion-collapse collapse @if ($product['show_unit_details']) show @endif">
            <div
                class="accordion-body p-0 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                @if ($items[$index]['is_have_stock'] == '0')
                    @if (isset($items[$index]['units']))
                        @foreach ($items[$index]['units'] as $unitName => $unitValue)
                            @if (!empty($unitName))
                                <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                                    style="width: 80px;min-height: 60px">
                                    {{-- Iterate through units and display each unit name and value as a span --}}
                                    <label
                                        class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                                        style='font-weight:500;font-size:10px;color:#888'>{{ $unitName }} </label>


                                    <span
                                        class="form-control quantity initial-balance-input width-full">{{ @number_format($unitValue, num_of_digital_numbers()) }}
                                    </span>
                                </div>
                            @endif
                        @endforeach
                    @endif
                @elseif($items[$index]['is_have_stock'] == 1)
                    @foreach ($items[$index]['units'] as $unitName => $unitValue)
                        @if (!empty($unitName))
                            <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                                style="width: 80px;min-height: 60px">
                                <label
                                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                                    style='font-weight:500;font-size:10px;color:#888'>{{ $unitName }} </label>
                                <input type="text" class="form-control quantity initial-balance-input width-full"
                                    wire:model="items.{{ $index }}.units.{{ $unitName }}" />

                            </div>
                        @endif
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
            <span
                class="dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} text-center d-flex justify-content-center py-1 align-items-center initial-balance-input width-full m-0"
                style='font-weight:700;font-size:14px;color:#333;'>{{ @number_format($product['dollar_purchase_price'], num_of_digital_numbers()) ?? 0 }}$</span>
            @error('items.' . $index . '.purchase_price')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>

        @if (!empty($product['quantity']) && (!empty($product['purchase_price']) || !empty($product['dollar_purchase_price'])))
            <div class="  animate__animated  animate__bounceInLeft d-flex flex-column align-items-center mr-1"
                style="width: 150px;min-height: 60px">
                <label for="sub_total"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.sub_total') }}</label>
                <b style='font-weight:700;font-size:14px;color:#333;'
                    class="text-center sub_total_span d-flex justify-content-center py-1 align-items-center initial-balance-input width-full m-0">
                    {{ $this->sub_total($index) }}
                </b>
                <b style='font-weight:700;font-size:14px;color:#333;'
                    class="text-center sub_total_span  d-flex mt-1 py-1 justify-content-center align-items-center initial-balance-input width-full m-0 dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} ">
                    {{ $this->dollar_sub_total($index) }}$
                </b>
            </div>
        @endif

        <div class=" animate__animated animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
            style="width: 100px;min-height: 60px">
            <label for="discount_type"
                class="mb-0 @if (app()->isLocale('ar')) d-block text-end mx-2 @else  mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.discount_type') }}</label>

            <div class="input-wrapper" style="width: 100%">
                {!! Form::select(
                    'items' . $index . '.discount_type',
                    [1 => __('lang.piece_discount'), 2 => __('lang.total_discount')],
                    1,
                    [
                        'class' => 'form-select store_id' . $index,
                        'data-live-search' => 'true',
                        'required',
                        'placeholder' => __('lang.please_select'),
                        'wire:model' => 'items.' . $index . '.discount_type',
                    ],
                ) !!}

            </div>

        </div>



        <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 {{ $items[$index]['discount_type'] != '1' ? 'd-none' : '' }}"
            style="width: 150px;min-height: 60px">
            <div class="d-flex justify-content-center width-full">
                {{-- <div class="width-full col-6 p-0">
                    <label class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                        style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.percente') }}</label>
                    <input type="text" class="form-control  initial-balance-input width-full p-0 px-2"
                        wire:model="items.{{ $index }}.purchase_discount_percent"
                        style='font-weight:500;font-size:10px;'
                        wire:change="changePurchasePrice({{ $index }})" placeholder="%">
                </div> --}}
                <div class="width-full col-9 p-0">
                    <label class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                        style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.amount') }}</label>
                    <input type="text" class="form-control initial-balance-input width-full p-0 px-2"
                        wire:model="items.{{ $index }}.purchase_discount"
                        style='font-weight:500;font-size:10px;'
                        wire:change="changePurchasePrice({{ $index }})" placeholder="@lang('lang.amount')">
                </div>
            </div>
            <div class="d-flex width-full dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} ">
                {{-- <span style='font-weight:500;font-size:10px;color:#888' class=" width-full col-6 p-0 ">
                    {{ @number_format(num_uf($product['dollar_purchase_discount_percent']), num_of_digital_numbers()) }}
                    $ </span> --}}
                <span style='font-weight:500;font-size:10px;color:#888' class=" width-full col-6 p-0 ">
                    {{ @number_format(num_uf($product['dollar_purchase_discount']), num_of_digital_numbers()) }}
                    $</span>
            </div>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                    name="discount_on_bonus_quantity{{ $index }}"
                    id="discount_on_bonus_quantity_{{ $index }}"
                    wire:model="items.{{ $index }}.discount_on_bonus_quantity"
                    wire:change="changePurchasePrice({{ $index }},null,null,'discount')"
                    style="font-size: 0.75rem" value="true">
                <label class="custom-control-label"
                    for="discount_on_bonus_quantity_{{ $index }}">@lang('lang.discount_from_original_price')</label>
            </div>
        </div>

        {{-- <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
            style="width: 120px;min-height: 60px">
            <label for="purchase_price"
                class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>@lang('lang.price_after_discount')</label>
            <div class="d-flex flex-column width-full">
                <b class="price_after_discount width-full  p-0 d-flex justify-content-center align-items-center initial-balance-input width-full m-0"
                    style='font-weight:700;font-size:14px;color:#333;'>
                    {{ @number_format(num_uf($product['purchase_after_discount']), num_of_digital_numbers()) }}
                </b>
                <b class="dollar_price_after_discount width-full  p-0 d-flex justify-content-center align-items-center initial-balance-input width-full m-0 mt-1 dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} "
                    style='font-weight:700;font-size:14px;color:#333;'>
                    {{ @number_format(num_uf($product['dollar_purchase_after_discount']), num_of_digital_numbers()) }}
                </b>
            </div>
        </div> --}}

        <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 {{ $items[$index]['discount_type'] != '2' ? 'd-none' : '' }}"
            style="width: 150px;min-height: 60px">
            <label for="purchase_price"
                class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>@lang('lang.discount_amount')</label>
            <div class="d-flex  width-full">
                {{-- <input type="text" class="form-control  initial-balance-input width-full col-6 p-0 px-2"
                    wire:model="items.{{ $index }}.discount_percent" style='font-weight:500;font-size:10px;'
                    placeholder="%"> --}}
                <input type="text" class="form-control  initial-balance-input width-full col-12 p-0 px-2"
                    wire:model="items.{{ $index }}.discount" style='font-weight:500;font-size:10px;'
                    placeholder="@lang('lang.discount_amount')">
            </div>
        </div>



        {{-- <div class=" animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
            style="width: 50px;min-height: 60px">
            <label for="%"
                class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>%</label>
            <input type="text" class="form-control initial-balance-input width-full mx-0"
                wire:model="items.{{ $index }}.discount_percent"
                wire:change="purchase_final({{ $index }})" placeholder="%">
        </div> --}}

        {{-- <div class=" animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
            style="width: 100px;min-height: 60px">
            <label for="discount amount"
                class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>@lang('lang.discount_amount')</label>
            <input type="text" class="form-control initial-balance-input width-full"
                wire:model="items.{{ $index }}.discount" wire:change="purchase_final({{ $index }})"
                placeholder="@lang('lang.discount_amount')">
            <div class="custom-control custom-switch d-flex justify-content-center align-items-center">
                <input type="checkbox" class="custom-control-input"
                    name="discount_on_bonus_quantity{{ $index }}"
                    id="discount_on_bonus_quantity_{{ $index }}"
                    wire:model="items.{{ $index }}.discount_on_bonus_quantity"
                    wire:change="purchase_final({{ $index }})" style="font-size: 0.75rem" value="true">
                <label class="custom-control-label"
                    style='font-weight:500;font-size:9px !important;color:#888;max-width: 70px'
                    for="discount_on_bonus_quantity_{{ $index }}">@lang('lang.discount_on_bonus_quantity')</label>
            </div>
        </div> --}}

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

                <div class="animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                    style="width: 100px;min-height: 60px">
                    <label for="Annual discount"
                        class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                        style='font-weight:500;font-size:10px;color:#888'>@lang('lang.annual_discount')</label>
                    <input type="text" name="items.{{ $index }}.annual_discount"
                        id="items.{{ $index }}.annual_discount"
                        class="form-control initial-balance-input width-full mx-0"
                        wire:model="items.{{ $index }}.annual_discount"
                        wire:change="cost({{ $index }})" placeholder="@lang('lang.annual_discount')">
                </div>


                <div class=" animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                    style="width: 100px;min-height: 60px">
                    <label for="seasonal discount"
                        class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                        style='font-weight:500;font-size:10px;color:#888'>@lang('lang.seasonal_discount')</label>
                    <input type="text" name="items.{{ $index }}.seasonal_discount"
                        id="items.{{ $index }}.seasonal_discount"
                        class="form-control initial-balance-input width-full mx-0"
                        wire:model="items.{{ $index }}.seasonal_discount"
                        wire:change="cost({{ $index }})" placeholder="@lang('lang.seasonal_discount')">
                </div>

                <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                    style="width: 100px;min-height: 60px">
                    <label for="purchase_price"
                        class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                        style='font-weight:500;font-size:10px;color:#888'>@lang('lang.cash_discount')</label>
                    {{-- <input type="text" class="form-control initial-balance-input width-full mx-0"
                        wire:model="items.{{ $index }}.cash_discount" wire:input="cost({{ $index }})"
                        placeholder="@lang('lang.cash_discount')"> --}}



                    <input type="text" name="items.{{ $index }}.invoice_discount"
                        id="items.{{ $index }}.invoice_discount"
                        class="form-control initial-balance-input width-full mx-0"
                        wire:model="items.{{ $index }}.invoice_discount"
                        wire:change="cost({{ $index }})" style="width: 100px;"
                        placeholder="invoice discount">

                    <input type="text" name="items.{{ $index }}.cash_discount"
                        id="items.{{ $index }}.cash_discount"class="form-control initial-balance-input width-full mx-0"
                        wire:model="items.{{ $index }}.cash_discount" style="width: 100px;"
                        wire:change="cost({{ $index }})" placeholder="cash discount">


                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input"
                            name="discount_dependency{{ $index }}"
                            id="discount_dependency_{{ $index }}"
                            wire:model="items.{{ $index }}.discount_dependency"
                            wire:input="purchase_final({{ $index }})" style="font-size: 0.75rem"
                            value="true">
                        <label class="custom-control-label"
                            for="discount_dependency_{{ $index }}">@lang('lang.discount_dependency')</label>
                    </div>
                </div>

            </div>
        </div>



        {{-- @if (!empty($product['quantity']) && !empty($product['purchase_price']))
            <div class="  animate__animated  animate__bounceInLeft d-flex flex-column align-items-center mr-1"
                style="width: 150px;min-height: 60px">
                <label for="final purchase for piece"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.final_purchase_for_piece') }}</label>
                <b style="font-weight: 700;color: #333"
                    class="final_total_span d-flex justify-content-center align-items-center initial-balance-input width-full m-0"
                    aria-placeholder="{{ __('lang.final purchase for piece') }}">
                    {{@number_format($this->final_purchase_for_piece($index),num_of_digital_numbers()) }}
                </b>
                <b style="font-weight: 700;color: #333"
                    class="final_total_span d-flex justify-content-center align-items-center initial-balance-input width-full m-0 mt-1 dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} "
                    aria-placeholder="{{ __('lang.final purchase for piece') }}">
                    {{@number_format($this->dollar_final_purchase_for_piece($index),num_of_digital_numbers()) }} $

                </b>
            </div>
        @endif --}}

        {{-- {{ $this->cost($index) }} --}}

        @if (!empty($product['quantity']) && !empty($product['purchase_price']))
            <div class="  animate__animated  animate__bounceInLeft d-flex flex-column align-items-center mr-1"
                style="width: 150px;min-height: 60px">
                <label for="cost"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.cost') }}</label>
                <b style="font-weight: 700;color: #333"
                    class="cost d-flex justify-content-center align-items-center initial-balance-input width-full m-0"
                    aria-placeholder="dollar cost">
                    {{ $product['cost'] }}
                </b>
                <b style="font-weight: 700;color: #333"
                    class="dollar_cost d-flex justify-content-center align-items-center initial-balance-input width-full m-0 mt-1 dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} "
                    aria-placeholder="dollar cost">
                    {{ $product['dollar_cost'] }} $
                </b>
            </div>
        @endif

        @if (!empty($product['quantity']) && !empty($product['purchase_price']))
            <div class=" animate__animated  animate__bounceInLeft d-flex flex-column align-items-center mr-1"
                style="width: 150px;min-height: 60px">
                <label for="final purchase"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.final_purchase') }}</label>
                <span style="font-weight: 700;color: #333"
                    class="final_total_span d-flex justify-content-center align-items-center initial-balance-input width-full m-0"
                    aria-placeholder="final purchase">
                    {{ @number_format($this->purchase_final($index), num_of_digital_numbers()) }}
                </span>
                <span style="font-weight: 700;color: #333"
                    class="final_total_span mt-1 d-flex justify-content-center align-items-center initial-balance-input width-full m-0 dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} "
                    aria-placeholder="final purchase">
                    {{ @number_format($this->purchase_final_dollar($index), num_of_digital_numbers()) }} $
                </span>
            </div>
        @endif

        <div class="  animate__animated  animate__bounceInLeft d-flex flex-column align-items-center mr-1"
            style="width: 80px;min-height: 60px">
            <label for="final purchase for piece"
                class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.size') }}</label>
            <span style="font-weight: 700;color:#333"
                class="size d-flex justify-content-center align-items-center initial-balance-input width-full m-0">
                {{ $product['size'] }}
            </span>
        </div>

        <div class="  animate__animated  animate__bounceInLeft d-flex flex-column align-items-center mr-1"
            style="width: 80px;min-height: 60px">
            <label for="final purchase for piece"
                class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.total_size') }}</label>
            @if (!empty($product['quantity']))
                <span style="font-weight: 500;color: #333"
                    class="total_size  d-flex justify-content-center align-items-center initial-balance-input width-full m-0">
                    {{ $this->total_size($index) }}
                </span>
            @else
                {{ 0.0 }}
            @endif
        </div>

        <div class="  animate__animated  animate__bounceInLeft d-flex flex-column align-items-center mr-1"
            style="width: 80px;min-height: 60px">
            <label for="final purchase for piece"
                class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.weight') }}</label>
            <span style="font-weight:700;color: #333"
                class="weight  d-flex justify-content-center align-items-center initial-balance-input width-full m-0">
                {{ $product['weight'] }}
            </span>
        </div>

        <div class="  animate__animated  animate__bounceInLeft d-flex flex-column align-items-center mr-1"
            style="width: 80px;min-height: 60px">
            <label for="final purchase for piece"
                class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.total_weight') }}</label>
            @if (!empty($product['quantity']))
                <span style="font-weight: 700;color: #333"
                    class="total_weight  d-flex justify-content-center align-items-center initial-balance-input width-full m-0">
                    {{ $this->total_weight($index) }}
                </span>
            @else
                <span style="font-weight: 700;color: #333"
                    class=" d-flex justify-content-center align-items-center initial-balance-input width-full m-0">
                    {{ 0.0 }}
                </span>
            @endif
        </div>

    </div>
</div>



<div class="d-flex justify-content-start align-items-center mt-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif @if ($index % 2 == 0) bg-white @else bg-dark-gray @endif"
    style="overflow-x: auto;">
    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        @foreach ($product['customer_prices'] as $key => $price)
            <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                style="width: 60px;min-height: 40px;">
                <label class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.percente') }}</label>
                <input type="text"
                    class="form-control initial-balance-input width-full mx-0 percent{{ $index }} {{ $key }}"
                    name="items.{{ $index }}.customer_prices.{{ $key }}.percent"
                    wire:input="changePercent({{ $index }},{{ $key }})"
                    wire:model="items.{{ $index }}.customer_prices.{{ $key }}.percent"
                    maxlength="6" placeholder="%">
            </div>
            <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                style="width: 60px;min-height: 40px">
                <label class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                    style='font-weight:500;font-size:10px;color:#333'>{{ $items[$index]['customer_prices'][$key]['customer_name'] }}</label>
                <input type="text" class="form-control mb-0 initial-balance-input width-full mx-0 dinar_sell_price"
                    wire:model="items.{{ $index }}.customer_prices.{{ $key }}.dinar_increase"
                    placeholder = "{{ $items[$index]['customer_prices'][$key]['customer_name'] }}"
                    wire:input="changeIncrease({{ $index }},{{ $key }})">
                <span class="dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} "
                    style='font-weight:500;font-size:10px;color:#888'>{{ $items[$index]['customer_prices'][$key]['dollar_increase'] }}
                    $</span>
                @error('items.' . $index . 'customer_prices' . $key . '.dinar_increase')
                    <label class="text-danger  validation-error error-msg">{{ $message }}</label>
                @enderror
            </div>

            <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                style="width: 60px;min-height: 40px">
                <label class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                    style='font-weight:500;font-size:10px;color:#333'>
                    {{ $items[$index]['customer_prices'][$key]['customer_name'] }}</label>
                <input type="text" class="form-control mb-0 initial-balance-input width-full mx-0 dinar_sell_price"
                    wire:model="items.{{ $index }}.customer_prices.{{ $key }}.dinar_sell_price"
                    placeholder = "{{ $items[$index]['customer_prices'][$key]['customer_name'] }}">
                <span class="dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} "
                    style='font-weight:500;font-size:10px;color:#888'>{{ $items[$index]['customer_prices'][$key]['dollar_sell_price'] }}
                    $</span>
                @error('items.' . $index . 'customer_prices' . $key . '.dinar_sell_price')
                    <label class="text-danger  validation-error error-msg">{{ $message }}</label>
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
                style="width: 200px;min-height: 60px;">
                <label for="store"
                    class="mb-0 @if (app()->isLocale('ar')) d-block text-end mx-2 @else  mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.store') }}</label>

                <div class="input-wrapper justify-content-between" style="width: 100% !important">
                    {!! Form::select('stores.' . $i . '.store_id', $stores, $store_id, [
                        'class' => 'form-select store_id' . $index . $i,
                        'data-live-search' => 'true',
                        'required',
                        'placeholder' => __('lang.please_select'),
                        'wire:model' => 'items.' . $index . '.stores.' . $i . '.store_id',
                    ]) !!}
                    <button type="button"
                        class="add-button d-flex justify-content-center align-items-center createStoreModal"
                        data-toggle="modal" data-key="{{ $i }}" data-index="{{ $index }}"
                        data-target="#createStoreModal">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                @error('items.' . $index . '.stores' . $i . '.store_id')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="animate__animated  animate__bounceInLeft d-flex flex-column store_drop_down  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                style="width: 100px;min-height: 60px;">
                <label for="unit"
                    class="mb-0 @if (app()->isLocale('ar')) d-block text-end mx-2 @else  mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.unit') }}</label>
                @if (isset($store['variations']) && count($store['variations']) > 0)
                    <div class="input-wrapper" style="width: 100%!important">
                        <select name="items.{{ $index }}.stores.{{ $i }}.variation_id"
                            class="form-select"
                            wire:model="items.{{ $index }}.stores.{{ $i }}.variation_id"
                            wire:input="getVariationData({{ $index }},'stores',{{ $i }})">
                            <option value="" selected>{{ __('lang.please_select') }}</option>
                            @foreach ($store['variations'] as $variant)
                                @if (!empty($variant['unit_id']))
                                    <option value="{{ $variant['id'] }}">{{ $variant['unit']['name'] ?? '' }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    {{-- Iterate through units and display each unit name and value as a span --}}
                    @if (isset($items[$index]['stores'][$i]['units']))
                        @foreach ($items[$index]['stores'][$i]['units'] as $unitName => $unitValue)
                            @if (!empty($unitName))
                                <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                                    style="width: 80px;min-height: 60px">
                                    <label
                                        class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                                        style='font-weight:500;font-size:10px;color:#888'>{{ @number_format($unitValue, num_of_digital_numbers()) }}</label>

                                    <input type="text"
                                        class="form-control quantity initial-balance-input width-full"
                                        value="{{ $unitName }}" readonly>
                                </div>
                            @endif
                        @endforeach
                    @endif
                @else
                    <span style='font-weight:500;font-size:10px;color:#888'>@lang('lang.no_units')</span>
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
                <input type="text" class="form-control initial-balance-input width-full quantity" required
                    wire:model="items.{{ $index }}.stores.{{ $i }}.quantity"
                    wire:input="changeCurrentStock({{ $index }},'stores',{{ $i }})">
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
                <input type="text" class="form-control initial-balance-input width-full bonus_quantity"
                    placeholder="{{ __('lang.b_qty') }}"
                    wire:model="items.{{ $index }}.stores.{{ $i }}.bonus_quantity"
                    wire:input="changeCurrentStock({{ $index }},'stores',{{ $i }})">
                @error('items.' . $index . '.stores' . $i . '.bonus_quantity')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                style="width: 80px;min-height: 60px">
                <label for="purchase_price"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.purchase_price') }}</label>
                <input type="number" class="form-control initial-balance-input width-full purchase_price"
                    wire:model="items.{{ $index }}.stores.{{ $i }}.purchase_price"
                    wire:input="convertPurchasePrice({{ $index }},'stores',{{ $i }})" required>
                <span style='font-weight:500;font-size:10px;color:#888'
                    class="dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} ">{{ $items[$index]['stores'][$i]['dollar_purchase_price'] ?? 0 }}$</span>
                @error('items.' . $index . '.stores' . $i . '.purchase_price')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>

            @if (!empty($store['quantity']) && (!empty($store['purchase_price']) || !empty($store['dollar_purchase_price'])))
                <div class="  animate__animated  animate__bounceInLeft d-flex flex-column align-items-center mr-1"
                    style="width: 150px;min-height: 60px">
                    <label for="sub_total"
                        class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                        style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.sub_total') }}</label>
                    <b style='font-weight:500;color:#333'
                        class="sub_total_span d-flex justify-content-center align-items-center initial-balance-input width-full m-0">
                        {{ $this->sub_total($index, 'stores', $i) }}
                    </b>
                    <b style='font-weight:500;color:#333'
                        class="sub_total_span d-flex justify-content-center align-items-center initial-balance-input width-full m-0 mt-1  dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} ">
                        {{ $this->dollar_sub_total($index, 'stores', $i) }}$
                    </b>
                </div>
            @endif

            <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                style="width: 150px;min-height: 60px">
                <label for="%"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>%</label>
                <div class="d-flex width-full">
                    <input type="text" class="form-control initial-balance-input width-full col-6 p-0 px-2"
                        wire:model="items.{{ $index }}.stores.{{ $i }}.purchase_discount"
                        style='font-weight:500;font-size:10px;'
                        wire:input="changePurchasePrice({{ $index }},'stores',{{ $i }})"
                        placeholder="@lang('lang.amount')">
                    {{-- <input type="text" class="form-control initial-balance-input width-full col-6 p-0 px-2"
                        wire:model="items.{{ $index }}.stores.{{ $i }}.purchase_discount_percent"
                        style='font-weight:500;font-size:10px;'
                        wire:input="changePurchasePrice({{ $index }},'stores',{{ $i }})"
                        placeholder="%"> --}}

                </div>
                <div class="d-flex width-full dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} ">
                    <span style='font-weight:500;font-size:10px;color:#888' class=" width-full col-6 p-0 ">
                        {{ @number_format($items[$index]['stores'][$i]['dollar_purchase_discount'], num_of_digital_numbers()) }}
                        $</span>
                    {{-- <span style='font-weight:500;font-size:10px;color:#888' class=" width-full col-6 p-0 ">
                        {{ @number_format($items[$index]['stores'][$i]['dollar_purchase_discount_percent'], num_of_digital_numbers()) }}
                        $ </span> --}}
                </div>

                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input"
                        name="discount_on_bonus_quantity{{ $index }}{{ $i }}"
                        id="discount_on_bonus_quantity{{ $i }}"
                        wire:model="items.{{ $index }}.stores.{{ $i }}.discount_on_bonus_quantity"
                        wire:input="changePurchasePrice({{ $index }}, 'stores', {{ $i }})"
                        style="font-size: 0.75rem" value="true">
                    <label class="custom-control-label"
                        for="discount_on_bonus_quantity{{ $i }}">@lang('lang.discount_from_original_price')</label>
                </div>

            </div>

            {{-- <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                style="width: 120px;min-height: 60px">
                <label for="purchase_price"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>@lang('lang.price_after_discount')</label>
                <div class="d-flex width-full flex-column">
                    <b class="price_after_discount price_after_discount width-full  d-flex justify-content-center align-items-center initial-balance-input width-full m-0 p-0"
                        style='font-weight:500;color:#333'>
                        {{ @number_format($items[$index]['stores'][$i]['purchase_after_discount'], num_of_digital_numbers()) ?? null }}
                    </b>
                    <b class="dollar_price_after_discount price_after_discount width-full  d-flex justify-content-center align-items-center initial-balance-input width-full m-0 mt-1 p-0 dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} "
                        style='font-weight:500;color:#333'>
                        {{ @number_format($items[$index]['stores'][$i]['dollar_purchase_after_discount'], num_of_digital_numbers()) ?? null }}
                    </b>
                </div>
            </div> --}}

            <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                style="width: 150px;min-height: 60px">
                <label for="purchase_price"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>@lang('lang.discount_amount')</label>
                <div class="d-flex  width-full">
                    <input type="text" class="form-control   initial-balance-input width-full col-6 p-0 px-2"
                        style='font-weight:500;font-size:10px;'
                        wire:model="items.{{ $index }}.stores.{{ $i }}.discount_percent"
                        wire:input="purchase_final({{ $index }},'stores',{{ $i }})"
                        placeholder="%">
                    <input type="text" class="form-control   initial-balance-input width-full col-6 p-0 px-2"
                        style='font-weight:500;font-size:10px;'
                        wire:model="items.{{ $index }}.stores.{{ $i }}.discount"
                        wire:input="purchase_final({{ $index }},'stores',{{ $i }})"
                        placeholder="@lang('lang.discount_amount')">
                </div>
            </div>

            <div class="  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                style="width: 100px;min-height: 60px">
                <label for="purchase_price"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>@lang('lang.cash_discount')</label>
                <input type="text" class="form-control  initial-balance-input width-full mx-0"
                    wire:model="items.{{ $index }}.stores.{{ $i }}.cash_discount"
                    style="width: 100px;"
                    wire:input="purchase_final({{ $index }},'stores',{{ $i }})"
                    placeholder="@lang('lang.cash_discount')">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input"
                        name="discount_dependency{{ $index }}{{ $i }}"
                        id="discount_dependency{{ $i }}"
                        wire:model="items.{{ $index }}.stores.{{ $i }}.discount_dependency"
                        wire:input="purchase_final({{ $index }},'stores',{{ $i }})"
                        style="font-size: 0.75rem" value="true">
                    <label class="custom-control-label"
                        for="discount_dependency{{ $i }}">@lang('lang.discount_dependency')</label>

                </div>
            </div>

            <div class=" animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                style="width: 100px;min-height: 60px">
                <label for="seasonal discount"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>@lang('lang.seasonal_discount')</label>
                <input type="text" class="form-control initial-balance-input width-full mx-0""
                    wire:model="items.{{ $index }}.stores.{{ $i }}.seasonal_discount"
                    wire:input="purchase_final({{ $index }},'stores',{{ $i }})"
                    placeholder="@lang('lang.seasonal_discount')">
            </div>

            <div class="animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1 "
                style="width: 100px;min-height: 60px">
                <label for="Annual discount"
                    class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2  @else mx-2 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>@lang('lang.annual_discount')</label>
                <input type="text" class="form-control initial-balance-input width-full mx-0"
                    wire:model="items.{{ $index }}.stores.{{ $i }}.annual_discount"
                    wire:input="purchase_final({{ $index }},'stores',{{ $i }})"
                    placeholder="@lang('lang.annual_discount')">
            </div>


            {{-- @if (!empty($store['quantity']) && !empty($store['purchase_price']))
                <div class=" animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                    style="width: 150px;min-height: 60px">
                    <label for="final purchase for piece"
                        class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                        style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.final_purchase_for_piece') }}</label>
                    <span style="font-weight: 700;color: #333"
                        class="final_total_span  d-flex justify-content-center align-items-center initial-balance-input width-full m-0"
                        aria-placeholder="{{ __('lang.final purchase for piece') }}">
                        {{ @number_format($this->final_purchase_for_piece($index,'stores',$i),num_of_digital_numbers()) }}
                    </span>
                    <span style="font-weight: 700;color: #333"
                        class="final_total_span  d-flex justify-content-center align-items-center initial-balance-input width-full m-0 mt-1 dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} "
                        aria-placeholder="{{ __('lang.final purchase for piece') }}">
                        {{ @number_format($this->dollar_final_purchase_for_piece($index,'stores',$i),num_of_digital_numbers()) }} $
                    </span>
                </div>
            @endif --}}

            @if (!empty($store['quantity']) && !empty($store['purchase_price']))
                <div class="  animate__animated  animate__bounceInLeft d-flex flex-column align-items-center mr-1"
                    style="width: 150px;min-height: 60px">
                    <label for="cost"
                        class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                        style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.cost') }}</label>
                    {{ $this->cost($index, 'stores', $i) }}
                    <span
                        class="cost_span  d-flex justify-content-center align-items-center initial-balance-input width-full m-0"
                        style="font-weight:700;color: #333"
                        aria-placeholder="{{ __('lang.final purchase for piece') }}">
                        {{ $store['cost'] }}
                    </span>
                    <span
                        class="cost_span  d-flex justify-content-center align-items-center initial-balance-input width-full m-0 mt-1 dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} "
                        style="font-weight:700;color: #333"
                        aria-placeholder="{{ __('lang.final purchase for piece') }}">
                        {{ $store['dollar_cost'] }} $
                    </span>
                </div>
            @endif


            @if (!empty($store['quantity']) && !empty($store['purchase_price']))
                <div class=" animate__animated  animate__bounceInLeft d-flex flex-column align-items-center mr-1"
                    style="width: 150px;min-height: 60px">
                    <label for="final purchase"
                        class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                        style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.final_purchase') }}</label>
                    <span style="font-weight: 700;color: #333"
                        class="final_total_span  d-flex justify-content-center align-items-center initial-balance-input width-full m-0"
                        aria-placeholder="final purchase">
                        {{ @number_format($this->purchase_final($index, 'stores', $i), num_of_digital_numbers()) }}
                    </span>
                    <span style="font-weight: 700;color: #333"
                        class="final_total_span  d-flex justify-content-center align-items-center initial-balance-input width-full m-0 mt-1 dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} "
                        aria-placeholder="final purchase">
                        {{ @number_format($this->purchase_final_dollar($index, 'stores', $i), num_of_digital_numbers()) }}
                        $
                    </span>
                </div>
            @endif

            <div class="d-flex align-items-center mt-2" style="height: fit-content">
                <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column justify-content-start align-items-center pl-1 mx-1 mt-1"
                    style="width: 40px;">
                    <div class="btn btn-sm btn-danger py-0 px-1"
                        wire:click="delete_product({{ $index }},'stores',{{ $i }})">
                        <i class="fa fa-trash"></i>
                    </div>
                </div>

                <div
                    class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column justify-content-start @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1 mx-1 mt-1">
                    <button class="btn btn-primary" style="font-weight: 500;font-size: 12px;min-width:140px"
                        wire:click="addStoreRow({{ $index }})" type="button">
                        <i class="fa fa-plus"></i> @lang('lang.add_new_unit')
                    </button>
                </div>
            </div>

        </div>
    </div>
    <div class="d-flex justify-content-start align-items-center mt-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif @if ($index % 2 == 0) bg-white @else bg-dark-gray @endif"
        style="overflow-x: auto;">
        <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            @foreach ($store['customer_prices'] as $key => $price)
                <div class=" mb-2 animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                    style="width: 60px;min-height: 40px;">
                    <label
                        class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                        style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.percente') }}</label>
                    <input type="text"
                        class="form-control initial-balance-input width-full mx-0 percent{{ $index }}{{ $key }}{{ $i }}"
                        id="percent{{ $i }}"
                        name="items.{{ $index }}.stores.{{ $i }}.customer_prices.{{ $key }}.percent"
                        wire:model="items.{{ $index }}.stores.{{ $i }}.customer_prices.{{ $key }}.percent"
                        wire:input="changePercent({{ $index }},{{ $key }},'stores',{{ $i }})"
                        maxlength="6" placeholder="%">
                </div>

                <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                    style="width: 60px;min-height: 40px">
                    <label
                        class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                        style='font-weight:500;font-size:10px;color:#333'>{{ $items[$index]['stores'][$i]['customer_prices'][$key]['customer_name'] }}</label>
                    <input type="text" class="form-control initial-balance-input width-full mx-0  dinar_sell_price"
                        wire:model="items.{{ $index }}.stores.{{ $i }}.customer_prices.{{ $key }}.dinar_increase"
                        placeholder = "{{ $items[$index]['stores'][$i]['customer_prices'][$key]['customer_name'] }}"
                        wire:input="changeIncrease({{ $index }},{{ $key }},'stores',{{ $i }})">
                    <span class="dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} s"
                        style='font-weight:500;font-size:10px;color:#888'>{{ $items[$index]['stores'][$i]['customer_prices'][$key]['dollar_increase'] }}
                        $</span>
                    @error('items.' . $index . '.stores' . $i . 'customer_prices' . $key . '.dinar_increase')
                        <br>
                        <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>

                <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mr-1"
                    style="width: 60px;min-height: 40px">
                    <label
                        class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                        style='font-weight:500;font-size:10px;color:#333'>
                        {{ $items[$index]['stores'][$i]['customer_prices'][$key]['customer_name'] }}</label>
                    <input type="text"
                        class="form-control  mb-0 initial-balance-input width-full mx-0  dinar_sell_price"
                        wire:model="items.{{ $index }}.stores.{{ $i }}.customer_prices.{{ $key }}.dinar_sell_price"
                        placeholder = "{{ $items[$index]['stores'][$i]['customer_prices'][$key]['customer_name'] }}">
                    <span class="dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }} "
                        style='font-weight:500;font-size:10px;color:#888'>{{ $items[$index]['stores'][$i]['customer_prices'][$key]['dollar_sell_price'] }}
                        $</span>
                    @error('items.' . $index . '.stores' . $i . 'customer_prices' . $key . '.dinar_sell_price')
                        <br>
                        <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>
            @endforeach

            <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column justify-content-center align-items-center mt-1"
                style="width: 85px;background-color: #596fd7;color: white;border-radius: 6px">
                <label for="purchase_price"
                    class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                    style='font-weight:500;font-size:10px;color:white!important'>{{ __('lang.new_stock') }}</label>
                <span class="current_stock_text" style="font-weight: 600">
                    {{ $store['total_stock'] }}
                </span>
            </div>


            <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-row justify-content-center @if (app()->isLocale('ar')) align-items-center @else align-items-start @endif pl-1 mx-1  mt-1"
                style="width: 100px;">
                <label for="">{{ __('lang.change_current_stock') }}</label>
                <input type="checkbox" name="change_price"
                    wire:model="items.{{ $index }}.stores.{{ $i }}.change_price_stock">
            </div>
        </div>
    </div>
@endforeach

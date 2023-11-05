{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}
<style>
    .accordion-item {
        background-color: transparent
    }

    .accordion-button {
        padding: 8px !important;
        width: fit-content !important;
        background-color: #596fd7 !important;
        color: white !important;
        border-radius: 6px !important;
        cursor: pointer;
    }

    .accordion-content {
        display: none;
    }
</style>
<div
    class="d-flex flex-wrap justify-content-between align-items-center p-2 rounded-3 text-center mb-3 @if ($index % 2 == 0) bg-light-gray @else bg-dark-gray @endif">

    <div class="col-12 d-flex justify-content-between align-items-center" style="height: 40px">
        <div class="col-md-6">
            <div class=" d-flex justify-content-center align-items-center text-white"
                style="width: 30px;height: 30px; border-radius: 50%;background-color: #596fd7">
                {{ $index + 1 }}
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-end ">
            <button class="btn btn btn-primary"
                wire:click="add_product({{ $product['product']['id'] }},null,{{ $index }},1)" type="button">
                <i class="fa fa-plus"></i> @lang('lang.add_new_unit')
            </button>
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
            align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">
            <span class="mb-2" style="font-weight: 700;
             font-size: 10px;">@lang('lang.products')</span>
            {{ $product['product']['name'] }}
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
          align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">
            <span class="mb-2" style="    font-weight: 700;
         font-size: 10px;">@lang('lang.sku')</span>
            {{ $product['product']['sku'] }}
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
            align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-2" style="    font-weight: 700;
           font-size: 10px;">@lang('lang.quantity')</span>

            <input type="text" class="form-control quantity p-1" style="width: 61px;height:30px;font-size:12px;"
                required wire:model="items.{{ $index }}.quantity"
                wire:change="changeCurrentStock({{ $index }})">
            @error('items.{{ $index }}.quantity')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
              align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-2" style="    font-weight: 700;
                font-size: 10px;">@lang('lang.unit')</span>

            @if (count($product['variations']) > 0)
                <div class="d-flex justify-content-center align-items-center">
                    <select name="items.{{ $index }}.variation_id" id="unit_name" class="form-control select"
                        style="width: 100%;font-size: 10px;" wire:model="items.{{ $index }}.variation_id"
                        wire:change="getVariationData({{ $index }})">
                        <option value="" selected>{{ __('lang.please_select') }}</option>
                        @foreach ($product['variations'] as $variant)
                            @if (!empty($variant['unit_id']))
                                <option value="{{ $variant['id'] }}">{{ $variant['unit']['name'] ?? '' }}</option>
                            @endif
                        @endforeach
                    </select>
                    {{-- <button type="button" class="btn btn-primary btn-sm "
                        style="padding: 2px;font-size: 10px; height: 20px;"
                        wire:click="add_product({{ $product['product']['id'] }},'unit',{{ $index }})">
                        <i class="fa fa-plus"></i>
                    </button> --}}
                </div>
            @else
                <span>@lang('lang.no_units')</span>
            @endif
            @error('items.' . $index . '.variation_id')
                <span class="error text-danger">{{ $message }}</span>
            @enderror

        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
             align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-2" style="    font-weight: 700;
            font-size: 10px;">@lang('lang.fill')</span>


        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                 align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-2" style="    font-weight: 700;
            font-size: 10px;">@lang('lang.basic_unit')</span>
            <span>{{ $product['unit'] }}</span>


        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex
                align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-1" style="    font-weight: 700;
            font-size: 10px;">@lang('lang.to_get_sell_price')</span>
            <div class="d-flex justify-content-between align-items-center">
                <select class="custom-select " style="width:35px;font-size:10px;height:30px;padding: 0"
                    wire:model="items.{{ $index }}.fill_type" wire:change="changeFilling({{ $index }})">
                    <option selected value="fixed">@lang('lang.fixed')</option>
                    <option value="percent">%</option>
                </select>
                <div class="input-group-prepend " style="width: 40px;margin-right: 3px">
                    <input type="text" class="form-control" wire:model="items.{{ $index }}.fill_quantity"
                        wire:change="changeFilling({{ $index }})" style="padding: 0;height:30px;font-size:12px;"
                        required>
                </div>

            </div>
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1 ">
        <div class="dollar-cell d-flex  flex-grow-1 flex-wrap justify-content-center
                align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.purchase_price')$</span>
            <input type="text" class="form-control" style="width: 61px;height:30px;font-size:12px;" required
                wire:model="items.{{ $index }}.dollar_purchase_price"
                wire:change="changeFilling({{ $index }})">
            @error('items.' . $index . '.dollar_purchase_price')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1 ">
        <div class="dollar-cell d-flex  flex-grow-1 flex-wrap justify-content-center
                 align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.selling_price')$</span>
            <input type="text" class="form-control" style="width: 61px;height:30px;font-size:12px;" required
                wire:model="items.{{ $index }}.dollar_selling_price">
            @error('items.' . $index . '.dollar_selling_price')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1 ">
        <div class="dollar-cell d-flex  flex-grow-1 flex-wrap justify-content-center
                 align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.sub_total')$</span>
            @if (!empty($product['quantity']) && (!empty($product['dollar_purchase_price']) || !empty($product['purchase_price'])))
                <span class="sub_total_span">
                    {{ $this->dollar_sub_total($index) }}
                </span>
            @endif
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.purchase_price')</span>
            <input type="text" class="form-control" wire:model="items.{{ $index }}.purchase_price"
                wire:change="changeFilling({{ $index }})" style="width: 61px;height:30px;font-size:12px;"
                required>
            @error('items.' . $index . '.purchase_price')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
               align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.selling_price')</span>
            <input type="text" class="form-control " wire:model="items.{{ $index }}.selling_price"
                style="width: 61px;height:30px;font-size:12px;" required>
            @error('items.' . $index . '.selling_price')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
              align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.sub_total')</span>
            @if (!empty($product['quantity']) && (!empty($product['purchase_price']) || !empty($product['dollar_purchase_price'])))
                <span class="sub_total_span">
                    {{ $this->sub_total($index) }}
                </span>
            @endif
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                 align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.size')</span>
            <span class="size">
                {{ $product['size'] }}
            </span>
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.total_size')</span>
            @if (!empty($product['quantity']))
                <span class="total_size">
                    {{ $this->total_size($index) }}
                </span>
            @else
                {{ 0.0 }}
            @endif
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                 align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.weight')</span>
            <span class="weight">
                {{ $product['weight'] }}
            </span>
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
              align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">

            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.total_weight')</span>
            @if (!empty($product['quantity']))
                <span class="total_weight">
                    {{ $this->total_weight($index) }}
                </span>
            @else
                {{ 0.0 }}
            @endif
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class="dollar-cell d-flex  flex-grow-1 flex-wrap justify-content-center
                  align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">
            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.cost')$</span>
            @if (!empty($product['quantity']) && (!empty($product['dollar_purchase_price']) || !empty($product['purchase_price'])))
                <span class="dollar_cost">
                    {{ $this->dollar_cost($index) }}
                </span>
            @else
                {{ 0.0 }}
            @endif
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class="dollar-cell d-flex  flex-grow-1 flex-wrap justify-content-center
                 align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">
            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.total_cost')$</span>
            @if (!empty($product['quantity']) && (!empty($product['dollar_purchase_price']) || !empty($product['purchase_price'])))
                <span class="dollar_total_cost">
                    {{ $this->dollar_total_cost($index) }}
                </span>
            @else
                {{ 0.0 }}
            @endif
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                  align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">
            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.cost')</span>
            @if (!empty($product['quantity']) && (!empty($product['purchase_price']) || !empty($product['dollar_purchase_price'])))
                <span class="cost">
                    {{ $this->cost($index) }}
                </span>
            @else
                {{ 0.0 }}
            @endif
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">
            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.total_cost')</span>
            @if (isset($product['quantity']) && (isset($product['purchase_price']) || isset($product['dollar_purchase_price'])))
                <span class="cost">
                    {{ $this->cost($index) }}
                </span>
            @else
                {{ 0.0 }}
            @endif
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
              align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">
            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.new_stock')</span>
            <span class="current_stock_text">
                {{ $product['total_stock'] }}
            </span>
        </div>
    </div>



    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                 align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 70px;">
            <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.change_current_stock')</span>
            <input type="checkbox" name="change_price" wire:model="items.{{ $index }}.change_price_stock">
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
               align-items-center rounded-3 text-center mb-1 flex-column align-items-center "
            style="font-size: 11px;height: 70px;">

            {{-- <span class="mb-2" style="    font-weight: 700;
    font-size: 10px;">@lang('lang.action')</span> --}}
            <div class="btn btn-sm btn-danger py-0 px-1" wire:click="delete_product({{ $index }})">
                <i class="fa fa-trash"></i>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column" style="width: 100%">
        <div class="accordion mb-1">
            <div class="accordion-item" style="border: none">
                <h2 class="accordion-header">
                    <div class="accordion-button"
                        onclick="toggleAccordion(`collapseOne{{ $index }}discount`)">
                        @lang('lang.discount')
                    </div>
                </h2>
                <div id="collapseOne{{ $index }}discount" class="accordion-content">
                    <div class="accordion-body p-0">
                        @foreach ($product['prices'] as $key => $price)
                            <div class="d-flex flex-wrap justify-content-between width-full mb-2"
                                style="background-color: whitesmoke;
                                                                padding: 5px;
                                                                border-radius: 6px;">

                                <div style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;"
                                    class="d-flex justify-content-center align-items-center flex-column">
                                    {!! Form::label('price_category', __('lang.price_category'), ['style' => 'font-weight:700;font-size: 10px;']) !!}
                                    <input style="width: 61px;height:30px;font-size:12px;" type="text"
                                        class="form-control price_category" name="price_category"
                                        wire:model="items.{{ $index }}.prices.{{ $key }}.price_category"
                                        maxlength="6">
                                </div>

                                <div style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;"
                                    class="d-flex justify-content-center align-items-center flex-column">
                                    {!! Form::label('price_type', __('lang.type'), ['style' => 'font-weight:700;font-size: 10px;']) !!}
                                    {!! Form::select(
                                        'items.' . $index . '.prices.' . $key . '.price_type',
                                        ['fixed' => __('lang.fixed'), 'percentage' => __('lang.percentage')],
                                        null,
                                        [
                                            'class' => ' form-control price_type',
                                            'style' => 'width: 61px;height:30px;font-size:12px;',
                                            //                'data-index' =>$index,
                                            'placeholder' => __('lang.please_select'),
                                            'wire:model' => 'items.' . $index . '.prices.' . $key . '.price_type',
                                            'wire:change' => 'changePrice(' . $index . ',' . $key . ')',
                                        ],
                                    ) !!}
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox"
                                            class="custom-control-input product-discount_from_original_price"
                                            name="discount_from_original_price" id="discount_from_original_price"
                                            style="font-size: 0.75rem;border-radius: 12px;height: 30px;"
                                            @if (!empty($discount_from_original_price) && $discount_from_original_price == '1') checked @endif
                                            wire:change="changePrice({{ $index }}, {{ $key }})">
                                        <label class="custom-control-label product-custom-label"
                                            id="custom-control-label" style="font-size: 8px"
                                            for="discount_from_original_price">
                                            @lang('lang.discount_from_original_price')
                                        </label>
                                    </div>
                                    @error('items.' . $index . '.prices.' . $key . '.price_type')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;"
                                    class="d-flex justify-content-center align-items-center flex-column">

                                    {!! Form::label(
                                        'price',
                                        !empty($price['price_type']) && $price['price_type'] == 'fixed' ? __('lang.amount') : __('lang.percent'),
                                        ['style' => 'font-weight:700;font-size: 10px;'],
                                    ) !!}
                                    <input type="text" style="width: 61px;height:30px;font-size:12px;"
                                        name="price" class="form-control price"
                                        wire:model="items.{{ $index }}.prices.{{ $key }}.price"
                                        wire:change="changePrice({{ $index }}, {{ $key }})"
                                        placeholder = "{{ __('lang.percent') }}">
                                </div>

                                <div style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;"
                                    class="d-flex justify-content-center align-items-center flex-column">
                                    {!! Form::label('', __('lang.price'), ['style' => 'font-weight:700;font-size: 10px;']) !!}
                                    <input type="text" style="width: 61px;height:30px;font-size:12px;"
                                        name="" class="form-control price"
                                        wire:model="items.{{ $index }}.prices.{{ $key }}.price_after_desc"
                                        placeholder = "{{ __('lang.price') }}" readonly>
                                </div>

                                <div style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;"
                                    class="d-flex justify-content-center align-items-center flex-column">
                                    {!! Form::label('price', __('lang.quantity'), ['style' => 'font-weight:700;font-size: 10px;']) !!}
                                    <input style="width: 61px;height:30px;font-size:12px;" type="text"
                                        class="form-control discount_quantity"
                                        wire:model="items.{{ $index }}.prices.{{ $key }}.discount_quantity"
                                        wire:change="changePrice({{ $index }}, {{ $key }})"
                                        placeholder = "{{ __('lang.quantity') }}">

                                </div>

                                <div style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;"
                                    class="d-flex justify-content-center align-items-center flex-column">
                                    {!! Form::label('b_qty', __('lang.b_qty'), ['style' => 'font-weight:700;font-size: 10px;']) !!}
                                    <input style="width: 61px;height:30px;font-size:12px;" type="text"
                                        class="form-control bonus_quantity"
                                        wire:model="items.{{ $index }}.prices.{{ $key }}.bonus_quantity"
                                        wire:change="changePrice({{ $index }}, {{ $key }})"
                                        placeholder = "{{ __('lang.b_qty') }}">

                                </div>
                                <div style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;"
                                    class="d-flex justify-content-center align-items-center flex-column">
                                    {!! Form::label('total_price', __('lang.total_price'), ['style' => 'font-weight:700;font-size: 10px;']) !!}
                                    <input type="text" style="width: 61px;height:30px;font-size:12px;"
                                        name="total_price" class="form-control total_price"
                                        wire:model="items.{{ $index }}.prices.{{ $key }}.total_price"
                                        placeholder = "{{ __('lang.total_price') }}">

                                </div>
                                <div style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;"
                                    class="d-flex justify-content-center align-items-center flex-column">
                                    {!! Form::label('piece_price', __('lang.piece_price'), ['style' => 'font-weight:700;font-size: 10px;']) !!}
                                    <input type="text" name="piece_price"
                                        style="width: 61px;height:30px;font-size:12px;"
                                        class="form-control piece_price"
                                        wire:model="items.{{ $index }}.prices.{{ $key }}.piece_price"
                                        placeholder = "{{ __('lang.total_price') }}">

                                </div>

                                <div style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;"
                                    class="d-flex justify-content-center align-items-center flex-column">
                                    {!! Form::label('customer_type', __('lang.customer_type'), ['style' => 'font-weight:700;font-size: 10px;']) !!}
                                    <select
                                        wire:model="items.{{ $index }}.prices.{{ $key }}.price_customer_types"
                                        data-name='price_customer_types' data-index="{{ $key }}"
                                        class="form-control js-example-basic-multiple" multiple='multiple'
                                        style="border-radius:6px !important; border: 2px solid gray"
                                        placeholder="{{ __('lang.please_select') }}">
                                        @foreach ($customer_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div style="width: 80px;padding:0;margin:0;font-size: 12px;border-radius: 6px;"
                                    class="d-flex justify-content-center align-items-center col-md-1">
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

        <div class="accordion">
            <div class="accordion-item" style="border: none">
                <h2 class="accordion-header">
                    <div class="accordion-button"
                        onclick="toggleAccordion(`collapseOne{{ $index }}validity`)">
                        @lang('lang.validity')
                    </div>
                </h2>
                <div id="collapseOne{{ $index }}validity" class="accordion-content">
                    <div class="accordion-body p-0" style="">

                        <div class="p-0 d-flex flex-wrap justify-content-between align-items-center py-2 rounded-3 text-center"
                            style="width: 100%;background-color: whitesmoke;
                                                                padding: 5px;
                                                                border-radius: 6px;">

                            <div class="col-md-3"
                                style="font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px">
                                {!! Form::label('', __('lang.expiry_date'), ['style' => 'font-weight:700;font-size: 10px;']) !!}
                                {!! Form::date('add_stock_lines[' . $index . '][expiry_date]', null, [
                                    'class' => 'form-control datepicker expiry_date',
                                    'wire:model' => 'items.' . $index . '.expiry_date',
                                ]) !!}
                            </div>
                            <div class="col-md-3"
                                style="font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px">
                                {!! Form::label('', __('lang.days_before_the_expiry_date'), ['style' => 'font-weight:700;font-size: 10px;']) !!}
                                {!! Form::text('add_stock_lines[' . $index . '][expiry_warning]', null, [
                                    'class' => 'form-control days_before_the_expiry_date',
                                    'wire:model' => 'items.' . $index . '.expiry_warning',
                                ]) !!}
                            </div>
                            <div class="col-md-3"
                                style="font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px">
                                {!! Form::label('', __('lang.convert_status_expire'), ['style' => 'font-weight:700;font-size: 10px;']) !!}
                                {!! Form::text('add_stock_lines[' . $index . '][convert_status_expire]', null, [
                                    'class' => 'form-control',
                                    'wire:model' => 'items.' . $index . '.convert_status_expire',
                                ]) !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<script>
    const checkbox = document.getElementById('discount_from_original_price');
    const label = document.getElementById('custom-control-label');

    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            label.textContent = "@lang('lang.discount_from_original_price')";
        } else {
            label.textContent = "@lang('lang.discount_from_original_price_with_free_quantity')";
        }
    });
</script>

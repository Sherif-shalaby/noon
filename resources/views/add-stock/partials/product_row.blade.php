<div class="d-flex flex-wrap justify-content-between align-items-center p-2 rounded-3 text-center mb-3"
    style="background-color: rgba(214, 214, 214, 0.439);">

    <div class="col-12 d-flex justify-content-between align-items-center" style="height: 40px">
        <div class="col-md-6">
            <div class=" d-flex justify-content-center align-items-center text-white"
                style="width: 30px;height: 30px; border-radius: 50%;background-color: #596fd7">
                {{ $index + 1 }}
            </div>
        </div>
        <div class="col-md-6">

        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
            align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.products')</span>
            {{ $product['product']['name'] }}
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
          align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">
            <span class="mb-2">@lang('lang.sku')</span>
            {{ $product['product']['sku'] }}
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
            align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.quantity')</span>

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
              align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.unit')</span>

            @if (count($product['variations']) > 0)
                <div class="d-flex justify-content-center">
                    <select name="items.{{ $index }}.variation_id" id="unit_name" class="form-control select"
                        style="width: 130px" wire:model="items.{{ $index }}.variation_id"
                        wire:change="getVariationData({{ $index }})">
                        <option value="" selected>{{ __('lang.please_select') }}</option>
                        @foreach ($product['variations'] as $variant)
                            <option value="{{ $variant['id'] }}">{{ $variant['unit']['name'] }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-primary btn-sm "
                        wire:click="add_product({{ $product['product']['id'] }},'unit',{{ $index }})">
                        <i class="fa fa-plus"></i>
                    </button>
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
             align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.fill')</span>


        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                 align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.basic_unit')</span>
            <span>{{ $product['unit'] }}</span>


        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex
                align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.to_get_sell_price')</span>
            <div class="d-flex justify-content-between flex-column align-items-center">
                <select class="custom-select " style="width:65px;font-size:10px;height:30px;padding: 0"
                    wire:model="items.{{ $index }}.fill_type" wire:change="changeFilling({{ $index }})">
                    <option selected value="fixed">@lang('lang.fixed')</option>
                    <option value="percent">%</option>
                </select>
                <div class="input-group-prepend align-items-center justify-content-center">
                    <input type="text" class="form-control" wire:model="items.{{ $index }}.fill_quantity"
                        wire:change="changeFilling({{ $index }})"
                        style="padding: 0;width: 80%;height:30px;font-size:12px;" required>
                </div>

            </div>
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.purchase_price')$</span>
            <input type="text" class="form-control" style="width: 61px;height:30px;font-size:12px;" required
                wire:model="items.{{ $index }}.dollar_purchase_price"
                wire:change="changeFilling({{ $index }})">
            @error('items.' . $index . '.dollar_purchase_price')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                 align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.selling_price')$</span>
            <input type="text" class="form-control" style="width: 61px;height:30px;font-size:12px;" required
                wire:model="items.{{ $index }}.dollar_selling_price">
            @error('items.' . $index . '.dollar_selling_price')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1" title="{{ __('lang.sub_total') }} $">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                 align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.sub_total')$</span>
            @if (!empty($product['quantity']) && (!empty($product['dollar_purchase_price']) || !empty($product['purchase_price'])))
                <span class="sub_total_span">
                    {{ $this->dollar_sub_total($index) }}
                </span>
            @endif
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.purchase_price')</span>
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
               align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.selling_price')</span>
            <input type="text" class="form-control " wire:model="items.{{ $index }}.selling_price"
                style="width: 61px;height:30px;font-size:12px;" required>
            @error('items.' . $index . '.selling_price')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
              align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.sub_total')</span>
            @if (!empty($product['quantity']) && (!empty($product['purchase_price']) || !empty($product['dollar_purchase_price'])))
                <span class="sub_total_span">
                    {{ $this->sub_total($index) }}
                </span>
            @endif
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                 align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.size')</span>
            <span class="size">
                {{ $product['size'] }}
            </span>
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.total_size')</span>
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
                 align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.weight')</span>
            <span class="weight">
                {{ $product['weight'] }}
            </span>
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
              align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">

            <span class="mb-2">@lang('lang.total_weight')</span>
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
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                  align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">
            <span class="mb-2">@lang('lang.cost')$</span>
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
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                 align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">
            <span class="mb-2">@lang('lang.total_cost')$</span>
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
                  align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">
            <span class="mb-2">@lang('lang.cost')</span>
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
                align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">
            <span class="mb-2">@lang('lang.total_cost')</span>
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
              align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">
            <span class="mb-2">@lang('lang.new_stock')</span>
            <span class="current_stock_text">
                {{ $product['total_stock'] }}
            </span>
        </div>
    </div>



    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
                 align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="background-color: white;font-size: 11px;height: 110px;">
            <span class="mb-2">@lang('lang.change_current_stock')</span>
            <input type="checkbox" name="change_price" wire:model="items.{{ $index }}.change_price_stock">
        </div>
    </div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 p-1">
        <div class=" d-flex  flex-grow-1 flex-wrap justify-content-center
               align-items-center rounded-3 text-center mb-3 flex-column align-items-center "
            style="font-size: 11px;height: 110px;">

            {{-- <span class="mb-2">@lang('lang.action')</span> --}}
            <div class="btn btn-sm btn-danger py-0 px-1" wire:click="delete_product({{ $index }})">
                <i class="fa fa-trash"></i>

            </div>
        </div>
    </div>


    <div style="width: 100%" class="accordion mt-1 p-3" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" style="padding: 5px 15px" type="button"
                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{ $index }}"
                    aria-expanded="false" aria-controls="panelsStayOpen-collapse{{ $index }}">
                    <h6>
                        @lang('lang.discount')
                    </h6>
                    <span class="accordion-arrow">
                        @if (true)
                            <i class="fas fa-arrow-up" style="font-size: 0.8rem"></i>
                        @else
                            <i class="fas fa-arrow-down" style="font-size: 0.8rem"></i>
                        @endif
                    </span>
                </button>
                {{-- <button class="accordion-button collapsed" style="padding: 5px 15px" type="button"
                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{ $index }}"
                    aria-expanded="true" aria-controls="panelsStayOpen-collapse{{ $index }}"
                    wire:click="stayShow({{ $index }})">
                    <h6>
                        @lang('lang.discount')
                    </h6>
                </button> --}}
            </h2>
            <div id="panelsStayOpen-collapse{{ $index }}" class="accordion-collapse collapse show">
                @foreach ($product['prices'] as $key => $price)
                    <div
                        class="accordion-body p-0 d-flex flex-wrap justify-content-between align-items-center py-2 rounded-3 text-center">
                        <div class="d-flex flex-wrap justify-content-between col-md-11">

                            <div
                                style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;">
                                {!! Form::label('price_category', __('lang.price_category'), ['style' => 'font-size:10px']) !!}
                                <input style="width: 61px;height:30px;font-size:12px;" type="text"
                                    class="form-control price_category" name="price_category"
                                    wire:model="items.{{ $index }}.prices.{{ $key }}.price_category"
                                    maxlength="6">
                            </div>

                            <div
                                style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;">
                                {!! Form::label('price_type', __('lang.type'), ['style' => 'font-size:10px']) !!}
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
                                    <input type="checkbox" class="custom-control-input"
                                        name="discount_from_original_price" id="discount_from_original_price"
                                        style="font-size: 0.75rem;border-radius: 12px;height: 30px;"
                                        @if (!empty($discount_from_original_price) && $discount_from_original_price == '1') checked @endif>
                                    <label class="custom-control-label" id="custom-control-label"
                                        style="font-size: 8px"
                                        for="discount_from_original_price">@lang('lang.discount_from_original_price_with_free_quantity')</label>
                                </div>
                                @error('items.' . $index . '.prices.' . $key . '.price_type')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div
                                style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;">

                                {!! Form::label(
                                    'price',
                                    !empty($price['price_type']) && $price['price_type'] == 'fixed' ? __('lang.amount') : __('lang.percent'),
                                    ['style' => 'font-size:10px'],
                                ) !!}
                                <input type="text" style="width: 61px;height:30px;font-size:12px;" name="price"
                                    class="form-control price"
                                    wire:model="items.{{ $index }}.prices.{{ $key }}.price"
                                    wire:change="changePrice({{ $index }}, {{ $key }})"
                                    placeholder = "{{ __('lang.percent') }}">
                            </div>

                            <div
                                style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;">
                                {!! Form::label('', __('lang.price'), ['style' => 'font-size:10px']) !!}
                                <input type="text" style="width: 61px;height:30px;font-size:12px;" name=""
                                    class="form-control price"
                                    wire:model="items.{{ $index }}.prices.{{ $key }}.price_after_desc"
                                    placeholder = "{{ __('lang.price') }}" readonly>
                            </div>

                            <div
                                style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;">
                                {!! Form::label('price', __('lang.quantity'), ['style' => 'font-size:10px']) !!}
                                <input style="width: 61px;height:30px;font-size:12px;" type="text"
                                    class="form-control discount_quantity"
                                    wire:model="items.{{ $index }}.prices.{{ $key }}.discount_quantity"
                                    placeholder = "{{ __('lang.quantity') }}">

                            </div>

                            <div
                                style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;">
                                {!! Form::label('b_qty', __('lang.b_qty'), ['style' => 'font-size:10px']) !!}
                                <input style="width: 61px;height:30px;font-size:12px;" type="text"
                                    class="form-control bonus_quantity"
                                    wire:model="items.{{ $index }}.prices.{{ $key }}.bonus_quantity"
                                    placeholder = "{{ __('lang.b_qty') }}">

                            </div>
                            <div
                                style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;">
                                {!! Form::label('total_price', __('lang.total_price'), ['style' => 'font-size:10px']) !!}
                                <input type="text" style="width: 61px;height:30px;font-size:12px;"
                                    name="total_price" class="form-control total_price"
                                    wire:model="items.{{ $index }}.prices.{{ $key }}.total_price"
                                    placeholder = "{{ __('lang.total_price') }}">

                            </div>
                            <div
                                style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;">
                                {!! Form::label('piece_price', __('lang.piece_price'), ['style' => 'font-size:10px']) !!}
                                <input type="text" name="piece_price"
                                    style="width: 61px;height:30px;font-size:12px;" class="form-control piece_price"
                                    wire:model="items.{{ $index }}.prices.{{ $key }}.piece_price"
                                    placeholder = "{{ __('lang.total_price') }}">

                            </div>

                            <div
                                style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;">
                                {!! Form::label('customer_type', __('lang.customer_type'), ['style' => 'font-size:10px']) !!}
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

                        </div>
                        <div style="width: 80px;padding:0;margin:0;font-size: 12px;background-color: white;border-radius: 6px;"
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


    <div class="p-0 d-flex flex-wrap justify-content-between align-items-center py-2 rounded-3 text-center"
        style="width: 100%">
        <div class="col-md-3"
            style="font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px">
            {!! Form::label('', __('lang.expiry_date'), ['style' => 'font-size:10px']) !!}
            {!! Form::date('add_stock_lines[' . $index . '][expiry_date]', null, [
                'class' => 'form-control datepicker expiry_date',
                'wire:model' => 'items.' . $index . '.expiry_date',
            ]) !!}
        </div>
        <div class="col-md-3"
            style="font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px">
            {!! Form::label('', __('lang.days_before_the_expiry_date'), ['style' => 'font-size:10px']) !!}
            {!! Form::text('add_stock_lines[' . $index . '][expiry_warning]', null, [
                'class' => 'form-control days_before_the_expiry_date',
                'wire:model' => 'items.' . $index . '.expiry_warning',
            ]) !!}
        </div>
        <div class="col-md-3"
            style="font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px">
            {!! Form::label('', __('lang.convert_status_expire'), ['style' => 'font-size:10px']) !!}
            {!! Form::text('add_stock_lines[' . $index . '][convert_status_expire]', null, [
                'class' => 'form-control',
                'wire:model' => 'items.' . $index . '.convert_status_expire',
            ]) !!}
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
{{--
<script>
    // Select all elements with the class "my-class" and add a click event listener to each element
    const elements = document.querySelectorAll(".accordion-button");
    for (const element of elements) {
        element.addEventListener("click", function() {
            // Do something when the element is clicked
            const dataIndex = element.getAttribute("data-index");
            let accs = document.querySelectorAll(".accordion-collapse")
            for (const acc of accs) {
                if (acc.getAttribute('data-index') == dataIndex) {
                    acc.classList.toggle('show')
                }
            }
        });
    }
</script> --}}

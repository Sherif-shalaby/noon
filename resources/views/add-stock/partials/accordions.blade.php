<div class="d-flex flex-column mb-2 @if ($index % 2 == 0) bg-white @else bg-dark-gray @endif"
    style="width: 100%">


    <div style="width: 100%;" class="accordion m-1 " id="accordionPanelsStayOpenExample">
        <div class="accordion-item" style="border: none">
            <h2 class="accordion-header">
                <button class="accordion-button dis-button collapsed" style="padding: 5px 15px;margin-bottom: 15px"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#panelsStayOpen-collapse{{ $index }}discount"
                    data-index="{{ $index }}" aria-expanded="true"
                    aria-controls="panelsStayOpen-collapse{{ $index }}discount"
                    wire:click="stayShowDiscount({{ $index }})">
                    <h6>
                        @lang('lang.discount')
                    </h6>
                    <span class="accordion-arrow">
                        @if ($product['show_discount'])
                            <i class="fas fa-arrow-up" style="font-size: 0.8rem"></i>
                        @else
                            <i class="fas fa-arrow-down" style="font-size: 0.8rem"></i>
                        @endif
                    </span>
                </button>
            </h2>
            <div id="panelsStayOpen-collapse{{ $index }}discount"
                class="accordion-collapse collapse @if ($product['show_discount']) show @endif">
                <div class="accordion-body @if ($index % 2 == 0) bg-white @else bg-dark-gray @endif p-0">
                    @foreach ($product['prices'] as $key => $price)
                        <div class="d-flex flex-wrap @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif width-full mb-2"
                            style="margin-top:-15px ">

                            <div style="width: 80px;padding:0;margin:0;font-size: 12px;"
                                class="d-flex justify-content-center align-items-center flex-column mx-1">
                                {!! Form::label('price_category', __('lang.price_category'), [
                                    'style' => 'font-weight:700;font-size: 10px;',
                                    'class' => 'mb-0',
                                ]) !!}
                                <input style="height:30px;font-size:12px;" type="text"
                                    class="form-control mt-0 initial-balance-input width-full price_category"
                                    name="price_category"
                                    wire:model="items.{{ $index }}.prices.{{ $key }}.price_category"
                                    maxlength="6">
                            </div>

                            <div style="width: 145px;padding:0;margin:0;margin-top: 13px"
                                class="d-flex justify-content-center align-items-end flex-column mx-1">
                                {!! Form::label('price_type', __('lang.type'), [
                                    'class' => 'mb-0 mx-2',
                                    'style' => 'font-weight:700;font-size: 10px;',
                                ]) !!}
                                <div class="input-wrapper" style="width: 100%">
                                    {!! Form::select(
                                        'items.' . $index . '.prices.' . $key . '.price_type',
                                        ['fixed' => __('lang.fixed'), 'percentage' => __('lang.percentage')],
                                        null,
                                        [
                                            'class' => ' form-select width-full price_type',
                                            'style' => 'height:30px;font-size:12px;',
                                            //                'data-index' =>$index,
                                            'wire:key' => 'collapseOndiscountsaxas',
                                            'placeholder' => __('lang.please_select'),
                                            'wire:model' => 'items.' . $index . '.prices.' . $key . '.price_type',
                                            'wire:change' => 'changePrice(' . $index . ',' . $key . ')',
                                        ],
                                    ) !!}
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input"
                                        name="discount_from_original_price"
                                        id="discount_from_original_price{{ $key }}"
                                        style="font-size: 0.75rem;border-radius: 12px;height: 30px;"
                                        @if (!empty($discount_from_original_price) && $discount_from_original_price == '1') checked @endif
                                        wire:change="change_discount_from_original_price({{ $index }})">
                                    <label class="custom-control-label" style="font-size: 8px"
                                        for="discount_from_original_price">
                                        @lang('lang.discount_from_original_price')
                                    </label>
                                </div>
                                @error('items.' . $index . '.prices.' . $key . '.price_type')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div style="width: 80px;padding:0;margin:0;font-size: 12px;"
                                class="d-flex justify-content-center align-items-end mx-1 flex-column">

                                {!! Form::label(
                                    'price',
                                    !empty($price['price_type']) && $price['price_type'] == 'fixed' ? __('lang.amount') : __('lang.percent'),
                                    ['style' => 'font-weight:700;font-size: 10px;', 'class' => 'mb-0 mx-2'],
                                ) !!}
                                <input type="text" style="height:30px;font-size:12px;" name="price"
                                    class="form-control initial-balance-input width-full mt-0 price"
                                    wire:model="items.{{ $index }}.prices.{{ $key }}.price"
                                    wire:change="changePrice({{ $index }}, {{ $key }})"
                                    placeholder = "{{ !empty($price['price_type']) && $price['price_type'] == 'fixed' ? __('lang.amount') : __('lang.percent') }}">
                            </div>

                            <div style="width: 80px;padding:0;margin:0;font-size: 12px;"
                                class="d-flex justify-content-center align-items-end mx-1 flex-column">
                                {!! Form::label('', __('lang.price'), ['style' => 'font-weight:700;font-size: 10px;', 'class' => 'mb-0 mx-2']) !!}
                                <input type="text" style="height:30px;font-size:12px;" name=""
                                    class="form-control initial-balance-input width-full mt-0 price"
                                    wire:model="items.{{ $index }}.prices.{{ $key }}.price_after_desc"
                                    placeholder = "{{ __('lang.price') }}">
                            </div>
                            <div style="width: 130px;padding:0;margin:0;font-size: 12px;margin-top:-10px"
                                class="d-flex justify-content-center align-items-end flex-column">
                                @if (count($product['variations']) > 0)
                                    <label class="mb-0 mx-2" for="">{{ __('lang.unit') }}</label>
                                    <div class="input-wrapper" style="width: 100%">
                                        <select name="items.{{ $index }}.prices.{{ $key }}.fill_id"
                                            class="form-select mt-0"
                                            wire:model="items.{{ $index }}.prices.{{ $key }}.fill_id">
                                            <option value="" selected>{{ __('lang.please_select') }}
                                            </option>
                                            @foreach ($product['variations'] as $variant)
                                                @if (!empty($variant['unit_id']))
                                                    <option value="{{ $variant['id'] }}">
                                                        {{ $variant['unit']['name'] ?? '' }}
                                                    </option>
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

                            <div style="width: 80px;padding:0;margin:0;font-size: 12px;"
                                class="d-flex justify-content-center align-items-end mx-1 flex-column">
                                {!! Form::label('price', __('lang.quantity'), [
                                    'style' => 'font-weight:700;font-size: 10px;',
                                    'class' => 'mx-1 mb-0',
                                ]) !!}
                                <input style="height:30px;font-size:12px;" type="text"
                                    class="form-control initial-balance-input width-full mt-0 discount_quantity"
                                    wire:model="items.{{ $index }}.prices.{{ $key }}.discount_quantity"
                                    wire:change="changePrice({{ $index }}, {{ $key }})"
                                    placeholder = "{{ __('lang.quantity') }}">

                            </div>

                            <div style="width: 80px;padding:0;margin:0;font-size: 12px;"
                                class="d-flex justify-content-center align-items-end mx-1 flex-column">
                                {!! Form::label('b_qty', __('lang.b_qty'), [
                                    'style' => 'font-weight:700;font-size: 10px;',
                                    'class' => 'mx-1 mb-0',
                                ]) !!}
                                <input style="height:30px;font-size:12px;" type="text"
                                    class="form-control  initial-balance-input width-full mt-0 bonus_quantity"
                                    wire:model="items.{{ $index }}.prices.{{ $key }}.bonus_quantity"
                                    wire:change="changePrice({{ $index }}, {{ $key }})"
                                    placeholder = "{{ __('lang.b_qty') }}">

                            </div>

                            <div style="width: 80px;padding:0;margin:0;font-size: 12px;"
                                class="d-flex justify-content-center align-items-end mx-1 flex-column">
                                {!! Form::label('total_price', __('lang.total_price'), [
                                    'style' => 'font-weight:700;font-size: 10px;',
                                    'class' => 'mx-1 mb-0',
                                ]) !!}
                                <input type="text" style="height:30px;font-size:12px;" name="total_price"
                                    class="form-control initial-balance-input width-full mt-0 total_price"
                                    wire:model="items.{{ $index }}.prices.{{ $key }}.total_price"
                                    placeholder = "{{ __('lang.total_price') }}">

                            </div>

                            <div style="width: 80px;padding:0;margin:0;font-size: 12px;"
                                class="d-flex justify-content-center align-items-end mx-1 flex-column">
                                {!! Form::label('piece_price', __('lang.piece_price'), [
                                    'style' => 'font-weight:700;font-size: 10px;',
                                    'class' => 'mx-1 mb-0',
                                ]) !!}
                                <input type="text" name="piece_price" style="height:30px;font-size:12px;"
                                    class="form-control initial-balance-input width-full mt-0 piece_price"
                                    wire:model="items.{{ $index }}.prices.{{ $key }}.piece_price"
                                    placeholder = "{{ __('lang.total_price') }}">

                            </div>

                            <div style="width: 100px;padding:0;margin:0;font-size: 12px;margin-top: -10px"
                                class="d-flex justify-content-center align-items-end mx-1 flex-column">
                                {!! Form::label('customer_type', __('lang.customer_type'), [
                                    'style' => 'font-weight:700;font-size: 10px;',
                                    'class' => 'mx-1 mb-0',
                                ]) !!}
                                <div class="input-wrapper" style="width: 100%">
                                    <select
                                        wire:model="items.{{ $index }}.prices.{{ $key }}.price_customer_types"
                                        data-name='price_customer_types' data-index="{{ $key }}"
                                        class="form-select" placeholder="{{ __('lang.please_select') }}">
                                        @foreach ($customer_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
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

    <div style="width: 100%;" class="accordion m-1" id="accordionPanelsStayOpenExample">
        <div class="accordion-item" style="border: none">
            <h2 class="accordion-header">
                <button class="accordion-button dis-button collapsed" style="padding: 5px 15px" type="button"
                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{ $index }}validity"
                    data-index="{{ $index }}" aria-expanded="true"
                    aria-controls="panelsStayOpen-collapse{{ $index }}validity"
                    wire:click="stayShowValidity({{ $index }})">
                    <h6>
                        @lang('lang.validity')
                    </h6>
                    <span class="accordion-arrow">
                        @if ($product['show_validity'])
                            <i class="fas fa-arrow-up" style="font-size: 0.8rem"></i>
                        @else
                            <i class="fas fa-arrow-down" style="font-size: 0.8rem"></i>
                        @endif
                    </span>
                </button>
            </h2>
            <div id="panelsStayOpen-collapse{{ $index }}validity"
                class="accordion-collapse collapse @if ($product['show_validity']) show @endif">
                <div class="accordion-body @if ($index % 2 == 0) bg-white @else bg-dark-gray @endif p-0">

                    <div class="p-0 mt-2 d-flex flex-wrap justify-content-between align-items-center rounded-3 text-center"
                        style="width: 100%;

                                                                border-radius: 6px;">

                        <div class="col-md-3 p-0">
                            {!! Form::label('', __('lang.expiry_date'), ['style' => 'font-weight:700;font-size: 10px;', 'class' => 'mb-0']) !!}
                            {!! Form::date('add_stock_lines[' . $index . '][expiry_date]', null, [
                                'class' => 'form-control datepicker initial-balance-input expiry_date',
                                'wire:model' => 'items.' . $index . '.expiry_date',
                            ]) !!}
                        </div>
                        <div class="col-md-3 p-0">
                            {!! Form::label('', __('lang.days_before_the_expiry_date'), [
                                'style' => 'font-weight:700;font-size: 10px;',
                                'class' => 'mb-0',
                            ]) !!}
                            {!! Form::text('add_stock_lines[' . $index . '][expiry_warning]', null, [
                                'class' => 'form-control initial-balance-input days_before_the_expiry_date',
                                'wire:model' => 'items.' . $index . '.expiry_warning',
                            ]) !!}
                        </div>
                        <div class="col-md-3 p-0">
                            {!! Form::label('', __('lang.convert_status_expire'), [
                                'style' => 'font-weight:700;font-size: 10px;',
                                'class' => 'mb-0',
                            ]) !!}
                            {!! Form::text('add_stock_lines[' . $index . '][convert_status_expire]', null, [
                                'class' => 'form-control initial-balance-input',
                                'wire:model' => 'items.' . $index . '.convert_status_expire',
                            ]) !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

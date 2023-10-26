<div class="d-flex flex-wrap justify-content-between align-items-center p-2 rounded-3 text-center mb-3 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
    style="background-color: rgba(214, 214, 214, 0.439);">

    <div class="col-md-1 d-inline-flex justify-content-center align-items-center text-white"
        style="width: 30px;height: 30px; border-radius: 50%;background-color: #596fd7">
        {{ $index + 1 }}
    </div>
    {{--  --}}
    <div
        class="d-flex col-md-11 flex-grow-1 flex-wrap justify-content-start
         align-items-center p-2 rounded-3 text-center mb-3 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">


        <div style="animation-delay: 2.1s; font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
            class="animate__animated animate__fadeInLeft table-width px-0 d-flex justify-content-center align-items-center flex-column">

            <span style="font-size: 11px" class="mb-2">@lang('lang.sku')</span>

            <input type="text" style="width: 85%" class="mx-auto form-control sku"
                wire:model="rows.{{ $index }}.sku" required>
            @error('rows.' . $index . '.sku')
                <label style="font-size: 10px;font-weight: 700;" class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>

        <div style="animation-delay: 2.2s; font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px 2px;height: 70px"
            class="animate__animated animate__fadeInLeft table-width px-0 d-flex justify-content-center align-items-center flex-column">
            <span style="font-size: 11px" class="mb-2">@lang('lang.quantity')</span>
            <input type="text" class="form-control quantity" wire:change="calculateTotalQuantity()"
                wire:model="rows.{{ $index }}.quantity" style="width: 70px;" required>
            @error('quantity')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>




        <div style="animation-delay: 2.3s; font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
            class="animate__animated animate__fadeInLeft  table-width px-0 d-flex justify-content-center align-items-center flex-column">
            <span style="font-size: 11px" class="mb-2">@lang('lang.unit')</span>
            <div class="d-flex justify-content-center" style="width: 65%;">
                <select wire:model="rows.{{ $index }}.unit_id" data-name='unit_id'
                    data-index="{{ $index }}" required class="form-control select2 unit_id{{ $index }}"
                    style="width: 100px;">
                    <option value="">{{ __('lang.please_select') }}</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}"
                            {{ $rows[$index]['unit_id'] == $unit->id ? 'selected' : '' }}>
                            {{ $unit->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-primary btn-sm ml-2 add_unit_raw" data-toggle="modal"
                    data-index="{{ $index }}" data-target=".add-unit" href="{{ route('units.create') }}"><i
                        class="fas fa-plus"></i></button>
            </div>
        </div>

        <div style="animation-delay: 2.4s;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
            class="animate__animated animate__fadeInLeft table-width px-0 d-flex justify-content-center align-items-center flex-column">
            <span style="font-size: 11px" class="mb-2">@lang('lang.fill_from_basic_unit')</span>
            <input type="text" class="form-control unit_equal" wire:model="rows.{{ $index }}.equal"
                style="width: 70px;" required>
        </div>




        <div style="animation-delay: 2.5s;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
            class="animate__animated animate__fadeInLeft table-width px-0 d-flex justify-content-center align-items-center flex-column">
            <span style="font-size: 11px" class="mb-2">@lang('lang.basic_unit')</span>
            <div class="d-flex justify-content-center align-items-center" style="width: 65%;">

                <select wire:model="rows.{{ $index }}.basic_unit_id" data-name='basic_unit_id'
                    data-index="{{ $index }}" required style=" width: fit-content"
                    class="form-control select2 basic_unit_id{{ $index }}" style="">
                    <option value="">{{ __('lang.please_select') }}</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}"
                            {{ $rows[$index]['basic_unit_id'] == $unit->id ? 'selected' : '' }}>{{ $unit->name }}
                        </option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-primary btn-sm ml-2 add_unit_raw" data-toggle="modal"
                    data-index="{{ $index }}" data-target=".add-unit" data-type="basic_unit"
                    href="{{ route('units.create') }}"><i class="fas fa-plus"></i></button>
            </div>
        </div>

        <div style="animation-delay: 2.6s;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
            class="animate__animated animate__fadeInLeft table-width px-0 d-flex justify-content-center align-items-center flex-column">
            <span style="font-size: 11px" class="mb-2">@lang('lang.to_get_sell_price')</span>
            <div class="d-flex justify-content-between align-items-center" style="width: 95%;">
                <div class="input-group-prepend" style="height: 100%;">
                    <input type="text" class="form-control p-0" wire:model="rows.{{ $index }}.fill_quantity"
                        wire:change="changeFilling({{ $index }})"
                        style="width: 70px;font-size: 12px;height: 100%;" required>
                </div>
                <select class="custom-select " wire:model="rows.{{ $index }}.fill_type"
                    wire:change="changeFilling({{ $index }})">
                    <option selected value="fixed">@lang('lang.fixed')</option>
                    <option value="percent">%</option>
                </select>


            </div>
        </div>

        <div style="animation-delay: 2.7s;font-size: 12px;border-radius: 6px;margin: 6px;padding: 8px;"
            class="animate__animated animate__fadeInLeft table-width px-0 d-flex justify-content-center align-items-center flex-column">
            <div class="btn btn-sm btn-danger py-2 px-1 " style="width: 50%;"
                wire:click="delete_product({{ $index }})">
                <i class="fa fa-trash"></i>
            </div>
        </div>

        <div style="animation-delay: 2.8s;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
            class="animate__animated animate__fadeInLeft table-width px-0 d-flex justify-content-center align-items-center flex-column">
            <span style="font-size: 11px" class="mb-2">@lang('lang.purchase_price')$</span>
            <input type="text" class="form-control" wire:model="rows.{{ $index }}.dollar_purchase_price"
                wire:change="changePurchasePrice({{ $index }})" style="width: 70px;" required>
            @error('rows.' . $index . '.dollar_purchase_price')
                <span style="font-size: 10px;font-weight: 700;" class="error text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div style="animation-delay: 2.9s;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
            class="animate__animated animate__fadeInLeft table-width px-0 d-flex justify-content-center align-items-center flex-column">
            <span style="font-size: 11px" class="mb-2">@lang('lang.selling_price')$</span>
            <input type="text" class="form-control " wire:model="rows.{{ $index }}.dollar_selling_price"
                wire:change="changeSellingPrice({{ $index }})" style="width: 70px;" required>
            @error('rows.' . $index . '.dollar_selling_price')
                <span style="font-size: 10px;font-weight: 700;" class="error text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div style="animation-delay: 3s;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
            class="animate__animated animate__fadeInLeft table-width px-0 d-flex justify-content-center align-items-center flex-column">
            <span style="font-size: 11px" class="mb-2">@lang('lang.sub_total') $</span>
            @if (isset($rows[$index]['quantity']) &&
                    (isset($rows[$index]['dollar_purchase_price']) || isset($rows[$index]['purchase_price'])))
                <span class="sub_total_span">
                    {{ $this->dollar_sub_total($index) }}
                </span>
            @endif
        </div>

        {{-- @endif --}}

        <div style="animation-delay: 3.1s;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
            class="animate__animated animate__fadeInLeft table-width px-0 d-flex justify-content-center align-items-center flex-column">
            <span style="font-size: 11px" class="mb-2">@lang('lang.purchase_price')</span>
            <input type="text" class="form-control" wire:model="rows.{{ $index }}.purchase_price"
                style="width: 70px;" wire:change="changeDollarPurchasePrice({{ $index }})" required>
            @error('rows.' . $index . '.purchase_price')
                <span style="font-size: 10px;font-weight: 700;" class="error text-danger">{{ $message }}</span>
            @enderror
        </div>



        <div style="animation-delay: 3.2s;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
            class="animate__animated animate__fadeInLeft table-width px-0 d-flex justify-content-center align-items-center flex-column">
            <span style="font-size: 11px" class="mb-2">@lang('lang.selling_price')</span>
            <input type="text" class="form-control " wire:model="rows.{{ $index }}.selling_price"
                style="width: 70px;" required>
            @error('rows.' . $index . '.selling_price')
                <span style="font-size: 10px;font-weight: 700;" class="error text-danger">{{ $message }}</span>
            @enderror
        </div>


        <div style="animation-delay: 3.3s;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
            class="animate__animated animate__fadeInLeft table-width px-0 d-flex justify-content-center align-items-center flex-column">
            <span style="font-size: 11px" class="mb-2">@lang('lang.sub_total')</span>
            @if (isset($rows[$index]['quantity']) && (isset($rows[$index]['purchase_price']) || isset($dollar_purchase_price)))
                <span class="sub_total_span">
                    {{ $this->sub_total($index) }}
                </span>
            @endif
        </div>



        <div style="animation-delay: 3.4s;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
            class="animate__animated animate__fadeInLeft table-width px-0 d-flex justify-content-center align-items-center flex-column">
            <span style="font-size: 11px" class="mb-2">@lang('lang.new_stock')</span>
            <span class="current_stock_text">
                {{ $this->total_quantity($index) ?? 0 }}
            </span>
        </div>



    </div>

</div>

<div style="width: 100%;animation-delay: 3.6s" class="accordion mt-1 p-3 animate__animated animate__lightSpeedInLeft"
    id="accordionPanelsStayOpenExample">
    <div class="accordion-item">
        <h2 class="accordion-header">
            @if ($rows[$index])
                <button class="accordion-button dis-button collapsed" style="padding: 5px 15px" type="button"
                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{ $index }}"
                    data-index="{{ $index }}" aria-expanded="true"
                    aria-controls="panelsStayOpen-collapse{{ $index }}"
                    wire:click="stayShow({{ $index }})">
                    <h6>
                        @lang('lang.discount')
                    </h6>
                    <span class="accordion-arrow">
                        @if ($rows[$index]['show_prices'])
                            <i class="fas fa-arrow-up" style="font-size: 0.8rem"></i>
                        @else
                            <i class="fas fa-arrow-down" style="font-size: 0.8rem"></i>
                        @endif
                    </span>
                </button>
            @endif
        </h2>
        <div id="panelsStayOpen-collapse{{ $index }}"
            class="accordion-collapse collapse @if ($rows[$index]['show_prices']) show @endif">
            @foreach ($rows[$index]['prices'] as $key => $price)
                <div class="accordion-body mb-3 p-0 d-flex flex-wrap justify-content-between align-items-center py-2 rounded-3 text-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                    style="background-color: #eee">
                    <div style="width: 100px;font-size: 12px;border-radius: 6px;margin: 6px;padding: 8px;"
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

                    <div
                        class="d-flex flex-wrap  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                        <div
                            style="width: 100px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;">
                            {!! Form::label('price_category', __('lang.price_category'), ['style' => 'font-size: 10px;', 'class' => 'pt-2']) !!}
                            <input type="text" class="form-control price_category" name="price_category"
                                wire:model="rows.{{ $index }}.prices.{{ $key }}.price_category"
                                maxlength="6" style="border-radius: 12px;height: 30px;">
                        </div>
                        <div
                            style="width: 100px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;">
                            {!! Form::label('price', __('lang.quantity'), ['style' => 'font-size: 10px;', 'class' => 'pt-2']) !!}
                            <input type="text" class="form-control discount_quantity"
                                wire:model="rows.{{ $index }}.prices.{{ $key }}.discount_quantity"
                                wire:change="changePrice({{ $index }}, {{ $key }})"
                                placeholder = "{{ __('lang.quantity') }}" style="border-radius: 12px;height: 30px;">
                            @error('rows.' . $index . '.prices.' . $key . '.discount_quantity')
                                <br>
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                        </div>

                        <div
                            style="width: 100px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;">
                            {!! Form::label('b_qty', __('lang.b_qty'), ['style' => 'font-size: 10px;', 'class' => 'pt-2']) !!}
                            <input type="text" class="form-control bonus_quantity"
                                style="border-radius: 12px;height: 30px;"
                                wire:model="rows.{{ $index }}.prices.{{ $key }}.bonus_quantity"
                                wire:change="changePrice({{ $index }}, {{ $key }})"
                                placeholder="{{ __('lang.b_qty') }}">
                            @error('rows.' . $index . '.prices.' . $key . '.bonus_quantity')
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                        </div>

                        <div
                            style="width: 100px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px">
                            {!! Form::label('price_type', __('lang.type'), ['style' => 'font-size: 10px;', 'class' => 'pt-2']) !!}
                            {!! Form::select(
                                'rows.' . $index . '.prices.' . $key . '.price_type',
                                ['fixed' => __('lang.fixed'), 'percentage' => __('lang.percentage')],
                                null,
                                [
                                    'class' => ' p-0 price_type',
                                    'placeholder' => __('lang.please_select'),
                                    'style' => 'border-radius: 12px;height: 30px;',
                                    'wire:model' => 'rows.' . $index . '.prices.' . $key . '.price_type',
                                    'wire:change' => 'changePrice(' . $index . ',' . $key . ')',
                                ],
                            ) !!}
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input"
                                    name="discount_from_original_price" id="discount_from_original_price"
                                    style="font-size: 0.75rem;border-radius: 12px;height: 30px;"
                                    @if (!empty($discount_from_original_price) && $discount_from_original_price == '1') checked @endif
                                    wire:change="changePrice({{ $index }}, {{ $key }})">
                                <label class="custom-control-label" id="custom-control-label" style="font-size: 8px"
                                    for="discount_from_original_price">
                                    @lang('lang.discount_from_original_price_with_free_quantity')
                                </label>
                            </div>
                            @error('rows.' . $index . '.prices.' . $key . '.price_type')
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                        </div>

                        <div
                            style="width: 100px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;">
                            {!! Form::label(
                                'price',
                                isset($price['price_type']) && $price['price_type'] == 'fixed'
                                    ? __('lang.amount') . ' $'
                                    : __('lang.percent') . ' $',
                                ['style' => 'font-size: 10px;', 'class' => 'pt-2'],
                            ) !!}
                            <input type="text" name="price" class="form-control price"
                                wire:model="rows.{{ $index }}.prices.{{ $key }}.price"
                                wire:change="changePrice({{ $index }}, {{ $key }})"
                                placeholder="{{ __('lang.percent') }}" style="border-radius: 12px;height: 30px;">
                            <p class="mb-0">
                                {{ isset($price['price_type']) && $price['price_type'] == 'fixed' ? __('lang.amount') : __('lang.percent') }}:{{ $this->rows[$index]['prices'][$key]['dinar_price'] ?? '' }}
                            </p>
                        </div>

                        <div
                            style="width: 100px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;">
                            {!! Form::label('', __('lang.price'), ['style' => 'font-size: 10px;', 'class' => 'pt-2']) !!}
                            <input type="text" name="" class="form-control price"
                                wire:model="rows.{{ $index }}.prices.{{ $key }}.price_after_desc"
                                placeholder="{{ __('lang.price') }}" style="border-radius: 12px;height: 30px;">
                            <p class="mb-0">
                                {{ __('lang.price') }}:{{ $this->rows[$index]['prices'][$key]['dinar_price_after_desc'] ?? '' }}
                            </p>
                        </div>

                        <div
                            style="width: 100px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;">
                            {!! Form::label('total_price', __('lang.total_price') . ' $', [
                                'style' => 'font-size: 10px;',
                                'class' => 'pt-2',
                            ]) !!}
                            <input type="text" name="total_price" class="form-control total_price"
                                wire:model="rows.{{ $index }}.prices.{{ $key }}.total_price"
                                placeholder = "{{ __('lang.total_price') }}"
                                style="border-radius: 12px;height: 30px;">
                            <p class="mb-0">
                                {{ __('lang.total_price') }}:{{ $this->rows[$index]['prices'][$key]['dinar_total_price'] ?? '' }}
                            </p>
                        </div>
                        <div
                            style="width: 100px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;">
                            {!! Form::label('piece_price', __('lang.piece_price') . ' $', [
                                'style' => 'font-size: 10px;',
                                'class' => 'pt-2',
                            ]) !!}
                            <input type="text" name="piece_price" class="form-control piece_price"
                                wire:model="rows.{{ $index }}.prices.{{ $key }}.piece_price"
                                placeholder = "{{ __('lang.total_price') }}"
                                style="border-radius: 12px;height: 30px;">
                            <p class="mb-0">
                                {{ __('lang.piece_price') }}:{{ $this->rows[$index]['prices'][$key]['dinar_piece_price'] ?? '' }}
                            </p>
                        </div>

                        <div
                            style="width: 100px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;">
                            {!! Form::label('customer_type', __('lang.customer_type'), ['style' => 'font-size: 10px;', 'class' => 'pt-2']) !!}
                            <div class="d-flex justify-content-center align-items-center"
                                style=" border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        width: 100%;
                                        margin: auto;
                                        flex-wrap: nowrap;">
                                <select
                                    wire:model="rows.{{ $index }}.prices.{{ $key }}.price_customer_types"
                                    data-name='price_customer_types' data-index="{{ $index }}"
                                    data-key="{{ $key }}" class="form-control js-example-basic-multiple"
                                    multiple='multiple' placeholder="{{ __('lang.please_select') }}">
                                    @foreach ($customer_types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>

                                {{-- <select class="selectpicker" data-live-search="true"
                                    wire:model="rows.{{ $index }}.prices.{{ $key }}.price_customer_types"
                                    data-name='price_customer_types' data-index="{{ $index }}"
                                    data-key="{{ $key }}" multiple='multiple'
                                    style="border-radius:6px !important; border: 2px solid gray"
                                    title="{{ __('lang.please_select') }}">
                                    @foreach ($customer_types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select> --}}


                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
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
{{-- <script>
    $(document).ready(function() {
        $('.dis-button').each(function() {
            $(this).on('click', function() {
                let index = $(this).attr('data-index');

                $(`#panelsStayOpen-collapse${index}`).toggleClass('show')
            });
        })
    })
</script> --}}

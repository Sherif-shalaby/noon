{{-- <td>
        {{ $index + 1 }}
    </td> --}}
<div class="d-flex flex-column">

    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        <div class="d-flex justify-content-start align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
            style="overflow-x: auto">
            <div
                class="mb-2 animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif px-1">

                <label class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>@lang('lang.sku')</label>
                <input type="text" class="form-control initial-balance-input sku"
                    wire:model="rows.{{ $index }}.sku"
                    style="width:160px;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;"
                    placeholder="@lang('lang.sku')" required>
                @error('rows.' . $index . '.sku')
                    <label class="text-danger error-msg">{{ $message }}</label>
                @enderror
            </div>

            <div
                class=" mb-2 animate__animated animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                <label class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ $index == 0 ? __('lang.choose_big_unit') : __('lang.choose_small_unit') }}</label>

                <div class="d-flex justify-content-center align-items-center"
                    style="background-color: #dedede;
                  border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                    <select wire:model="rows.{{ $index }}.unit_id" data-name='unit_id'
                        data-index="{{ $index }}" required
                        class="form-control select2 unit_id{{ $index }}" style="width: 160px !important;">
                        <option value="">
                            {{ $index == 0 ? __('lang.choose_big_unit') : __('lang.choose_small_unit') }}
                        </option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}"
                                {{ $rows[$index]['unit_id'] == $unit->id ? 'selected' : '' }}>
                                {{ $unit->name }}</option>
                        @endforeach
                    </select>
                    <button type="button"
                        class="add-button d-flex justify-content-center align-items-center add_unit_raw"
                        data-toggle="modal" data-index="{{ $index }}" data-target=".add-unit"
                        href="{{ route('units.create') }}"><i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class=" animate__animated animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1"
                style="width: 100px">
                <button class="btn btn-sm mx-1 d-flex justify-content-center align-items-center btn-primary"
                    style="width: 100%" wire:click="addRaw()" type="button">
                    <i class="fa fa-plus"></i> @lang('lang.add')
                </button>
            </div>

        </div>
    </div>

    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        <div class="d-flex justify-content-start align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
            style="overflow-x: auto">
            <div
                class="mb-2 animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                <label
                    class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif  {{ $index == 0 ? 'd-none' : '' }}"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.fill') }}</label>
                <input type="text" class="form-control initial-balance-input fill {{ $index == 0 ? 'd-none' : '' }}"
                    style="width: 90px;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;"
                    wire:model="rows.{{ $index }}.fill" placeholder = "{{ __('lang.fill') }}"
                    wire:change="changeFill({{ $index }})">
            </div>
            <div
                class="mb-2 animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                <label class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.purchase_price') }}</label>
                <input type="text" class="form-control initial-balance-input purchase_price"
                    style="width: 90px;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;"
                    wire:model="rows.{{ $index }}.purchase_price"
                    placeholder = "{{ __('lang.purchase_price') }}">
                @error('rows.' . $index . '.purchase_price')
                    <label class="text-danger error-msg">{{ $message }}</label>
                @enderror
            </div>

            <div
                class="mb-2 animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                <label class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.quantity') }}</label>
                <input type="text" class="form-control initial-balance-input quantity" name="quantity"
                    wire:model="rows.{{ $index }}.quantity" maxlength="6"
                    style="width: 90px;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;"
                    placeholder="{{ __('lang.quantity') }}">
            </div>

            <td class="text-center">
                <div style="width:50px" class="{{ $index == '0' ? 'd-none' : '' }}">
                    <div class="btn
                    btn-sm btn-danger py-0 px-1 "
                        wire:click="delete_product({{ $index }})">
                        <i class="fa fa-trash"></i>
                    </div>
                </div>
                <div style="width:50px">
                    <button class="btn btn-sm btn-primary py-0 px-1 "data-bs-toggle=" collapse"
                        data-bs-target="#panelsStayOpen-collapse{{ $index }}" data-index="{{ $index }}"
                        aria-expanded="true" aria-controls="panelsStayOpen-collapse{{ $index }}"
                        wire:click="stayShow({{ $index }})">
                        @if ($rows[$index]['show_prices'])
                            <i class="fas fa-arrow-up" style="font-size: 0.8rem"></i>
                        @else
                            <i class="fas fa-arrow-down" style="font-size: 0.8rem"></i>
                        @endif
                    </button>
                </div>

            </td>
        </div>
    </div>
    <div id="panelsStayOpen-collapse{{ $index }}"
        class="accordion-collapse flex-column collapse @if ($rows[$index]['show_prices']) show @endif">
        @foreach ($rows[$index]['prices'] as $key => $price)
            <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div
                    class="d-flex justify-content-start align-items-start @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div class="mb-2 animate__animated  animate__bounceInLeft d-flex flex-column  align-items-center pl-1"
                        style="width: 75px">
                        <label
                            class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                            style='font-weight:500;font-size:10px;color:#888'>%</label>
                        <input type="text" class="form-control initial-balance-input percent" name="percent"
                            wire:change="changePercent({{ $index }},{{ $key }})"
                            style="width:100%;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;"
                            wire:model="rows.{{ $index }}.prices.{{ $key }}.percent" maxlength="6"
                            placeholder="%">
                    </div>
                    <div class="mb-2 animate__animated  animate__bounceInLeft d-flex flex-column  align-items-center pl-1"
                        style="width: 75px">
                        <label
                            class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                            style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.value') . ' ' . $rows[$index]['prices'][$key]['customer_name'] }}</label>
                        <input type="text" class="form-control initial-balance-input dinar_sell_price"
                            style="width:100%;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;"
                            wire:model="rows.{{ $index }}.prices.{{ $key }}.dinar_increase"
                            placeholder = "{{ __('lang.value') . ' ' . $rows[$index]['prices'][$key]['customer_name'] }}"
                            wire:change="changeIncrease({{ $index }},{{ $key }})">
                        <span
                            style='font-weight:500;font-size:12px;color:#888'>{{ $rows[$index]['prices'][$key]['dollar_increase'] }}
                            $</span>
                        @error('rows.' . $index . 'prices' . $key . '.dinar_increase')
                            <label class="text-danger error-msg">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="mb-2 animate__animated  animate__bounceInLeft d-flex flex-column  align-items-center pl-1"
                        style="width: 75px">
                        <label
                            class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                            style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.overall') }}</label>

                        <input type="text" class="form-control initial-balance-input dinar_sell_price"
                            style="width:100%;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;"
                            wire:model="rows.{{ $index }}.prices.{{ $key }}.dinar_sell_price"
                            placeholder = "{{ __('lang.overall') }}">
                        <span
                            style='font-weight:500;font-size:12px;color:#888'>{{ $rows[$index]['prices'][$key]['dollar_sell_price'] }}
                            $</span>
                        @error('rows.' . $index . 'prices' . $key . '.dinar_sell_price')
                            <label class="text-danger error-msg">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

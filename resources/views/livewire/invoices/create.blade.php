<section class="app mb-3 mt-0 no-print">

    {!! Form::open(['route' => 'pos.store', 'method' => 'post']) !!}

    <div class="row justify-content-start @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

        <div
            class="col-md-6 row justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {{-- ++++++++++++++++++++++ مخزن ++++++++++++++++++++++ --}}
            <div class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                style="animation-delay: 1.1s">
                {!! Form::label('store_id', __('lang.store') . '*', [
                    'class' => app()->isLocale('ar') ? 'd-block text-end h5  mb-0 width-fit' : ' mb-0 h5 width-fit',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper mx-2">
                    {!! Form::select('store_id', $stores ?? [], $store_id, [
                        'class' => 'select2 form-control',
                        'data-live-search' => 'true',
                        'id' => 'store_id',
                        'required',
                        'placeholder' => __('lang.please_select'),
                        'data-name' => 'store_id',
                        'wire:model' => 'store_id',
                        'wire:change' => 'changeAllProducts',
                    ]) !!}
                </div>
                @error('store_id')
                    <span style="font-size: 12px;font-weight: 500;" class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
            {{-- ++++++++++++++++++++++ نقاط البيع +++++++++++++++++++++ --}}
            <div class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                style="animation-delay: 1.15s">
                {!! Form::label('store_pos_id', __('lang.pos') . '*', [
                    'class' => app()->isLocale('ar') ? 'd-block text-end h5   mb-0 width-fit' : '  mb-0 h5 width-fit',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper mx-2">
                    {!! Form::select('store_pos_id', $store_pos, $store_pos_id, [
                        'class' => 'select2 form-control',
                        'data-name' => 'store_pos_id',
                        'data-live-search' => 'true',
                        'required',
                        'placeholder' => __('lang.please_select'),
                        'wire:model' => 'store_pos_id',
                    ]) !!}
                </div>
                @error('store_pos_id')
                    <span style="font-size: 12px;font-weight: 500;" class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
            {{-- +++++++++++++++++ Customers Dropdown +++++++++++++++++ --}}
            <div class="col-md-6 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                style="animation-delay: 1.2s">
                <label for="" class=" @if (app()->isLocale('ar')) d-block text-end @endif h5 mb-0"
                    style="font-size: 12px;font-weight: 500;">العملاء</label>
                <div class="input-wrapper mx-2">
                    <select class="form-control client select2" wire:model="client_id" id="client_id"
                        data-name="client_id">
                        <option value="0 " readonly>اختر </option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $client_id == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="add-button d-flex justify-content-center align-items-center"
                        data-toggle="modal" data-target="#add_customer"><i class="fas fa-plus"></i></button>
                </div>
                <div class="col-md-1 mx-1 p-0">
                    <button style="width: 100%; background: #5b808f;font-size: 13px;font-weight: 600"
                        wire:click="redirectToCustomerDetails({{ $client_id }})"
                        class="btn btn-primary d-flex justify-content-center align-items-center payment-btn">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                @error('client_id')
                    <span style="font-size: 12px;font-weight: 500;" class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        {{-- <div
                    class="row col-md-5 justify-content-between mb-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"> --}}
        <div class="d-flex col-md-6 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
            style="animation-delay: 1.45s">

            <div class="col-md-2 p-0 d-flex flex-column justify-content-center align-items-center dollar-cell "
                style="border-left: 1px solid #ccc;width: 120px">
                <span class="d-flex justify-content-center align-items-center"
                    style='width:100%;font-weight: 700;font-size: 12px'>@lang('lang.min_amount_in_dollar')</span>
                <span class="d-flex justify-content-center align-items-center"
                    style='width:100%;font-weight: 700;font-size: 12px'>{{ $customer_data->min_amount_in_dollar ?? 0 }}</span>
            </div>

            <div class="col-md-2 dollar-cell p-0 d-flex flex-column justify-content-center align-items-center "
                style="border-left: 1px solid #ccc;width: 120px">
                <span class="d-flex justify-content-center align-items-center"
                    style='width:100%;font-weight: 700;font-size: 12px'> @lang('lang.max_amount_in_dollar')</span>
                <span class="d-flex justify-content-center align-items-center"
                    style='width:100%;font-weight: 700;font-size: 12px'>{{ $customer_data->max_amount_in_dollar ?? 0 }}</span>
            </div>

            <div class="col-md-2 p-0 d-flex flex-column justify-content-center align-items-center "
                style="border-left: 1px solid #ccc;width: 120px">
                <span class="d-flex justify-content-center align-items-center"
                    style='width:100%;font-weight: 700;font-size: 12px'> @lang('lang.min_amount_in_dinar')</span>
                <span class="d-flex justify-content-center align-items-center"
                    style='width:100%;font-weight: 700;font-size: 12px'>{{ $customer_data->min_amount_in_dinar ?? 0 }}</span>
            </div>

            <div class="col-md-2 p-0 d-flex flex-column justify-content-center align-items-center "
                style="border-left: 1px solid #ccc;width: 120px">
                <span class="d-flex justify-content-center align-items-center"
                    style='width:100%;font-weight: 700;font-size: 12px'> @lang('lang.max_amount_in_dinar')</span>
                <span class="d-flex justify-content-center align-items-center"
                    style='width:100%;font-weight: 700;font-size: 12px'>{{ $customer_data->max_amount_in_dinar ?? 0 }}</span>
            </div>

            <div class="col-md-2 p-0 d-flex flex-column justify-content-center align-items-center "
                style="border-left: 1px solid #ccc;width: 120px">
                <span class="d-flex justify-content-center align-items-center"
                    style='width:100%;font-weight: 700;font-size: 12px'> @lang('lang.balance_in_dinar')</span>
                <span class="d-flex justify-content-center align-items-center"
                    style='width:100%;font-weight: 700;font-size: 12px'>{{ $customer_data->balance_in_dinar ?? 0 }}</span>
            </div>

            <div class="col-md-2 p-0 dollar-cell d-flex flex-column justify-content-center align-items-center ">
                <span class="d-flex justify-content-center align-items-center"
                    style='width:100%;font-weight: 700;font-size: 12px'> @lang('lang.balance_in_dollar')</span>
                <span class="d-flex justify-content-center align-items-center"
                    style='width:100%;font-weight: 700;font-size: 12px'>{{ $customer_data->balance_in_dollar ?? 0 }}</span>
            </div>
        </div>



        <button></button>

        {{-- </div> --}}
    </div>


    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        <div class="col-md-2 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
            style="animation-delay: 1.25s">
            {!! Form::label('brand_id', __('lang.brand') . '*', [
                'class' => app()->isLocale('ar') ? 'd-block text-end h5 mb-0 width-fit' : '  mb-0 h5 width-fit',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="input-wrapper mx-2">

                {!! Form::select('brand_id', $brands, $brand_id, [
                    'class' => 'select2 form-control',
                    'data-live-search' => 'true',
                    'id' => 'brand_id',
                    'required',
                    'placeholder' => __('lang.please_select'),
                    'data-name' => 'brand_id',
                    'wire:model' => 'brand_id',
                ]) !!}
            </div>
            @error('brand_id')
                <span style="font-size: 12px;font-weight: 500;" class="error text-danger">{{ $message }}</span>
            @enderror
        </div>

        @include('invoices.partials.search')
        <div class="col-md-2 animate__animated animate__bounceInLeft" style="animation-delay: 1.3s">

            <div style="background-color: #E6E6E6;color: black;border-right adius: 16px;box-shadow: 5px 8px 4px -5px #bbb inset;"
                class=" d-flex mb-3 justify-content-between rounded p-2">

                <div class="col-md-6 p-0 form-check-inline checkbox-dark d-flex">
                    <input type="checkbox" id="from_a_to_z" wire:model="from_a_to_z" name="customCheckboxInline2"
                        class="sorting_filter filterInput">
                    <label style="font-size: 11px;font-weight: 600;" for="from_a_to_z"
                        class="checkbox-inline filterLabel mb-0 ml-2">
                        @lang('lang.from_a_to_z')
                    </label>
                </div>

                <div class="col-md-6 p-0 form-check-inline checkbox-dark d-flex">
                    <input type="checkbox" id="from_z_to_a" wire:model="from_z_to_a" name="customCheckboxInline2"
                        class="sorting_filter filterInput">
                    <label style="font-size: 11px;font-weight: 600;" class="checkbox-inline filterLabel mb-0 ml-2"
                        for="from_z_to_a">@lang('lang.from_z_to_a')</label>
                </div>
            </div>
        </div>

        <div class="col-md-2 animate__animated animate__bounceInLeft" style="animation-delay: 1.35s">
            <div style="background-color: #E6E6E6;color: black;border-right adius: 16px;box-shadow: 5px 8px 4px -5px #bbb inset;"
                class=" d-flex mb-3 justify-content-between rounded  p-2">
                <div class="col-md-6 p-0 form-check-inline checkbox-dark d-flex">

                    <input type="checkbox" id="highest_price" wire:model="highest_price"
                        name="customCheckboxInline2" class="sorting_filter filterInput">
                    <label style="font-size: 11px;font-weight: 600;" class="checkbox-inline filterLabel mb-0 ml-2"
                        for="highest_price">@lang('lang.highest_price')</label>

                </div>

                <div class="col-md-6 p-0 form-check-inline checkbox-dark d-flex">

                    <input type="checkbox" id="lowest_price" wire:model="lowest_price" name="customCheckboxInline2"
                        class="sorting_filter filterInput">
                    <label style="font-size: 11px;font-weight: 600;" class="checkbox-inline filterLabel mb-0 ml-2"
                        for="lowest_price">@lang('lang.lowest_price')</label>

                </div>
            </div>
        </div>

        <div class="col-md-3 animate__animated animate__bounceInLeft" style="animation-delay: 1.4s">

            <div style="background-color: #E6E6E6;color: black;border-right adius: 16px;box-shadow: 5px 8px 4px -5px #bbb inset;"
                class=" d-flex mb-3 justify-content-between rounded p-2">
                <div class="col-md-6 p-0 form-check-inline checkbox-dark d-flex">
                    <input class="sorting_filter filterInput" type="checkbox" id="nearest_expiry_filter"
                        wire:model="nearest_expiry_filter" name="customCheckboxInline2">
                    <label style="font-size: 11px;font-weight: 600;" class="checkbox-inline filterLabel mb-0 ml-2"
                        for="nearest_expiry_filter">@lang('lang.nearest_expiry_filter')</label>

                </div>

                <div class="col-md-6 p-0 form-check-inline checkbox-dark d-flex">

                    <input class="sorting_filter filterInput" type="checkbox" id="longest_expiry_filter"
                        wire:model="longest_expiry_filter" name="customCheckboxInline2">
                    <label style="font-size: 11px;font-weight: 600;" class="checkbox-inline filterLabel mb-0 ml-2"
                        for="longest_expiry_filter">@lang('lang.longest_expiry_filter')</label>

                </div>

            </div>
        </div>
    </div>





    <div class="row cards hide-print @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        @include('invoices.partials.products')
        <div class="col-xl-9 special-medal-col animate__animated animate__bounceInLeft" style="animation-delay: 1.6s">
            <div class="card-app ">
                <div class="body-card-app content py-2 ">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="body-card-app">
                            <div class="table-responsive box-table @if (app()->isLocale('ar')) dir-rtl @endif"
                                style="height: 400px;overflow: scroll">
                                <table class="table">
                                    <tr>
                                        <th style="font-weight: 700;font-size: 10px;text-align: center;width: 5%">
                                            @lang('lang.sku')</th>
                                        <th style="font-weight: 700;font-size: 10px;text-align: center;width: 5%">
                                            @lang('lang.product')</th>
                                        <th style="font-weight: 700;font-size: 10px;text-align: center;width: 10%;">
                                            @lang('lang.quantity')</th>
                                        <th style="font-weight: 700;font-size: 10px;text-align: center;width: 4%">
                                            @lang('lang.extra')</th>
                                        <th style="font-weight: 700;font-size: 10px;text-align: center;width: 5%;">
                                            @lang('lang.unit')</th>
                                        <th style="font-weight: 700;font-size: 10px;text-align: center;width: 5%;">
                                            @lang('lang.c_type')</th>
                                        <th style="font-weight: 700;font-size: 10px;text-align: center;width: 8%">
                                            @lang('lang.price')</th>
                                        <th class="dollar-cell"
                                            style="font-weight: 700;font-size: 10px;text-align: center;width: 8%">
                                            @lang('lang.price') $ </th>
                                        <th style="font-weight: 700;font-size: 10px;text-align: center;width: 8%">
                                            @lang('lang.exchange_rate')</th>
                                        <th style="font-weight: 700;font-size: 10px;text-align: center;width: 9%">
                                            @lang('lang.discount')</th>
                                        <th style="font-weight: 700;font-size: 10px;text-align: center;width: 5%;">
                                            @lang('lang.discount_category')</th>
                                        <th style="font-weight: 700;font-size: 10px;text-align: center">
                                            @lang('lang.sub_total')</th>
                                        <th class="dollar-cell"
                                            style="font-weight: 700;font-size: 10px;text-align: center">
                                            @lang('lang.sub_total') $</th>
                                        <th style="font-weight: 700;font-size: 10px;text-align: center">
                                            @lang('lang.current_stock')</th>
                                        <th style="font-weight: 700;font-size: 10px;text-align: center">
                                            @lang('lang.action')</th>
                                    </tr>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($items as $key => $item)
                                        <tr style="height: 50px">
                                            <td style="font-weight: 700;font-size: 10px;height: 50px;"
                                                class="px-1 border-right ">{{ $item['product']['product_symbol'] }}
                                            </td>
                                            <td style="font-weight: 700;font-size: 10px;height: 50px;"
                                                class="px-1 border-right ">
                                                <div style="height: 100%;max-width: 100%;"
                                                    class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                    {{ $item['product']['name'] }}
                                                </div>
                                            </td>

                                            <td style="font-weight: 700;font-size: 10px;height: 50px;"
                                                class="px-1 border-right ">
                                                <div class="d-flex align-items-center gap-1 " style="width: 80px">
                                                    <div class="btn-success add-num control-num d-flex justify-content-center align-items-center"
                                                        style="width: 15px;height: 15px;border-radius: 50%;color: white;cursor:pointer;"
                                                        wire:click="increment({{ $key }})">
                                                        <i style="font-size: 10px;width: 50px;font-weight: 600"
                                                            class="fa-solid fa-plus"></i>
                                                    </div>
                                                    <input class="form-control p-1 text-center"
                                                        style="width: 50px font-size: 12px;font-weight: 700;"
                                                        type="text" min="1"
                                                        wire:model="items.{{ $key }}.quantity"
                                                        Wire:change="subtotal({{ $key }})">
                                                    @error("items.$key.quantity")
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    <div class="btn-danger decrease-num control-num d-flex justify-content-center align-items-center"
                                                        style="width: 15px;height: 15px;border-radius: 50%;color: white;cursor:pointer;"
                                                        wire:click="decrement({{ $key }})">
                                                        <i style="font-size: 10px;width: 50px;font-weight: 600"
                                                            class="fa-solid fa-minus"></i>
                                                    </div>
                                                </div>
                                            </td>

                                            <td style="font-weight: 700;font-size: 10px;height: 50px;"
                                                class="px-1 border-right ">
                                                <div style="height: 100%;max-width: 100%;"
                                                    class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                    {{ $item['extra_quantity'] }}
                                                </div>
                                            </td>

                                            <td style="font-weight: 700;font-size: 10px;height: 50px;"
                                                class="px-1 border-right ">
                                                <select class="form-control" style="width:50px;"
                                                    wire:model="items.{{ $key }}.unit_id"
                                                    wire:change="changeUnit({{ $key }})">
                                                    <option value="0.00">select</option>
                                                    @if (!empty($item['variation']))
                                                        @foreach ($item['variation'] as $i => $var)
                                                            @if (!empty($var['unit_id']))
                                                                <option value="{{ $var['id'] }}"
                                                                    {{ $i == 0 ? 'selected' : '' }}>
                                                                    {{ $var['unit']['name'] ?? '' }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>

                                            <td style="font-weight: 700;font-size: 10px;height: 50px;"
                                                class="px-1 border-right ">
                                                <select class="form-control"
                                                    style="height:30% !important;width:100px;"
                                                    wire:model="items.{{ $key }}.customer_type_id"
                                                    wire:change="changeCustomerType({{ $key }})">
                                                    <option value="0">select</option>
                                                    @if (!empty($item['customer_types']))
                                                        @foreach ($item['customer_types'] as $x => $var)
                                                            @if (!empty($var['id']))
                                                                <option value="{{ $var['id'] }}"
                                                                    {{ $x == 0 ? 'selected' : '' }}>
                                                                    {{ $var['name'] ?? '' }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>

                                            <td style="font-weight: 700;font-size: 10px;height: 50px;"
                                                class="px-1 border-right ">
                                                <div style="height: 100%;max-width: 100%;"
                                                    class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                    <input class="form-control dinarPrice"
                                                        data-key="{{ $key }}" type="text"
                                                        wire:model="items.{{ $key }}.price"
                                                        style="font-weight: 700;font-size: 10px;width: 65px" />
                                                    {{-- {{ $item['price'] ?? '' }} --}}
                                                </div>
                                            </td>

                                            <td style="font-weight: 700;font-size: 10px;height: 50px;"
                                                class="px-1 border-right dollar-cell">
                                                <div style="height: 100%;max-width: 100%;"
                                                    class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                    <input class="form-control dollarPrice"
                                                        data-key="{{ $key }}" type="text"
                                                        wire:model="items.{{ $key }}.dollar_price"
                                                        style="font-weight: 700;font-size: 10px;width: 65px" />
                                                    {{-- {{ number_format($item['dollar_price'] ?? 0, 2) }} --}}
                                                </div>
                                            </td>

                                            <td style="font-weight: 700;font-size: 10px;height: 50px;"
                                                class="px-1 border-right ">
                                                <div style="height: 100%;max-width: 100%;"
                                                    class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                    <input style="font-weight: 700;font-size: 10px;width: 65px"
                                                        class="form-control p-1 text-center ex-rate-cell"
                                                        type="text" min="1"
                                                        wire:model="items.{{ $key }}.exchange_rate">
                                                    @php
                                                        $dollar_exchange = App\Models\System::where('key', '=', 'dollar_exchange')->get('value');
                                                    @endphp
                                                    <input style="font-weight: 700;font-size: 10px;width: 65px;"
                                                        class="form-control p-1 text-center my-ex-rate-cell"
                                                        type="text" min="1"
                                                        value="{{ $dollar_exchange[0]['value'] }}">
                                                </div>
                                            </td>

                                            <td style="font-weight: 700;font-size: 10px;height: 50px;"
                                                class="px-1 border-right">
                                                <input class="form-control p-1 text-center" style="width:60px"
                                                    type="text" min="1" readonly
                                                    wire:model="items.{{ $key }}.discount_price">
                                            </td>

                                            <td style="font-weight: 700;font-size: 10px;height: 50px;"
                                                class="px-1 border-right ">
                                                <select class="form-control discount_category "
                                                    style="width:50px;font-size:14px;"
                                                    wire:model="items.{{ $key }}.discount"
                                                    wire:change="subtotal({{ $key }},'discount')">
                                                    <option selected value="0">select</option>
                                                    @if (!empty($item['discount_categories']))
                                                        @if (!empty($client_id))
                                                            @foreach ($item['discount_categories'] as $discount)
                                                                @if ($discount['price_category'] !== null)
                                                                    {{--                                                                        @if (in_array($client_id, $discount['price_customer_types'])) --}}
                                                                    <option value="{{ $discount['id'] }}">
                                                                        {{ $discount['price_category'] }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            @foreach ($item['discount_categories'] as $discount)
                                                                {{-- @if ($discount['price_category'] !== null) --}}
                                                                <option value="{{ $discount['id'] }}">
                                                                    {{ $discount['price_category'] ?? '' }}
                                                                </option>
                                                                {{-- @endif --}}
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                </select>
                                            </td>
                                            <td style="font-weight: 700;font-size: 10px;height: 50px;"
                                                class="px-1 border-right ">
                                                <div style="height: 100%;max-width: 100%;"
                                                    class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                    {{ $item['sub_total'] ?? 0 }}
                                                </div>
                                            </td>
                                            <td style="font-weight: 700;font-size: 10px;height: 50px;"
                                                class="px-1 border-right dollar-cell">
                                                <div style="height: 100%;max-width: 100%;"
                                                    class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                    {{ $item['dollar_sub_total'] ?? 0 }}
                                                </div>
                                            </td>
                                            <td style="font-weight: 700;font-size: 10px;height: 50px;"
                                                class="px-1 border-right ">
                                                <span
                                                    class="current_stock d-flex flex-wrap justify-content-center align-items-center text-center"
                                                    style="font-weight: 700;font-size: 10px;height: 100%;max-width: 100%;">
                                                    {{ $item['quantity_available'] }}
                                                </span>
                                            </td>
                                            <td class="text-center px-1 border-right">
                                                <div class="btn btn-sm btn-success py-0 px-1 my-1"
                                                    wire:click="changePrice({{ $key }})">
                                                    <i class="fas fa-undo"></i>
                                                </div>
                                                <div class="btn btn-sm btn-danger py-0 px-1"
                                                    wire:click="delete_item({{ $key }})">
                                                    <i class="fas fa-trash-can"></i>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                            @include('invoices.partials.rightSidebar')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('invoices.partials.draft_transaction')

    {!! Form::close() !!}
    <button class="btn btn-danger" wire:click="cancel"> @lang('lang.close')</button>

    <!-- recent transaction modal -->
    <div id="recentTransaction" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal text-left">
        <div class="modal-dialog modal-xl" role="document" style="max-width: 65%;">
            <div class="modal-content @if (app()->isLocale('ar')) text-end @else text-start @endif">
                <div
                    class="modal-header d-flex justify-content-between py-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <h4 class="modal-title">@lang('lang.recent_transactions')</h4>
                    <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close"
                        id="closeRecentTransactionModal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 modal-filter">
                        <div class="row">

                        </div>
                    </div>

                    <div class="col-md-12">
                        @include('invoices.partials.recent_transactions')
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="closeRecentTransactionModal"
                        data-dismiss="modal">@lang('lang.close')</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</section>
@include('customers.quick_add', ['quick_add' => 1])


{{-- <!-- This will be printed --> --}}
<section class="invoice print_section print-only" id="receipt_section_print">fff </section>
@push('javascripts')

    @if (empty($store_pos) || empty($stores))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const noUserPosEvent = new Event('NoUserPos');
                window.dispatchEvent(noUserPosEvent);
            });
        </script>
    @endif
    <script>
        $(document).on("click", "#recent-transaction-btn", function() {
            $("#recentTransaction").modal("show");
        });
        $(document).on("click", "#closeRecentTransactionModal", function() {
            $("#recentTransaction").modal("hide");
        });
        document.addEventListener('livewire:load', function() {
            $('.depart').select().on('change', function(e) {
                @this.set('department_id', $(this).val());
            });
        });
        document.addEventListener('livewire:load', function() {
            $('#store_id').select();
            // Trigger Livewire updates when the select2 value changes
            $('#store_id').on('change', function(e) {
                @this.set('store_id', $(this).val());
            });
        });
        document.addEventListener('livewire:load', function() {
            Livewire.on('printInvoice', function(htmlContent) {
                // Set the generated HTML content
                $("#receipt_section_print").html(htmlContent);
                // Trigger the print action
                window.print("#receipt_section_print");
            });
        });
        $(document).on("click", ".print-invoice", function() {
            // $(".modal").modal("hide");
            $.ajax({
                method: "get",
                url: $(this).data("href"),
                data: {},
                success: function(result) {
                    if (result.success) {
                        Livewire.emit('printInvoice', result.html_content);
                        window.location.reload(true)

                    }
                },
            });
        });
        window.addEventListener('quantity_not_enough', function(event) {
            var id = event.detail.id;
            Swal.fire({
                title: "{{ __('lang.out_of_stock') }}" + "<br>",
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: LANG.cancel,
                cancelButtonText: LANG.po,
            }).then((result) => {
                if (result.isConfirmed) {} else {
                    Livewire.emit('create_purchase_order', id);
                }
            });
        });

        @if (empty($store_pos))
            window.addEventListener('NoUserPos', function(event) {
                Swal.fire({
                    title: "{{ __('lang.kindly_assign_pos_for_that_user_to_able_to_use_it') }}" + "<br>",
                    icon: 'error',
                }).then((result) => {
                    window.location.href = "{{ route('home') }}";
                });
            });
        @endif
        $(document).ready(function() {
            $('select').on('change', function(e) {

                var name = $(this).data('name');
                var index = $(this).data('index');
                var select2 = $(this); // Save a reference to $(this)
                Livewire.emit('listenerReferenceHere', {
                    var1: name,
                    var2: select2.select2("val"),
                    var3: index
                });

            });
        });

        $(document).on('change', '.dinarPrice', function(e) {
            var key = $(this).data('key');
            Swal.fire({
                'type': 'info',
                'title': 'تأكيد',
                'text': 'هل نريد تغيير السعر بصورة دائمة ؟',
                'showCancelButton': true,
                'confirmButtonText': 'نعم',
                'cancelButtonText': 'إلغاء',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('changeDinarPrice', key);
                } else {
                    Livewire.emit('changePrices', key);
                }
            });

        });




        $(document).on('change', '.dollarPrice', function(e) {
            var key = $(this).data('key');
            Swal.fire({
                'type': 'info',
                'title': 'تأكيد',
                'text': 'هل نريد تغيير السعر بصورة دائمة ؟',
                'showCancelButton': true,
                'confirmButtonText': 'نعم',
                'cancelButtonText': 'إلغاء',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('changeDollarPrice', key);
                } else {
                    Livewire.emit('changePrices', key);
                }
            });

        });
    </script>
@endpush

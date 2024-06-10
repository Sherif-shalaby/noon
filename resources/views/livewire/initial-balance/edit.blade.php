<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">

                        @if (!empty($is_raw_material))
                            <h4>@lang('lang.add_stock_for_raw_material')</h4>
                        @else
                            <h4>@lang('lang.add_initial_balance')</h4>
                        @endif
                    </div>
                    @php
                        $index = 0;
                    @endphp
                    <div class="row mt-2">
                        <div class="col-md-9">
                            <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info')</small></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1">
                                {!! Form::label('product_symbol', __('lang.product_symbol'), ['class' => 'h5']) !!}
                                {!! Form::text('product_symbol', $item[0]['product_symbol'], [
                                    'class' => 'form-control',
                                    'wire:model' => 'item.0.product_symbol',
                                ]) !!}
                                @error('item.0.product_symbol')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                {!! Form::label('name', __('lang.product_name'), ['class' => 'h5']) !!}
                                {!! Form::text('name', $item[0]['name'], [
                                    'class' => 'form-control required',
                                    'wire:model' => 'item.0.name',
                                    'wire:change' => 'confirmCreateProduct()',
                                ]) !!}
                                @error('item.0.name')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('supplier_id ', __('lang.supplier') . ':*', []) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('supplier_id', $suppliers, $item[0]['supplier_id'], [
                                        'id' => 'supplier_id',
                                        'class' => ' form-control select2 supplier_id',
                                        'data-name' => 'supplier_id',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'wire:model' => 'item.0.supplier_id',
                                    ]) !!}
                                    <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
                                        data-target=".add-supplier" href="{{ route('suppliers.create') }}"><i
                                            class="fas fa-plus"></i></button>
                                    @include('suppliers.quick_add', ['quick_add' => 1])
                                </div>
                                @error('item.0.supplier_id ')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                {!! Form::label('exchange_rate', __('lang.exchange_rate') . ':', []) !!}
                                <input type="text" class="form-control" id="exchange_rate"
                                    value="{{ $item[0]['exchange_rate'] }}"
                                    placeholder="سعر السوق({{ $exchange_rate }})" wire:model="exchange_rate"
                                    wire:change="changeExchangeRateBasedPrices()">
                            </div>

                             {{-- +++++++++++++++++++++++ "balance return request"  +++++++++++++++++++++++ --}}
                             <div class="col-md-1">
                                {!! Form::label('balance_return_request', __('lang.balance_return_request'), ['class' => 'h5 ']) !!}
                                {!! Form::text('balance_return_request', $item[0]['balance_return_request'], [
                                    'wire:model' => 'item.0.balance_return_request',
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="col-md-1">
                                <label for="invoice_currency" class="h5 pt-1">@lang('lang.currency') :*</label>
                                {!! Form::select('invoice_currency', $selected_currencies, $transaction_currency,
                                    ['class' => 'form-control ','placeholder' => __('lang.please_select'), 'data-live-search' => 'true', 'disabled',
                                     'required', 'data-name' => 'transaction_currency', 'wire:model' => 'transaction_currency']) !!}
                                @error('transaction_currency')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- +++++++++++++++++++++++ "product_tax" selectbox +++++++++++++++++++++++ --}}
                            <div class="col-md-2">
                                <label for="product" class="h5 pt-1">{{ __('lang.product_tax') . ':*' }}</label>
                                <div class="d-flex justify-content-center">
                                    <select id="product_tax" class="form-control select2"
                                        wire:model="item.0.product_tax_id" placeholder="{{ __('lang.please_select') }}"
                                        data-name="product_tax_id">
                                        <option value="">{{ __('lang.please_select') }}</option>
                                        @foreach ($product_taxes as $tax)
                                            @if ($tax->status == 'active')
                                                <option value="{{ $tax->id }}"
                                                    {{ $item[0]['product_tax_id'] == $tax->id ? 'selected' : '' }}>
                                                    {{ $tax->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary btn-sm ml-2 select_sub_category"
                                        data-toggle="modal" data-target="#add_product_tax_modal"
                                        data-select_category="2"><i class="fas fa-plus"></i></button>
                                    @include('product-tax.create', ['quick_add' => 1])
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label for="method" class="h5 pt-1">{{ __('lang.tax_method') . ':*' }}</label>
                                {!! Form::select(
                                    'method',
                                    ['inclusive' => __('lang.inclusive'), 'exclusive' => __('lang.exclusive')],
                                    $item[0]['method'],
                                    [
                                        'id' => 'method',
                                        'class' => ' form-control select2 method',
                                        'data-name' => 'method',
                                        'placeholder' => __('lang.please_select'),
                                        'wire:model' => 'item.0.method',
                                    ],
                                ) !!}
                            </div>



                            <div class="col-md-3">
                                <div class="main_category">
                                    {!! Form::label('category', __('lang.category'), ['class' => 'h5']) !!}
                                    <div class="d-flex justify-content-center">
                                        {!! Form::select('category_id', $categories, $item[0]['category_id'], [
                                            'class' => 'form-control select2 category_id',
                                            'placeholder' => __('lang.please_select'),
                                            'data-name' => 'category_id',
                                            'id' => 'categoryId',
                                            'wire:model' => 'item.0.category_id',
                                        ]) !!}
                                        <a data-href="{{ route('categories.sub_category_modal') }}"
                                            data-container=".view_modal"
                                            class="btn btn-modal btn-primary text-white btn-sm ml-2 openCategoryModal"
                                            data-toggle="modal" data-select_category="0"><i class="fas fa-plus"></i></a>
                                        {{--                                    @include('categories.create_modal', ['quick_add' => 1]) --}}
                                        <button type="button" class="btn btn-warning btn-sm ml-2"
                                            wire:click="showCategory1()"><i
                                                class="fas {{ $show_category1 == 0 ? 'fa-arrow-right' : 'fa-arrow-left' }}"></i></button>
                                    </div>
                                    @error('item.0.category_id')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div
                                    class="subcategory_id1 {{ ($show_category1 == 0 && $show_category3 == 0 && $show_category2 == 0)  ? (empty($item[0]['subcategory_id1'])?'d-none':'') : '' }}">
                                    {!! Form::label('subcategory', __('lang.category') . ' 1', ['class' => 'h5 ']) !!}
                                    <div class="d-flex justify-content-center">
                                        {!! Form::select('subcategory_id1', $subcategories1, $item[0]['subcategory_id1'], [
                                            'class' => 'form-control select2 subcategory1',
                                            'data-name' => 'subcategory_id1',
                                            'placeholder' => __('lang.please_select'),
                                            'id' => 'subcategory_id1',
                                            'wire:model' => 'item.0.subcategory_id1',
                                        ]) !!}
                                        <a data-href="{{ route('categories.sub_category_modal') }}"
                                            data-container=".view_modal"
                                            class="btn btn-primary text-white btn-sm ml-2 openCategoryModal"
                                            data-toggle="modal" data-select_category="1"><i class="fas fa-plus"></i></a>
                                        <button type="button" class="btn btn-warning btn-sm ml-2"
                                            wire:click="showCategory2()"><i
                                                class="fas {{ $show_category2 == 0 ? 'fa-arrow-right' : 'fa-arrow-left' }}"></i></button>
                                    </div>
                                    @error('item.0.subcategory_id1')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div
                                    class="subcategory2 {{ $show_category3 == 0 && $show_category2 == 0 ? (empty($item[0]['subcategory_id2'])?'d-none':'') : '' }}">
                                    {!! Form::label('subcategory', __('lang.category') . ' 2', ['class' => 'h5 ']) !!}
                                    <div class="d-flex justify-content-center">
                                        {!! Form::select('subcategory_id2', $subcategories2, $item[0]['subcategory_id2'], [
                                            'class' => 'form-control select2 subcategory2',
                                            'data-name' => 'subcategory_id2',
                                            'placeholder' => __('lang.please_select'),
                                            'id' => 'subCategoryId2',
                                            'wire:model' => 'item.0.subcategory_id2',
                                        ]) !!}
                                        <a data-href="{{ route('categories.sub_category_modal') }}"
                                            data-container=".view_modal"
                                            class="btn btn-primary text-white btn-sm ml-2 openCategoryModal"
                                            data-toggle="modal" data-select_category="2"><i
                                                class="fas fa-plus"></i></a>
                                        {{-- <button type="button" class="btn btn-primary btn-sm ml-2  openCategoryModal"
                                        data-toggle="modal" data-target=".createSubCategoryModal"
                                        data-select_category="2"><i class="fas fa-plus"></i></button> --}}
                                        <button type="button" class="btn btn-warning btn-sm ml-2"
                                            wire:click="showCategory3()"><i
                                                class="fas {{ $show_category3 == 0 ? 'fa-arrow-right' : 'fa-arrow-left' }}"></i></button>
                                    </div>
                                    @error('item.0.subcategory_id2')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="subcategory3 {{ $show_category3 == 0 ? (empty($item[0]['subcategory_id3'])?'d-none':'') : '' }}">
                                    {!! Form::label('subcategory', __('lang.category') . ' 3', ['class' => 'h5 ']) !!}
                                    <div class="d-flex justify-content-center">
                                        {!! Form::select('subcategory_id3', $subcategories3, $item[0]['subcategory_id3'], [
                                            'class' => 'form-control select2 subcategory3',
                                            'data-name' => 'subcategory_id3',
                                            'placeholder' => __('lang.please_select'),
                                            'id' => 'subCategoryId3',
                                            'wire:model' => 'item.0.subcategory_id3',
                                        ]) !!}
                                        {{-- <button type="button" class="btn btn-primary btn-sm ml-2 openCategoryModal"
                                        data-toggle="modal" data-target=".createSubCategoryModal"
                                        data-select_category="3"><i class="fas fa-plus"></i></button> --}}
                                        <a data-href="{{ route('categories.sub_category_modal') }}"
                                            data-container=".view_modal"
                                            class="btn btn-primary btn-sm ml-2 text-white openCategoryModal"
                                            data-toggle="modal" data-select_category="3"><i
                                                class="fas fa-plus"></i></a>
                                    </div>
                                    @error('item.0.subcategory_id3')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                {!! Form::label('store_id', __('lang.store') . ':*', []) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('store_id', $stores, $item[0]['store_id'], [
                                        'class' => ' form-control select2 store_id',
                                        'data-name' => 'store_id',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'wire:model' => 'item.0.store_id',
                                    ]) !!}
                                    <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
                                        data-target=".add-store" href="{{ route('store.create') }}"><i
                                            class="fas fa-plus"></i></button>
                                    @include('store.create', ['quick_add' => 1])
                                </div>
                                @error('item.0.store_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>
                        <br>

                        {{-- add prices --}}

                        {{-- <div class="row">
                                    <div class="col-md-12 pt-5">
                                        <h4 class="text-primary">{{ __('lang.add_prices_for_different_users') }}</h4>
                                    </div>
                                    <div class="col-md-12 ">
                                        <table class="table table-bordered" id="consumption_table_price">
                                            <thead>
                                                <tr>
                                                    <th style="width: 3%;">#</th>
                                                    <th style="width: 10%;">@lang('lang.type')</th>
                                                    <th style="width: 10%;">@lang('lang.price_category')</th>
                                                    <th style="width: 10%;">@lang('lang.price')</th>
                                                    <th style="width: 10%;">@lang('lang.quantity')</th>
                                                    <th style="width: 11%;">@lang('lang.b_qty')</th>
                                                    <th style="width: 20%;">@lang('lang.customer_type')
                                                        <i class="dripicons-question" data-toggle="tooltip"
                                                            title="@lang('lang.discount_customer_info')"></i>
                                                    </th>
                                                    <th style="width: 5%;">
                                                        <button class="btn btn-xs btn-primary" wire:click="addPriceRaw()"
                                                            type="button">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($priceRow as $index => $row)
                                                    @include('products.product_raw_price', [
                                                        'index' => $index,
                                                    ])
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="raw_price_index" id="raw_price_index"
                                            value="1">
                                    </div>
                        </div>
                        <br><br>
                        <div class="row text-right">
                            <div class="col">
                                <button class="btn btn btn-primary" wire:click="addRaw()" type="button">
                                    <i class="fa fa-plus"></i> @lang('lang.add')
                                </button>
                            </div>
                        </div>
                        <br>
                        {{-- add prices --}}
                        <br>
                        <div class="row text-right">
                            <div class="col">
                                <button class="btn btn btn-primary" wire:click="addRaw()" type="button">
                                    <i class="fa fa-plus"></i> @lang('lang.add')
                                </button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            @foreach ($rows as $index => $row)
                                <div class="col-md-12 col-sm-12 col-lg-6">
                                    <div class="table-responsive">
                                        <table class="table " style="border: 2px solid rgb(177, 177, 177);">
                                            <thead>
                                                <tr>
                                                    <th style="width: 2%">#</th>
                                                    <th style="width: 6%">@lang('lang.sku')</th>
                                                    <th style="width: 6%">@lang('lang.unit')</th>
                                                    <th style="width: 15%">@lang('lang.purchase_price')</th>
                                                    <th style="width: 15%">@lang('lang.quantity')</th>
                                                    <th style="width: 5%">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @include('initial-balance.partial.new_raw_unit', [
                                                    'index' => $index,
                                                ])
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="col-md-12 text-center mt-1 ">
                            <h4>
                                {{--                                @lang('lang.items_count'): --}}
                                {{--                                <span class="items_count_span" style="margin-right: 15px;">{{ count($rows) }}</span> --}}
                                {{--                                <br> --}}
                                {{ $this->count_total_by_variations() }}
                                @if (!empty($variationSums))
                                    @foreach ($variationSums as $unit_name => $variant)
                                        {{ $unit_name }}:
                                        <span class="items_quantity_span" style="margin-right: 15px;">
                                            {{ $variant }} </span><br>
                                    @endforeach
                                @endif
                                <span class="items_quantity_span" style="margin-right: 15px;">
                                    {{ $this->getStore() }}</span>
                                {{--                                @lang('lang.items_quantity'): <span class="items_quantity_span" --}}
                                {{--                                    style="margin-right: 15px;">{{ $totalQuantity }}</span> --}}
                            </h4>
                        </div>

                         {{-- sizes --}}
                         <div class="row">
                            <div class="col-md-12 pt-5 ">
                                <h5 class="text-primary">{{ __('lang.product_dimensions') }}</h5>
                                <button type="button" class="btn btn-warning btn-sm ml-2 "
                                    wire:click="showDimensions()"><i
                                        class="fas {{ $show_dimensions == 0 ? 'fa-arrow-right' : 'fa-arrow-left' }}"></i></button>
                            </div>
                        </div>
                        <div class="row dimensions {{ $show_dimensions == 0 ? (empty($item[0]['basic_unit_variation_id'])?'d-none':'') : '' }}">
                            <div class="col-md-2">
                                {!! Form::label('weight', __('lang.weight'), ['class' => 'h5 pt-3']) !!}
                                <input type="text" wire:model='item.0.weight' wire:change='changeSize()'
                                    class='form-control weight' />
                                <br>
                                @error('item.0.weight')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('height', __('lang.height'), ['class' => 'h5 pt-3']) !!}
                                <input type="text" wire:model='item.0.height' wire:change='changeSize()'
                                    class='form-control height' />
                                <br>
                                @error('item.0.height')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('length', __('lang.length'), ['class' => 'h5 pt-3']) !!}
                                <input type="text" wire:model='item.0.length' wire:change='changeSize()'
                                    class='form-control length' />
                                <br>
                                @error('item.0.length')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('width', __('lang.width'), ['class' => 'h5 pt-3']) !!}
                                <input type="text" wire:model='item.0.width' wire:change='changeSize()'
                                    class='form-control width' />
                                <br>
                                @error('item.0.width')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('size', __('lang.size'), ['class' => 'h5 pt-3']) !!}
                                <input type="text" wire:model='item.0.size' wire:change='changeSize()'
                                    class='form-control size' />
                                <br>
                                @error('item.0.size')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="basic_unit_variation_id" class="h5 pt-3">{{ __('lang.basic_unit_for_import_product') . ':*' }}</label>
                                {!! Form::select('basic_unit_variation_id', $basic_unit_variations, $item[0]['basic_unit_variation_id'], [
                                    'id' => 'basic_unit_variation_id',
                                    'class' => ' form-control select2 basic_unit_variation_id',
                                    'data-name' => 'basic_unit_variation_id',
                                    'placeholder' => __('lang.please_select'),
                                    'wire:model' => 'item.0.basic_unit_variation_id',
                                ]) !!}
                            </div>

                        </div>


                           {{-- discount --}}
                        <div class="row">
                            <div class="col-md-12 pt-5 ">
                                <h5 class="text-primary">{{ __('lang.discount') }}</h5>
                                <button type="button" class="btn btn-warning btn-sm ml-2 "
                                    wire:click="showDiscount()"><i
                                        class="fas {{ $show_discount == 0 ? 'fa-arrow-right' : 'fa-arrow-left' }}"></i></button>
                            </div>
                        </div>
                        @foreach ($prices as $key => $price)
                        {{-- @dd($prices) --}}
                        <div class="discount {{ $show_discount == 0 ? (empty($prices)?'d-none':'') : '' }}">

                                <div class="row">
                                    <div class="col-md-1">
                                        <label for="fill_id" class="h5 pt-3">{{ __('lang.fill') . ':*' }}</label>
                                        {!! Form::select('fill_id', $basic_unit_variations, $prices[$key]['fill_id'], [
                                            'class' => ' form-control select2 fill_id',
                                            'data-name' => 'fill_id',
                                            'data-index' => $key,
                                            'placeholder' => __('lang.please_select'),
                                            'wire:model' => 'prices.' . $key . '.fill_id',
                                        ]) !!}
                                    </div>
                                    <div class="col-md-1">
                                        {!! Form::label('price', __('lang.quantity')) !!}
                                        <input type="text" class="form-control discount_quantity"
                                            wire:model="prices.{{ $key }}.discount_quantity"
                                            wire:change="changePrice({{ $key }}, 'quantity')"
                                            placeholder = "{{ __('lang.quantity') }}">
                                        @error('prices.' . $key . '.discount_quantity')
                                            <br>
                                            <label class="text-danger error-msg">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-md-1">
                                        {!! Form::label('price_category', __('lang.price_category'), ['style' => 'font-size: 10px;', 'class' => 'pt-2']) !!}
                                        <input type="text" class="form-control price_category"
                                            name="price_category"
                                            wire:model="prices.{{ $key }}.price_category" maxlength="6">
                                    </div>
                                    <div class="col-md-1">
                                        {!! Form::label('b_qty', __('lang.b_qty')) !!}
                                        <input type="text" class="form-control bonus_quantity"
                                            wire:model="prices.{{ $key }}.bonus_quantity"
                                            wire:change="changePrice({{ $key }}, 'quantity')"
                                            placeholder = "{{ __('lang.b_qty') }}">
                                        @error('prices.' . $key . '.bonus_quantity')
                                            <br>
                                            <label class="text-danger error-msg">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        {!! Form::label('customer_type', __('lang.customer_type')) !!}
                                        <select wire:model="prices.{{ $key }}.price_customer_types"
                                            data-name='price_customer_types' data-index="{{ $key }}"
                                            data-key="{{ $key }}" class="form-control select2"
                                            placeholder="{{ __('lang.please_select') }}">
                                            @foreach ($customer_types as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="col-md-2">
                                        {!! Form::label('customer_type', __('lang.customer_type')) !!}
                                        <select wire:model="prices.{{ $index }}.price_customer_types"
                                            data-name='price_customer_types' data-index="{{ $index }}"
                                            data-key="{{ $key }}"
                                            class="form-control js-example-basic-multiple" multiple='multiple'
                                            placeholder="{{ __('lang.please_select') }}">
                                            @foreach ($customer_types as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="col-md-1">
                                        {!! Form::label('price_type', __('lang.type')) !!}
                                        <div class="d-flex justify-content-between">
                                            {!! Form::select(
                                                'prices.' . $key . '.price_type',
                                                ['fixed' => __('lang.fixed'), 'percentage' => __('lang.percentage')],
                                                null,
                                                [
                                                    'class' => ' form-control price_type',
                                                    'placeholder' => __('lang.please_select'),
                                                    'wire:model' => 'prices.' . $key . '.price_type',
                                                    'wire:change' => 'changePrice(' . $key . ')',
                                                    'style' => 'width:120px;font-size:15px;height:38px;',
                                                ],
                                            ) !!}
                                            {{-- <select class="custom-select "
                                                style="width:68px;font-size:10px;height:38px; {{ $prices[$key]['price_type'] !== 'fixed' ? 'display:none;' : '' }}"
                                                wire:model="prices.{{ $index }}.price_currency">
                                                <option value="dinar">Dinar</option>
                                                <option selected value="dollar">Dollar</option>
                                            </select> --}}
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input"
                                                name="discount_from_original_price"
                                                id="discount_from_original_price{{ $key }}"
                                                style="font-size: 0.75rem"
                                                wire:model='prices.{{ $key }}.discount_from_original_price'
                                                wire:change="changePrice({{ $key }},'change_price')">
                                            <label class="custom-control-label"
                                                for="discount_from_original_price{{ $key }}">@lang('lang.discount_from_original_price')</label>
                                        </div>
                                        {{-- @error('prices.' . $key . '.price_type')
                                            <br>
                                            <label class="text-danger error-msg">{{ $message }}</label>
                                        @enderror --}}
                                    </div>
                                    <div class="col-md-1">
                                        {!! Form::label(
                                            'price',
                                            isset($price['price_type']) && $price['price_type'] == 'fixed' ? __('lang.amount') : __('lang.percent'),
                                        ) !!}
                                        <input type="text" name="prices.{{ $key }}.dinar_price"
                                            class="form-control price"
                                            wire:model="prices.{{ $key }}.dinar_price"
                                            wire:change="changePrice({{ $key }})"
                                            placeholder = "{{ isset($price['price_type']) && $price['price_type'] == 'fixed' ? __('lang.amount') : __('lang.percent') }}"
                                            @if (empty($prices[$key]['price_type'])) readonly @endif>
                                        <p class="{{$settings['toggle_dollar']=='1'?'d-none':''}}">
                                            {{ $price['price_type'] == 'fixed' ? __('lang.amount') : __('lang.percent') . ' $' }} : {{ $this->prices[$key]['price'] ?? '' }}
                                        </p>
                                    </div>
                                    <div class="col-md-1">
                                        {!! Form::label('', __('lang.price')) !!}
                                        <input type="text"
                                            name="prices.{{ $key }}.dinar_price_after_desc"
                                            class="form-control price"
                                            wire:model="prices.{{ $key }}.dinar_price_after_desc"
                                            placeholder = "{{ __('lang.price') }}">
                                        <p class="{{$settings['toggle_dollar']=='1'?'d-none':''}}">
                                            {{ __('lang.price') . ' $' }}:{{ $this->prices[$key]['price_after_desc'] ?? '' }}
                                        </p>
                                    </div>
                                    <div class="col-md-1">
                                        {!! Form::label('total_price', __('lang.total_price')) !!}
                                        <input type="text" name="prices.{{ $key }}.dinar_total_price"
                                            class="form-control total_price"
                                            wire:model="prices.{{ $key }}.dinar_total_price"
                                            placeholder = "{{ __('lang.total_price') }}">
                                        <p class="{{$settings['toggle_dollar']=='1'?'d-none':''}}">
                                            {{ __('lang.total_price') . ' $' }}:{{ $this->prices[$key]['total_price'] ?? '' }}
                                        </p>
                                    </div>
                                    <div class="col-md-1">
                                        {!! Form::label('piece_price', __('lang.piece_price')) !!}
                                        <input type="text" name="prices.{{ $key }}.dinar_piece_price"
                                            class="form-control piece_price"
                                            wire:model="prices.{{ $key }}.dinar_piece_price"
                                            placeholder = "{{ __('lang.total_price') }}">
                                        {{--                                             <span>{{$rows[$index]['prices'][$key]['dollar_piece_price']??0}} $</span> --}}
                                        <p class="{{$settings['toggle_dollar']=='1'?'d-none':''}}">
                                            {{ __('lang.piece_price') . ' $' }}:{{ $this->prices[$key]['piece_price'] ?? '' }}
                                        </p>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input"
                                                name="prices.{{ $key }}.apply_on_all_customers"
                                                id="apply_on_all_customers{{ $key }}"
                                                style="font-size: 0.75rem"
                                                wire:model="prices.{{ $key }}.apply_on_all_customers"
                                                wire:change="applyOnAllCustomers({{ $key }})">
                                            <br>
                                            <label class="custom-control-label"
                                                for="apply_on_all_customers{{ $key }}">@lang('lang.apply_on_all_customers')</label>
                                        </div>
                                    </div>


                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-sm btn-primary"
                                            wire:click="addPriceRow()">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        @if ($key > 0)
                                            <button class="btn btn-sm btn-danger"
                                                wire:click="delete_price_raw({{ $key }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                        </div>
                        @endforeach
                         {{-- new store --}}
                         <div class="row">
                            <div class="col-md-12 pt-5 ">
                                <h5 class="text-primary">{{ __('lang.add_to_another_store') }}</h5>
                                <button type="button" class="btn btn-warning btn-sm ml-2 "
                                    wire:click="showStore()"><i
                                        class="fas {{ $show_store == 0 ? 'fa-arrow-right' : 'fa-arrow-left' }}"></i></button>
                            </div>
                            @forelse ($fill_stores as $i => $store)
                                <div class="row">
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-sm btn-primary"
                                        wire:click="addStoreRow()">
                                        <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="extra_store_id"
                                        class="h5 ">{{ __('lang.store') . ':*' }}</label>
                                            {!! Form::select('extra_store_id', $stores, $fill_stores[$i]['extra_store_id'], [
                                                'class' => 'form-control select2 extra_store_id',
                                                'data-index' => $i,
                                                'data-name' => 'extra_store_id',
                                                'required',
                                                'placeholder' => __('lang.please_select'),
                                                'wire:model' => 'fill_stores.'.$i.'.extra_store_id',
                                                'wire:key' => 'extra_store_id_'.$i,
                                            ]) !!}

                                        {{-- @error('fill_stores.'.$i.'.extra_store_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror --}}
                                    </div>
                                    @foreach ($fill_stores[$i]['data'] as $x => $fill)
                                        <div class="col-md-1">
                                            <label for="store_fill_id"
                                                class="h5 ">{{ __('lang.fill') . ':*' }}</label>
                                            {!! Form::select('store_fill_id', $basic_unit_variations, $fill_stores[$i]['data'][$x]['store_fill_id'], [
                                                // 'id' => 'store_fill_id',
                                                'class' => ' form-control select2 store_fill_id',
                                                'data-name' => 'store_fill_id',
                                                'data-index' => $i,
                                                'data-key' => $x,
                                                'placeholder' => __('lang.please_select'),
                                                'wire:model' => 'fill_stores.' . $i .'.data.'.$x. '.store_fill_id',
                                            ]) !!}
                                        </div>
                                        <div class="col-md-1">
                                            {!! Form::label('quantity', __('lang.quantity')) !!}
                                            <input type="text" class="form-control quantity"
                                                wire:model="fill_stores.{{ $i }}.data.{{$x}}.quantity"
                                                placeholder = "{{ __('lang.quantity') }}">
                                            @error('fill_stores.' . $i .'data'.$x. '.quantity')
                                                <br>
                                                <label class="text-danger error-msg">{{ $message }}</label>
                                            @enderror

                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-sm btn-danger"
                                            wire:click="delete_store_data_raw({{$i}},{{ $x }})">
                                            <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-1 {{$x!=(count($fill_stores[$i]['data'])-1)?'d-none':''}}">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                wire:click="addStoreDataRow({{$i}})">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                            {{-- @if ($i > 0) --}}
                                            <button class="btn btn-sm btn-danger"
                                                wire:click="delete_store_raw({{ $i }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            {{-- @endif --}}
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                            @if (!empty($this->count_fill_stores_unit($i)))
                                                @foreach ($this->count_fill_stores_unit($i) as $unit_name => $variant)
                                                    <h2 class="items_quantity_span" style="margin-right: 15px;">
                                                        {{ $unit_name }}: {{ $variant }} </h2><br>
                                                @endforeach
                                            @endif
                                            <h2 class="items_quantity_span" style="margin-right: 15px;">
                                                {{ $this->getExtraFillStore($i) }}</h2>
                                    </div>
                                </div>
                            @empty
                            <div class="row">
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-primary"
                                                wire:click="addStoreRow()">
                                                <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- {!! Form::close() !!} --}}
                    <div class="col-sm-12">
                        <button type="submit" name="submit" id="submit-save" style="margin: 10px" value="save"
                            class="btn btn-primary pull-right btn-flat submit"
                            wire:click.prevent="edit()">@lang('lang.edit')</button>

                    </div>
                    <div class="col-md-12 text-center">
                        {{ $this->count_total_by_variation_stores() }}
                        @if (!empty($variationStoreSums))
                            @foreach ($variationStoreSums as $unitName => $variant_qty)
                                <h2 class="items_quantity_span" style="margin-right: 15px;">
                                    {{ $unitName }} : {{ $variant_qty }} </h2><br>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <!-- This will be printed --> --}}
<div class="view_modal no-print"></div>
<section class="invoice print_section print-only" id="receipt_section"> </section>
@include('units.create', ['quick_add' => 1])


@push('javascripts')
    <script>
        document.addEventListener('livewire:load', function() {
            $('.js-example-basic-multiple').select2({
                placeholder: LANG.please_select,
                tags: true
            });
            // $('.select2').select2();
            Livewire.hook('message.processed', (message, component) => {
                if (message.updateQueue && message.updateQueue.some(item => item.payload.event ===
                        'updated:selectedProducts')) {
                    $('.product_selected').on('click', function(event) {
                        event.stopPropagation();
                        var value = $(this).prop('checked');
                        var productId = $(this).val();
                        Livewire.find(component.fingerprint).set('selectedProducts.' + productId,
                            value);
                    });
                }
            });
        });
        document.addEventListener('livewire:load', function() {
            Livewire.on('closeModal', function() {
                // Close the modal using Bootstrap's modal API
                $('#select_products_modal').modal('hide');
            });
        });
        document.addEventListener('livewire:load', function() {
            Livewire.on('printInvoice', function(htmlContent) {
                window.print();
            });
        });
        $(document).on('change', 'select', function(e) {

            var name = $(this).data('name');
            console.log(name)
            if (name != undefined) {
                var index = $(this).data('index');
                var key = $(this).data('key');
                var select2 = $(this);
                Livewire.emit('listenerReferenceHere', {
                    var1: name,
                    var2: select2.select2("val"),
                    var3: index,
                    var4: key
                });
            }

        });
        window.addEventListener('showCreateProductConfirmation', function() {
            Swal.fire({
                title: "{{ __('lang.this_product_exists_before') }}" + "<br>" +
                    "{{ __('lang.continue_to_add_stock') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('create');
                } else {
                    Livewire.emit('cancelCreateProduct');
                }
            });
        });

        $(document).on("click", ".add_price_row", function() {
            let row_id = parseInt($("#raw_price_index").val());
            $("#raw_price_index").val(row_id + 1);
            $.ajax({
                method: "get",
                url: "/product/get-raw-price",
                data: {
                    row_id: row_id
                },
                success: function(result) {
                    $("#consumption_table_price > tbody").prepend(result);
                },
            });
        });
        $(document).on("click", ".remove_row", function() {
            row_id = $(this).closest("tr").data("row_id");
            $(this).closest("tr").remove();
        });
    </script>
@endpush

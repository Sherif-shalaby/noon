<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header d-flex align-items-center">
                        <h4>@lang('lang.add-stock')</h4>
                    </div>
                    <div class="row ">
                        <div class="col-md-5">
                            <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info')</small></p>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>
                                    {!! Form::checkbox('change_exchange_rate_to_supplier', 1, false, [
                                        'wire:model' => 'change_exchange_rate_to_supplier',
                                    ]) !!}
                                    @lang('lang.change_exchange_rate_to_supplier')
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="i-checks">
                                <input id="clear_all_input_form" name="clear_all_input_form" type="checkbox"
                                    @if (isset($clear_all_input_stock_form) && $clear_all_input_stock_form == '1') checked @endif class="">
                                <label for="clear_all_input_form" style="font-size: 0.75rem">
                                    <strong>
                                        @lang('lang.clear_all_input_form')
                                    </strong>
                                </label>
                            </div>
                        </div>
                        {{-- ++++++++++++++++ checkbox : Toggle Customer Dropdown ++++++++++++++ --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>
                                    {!! Form::checkbox('toggle_customers_dropdown', 1, false, ['wire:model' => 'toggle_customers_dropdown']) !!}
                                    @lang('lang.toggle_customers_dropdown')
                                </label>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['id' => 'add_stock_form', 'wire:submit.prevent' => 'validateItems']) !!}
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                                {{-- <div class="col-md-3">
                                    {!! Form::label('store_id', __('lang.store') . ':*', []) !!}
                                    {!! Form::select('store_id', $stores, $store_id, ['class' => ' form-control select2','data-name' => 'store_id', 'data-live-search' => 'true', 'required', 'placeholder' => __('lang.please_select'), 'wire:model' => 'store_id']) !!}
                                    @error('store_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}
                                {{-- +++++++++++++++ supplier dropdown ++++++++++ --}}
                                <div class="col-md-3">
                                    {!! Form::label('supplier_id', __('lang.supplier') . ':*', []) !!}
                                    <div class="d-flex justify-content-center">
                                        {!! Form::select('supplier_id', $suppliers, $supplier, [
                                            'class' => 'form-control select2',
                                            'data-live-search' => 'true',
                                            'id' => 'supplier_id',
                                            'placeholder' => __('lang.please_select'),
                                            'data-name' => 'supplier',
                                            'wire:model' => 'supplier',
                                            'wire:change' => 'changeExchangeRate()',
                                        ]) !!}
                                        <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
                                            data-target=".add-supplier"><i class="fas fa-plus"></i></button>
                                    </div>
                                    @error('supplier')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- <div class="col-md-2">
                                    <label for="invoice_currency">@lang('lang.invoice_currency') :*</label>
                                    {!! Form::select('invoice_currency', $selected_currencies, $transaction_currency,
                                        ['class' => 'form-control select2','placeholder' => __('lang.please_select'), 'data-live-search' => 'true',
                                         'required', 'data-name' => 'transaction_currency', 'wire:model' => 'transaction_currency']) !!}
                                    @error('transaction_currency')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}
                                <div class="col-md-2">
                                    {!! Form::label('purchase_type', __('lang.purchase_type') . ':*', []) !!}
                                    {!! Form::select('purchase_type', ['import' => __('lang.import'), 'local' => __('lang.local')], $purchase_type, [
                                        'class' => 'form-control',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'data-name' => 'purchase_type',
                                        'wire:model' => 'purchase_type',
                                    ]) !!}

                                    @error('purchase_type')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    {!! Form::label('purchase_type', __('lang.po'), []) !!}
                                    {!! Form::select('purchase_type', $po_nos, null, [
                                        'class' => 'form-control select2',
                                        'data-live-search' => 'true',
                                        'placeholder' => __('lang.please_select'),
                                        'data-name' => 'po_id',
                                        'wire:model' => 'po_id',
                                    ]) !!}
                                    @error('po_id')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 pt-2 pb-2 {{ $supplier != null ? '' : 'd-none' }}">
                                    <div class="row">
                                        <div class="col-md-2">@lang('lang.debit') {{ $supplier_data['dollar_debit'] }} $
                                        </div>
                                        <div class="col-md-2">@lang('lang.debit') {{ $supplier_data['dinar_debit'] }} د.ع
                                        </div>
                                        <div class="col-md-2">@lang('lang.email') {{ $supplier_data['email'][0]?? '' }}</div>
                                        <div class="col-md-2">@lang('lang.phone') {{ $supplier_data['mobile'][0] ?? '' }}</div>
                                        <div class="col-md-2">@lang('lang.state') {{ $supplier_data['state'] }}</div>
                                        <div class="col-md-2">@lang('lang.city') {{ $supplier_data['city'] }}</div>
                                        <div class="col-md-2">@lang('lang.address') {{ $supplier_data['address'] }}</div>
                                        <div class="col-md-2">@lang('lang.notes') {{ $supplier_data['notes'] }}</div>
                                    </div>
                                </div>
                                {{-- +++++++++++++++++ customers Dropdown +++++++++++++++++ --}}
                                @if (!empty($toggle_customers_dropdown))
                                    <div class="col-md-3">
                                        {!! Form::label('customer_id', __('lang.customers') . ':*', []) !!}
                                        <div class="d-flex justify-content-center">
                                            {!! Form::select('customer_id', $customers, $customer_id, [
                                                'class' => 'form-control select2',
                                                'data-live-search' => 'true',
                                                'id' => 'customer_id',
                                                'placeholder' => __('lang.please_select'),
                                                'data-name' => 'customer_id',
                                                'wire:model' => 'customer_id',
                                            ]) !!}
                                            {{-- <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target=".add-supplier" ><i class="fas fa-plus"></i></button> --}}
                                        </div>
                                        @error('customer_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="row">

                                <div class="col-md-3">
                                    {!! Form::label('divide_costs', __('lang.divide_costs') . ':', []) !!}
                                    {!! Form::select(
                                        'divide_costs',
                                        ['size' => __('lang.size'), 'weight' => __('lang.weight'), 'price' => __('lang.price')],
                                        $divide_costs,
                                        [
                                            'class' => 'form-control select2',
                                            'data-live-search' => 'true',
                                            'required',
                                            'placeholder' => __('lang.please_select'),
                                            'data-name' => 'divide_costs',
                                            'wire:model' => 'divide_costs',
                                        ],
                                    ) !!}
                                    @error('divide_costs')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('transaction_date', __('lang.print_date'), []) !!}
                                    <input type="datetime-local" wire:model="transaction_date"
                                        value="{{ date('Y-m-d\TH:i') }}" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('exchange_rate', __('lang.exchange_rate') . ':', []) !!}
                                    <input type="text" class="form-control changeExchangerateForSupplier"
                                        id="exchange_rate" name="exchange_rate" wire:model="exchange_rate">
                                </div>
                                @if (!empty($change_exchange_rate_to_supplier))
                                    <div class="col-md-3">
                                        {!! Form::label('exchange_rate', __('lang.end_date') . ':', []) !!}
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            wire:model="end_date">
                                    </div>
                                @endif

                            </div>
                            <div class="row">
                                {{-- <div class="col-md-2">

                                    @error('expenses_currency')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}
                                <div class="col-md-8">
                                    @foreach ($expenses as $index => $expense)
                                        <div class="row">
                                                <div class="form-group">
                                                    <label for="expenses_currency">@lang('lang.expenses_currency')</label>
                                                    {!! Form::select('expenses_currency', $selected_currencies, $transaction_currency, [
                                                        'class' => 'form-control select2',
                                                        'placeholder' => __('lang.please_select'),
                                                        'data-name' => 'expense_currency',
                                                        'data-index' =>$index,
                                                        'wire:model' => 'expenses.' . $index . '.expense_currency',
                                                    ]) !!}
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('details', __('Details'), []) !!} <br>
                                                    {!! Form::text('expenses.' . $index . '.details', $expense['details'], [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('Details'),
                                                        'wire:model' => 'expenses.' . $index . '.details',
                                                    ]) !!}
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('amount', __('Amount'), []) !!} <br>
                                                    {!! Form::text('expenses.' . $index . '.amount', $expense['amount'], [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('Amount'),
                                                        'wire:model' => 'expenses.' . $index . '.amount',
                                                        'wire:change' => 'changeTotalAmount',
                                                    ]) !!}
                                                </div>
                                                <button class="btn btn-primary btn-sm ml-2"
                                                    wire:click="removeExpense({{ $index }})">Remove</button>

                                        </div>
                                    @endforeach

                                    <button class="btn btn-primary btn-sm ml-2 " wire:click="addExpense">Add
                                        Expense</button>
                                </div>
                                <div class="col-md-2 pt-3">
                                    {{$this->getTotalExpenses()}}
                                    <h3 class="{{$dollar_expenses>0?'':'d-none'}}">@lang('lang.total_expenses') {{$dollar_expenses}} $</h3>
                                    <h3 class="{{$dinar_expenses>0?'':'d-none'}}">@lang('lang.total_expenses') {{$dinar_expenses}} </h3>
                                    {{$this->total_expenses}}
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('other_payments', __('lang.other_payments'), []) !!} <br>
                                        {!! Form::text('other_payments', $other_payments,
                                        ['class' => 'form-control', 'placeholder' => __('lang.other_payments'), 'id' => 'other_payments',
                                         'wire:model' => 'other_payments','wire:change'=>'changeTotalAmount()']) !!}
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-2 border border-1 mr-3 p-0">
                                <div class="p-3 text-center font-weight-bold " style="background-color: #eee;">
                                    الأقسام الرئيسيه
                                    <div for="" class="d-flex align-items-center text-nowrap gap-1" wire:ignore>
                                        <div class="row">
                                            {{-- الاقسام --}}
                                            <select class="form-control depart1 select2" wire:model="department_id1"
                                                data-name="department_id1">
                                                <option value="0 " readonly selected>اختر </option>
                                                @foreach ($departments as $depart)
                                                    @if ($depart->parent_id === 1)
                                                        <option value="{{ $depart->id }}">{{ $depart->name }}
                                                        </option>
                                                        {{-- @if ($depart->subCategories->count() > 0) --}}
                                                        {{-- @include('categories.category-select', ['categories' => $depart->subCategories, 'prefix' => '-']) --}}
                                                        {{-- @endif --}}
                                                    @endif
                                                @endforeach
                                            </select>
                                            <select class="form-control depart select2" wire:model="department_id2"
                                                data-name="department_id2">
                                                <option value="0 " readonly selected>اختر </option>
                                                @foreach ($departments as $depart)
                                                    @if ($depart->parent_id === 2)
                                                        <option value="{{ $depart->id }}">{{ $depart->name }}
                                                        </option>
                                                        {{-- @if ($depart->subCategories->count() > 0) --}}
                                                        {{-- @include('categories.category-select', ['categories' => $depart->subCategories, 'prefix' => '-']) --}}
                                                        {{-- @endif --}}
                                                    @endif
                                                @endforeach
                                            </select>
                                            <select class="form-control depart select2" wire:model="department_id3"
                                                data-name="department_id3">
                                                <option value="0 " readonly selected>اختر </option>
                                                @foreach ($departments as $depart)
                                                    @if ($depart->parent_id === 3)
                                                        <option value="{{ $depart->id }}">{{ $depart->name }}
                                                        </option>
                                                        {{-- @if ($depart->subCategories->count() > 0) --}}
                                                        {{-- @include('categories.category-select', ['categories' => $depart->subCategories, 'prefix' => '-']) --}}
                                                        {{-- @endif --}}
                                                    @endif
                                                @endforeach
                                            </select>
                                            <select class="form-control depart select2" wire:model="department_id4"
                                                data-name="department_id4">
                                                <option value="0 " readonly selected>اختر </option>
                                                @foreach ($departments as $depart)
                                                    @if ($depart->parent_id === 4)
                                                        <option value="{{ $depart->id }}">{{ $depart->name }}
                                                        </option>
                                                        {{-- @if ($depart->subCategories->count() > 0) --}}
                                                        {{-- @include('categories.category-select', ['categories' => $depart->subCategories, 'prefix' => '-']) --}}
                                                        {{-- @endif --}}
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    @if ($allproducts and $allproducts != null)
                                        @forelse ($allproducts as $product)
                                            <div class="order-btn" wire:click='add_product({{ $product->id }})'
                                                style="cursor: pointer">
                                                <span>{{ $product->name }}</span>
                                                <span>{{ $product->sku }} </span>
                                            </div>
                                            <hr />
                                        @empty
                                            <div class="col-md-12">
                                                <span>عفوا لايوجد منتجات فى هذا القسم</span>
                                            </div>
                                        @endforelse
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="table-responsive col-md-12 border border-1">
                                        <table class="table" style="width: auto">
                                            <thead>
                                                <tr>
                                                    <th>#</th>

                                                    {{--                                        <th style="width: 7%" class="col-sm-8">@lang('lang.image')</th> --}}
                                                    <th>@lang('lang.currency')</th>
                                                    <th style="width: 10%" class="col-sm-8">@lang('lang.products')</th>
                                                    <th style="width: 10%">@lang('lang.store')</th>
                                                    {{-- <th style="width: 10%" >@lang('lang.sku')</th> --}}
                                                    <th style="width: 10%">@lang('lang.unit')</th>
                                                    <th style="width: 10%">@lang('lang.quantity')</th>
                                                    <th style="width: 10%">@lang('lang.bonus_quantity')</th>

                                                    {{--                                        <th style="width: 10%">@lang('lang.fill')</th> --}}
                                                    {{--                                        <th style="width: 10%">@lang('lang.basic_unit')</th> --}}

                                                    {{--                                        <th style="width: 10%">@lang('lang.total_quantity')</th> --}}
                                                    {{--                                        @if ($showColumn) --}}
                                                    {{-- <th style="width: 10%">@lang('lang.purchase_price')$</th>
                                                    <th style="width: 10%">@lang('lang.selling_price')$</th>
                                                    <th style="width: 10%">@lang('lang.sub_total')$</th> --}}
                                                    {{--                                        @endif --}}
                                                    <th style="width: 10%">@lang('lang.purchase_price') </th>
                                                    {{-- <th style="width: 10%">@lang('lang.selling_price') </th> --}}
                                                    <th style="width: 10%">@lang('lang.sub_total')</th>

                                                    {{--                                        @if ($showColumn) --}}
                                                    {{-- <th style="width: 10%">@lang('lang.cost')$</th>
                                                    <th style="width: 10%">@lang('lang.total_cost')$</th> --}}
                                                    {{--                                        @endif --}}
                                                    {{-- <th style="width: 10%">@lang('lang.cost') </th>
                                                <th style="width: 10%">@lang('lang.total_cost')</th> --}}

                                                    <th style="width: 10%">@lang('lang.new_stock')</th>
                                                    <th style="width: 10%">@lang('lang.change_current_stock')</th>

                                                    <th style="width: 10%">@lang('lang.action')</th>
                                                    <th></th>
                                                    <th style="width: 10%">@lang('lang.cost')</th>
                                                    <th style="width: 10%">@lang('lang.size')</th>
                                                    <th style="width: 10%">@lang('lang.total_size')</th>
                                                    <th style="width: 10%">@lang('lang.weight')</th>
                                                    <th style="width: 10%">@lang('lang.total_weight')</th>
                                                    {{-- <th style="width: 10%">@lang('lang.to_get_sell_price')</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($items))
                                                    @foreach ($items as $index => $product)
                                                        @include('add-stock.partials.product_row')
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="8" style="text-align: right">
                                                            @lang('lang.total')</td>
                                                        {{--                                            @if ($showColumn) --}}
                                                        {{-- <td> {{$this->sum_dollar_sub_total()}} </td> --}}
                                                        <td></td>
                                                        <td></td>
                                                        {{--                                            @endif --}}
                                                        {{-- <td> {{$this->sum_sub_total()}} </td> --}}
                                                        <td></td>
                                                        <td style="">
                                                            {{-- {{$this->sum_size() ?? 0}} --}}
                                                        </td>
                                                        <td></td>
                                                        <td style=";">
                                                            {{-- {{$this->sum_weight() ?? 0}} --}}
                                                        </td>
                                                        <td></td>
                                                        {{--                                            @if ($showColumn) --}}
                                                        <td>
                                                            {{-- {{$this->sum_dollar_total_cost() ?? 0}} --}}
                                                        </td>
                                                        <td></td>
                                                        {{--                                            @endif --}}
                                                        <td style=";">
                                                            {{-- {{$this->sum_total_cost() ?? 0}} --}}
                                                        </td>

                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            {{-- ++++++ "البحث "برمز المنتج ++++++ --}}
                                            <div class="col-md-3 m-t-15">
                                                <div class="search-box input-group">
                                                    <input type="search" name="search_by_product_symbol"
                                                        id="search_by_product_symbol"
                                                        wire:model.debounce.200ms="search_by_product_symbol"
                                                        placeholder="@lang('lang.enter_product_symbol')" class="form-control"
                                                        autocomplete="off">

                                                    @if (!empty($search_result) && !empty($search_by_product_symbol))
                                                        <ul id="ui-id-1" tabindex="0"
                                                            class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2"
                                                            style="top: 37.423px; left: 39.645px; width: 90.2%;">
                                                            @foreach ($search_result as $product)
                                                                <li class="ui-menu-item"
                                                                    wire:click="add_product({{ $product->id }})">
                                                                    <div id="ui-id-73" tabindex="-1"
                                                                        class="ui-menu-item-wrapper">
                                                                        @if ($product->image)
                                                                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                                                alt="{{ $product->name }}"
                                                                                class="img-thumbnail" width="100px">
                                                                        @else
                                                                            <img src="{{ asset('uploads/' . $settings['logo']) }}"
                                                                                alt="{{ $product->name }}"
                                                                                class="img-thumbnail" width="100px">
                                                                        @endif
                                                                        {{ $product->product_symbol ?? '' }} -
                                                                        {{ $product->name }}
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- ++++++ "البحث "باسم المنتج" و "الباركود ++++++ --}}
                                            <div class="col-md-7 m-t-15">
                                                <div class="search-box input-group">
                                                    <button type="button" class="btn btn-secondary"
                                                        id="search_button"><i class="fa fa-search"></i>
                                                    </button>
                                                    <input type="search" name="search_product" id="search_product"
                                                        wire:model.debounce.200ms="searchProduct"
                                                        placeholder="@lang('lang.enter_product_name_to_print_labels')" class="form-control"
                                                        autocomplete="off">

                                                    @if (!empty($search_result) && !empty($searchProduct))
                                                        <ul id="ui-id-1" tabindex="0"
                                                            class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2"
                                                            style="top: 37.423px; left: 39.645px; width: 90.2%;">
                                                            @foreach ($search_result as $product)
                                                                <li class="ui-menu-item"
                                                                    wire:click="add_product({{ $product->id }})">
                                                                    <div id="ui-id-73" tabindex="-1"
                                                                        class="ui-menu-item-wrapper">
                                                                        @if ($product->image)
                                                                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                                                alt="{{ $product->name }}"
                                                                                class="img-thumbnail" width="100px">
                                                                        @else
                                                                            <img src="{{ asset('uploads/' . $settings['logo']) }}"
                                                                                alt="{{ $product->name }}"
                                                                                class="img-thumbnail" width="100px">
                                                                        @endif
                                                                        {{ $product->sku ?? '' }} -
                                                                        {{ $product->name }}
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="col-md-12 text-center mt-1 ">
                            <h4>@lang('lang.items_count'):
                                <span class="items_count_span"
                                    style="margin-right: 15px;">{{ $this->countItems() }}</span><br>
                                {{--                                @lang('lang.units_count'): --}}
                                {{--                                <span class="items_quantity_span" style="margin-right: 15px;">{{ $this->countUnitsItems() }}</span><br> --}}
                                {{ $this->count_total_by_variations() }}
                                @if (!empty($variationSums))
                                    @foreach ($variationSums as $unit_name => $variant)
                                        {{ $unit_name == "" ? __('lang.no_units') : $unit_name }}:
                                        <span class="items_quantity_span" style="margin-right: 15px;">
                                            {{ $variant }} </span><br>
                                    @endforeach
                                @endif

                            </h4>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <div class="col-md-3 offset-md-8 text-right">
                                <h3> @lang('lang.total') :
                                    {{-- @if ($paying_currency == 2) --}}
                                    {{-- {{$this->sum_dollar_total_cost() ?? 0.00}} --}}
                                    {{-- @else --}}
                                    {{ $this->sum_total_cost() ?? 0.0 }}
                                    {{-- @endif --}}
                                    <span class="final_total_span"></span>
                                </h3>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <div class="col-md-3 offset-md-8 text-right">
                                <h3> @lang('lang.total')$ :
                                    {{-- @if ($paying_currency == 2) --}}
                                    {{ $this->sum_dollar_total_cost() ?? 0.0 }}
                                    {{-- @else --}}
                                    {{-- {{$this->sum_total_cost() ?? 0.00}} --}}
                                    {{-- @endif --}}
                                    <span class="final_total_span"></span>
                                </h3>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('files', __('lang.files'), []) !!} <br>
                                    <input type="file" name="files[]" id="files" wire:model="files">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('invoice_no', __('lang.invoice_no'), []) !!} <br>
                                    {!! Form::text('invoice_no', $invoice_no, [
                                        'class' => 'form-control',
                                        'placeholder' => __('lang.invoice_no'),
                                        'wire:model' => 'invoice_no',
                                    ]) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('discount_amount', __('lang.discount'), []) !!} <br>
                                    {!! Form::text('discount_amount', $discount_amount, [
                                        'class' => 'form-control',
                                        'placeholder' => __('lang.discount'),
                                        'id' => 'discount_amount',
                                        'wire:model' => 'discount_amount',
                                        'wire:change' => 'changeTotalAmount()',
                                    ]) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('source_type', __('lang.source_type') . ':*', []) !!} <br>
                                    {!! Form::select('source_type', ['pos' => __('lang.pos'), 'safe' => __('lang.safe')], $source_type, [
                                        'class' => 'form-control select2',
                                        'data-live-search' => 'true',
                                        'placeholder' => __('lang.please_select'),
                                        'data-name' => 'source_type',
                                        'wire:model' => 'source_type',
                                    ]) !!}
                                </div>
                                @error('source_type')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label(null, null, []) !!} <br>
                                    {!! Form::select('source_id', $users, $source_id, [
                                        'class' => 'form-control select2',
                                        'data-live-search' => 'true',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'source_id',
                                        'required',
                                        'data-name' => 'source_id',
                                        'wire:model' => 'source_id',
                                    ]) !!}
                                </div>
                                @error('source_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('payment_status', __('lang.payment_status') . ':*', []) !!}
                                    {!! Form::select('payment_status', $payment_status_array, $payment_status, [
                                        'class' => 'form-control select2',
                                        'data-live-search' => 'true',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'data-name' => 'payment_status',
                                        'wire:model' => 'payment_status',
                                    ]) !!}
                                    @error('payment_status')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 payment_fields hide {{ $show_payment == 1 ? 'd-none' : '' }}">
                                <div class="form-group">
                                    {!! Form::label('method', __('lang.payment_type'), []) !!}
                                    {!! Form::select('method', $payment_type_array, $method, [
                                        'class' => 'form-control select2',
                                        'data-live-search' => 'true',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'data-name' => 'method',
                                        'wire:model' => 'method',
                                        'wire:change' => 'reset_change()',
                                    ]) !!}
                                    @error('method')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @include('add-stock.partials.payment_form')
                            @if ($payment_status != 'paid' && isset($payment_status))
                                @if (!empty($amount))
                                    <div class="col-md-3 due_amount_div {{ $show_payment == 1 ? 'd-none' : '' }}">
                                        <label for="due_amount" style="margin-top: 25px;">@lang('lang.duePaid'):
                                            <span class="due_amount_span">
                                                @if ($paying_currency == 2)
                                                    {{ $this->sum_dollar_total_cost() - $amount ?? '' }}
                                                @else
                                                    {{ @num_uf($this->sum_total_cost()) - $amount ?? '' }}
                                                @endif
                                            </span>
                                        </label>
                                    </div>
                                @endif
                                <div class="col-md-3 due_amount_div {{ $show_payment == 1 ? 'd-none' : '' }}">
                                    <div class="form-group">
                                        <label for="due_date">@lang('lang.due'): </label>
                                        <input class="form-control" placeholder="@lang('lang.due')" name="due_date"
                                            type="date" id="due_date" autocomplete="off" fdprocessedid="pipnea"
                                            wire:model="due_date">
                                    </div>
                                </div>

{{--                                <div class="col-md-3 due_fields d-none {{ $show_payment == 1 ? 'd-none' : '' }}">--}}
{{--                                    <div class="form-group">--}}
{{--                                        {!! Form::label('due_date', __('lang.due_date') . ':', []) !!} <br>--}}
{{--                                        {!! Form::date(--}}
{{--                                            'due_date',--}}
{{--                                            !empty($transaction_payment) && !empty($transaction_payment->due_date)--}}
{{--                                                ? @format_date($transaction_payment->due_date)--}}
{{--                                                : (!empty($payment)--}}
{{--                                                    ? @format_date($payment->due_date)--}}
{{--                                                    : null),--}}
{{--                                            ['class' => 'form-control', 'placeholder' => __('lang.due_date'), 'wire:model' => 'due_date'],--}}
{{--                                        ) !!}--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="col-md-3 due_fields d-none {{ $show_payment == 1 ? 'd-none' : '' }}">
                                    <div class="form-group">
                                        {!! Form::label('notify_before_days', __('lang.notify_before_days') . ':', []) !!}
                                        <br>
                                        {!! Form::text(
                                            'notify_before_days',
                                            !empty($transaction_payment) && !empty($transaction_payment->notify_before_days)
                                                ? $transaction_payment->notify_before_days
                                                : (!empty($payment)
                                                    ? $payment->notify_before_days
                                                    : null),
                                            ['class' => 'form-control', 'placeholder' => __('lang.notify_before_days'), 'wire:model' => 'notify_before_days'],
                                        ) !!}
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('notes', __('lang.notes') . ':', []) !!} <br>
                                    {!! Form::textarea(
                                        'notes',
                                        !empty($recent_stock) && !empty($recent_stock->notes) ? $recent_stock->notes : null,
                                        ['class' => 'form-control', 'rows' => 3, 'wire:model' => 'notes'],
                                    ) !!}
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" name="submit" id="submit-save" style="margin: 10px" value="save"
                            class="btn btn-primary pull-right btn-flat submit"
                            wire:click.prevent = "store()">@lang('lang.save')</button>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
<div class="view_modal no-print"></div>
{{-- <!-- This will be printed --> --}}
<section class="invoice print_section print-only" id="receipt_section"> </section>
@include('suppliers.quick_add', ['quick_add' => 1])
@include('products.partials.add_store_modal')
@include('store.create', ['quick_add' => $quick_add])

@push('javascripts')
    <script>
        $(document).on('change', '.changeExchangerateForSupplier', function(e) {
            Swal.fire({
                'type': 'info',
                'title': 'تأكيد',
                'text': 'هل نريد تغيير سعر الصرف لهذا المورد ؟',
                'showCancelButton': true,
                'confirmButtonText': 'نعم',
                'cancelButtonText': 'إلغاء',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('changeExchangerateForSupplier', 'ok');
                } else {
                    Livewire.emit('changeExchangerateForSupplier', 'cancel');
                }
            });

        });
        document.addEventListener('livewire:load', function() {
            $('.depart1').select().on('change', function(e) {
                @this.set('department_id1', $(this).val());
            });
        });
        document.addEventListener('livewire:load', function() {
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
                // Set the generated HTML content
                // $("#receipt_section").html(htmlContent);

                // Trigger the print action
                window.print();
            });
        });
        $(document).on("click", "#clear_all_input_form", function() {
            var value = $('#clear_all_input_form').is(':checked') ? 1 : 0;
            $.ajax({
                method: "get",
                url: "/create-or-update-system-property/clear_all_input_stock_form/" + value,
                contentType: "html",
                success: function(result) {
                    if (result.success) {
                        Swal.fire("Success", response.msg, "success");
                    }
                },
            });
        });

        $(document).ready(function() {
            $(document).on('change','.select2',function(){
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
        document.addEventListener("livewire:load", function() {
            Livewire.hook('afterDomUpdate', () => {
                // Your custom logic here
                console.log('DOM updated');
            });
        });
    </script>
@endpush

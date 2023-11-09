<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header animate__animated animate__fadeInUp d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif"
                        style="animation-delay: 1.1s">
                        <h4>@lang('lang.add-stock')
                        </h4>
                    </div>
                    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div class="col-md-7 animate__animated animate__bounceInRight" style="animation-delay: 1.1s">
                            <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info')</small></p>
                        </div>
                        <div class="col-md-2 animate__animated animate__bounceInLeft" style="animation-delay: 1.1s">
                            <div class="form-group">
                                <label>
                                    {!! Form::checkbox('change_exchange_rate_to_supplier', 1, false, [
                                        'wire:model' => 'change_exchange_rate_to_supplier',
                                    ]) !!}
                                    @lang('lang.change_exchange_rate_to_supplier')
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 animate__animated animate__bounceInLeft" style="animation-delay: 1.1s">
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
                    </div>
                    {!! Form::open(['id' => 'add_stock_form', 'wire:submit.prevent' => 'validateItems']) !!}
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 1.15s">
                                    {!! Form::label('store_id', __('lang.store') . '*', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">

                                        {!! Form::select('store_id', $stores, $store_id, [
                                            'class' => ' form-control select2',
                                            'data-name' => 'store_id',
                                            'data-live-search' => 'true',
                                            'required',
                                            'placeholder' => __('lang.please_select'),
                                            'wire:model' => 'store_id',
                                        ]) !!}
                                    </div>
                                    @error('store_id')
                                        <span style="font-size: 10px;font-weight: 700;"
                                            class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 1.2s">
                                    {!! Form::label('supplier_id', __('lang.supplier') . '*', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">
                                        {!! Form::select('supplier_id', $suppliers, $supplier, [
                                            'class' => 'form-control select2',
                                            'data-live-search' => 'true',
                                            'id' => 'supplier_id',
                                            'placeholder' => __('lang.please_select'),
                                            'data-name' => 'supplier',
                                            'wire:model' => 'supplier',
                                            'wire:change' => 'changeExchangeRate()',
                                        ]) !!}
                                        <button type="button"
                                            class="add-button d-flex justify-content-center align-items-center"
                                            data-toggle="modal" data-target=".add-supplier"><i
                                                class="fas fa-plus"></i></button>
                                    </div>
                                    @error('supplier')
                                        <span style="font-size: 10px;font-weight: 700;"
                                            class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 1.25s">
                                    <label
                                        class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter"
                                        style="font-size: 12px;font-weight: 500;" for="invoice_currency">*
                                        @lang('lang.invoice_currency')</label>
                                    <div class="input-wrapper">
                                        {!! Form::select('invoice_currency', $selected_currencies, $transaction_currency, [
                                            'class' => 'form-control select2',
                                            'placeholder' => __('lang.please_select'),
                                            'data-live-search' => 'true',
                                            'required',
                                            'data-name' => 'transaction_currency',
                                            'wire:model' => 'transaction_currency',
                                        ]) !!}
                                    </div>
                                    @error('transaction_currency')
                                        <span style="font-size: 10px;font-weight: 700;"
                                            class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div
                                    class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"style="animation-delay: 1.3s">
                                    {!! Form::label('purchase_type', __('lang.purchase_type') . '*', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">

                                        {!! Form::select('purchase_type', ['import' => __('lang.import'), 'local' => __('lang.local')], $purchase_type, [
                                            'class' => 'form-control ',
                                            'required',
                                            'style' => 'width:100%;height:100%',
                                            'placeholder' => __('lang.please_select'),
                                            'data-name' => 'purchase_type',
                                            'wire:model' => 'purchase_type',
                                        ]) !!}
                                    </div>
                                    @error('purchase_type')
                                        <span style="font-size: 10px;font-weight: 700;"
                                            class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 1.35s">
                                    {!! Form::label('purchase_type', __('lang.po_no'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">
                                        {!! Form::select('purchase_type', $po_nos, null, [
                                            'class' => 'form-control select2',
                                            'data-live-search' => 'true',
                                            'placeholder' => __('lang.please_select'),
                                            'data-name' => 'po_id',
                                            'wire:model' => 'po_id',
                                        ]) !!}
                                    </div>
                                    @error('po_id')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 1.4s">
                                    {!! Form::label('divide_costs', __('lang.divide_costs'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">
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
                                    </div>
                                    @error('divide_costs')
                                        <span style="font-size: 10px;font-weight: 700;"
                                            class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 1.45s">
                                    {!! Form::label('transaction_date', __('lang.date_and_time'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}

                                    <input type="datetime-local" wire:model="transaction_date"
                                        value="{{ date('Y-m-d\TH:i') }}" class="form-control initial-balance-input m-0">
                                </div>

                                <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 1.5s">
                                    {!! Form::label('exchange_rate', __('lang.exchange_rate'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <input type="text" class="form-control initial-balance-input m-0"
                                        id="exchange_rate" name="exchange_rate" wire:model="exchange_rate"
                                        wire:change="changeExchangeRateBasedPrices()">
                                </div>

                                @if (!empty($change_exchange_rate_to_supplier))
                                    <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                        style="animation-delay: 1.55s">
                                        {!! Form::label('exchange_rate', __('lang.end_date'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                            'style' => 'font-size: 12px;font-weight: 500;',
                                        ]) !!}
                                        <input type="date" class="form-control m-0 initial-balance-input"
                                            id="end_date" name="end_date" wire:model="end_date">
                                    </div>
                                @endif

                                <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 1.6s">
                                    {!! Form::label('other_expenses', __('lang.other_expenses'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}

                                    <div class="input-wrapper">

                                        {!! Form::text('other_expenses', $other_expenses, [
                                            'class' => 'form-control m-0 initial-balance-input width-full',
                                            'placeholder' => __('lang.other_expenses'),
                                            'id' => 'other_expenses',
                                            'wire:model' => 'other_expenses',
                                            'wire:change' => 'changeTotalAmount()',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 1.65s">
                                    {!! Form::label('other_payments', __('lang.other_payments'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">

                                        {!! Form::text('other_payments', $other_payments, [
                                            'class' => 'form-control m-0 initial-balance-input width-full',
                                            'placeholder' => __('lang.other_payments'),
                                            'id' => 'other_payments',
                                            'wire:model' => 'other_payments',
                                            'wire:change' => 'changeTotalAmount()',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div class="col-md-4 animate__animated animate__bounceInRight"
                                    style="animation-delay: 1.7s">
                                    <div class="search-box input-group">
                                        <input type="search" name="search_by_product_symbol"
                                            id="search_by_product_symbol"
                                            wire:model.debounce.200ms="search_by_product_symbol"
                                            placeholder="@lang('lang.enter_product_symbol')" class="form-control" autocomplete="off">

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
                                                                    alt="{{ $product->name }}" class="img-thumbnail"
                                                                    width="100px">
                                                            @else
                                                                <img src="{{ asset('uploads/' . $settings['logo']) }}"
                                                                    alt="{{ $product->name }}" class="img-thumbnail"
                                                                    width="100px">
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
                                <div class="col-md-8 mb-3 animate__animated animate__bounceInLeft"
                                    style="animation-delay: 1.7s">
                                    <div class="search-box input-group">
                                        <button type="button" class="btn btn-secondary" id="search_button"><i
                                                class="fa fa-search"></i>
                                        </button>
                                        <input type="search" name="search_product" id="search_product"
                                            wire:model.debounce.200ms="searchProduct" placeholder="@lang('lang.enter_product_name_to_print_labels')"
                                            class="form-control" autocomplete="off">
                                        {{--                                    <button type="button" class="btn btn-success  btn-modal" --}}
                                        {{--                                            data-href="{{ route('products.create') }}?quick_add=1" --}}
                                        {{--                                            data-container=".view_modal"><i class="fa fa-plus"></i> --}}
                                        {{--                                    </button> --}}
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
                                                                    alt="{{ $product->name }}" class="img-thumbnail"
                                                                    width="100px">
                                                            @else
                                                                <img src="{{ asset('uploads/' . $settings['logo']) }}"
                                                                    alt="{{ $product->name }}" class="img-thumbnail"
                                                                    width="100px">
                                                            @endif
                                                            {{ $product->sku ?? '' }} - {{ $product->name }}
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        {{--                                    {{$search_result->links()}} --}}
                                    </div>

                                </div>
                            </div>

                            <div
                                class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div class="col-md-2 border border-1 p-0 animate__animated animate__bounceInRight"
                                    style="height: 100vh;overflow: scroll;animation-delay: 1.8s">
                                    <div class="p-3 text-center font-weight-bold " style="background-color: #eee;">
                                        الأقسام الرئيسيه
                                        <div for="" class="d-flex align-items-center text-nowrap gap-1"
                                            wire:ignore>
                                            {{-- الاقسام --}}
                                            <select class="form-control select2" data-name="department_id"
                                                wire:model="department_id">
                                                <option value="" readonly selected>اختر </option>
                                                @foreach ($departments as $depart)
                                                    @if ($depart->parent_id === null)
                                                        <option value="{{ $depart->id }}">{{ $depart->name }}
                                                        </option>
                                                        @if ($depart->subCategories->count() > 0)
                                                            @include('categories.category-select', [
                                                                'categories' => $depart->subCategories,
                                                                'prefix' => '-',
                                                            ])
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        @foreach ($products as $product)
                                            <div class="order-btn py-2 border-bottom"
                                                wire:click='add_product({{ $product->id }})'
                                                style="cursor: pointer">
                                                @if ($product->image)
                                                    <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                        alt="{{ $product->name }}" class="img-thumbnail"
                                                        width="100px">
                                                @else
                                                    <img src="{{ asset('uploads/' . $settings['logo']) }}"
                                                        alt="{{ $product->name }}" class="img-thumbnail"
                                                        width="100px">
                                                @endif
                                                <span>{{ $product->name }}</span>
                                                <span>{{ $product->sku }} </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="table-responsive col-md-10 border border-1  animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) dir-rtl @endif"
                                    style="height: 100vh;overflow: scroll;animation-delay: 1.8s">

                                    @if (!empty($items))
                                        @foreach ($items as $index => $product)
                                            @include('add-stock.partials.product_row')
                                        @endforeach

                                        <div class="d-flex justify-content-between align-items-center">

                                            <div>
                                                <span style="font-weight:700;font-size: 14px;"
                                                    class="dollar-cell">$@lang('lang.total')</span>
                                                <span style="font-weight:700;font-size: 16px;" class="dollar-cell">
                                                    {{ $this->sum_dollar_sub_total() }} </span>
                                            </div>

                                            <div>

                                                <span style="font-weight:700;font-size: 14px;">@lang('lang.total')</span>
                                                <span style="font-weight:700;font-size: 16px;">
                                                    {{ $this->sum_sub_total() }} </span>
                                            </div>

                                            <div>
                                                <span style="font-weight:700;font-size: 14px;">@lang('lang.total_size')</span>
                                                <span
                                                    style="font-weight:700;font-size: 16px;">{{ $this->sum_size() ?? 0 }}</span>
                                            </div>

                                            <div>
                                                <span
                                                    style="font-weight:700;font-size: 14px;">@lang('lang.total_weight')</span>
                                                <span
                                                    style="font-weight:700;font-size: 16px;">{{ $this->sum_weight() ?? 0 }}</span>
                                            </div>

                                            <div>
                                                <span style="font-weight:700;font-size: 14px;"
                                                    class="dollar-cell">$@lang('lang.total_cost')</span>
                                                <span style="font-weight:700;font-size: 16px;"
                                                    class="dollar-cell">{{ $this->sum_dollar_total_cost() ?? 0 }}</span>
                                            </div>

                                            <div>
                                                <span
                                                    style="font-weight:700;font-size: 14px;">@lang('lang.total_cost')</span>
                                                <span
                                                    style="font-weight:700;font-size: 16px;">{{ $this->sum_total_cost() ?? 0 }}</span>
                                            </div>
                                        </div>


                                    @endif
                                </div>
                            </div>
                            @php
                                //                            $collection = collect($items);
                                //                            // Filter out elements where show_product_data is false
                                //                            $filteredCollection = $collection->filter(function ($item) {
                                //                                return $item['show_product_data'] !== false;
                                //                            });
                                //                            // Count the remaining elements
                                //                            $count = $filteredCollection->count();
                            @endphp
                            <div class="col-md-12 text-center mt-1 d-flex justify-content-center">
                                <h4 class="mx-5">@lang('lang.items_count'):
                                    <span class="items_count_span"
                                        style="margin-right: 5px;">{{ $this->countItems() }}</span>
                                </h4>
                                <h4 class=" mx-5">
                                    @lang('lang.units_count'): <span class="items_quantity_span"
                                        style="margin-right: 5px;">{{ $this->countUnitsItems() }}</span>
                                </h4>
                                <h4 class="mx-5">
                                    @lang('lang.items_quantity'): <span class="items_quantity_span"
                                        style="margin-right: 5px;">{{ $this->total_quantity() }}</span>
                                </h4>
                                <h4 class="mx-5"> @lang('lang.total') :
                                    @if ($paying_currency == 2)
                                        {{ $this->sum_dollar_total_cost() ?? 0.0 }}
                                    @else
                                        {{ $this->sum_total_cost() ?? 0.0 }}
                                    @endif
                                    <span class="final_total_span"></span>
                                </h4>
                            </div>

                            <div
                                class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div class=" col-md-3 mb-2 d-flex align-items-center  animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 1.85s">
                                    {!! Form::label('files', __('lang.files'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="initial-balance-input my-0 mr-0">
                                        <label for="files"
                                            style="width: 100%;height: 100%;font-size: 12px;font-weight: 500;"
                                            class="d-flex justify-content-evenly align-items-center">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            {{ __('lang.upload_image') }}
                                        </label>
                                        <input style="opacity: 0;" type="file" name="files[]" id="files"
                                            wire:model="files">
                                    </div>

                                </div>

                                <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 1.9s">
                                    {!! Form::label('invoice_no', __('lang.invoice_no'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">

                                        {!! Form::text('invoice_no', $invoice_no, [
                                            'class' => 'form-control initial-balance-input m-0 width-full',
                                            'placeholder' => __('lang.invoice_no'),
                                            'wire:model' => 'invoice_no',
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 1.95s">
                                    {!! Form::label('discount_amount', __('lang.discount'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">

                                        {!! Form::text('discount_amount', $discount_amount, [
                                            'class' => 'form-control m-0 initial-balance-input width-full',
                                            'placeholder' => __('lang.discount'),
                                            'id' => 'discount_amount',
                                            'wire:model' => 'discount_amount',
                                            'wire:change' => 'changeTotalAmount()',
                                        ]) !!}
                                    </div>
                                </div>


                                <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 2s">
                                    {!! Form::label('source_type', __('lang.source_type') . '*', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">

                                        {!! Form::select('source_type', ['pos' => __('lang.pos'), 'safe' => __('lang.safe')], $source_type, [
                                            'class' => 'form-control select2',
                                            'data-live-search' => 'true',
                                            'placeholder' => __('lang.please_select'),
                                            'data-name' => 'source_type',
                                            'wire:model' => 'source_type',
                                        ]) !!}
                                    </div>
                                </div>
                                @error('source_type')
                                    <span style="font-size: 10px;font-weight: 700;"
                                        class="error text-danger">{{ $message }}</span>
                                @enderror
                                <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 2.1s">
                                    {!! Form::label('source_of_payment', __('lang.source_of_payment') . '*', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">

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
                                        <span style="font-size: 10px;font-weight: 700;"
                                            class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-2 col-md-3 d-flex align-items-center animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    style="animation-delay: 2.15">
                                    {!! Form::label('payment_status', __('lang.payment_status') . '*', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">

                                        {!! Form::select('payment_status', $payment_status_array, $payment_status, [
                                            'class' => 'form-control select2',
                                            'data-live-search' => 'true',
                                            'required',
                                            'placeholder' => __('lang.please_select'),
                                            'data-name' => 'payment_status',
                                            'wire:model' => 'payment_status',
                                        ]) !!}
                                    </div>
                                    @error('payment_status')
                                        <span style="font-size: 10px;font-weight: 700;"
                                            class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                @include('add-stock.partials.payment_form')
                                @if ($payment_status != 'paid' && isset($payment_status))
                                    @if (!empty($amount))

                                        <div
                                            class="col-md-3 mb-2 d-flex align-items-center  animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif due_amount_div">
                                            <label
                                                class="@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 width-quarter @endif"
                                                for="due_amount"
                                                style="margin-top: 25px;font-size: 12px;font-weight: 500;">@lang('lang.duePaid'):
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
                                    <div
                                        class="col-md-3 mb-2 d-flex align-items-center  animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif due_amount_div">

                                        <label
                                            class="@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 width-quarter @endif"
                                            for="due_date"
                                            style="font-size: 12px;font-weight: 500;">@lang('lang.due')</label>
                                        <input class="form-control m-0 initial-balance-input"
                                            placeholder="@lang('lang.due')" name="due_date" type="date"
                                            id="due_date" autocomplete="off" fdprocessedid="pipnea"
                                            wire:model="due_date">
                                    </div>

                                    <div
                                        class="col-md-3 mb-2 d-flex align-items-center  animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif due_fields d-none">
                                        {!! Form::label('due_date', __('lang.due_date'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                            'style' => 'font-size: 12px;font-weight: 500;',
                                        ]) !!}
                                        {!! Form::text(
                                            'due_date',
                                            !empty($transaction_payment) && !empty($transaction_payment->due_date)
                                                ? @format_date($transaction_payment->due_date)
                                                : (!empty($payment)
                                                    ? @format_date($payment->due_date)
                                                    : null),
                                            [
                                                'class' => 'form-control m-0 initial-balance-input',
                                                'placeholder' => __('lang.due_date'),
                                                'wire:model' => 'due_date',
                                            ],
                                        ) !!}
                                    </div>

                                    <div
                                        class="col-md-3 mb-2 d-flex align-items-center  animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif due_fields d-none">
                                        {!! Form::label('notify_before_days', __('lang.notify_before_days'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                            'style' => 'font-size: 12px;font-weight: 500;',
                                        ]) !!}
                                        {!! Form::text(
                                            'notify_before_days',
                                            !empty($transaction_payment) && !empty($transaction_payment->notify_before_days)
                                                ? $transaction_payment->notify_before_days
                                                : (!empty($payment)
                                                    ? $payment->notify_before_days
                                                    : null),
                                            [
                                                'class' => 'form-control m-0 initial-balance-input',
                                                'placeholder' => __('lang.notify_before_days'),
                                                'wire:model' => 'notify_before_days',
                                            ],
                                        ) !!}
                                    </div>

                                    {{--                                <div class="col-md-3 due_fields "> --}}
                                    {{--                                    <div class="form-group"> --}}
                                    {{--                                        {!! Form::label('notify_before_days', __('lang.notify_before_days') . ':', []) !!} --}}
                                    {{--                                         --}}
                                    {{--                                        {!! Form::text('notify_before_days', !empty($transaction_payment)&&!empty($transaction_payment->notify_before_days)?$transaction_payment->notify_before_days:(!empty($payment) ? $payment->notify_before_days : null), ['class' => 'form-control', 'placeholder' => __('lang.notify_before_days'), 'wire:model' => 'notify_before_days']) !!} --}}
                                    {{--                                    </div> --}}
                                    {{--                                </div> --}}
                                @endif
                                <div class="col-md-12 d-flex flex-column justify-content-start mt-2  animate__animated animate__flipInX"
                                    style="animation-delay: 2.2s">
                                    {!! Form::label('notes', __('lang.notes'), [
                                        'class' => app()->isLocale('ar')
                                            ? 'd-block text-end  mx-2 mb-0 width-quarter width-full'
                                            : 'mr-3 mb-0 width-quarter width-full',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper" style="width: 90% !important;">
                                        {!! Form::textarea(
                                            'notes',
                                            !empty($recent_stock) && !empty($recent_stock->notes) ? $recent_stock->notes : null,
                                            ['class' => 'form-control width-full initial-balance-input m-0', 'rows' => 3, 'wire:model' => 'notes'],
                                        ) !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" name="submit" id="submit-save" style="margin: 10px"
                                value="save" class="btn btn-primary pull-right btn-flat submit"
                                wire:click.prevent = "store()">@lang('lang.save')</button>

                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
</section>
<div class="view_modal no-print"></div>
<div class="row">
    <div class="col">
        @php
            $letter_header = App\Models\System::getProperty('letter_header');
        @endphp
        {{ asset('uploads/' . $letter_header) }}
        <img src="@if (!empty($letter_header)) {{ asset('uploads/' . $letter_header) }}@else{{ asset('/uploads/' . session('logo')) }} @endif"
            alt="header" id="header_invoice_img" style="width: auto; margin: auto;  max-height: 150px;">

    </div>
</div>
{{-- <!-- This will be printed --> --}}
<section class="invoice print_section print-only" id="receipt_section"> </section>
@include('suppliers.quick_add', ['quick_add' => 1])


@push('javascripts')
    <script>
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
                        Swal.fire("Success", response.msg, "success", 1000);
                    }
                },
            });
        });

        $(document).ready(function() {
            $('.select2').on('change', function(e) {
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
    </script>
@endpush

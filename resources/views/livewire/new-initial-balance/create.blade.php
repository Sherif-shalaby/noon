<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-1 mb-1">
                    <div class="card-header animate__animated animate__fadeInUp" style="animation-delay: 1.1s">

                        @if (!empty($is_raw_material))
                            <h6 class="@if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.add_stock_for_raw_material')</h6>
                        @else
                            <h6 class="@if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.add_initial_balance')</h6>
                        @endif
                    </div>
                    @php
                        $index = 0;
                    @endphp
                    <div
                        class="row mt-1 justify-content-evenly @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div class="col-md-3 animate__animated animate__bounceInLeft" style="animation-delay: 1.1s">
                            <div class="i-checks">
                                <input id="clear_all_input_form" name="clear_all_input_form" type="checkbox"
                                    @if (isset($clear_all_input_stock_form) && $clear_all_input_stock_form == '1') checked @endif class="">
                                <label for="clear_all_input_form" class="mb-0" style="font-size: 0.75rem">
                                    <strong>
                                        @lang('lang.clear_all_input_form')
                                    </strong>
                                </label>
                            </div>
                        </div>
                        {{-- ++++++++++++++++ checkbox : Toggle Customer Dropdown ++++++++++++++ --}}
                        <div div class="col-md-3 animate__animated animate__bounceInLeft" style="animation-delay: 1.1s">
                            <label class="mb-0">
                                {!! Form::checkbox('toggle_customers_dropdown', 1, false, [
                                    'wire:model' => 'toggle_customers_dropdown',
                                    'wire:change' => 'toggle_suppliers_dropdown',
                                ]) !!}
                                @lang('lang.toggle_customers_dropdown')
                            </label>
                        </div>
                    </div>
                    {{-- {!! Form::open(['id' => 'add_stock_form']) !!} --}}
                    <div class="card-body py-0">

                        <div class="d-flex justify-content-start align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="overflow-x: auto">

                            <div
                                class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                <div class=" mb-2 align-items-center animate__animated animate__bounceInLeft  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif pl-1"
                                    style="animation-delay: 1.15s;width: 75px">
                                    {!! Form::label('product_symbol', __('lang.product_symbol'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                    ]) !!}
                                    {!! Form::text('product_symbol', null, [
                                        'class' => 'form-control initial-balance-input',
                                        'style' => 'width:100%;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;',
                                        'wire:model' => 'item.0.product_symbol',
                                        'placeholder' => __('lang.product_symbol'),
                                    ]) !!}
                                    @error('item.0.product_symbol')
                                        <label class="text-danger validation-error error-msg">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class=" mb-2 align-items-center animate__animated animate__bounceInLeft  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif pl-1"
                                    style="animation-delay: 1.2s;width: 375px">
                                    {!! Form::label('name', __('lang.product_name'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                    ]) !!}
                                    {!! Form::text('name', $item[0]['name'], [
                                        'class' => app()->isLocale('ar')
                                            ? 'd-block text-end  mx-2 mb-0 form-control  required initial-balance-input'
                                            : 'mx-2 mb-0 form-control  required initial-balance-input',
                                        'style' => 'width:100%;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;',
                                        'wire:model' => 'item.0.name',
                                        'placeholder' => __('lang.product_name'),
                                        'wire:change' => 'confirmCreateProduct()',
                                    ]) !!}
                                    @error('item.0.name')
                                        <label class="text-danger validation-error error-msg">{{ $message }}</label>
                                    @enderror
                                </div>
                                @if (empty($toggle_customers_dropdown))
                                    <div class="mb-2 align-items-center animate__animated animate__bounceInLeft supplier  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif pl-1"
                                        style="animation-delay: 1.2s;min-width: 200px">
                                        {!! Form::label('supplier_id ', __('lang.supplier') . '*', [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                        ]) !!}
                                        <div class="d-flex justify-content-center align-items-center"
                                            style="background-color: #dedede;
                                            border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                            {!! Form::select('supplier_id', $suppliers, $item[0]['supplier_id'], [
                                                'id' => 'supplier_id',
                                                'class' => ' form-control select2 supplier_id',
                                                'data-name' => 'supplier_id',
                                                'required',
                                                'placeholder' => __('lang.supplier'),
                                                'wire:model' => 'item.0.supplier_id',
                                            ]) !!}
                                            <button type="button"
                                                class="add-button d-flex justify-content-center align-items-center"
                                                data-toggle="modal" data-target=".add-supplier"
                                                href="{{ route('suppliers.create') }}"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                        @error('item.0.supplier_id ')
                                            <span class="error validation-error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
                                @include('suppliers.quick_add', ['quick_add' => 1])

                                <div class="mb-2 align-items-center animate__animated animate__bounceInLeft  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif pl-1"
                                    style="animation-delay: 1.2s;width: 75px">
                                    {!! Form::label('exchange_rate', __('lang.exchange_rate'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                    ]) !!}
                                    <input type="text" class="form-control initial-balance-input p-1"
                                        id="exchange_rate" value="{{ $item[0]['exchange_rate'] }}"
                                        style="width:100%;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;"
                                        placeholder="سعر السوق({{ $exchange_rate }})" wire:model="exchange_rate"
                                        wire:change="changeExchangeRateBasedPrices()">
                                </div>
                                {{-- +++++++++++++++++++++++ "balance return request"  +++++++++++++++++++++++ --}}
                                <div class="mb-2 align-items-center animate__animated animate__bounceInLeft  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif pl-1"
                                    style="animation-delay: 1.2s;width: 100px">
                                    {!! Form::label('balance_return_request', __('lang.balance_return_request'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                    ]) !!}
                                    {!! Form::text('balance_return_request', $item[0]['balance_return_request'], [
                                        'wire:model' => 'item.0.balance_return_request',
                                        'class' => 'form-control initial-balance-input p-1',
                                        'style' => 'width:100%;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;',
                                        'placeholder' => __('lang.balance_return_request'),
                                    ]) !!}
                                </div>
                                <div class=" mb-2 animate__animated animate__bounceInLeft d-flex flex-column store  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1"
                                    style="animation-delay: 1.2s;min-width: 200px">
                                    {!! Form::label('store_id', __('lang.store') . '*', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                    ]) !!}
                                    <div class="d-flex justify-content-center align-items-center"
                                        style="background-color: #dedede;
                                         border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                        {!! Form::select('store_id', $stores, $item[0]['store_id'], [
                                            'class' => ' form-control select2 store_id',
                                            'data-name' => 'store_id',
                                            'required',
                                            'placeholder' => __('lang.store'),
                                            'wire:model' => 'item.0.store_id',
                                        ]) !!}
                                        <button type="button"
                                            class="add-button d-flex justify-content-center align-items-center"
                                            data-toggle="modal" data-target=".add-store"
                                            href="{{ route('store.create') }}"><i class="fas fa-plus"></i></button>

                                    </div>
                                    @error('item.0.store_id')
                                        <span class="error validation-error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- +++++++++++++++++ customers Dropdown +++++++++++++++++ --}}
                                @if (!empty($toggle_customers_dropdown))
                                    <div class=" mb-2 animate__animated animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1"
                                        style="animation-delay: 1.2s;width: 160px">
                                        {!! Form::label('customer_id', __('lang.customers') . '*', [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                        ]) !!}
                                        <div class="d-flex justify-content-center align-items-center"
                                            style="background-color: #dedede;
                                         border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
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
                                            <span class="error validation-error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                <div class="mb-2 align-items-center animate__animated animate__bounceInLeft  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif pl-1"
                                    style="animation-delay: 1.2s;width: 100px">
                                    <label for="invoice_currency"
                                        class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                                        style='font-weight:500;font-size:10px;color:#888'>@lang('lang.currency') *</label>
                                    <div class="d-flex justify-content-center align-items-center"
                                        style="background-color: #dedede;
                                            border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                        {!! Form::select('invoice_currency', $selected_currencies, $transaction_currency, [
                                            'class' => 'form-control select2',
                                            'placeholder' => __('lang.currency'),
                                            'data-live-search' => 'true',
                                            'required',
                                            'data-name' => 'transaction_currency',
                                            'wire:model' => 'transaction_currency',
                                        ]) !!}
                                    </div>
                                    @error('transaction_currency')
                                        <span class="error validation-error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="accordion d-flex">
                                    <div class="accordion-item d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                        style=" background-color: transparent;border:none">
                                        <h2 class="accordion-header animate__animated animate__bounceInLeft p-0 d-flex justify-content-end align-items-center"
                                            style="animation-delay: 1.2s;margin-top: 7px;">
                                            <div class="accordion-button"
                                                style="padding: 5px !important;background-color: #596fd7 !important;color: white !important;border-radius: 6px !important;cursor: pointer;justify-content: space-between;min-width: 140px;font-size: 14px;font-weight: 500"
                                                onclick="toggleProductAccordion(`balanceTax`)">
                                                <span class="balanceTax mx-2">
                                                    <i class="fas fa-arrow-left d-flex justify-content-center align-items-center"
                                                        style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                                                </span>
                                                {{ __('lang.product_tax') }}
                                            </div>
                                        </h2>
                                        <div id="balanceTax" class="accordion-content p-0"
                                            style=" display: none;width: fit-content">
                                            <div class="accordion-body d-flex flex-row p-0">
                                                {{-- +++++++++++++++++++++++ "product_tax" selectbox +++++++++++++++++++++++ --}}
                                                <div
                                                    class=" animate__animated  animate__bounceInRight mb-1 d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif px-1">
                                                    <label for="product"
                                                        class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                                                        style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.product_tax') . '*' }}</label>
                                                    <div class="d-flex justify-content-center align-items-center"
                                                        style="background-color: #dedede; border: none;
                                                        border-radius: 16px;
                                                        color: #373737;
                                                        box-shadow: 0 8px 6px -5px #bbb;
                                                        height: 30px;
                                                        flex-wrap: nowrap;">
                                                        <select id="product_tax" class="form-control select2"
                                                            wire:model="item.0.product_tax_id"
                                                            placeholder="{{ __('lang.product_tax') }}"
                                                            data-name="product_tax_id">
                                                            <option value="">{{ __('lang.product_tax') }}
                                                            </option>
                                                            @foreach ($product_taxes as $tax)
                                                                @if ($tax->status == 'active')
                                                                    <option value="{{ $tax->id }}">
                                                                        {{ $tax->name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <button type="button"
                                                            class="add-button d-flex justify-content-center align-items-center select_sub_category"
                                                            data-toggle="modal" data-target="#add_product_tax_modal"
                                                            data-select_category="2"><i
                                                                class="fas fa-plus"></i></button>
                                                    </div>
                                                </div>
                                                @include('product-tax.create', ['quick_add' => 1])

                                                <div
                                                    class=" animate__animated  animate__bounceInRight mb-1 d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif px-1">
                                                    <label for="method"
                                                        class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                                                        style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.tax_method') . '*' }}</label>
                                                    <div class="d-flex justify-content-center align-items-center"
                                                        style="background-color: #dedede; border: none;
                                                        border-radius: 16px;
                                                        color: #373737;
                                                        box-shadow: 0 8px 6px -5px #bbb;

                                                        height: 30px;
                                                        flex-wrap: nowrap;">
                                                        {!! Form::select(
                                                            'method',
                                                            ['inclusive' => __('lang.inclusive'), 'exclusive' => __('lang.exclusive')],
                                                            $item[0]['method'],
                                                            [
                                                                'id' => 'method',
                                                                'class' => ' form-control select2 method',
                                                                'data-name' => 'method',
                                                                'placeholder' => __('lang.tax_method'),
                                                                'wire:model' => 'item.0.method',
                                                            ],
                                                        ) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="file" wire:model="image" id="imageInput" style="width: 205px" />
                                    <label class="file-input__label animate__animated  animate__bounceInLeft mx-3"
                                        for="imageInput"
                                        style="width: 30px;height: 30px;margin-top: 16px;color:white !important">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div
                            class="d-flex justify-content-start align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div
                                class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div class="mb-2 mx-2 align-items-end animate__animated animate__bounceInLeft d-flex  flex-column  px-1"
                                    style="width:200px;animation-delay: 1.2s;">

                                    {!! Form::label('category', __('lang.category'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                    ]) !!}
                                    <div class="d-flex flex-row-reverse">

                                        <div class="d-flex justify-content-center align-items-center  main_category"
                                            style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;
                                        ">
                                            {!! Form::select('category_id', $categories, $item[0]['category_id'], [
                                                'class' => 'form-control select2 category_id',
                                                'placeholder' => __('lang.category'),
                                                'data-name' => 'category_id',
                                                'id' => 'categoryId',
                                                'wire:model' => 'item.0.category_id',
                                            ]) !!}
                                            <a data-href="{{ route('categories.sub_category_modal') }}"
                                                data-container=".view_modal"
                                                class=" btn-modal  text-white add-button  d-flex justify-content-center align-items-center openCategoryModal"
                                                style="cursor: pointer" data-toggle="modal"
                                                data-select_category="0"><i class="fas fa-plus"></i></a>
                                            {{--                                    @include('categories.create_modal', ['quick_add' => 1]) --}}
                                        </div>

                                        <div style="width: 20%">
                                            <button type="button" class="plus-button-x h-100"
                                                wire:click="showCategory1()"><i
                                                    class="fas {{ $show_category1 == 0 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                                            </button>
                                        </div>
                                    </div>

                                    @error('item.0.category_id')
                                        <label class="text-danger validation-error error-msg">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="mb-2 mx-2 align-items-end animate__animated animate__bounceInLeft  d-flex flex-column  px-1 {{ $show_category1 == 0 && $show_category3 == 0 && $show_category2 == 0 ? 'd-none' : '' }}"
                                    style="width:200px">

                                    {!! Form::label('subcategory', __('lang.category') . ' 1', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                    ]) !!}
                                    <div class="d-flex flex-row-reverse">
                                        <div class="d-flex justify-content-center align-items-center subcategory_id1 "
                                            style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 80%;
                                        height: 30px;
                                        flex-wrap: nowrap;
                                        ">
                                            {!! Form::select('subcategory_id1', $subcategories1, $item[0]['subcategory_id1'], [
                                                'class' => 'form-control select2 subcategory1',
                                                'data-name' => 'subcategory_id1',
                                                'placeholder' => __('lang.subcategory'),
                                                'id' => 'subcategory_id1',
                                                'wire:model' => 'item.0.subcategory_id1',
                                            ]) !!}
                                            <a data-href="{{ route('categories.sub_category_modal') }}"
                                                data-container=".view_modal"
                                                class="btn add-button text-white d-flex justify-content-center align-items-center openCategoryModal"
                                                data-toggle="modal" style="cursor: pointer"
                                                data-select_category="1"><i class="fas fa-plus"></i></a>
                                        </div>
                                        <div style="width: 20%">
                                            <button type="button" class="plus-button-x h-100"
                                                wire:click="showCategory2()"><i
                                                    class="fas {{ $show_category2 == 0 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i></button>
                                        </div>
                                    </div>
                                    @error('item.0.subcategory_id1')
                                        <label class="text-danger validation-error error-msg">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="mb-2 mx-2 align-items-end animate__animated animate__bounceInLeft d-flex  flex-column  pl-1  {{ $show_category3 == 0 && $show_category2 == 0 ? 'd-none' : '' }}"
                                    style="width:200px">
                                    {!! Form::label('subcategory', __('lang.category') . ' 2', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                    ]) !!}
                                    <div class="d-flex flex-row-reverse">
                                        <div class="d-flex justify-content-center align-items-center  subcategory2"
                                            style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 80%;
                                        height: 30px;
                                        flex-wrap: nowrap;
                                        ">

                                            {!! Form::select('subcategory_id2', $subcategories2, $item[0]['subcategory_id2'], [
                                                'class' => 'form-control select2 subcategory2',
                                                'data-name' => 'subcategory_id2',
                                                'placeholder' => __('lang.subcategory'),
                                                'id' => 'subCategoryId2',
                                                'wire:model' => 'item.0.subcategory_id2',
                                            ]) !!}
                                            <a data-href="{{ route('categories.sub_category_modal') }}"
                                                data-container=".view_modal"
                                                class="btn add-button text-white d-flex justify-content-center align-items-center openCategoryModal"
                                                data-toggle="modal" style="cursor: pointer"
                                                data-select_category="2"><i class="fas fa-plus"></i></a>
                                            {{-- <button type="button" class="btn btn-primary btn-sm ml-2  openCategoryModal"
                                        data-toggle="modal" data-target=".createSubCategoryModal"
                                        data-select_category="2"><i class="fas fa-plus"></i></button> --}}
                                        </div>
                                        <div style="width: 20%">
                                            <button type="button" class="plus-button-x h-100"
                                                wire:click="showCategory3()"><i
                                                    class="fas {{ $show_category3 == 0 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('item.0.subcategory_id2')
                                        <label class="text-danger validation-error error-msg">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="mb-2 mx-2 align-items-end animate__animated animate__bounceInLeft d-flex  flex-column  pl-1 {{ $show_category3 == 0 ? 'd-none' : '' }}"
                                    style="width:200px">
                                    {!! Form::label('subcategory', __('lang.category') . ' 3', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                    ]) !!}
                                    <div class="d-flex flex-row-reverse">
                                        <div class="d-flex justify-content-center align-items-center subcategory3 "
                                            style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;
                                        ">
                                            {!! Form::select('subcategory_id3', $subcategories3, $item[0]['subcategory_id3'], [
                                                'class' => 'form-control select2 subcategory3',
                                                'data-name' => 'subcategory_id3',
                                                'placeholder' => __('lang.subcategory'),
                                                'id' => 'subCategoryId3',
                                                'wire:model' => 'item.0.subcategory_id3',
                                            ]) !!}
                                            {{-- <button type="button" class="btn btn-primary btn-sm ml-2 openCategoryModal"
                                        data-toggle="modal" data-target=".createSubCategoryModal"
                                        data-select_category="3"><i class="fas fa-plus"></i></button> --}}
                                            <a data-href="{{ route('categories.sub_category_modal') }}"
                                                data-container=".view_modal"
                                                class="btn add-button text-white d-flex justify-content-center align-items-center openCategoryModal"
                                                style="cursor: pointer" data-toggle="modal"
                                                data-select_category="3"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                    @error('item.0.subcategory_id3')
                                        <label class="text-danger validation-error error-msg">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="animation-delay: 1.2s;">
                            <div class="d-flex justify-content-start align-items-start @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                style="overflow-x: auto">

                                @foreach ($rows as $index => $row)
                                    @include('initial-balance.partial.new_raw_unit', [
                                        'index' => $index,
                                    ])
                                @endforeach
                            </div>
                        </div>
                        @include('store.create', ['quick_add' => 1])
                        {{-- add prices --}}

                        {{-- <div class="row text-right">
                                    <div class="col">
                                        <button class="btn btn btn-primary" wire:click="addRaw()" type="button">
                                            <i class="fa fa-plus"></i> @lang('lang.add')
                                        </button>
                                    </div>
                                </div> --}}

                        {{-- <div class="row">
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

                                     </div> --}}
                        <div class="d-flex justify-content-end my-2">

                            <div class="text-center mx-1">
                                {{ $this->count_total_by_variation_stores() }}
                                @if (!empty($variationStoreSums))
                                    @foreach ($variationStoreSums as $unitName => $variant_qty)
                                        <h2 class="items_quantity_span" style="margin-right: 15px;">
                                            {{ $unitName }} : {{ __('lang.total') }} : {{ $variant_qty }} </h2>
                                    @endforeach
                                    <h2 style="margin-right: 15px;">
                                        {{ __('lang.total_stores') }} </h2>
                                @endif
                            </div>
                            <div class="d-flex mx-1">

                                @foreach ($fill_stores as $i => $store)
                                    <div class="mx-1">

                                        @if (!empty($this->count_fill_stores_unit($i)))
                                            @foreach ($this->count_fill_stores_unit($i) as $unit_name => $variant)
                                                <div class="text-center">
                                                    <h2 class="items_quantity_span" style="margin-right: 15px;">
                                                        {{ $unit_name }}: {{ $variant }} </h2>
                                                </div>
                                            @endforeach
                                        @endif
                                        <h2 class="items_quantity_span" style="margin-right: 15px;">
                                            {{ $this->getExtraFillStore($i) }}</h2>
                                    </div>
                                @endforeach
                            </div>



                            <div class=" text-center mx-1">

                                {{ $this->count_total_by_variations() }}
                                @if (!empty($variationSums))
                                    @foreach ($variationSums as $unit_name => $variant)
                                        <h2 class="items_quantity_span" style="margin-right: 15px;">
                                            {{ $unit_name }}: {{ $variant }} </h2>
                                    @endforeach
                                @endif
                                <h2 class="items_quantity_span" style="margin-right: 15px;">
                                    {{ $this->getStore() }}</h2>

                                </h4>
                            </div>
                        </div>

                        {{-- sizes --}}
                        <div class="accordion animate__animated  animate__bounceInLeft mb-2"
                            style="animation-delay: 1.2s;">
                            <div class="accordion-item d-flex flex-column"
                                style=" background-color: transparent;border:none">
                                <h2 class="accordion-header p-0 d-flex justify-content-end align-items-center">
                                    <div class="accordion-button-down"
                                        style="padding: 5px !important;background-color: #596fd7 !important;color: white !important;border-radius: 6px !important;cursor: pointer;justify-content: space-between;max-width: 190px;font-size: 14px;font-weight: 500"
                                        wire:click="showStore()">
                                        <span class="mx-2">
                                            <i class="fas {{ $show_store == 0 ? 'fa-arrow-down' : 'fa-arrow-up' }} d-flex justify-content-center align-items-center"
                                                style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                                        </span>
                                        {{ __('lang.add_to_another_store') }}
                                    </div>
                                </h2>
                                <div
                                    class="d-flex flex-column justify-content-start align-items-end   {{ $show_store == 0 ? 'd-none' : '' }}">
                                    <button type="button" class="plus-button py-2 my-1" wire:click="addStoreRow()">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    @foreach ($fill_stores as $i => $store)
                                        <div
                                            class="d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <button class="del-button btn-xl mx-1 py-2"
                                                wire:click="delete_store_raw({{ $i }})">
                                                <i class="fa fa-trash"></i>

                                            </button>
                                            <div class=" mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif px-1 extra_store_accordion"
                                                style="width: 160px">
                                                <label for="extra_store_id"
                                                    class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                                                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.store') . '*' }}</label>
                                                <div class="d-flex justify-content-center align-items-center"
                                                    style="background-color: #dedede;
                                                    border: none;
                                                border-radius: 16px;
                                                color: #373737;
                                                box-shadow: 0 8px 6px -5px #bbb;
                                                width: 100%;
                                                height: 30px;
                                                flex-wrap: nowrap;">
                                                    {!! Form::select('extra_store_id', $stores, $fill_stores[$i]['extra_store_id'], [
                                                        'class' => 'form-control select2 extra_store_id',
                                                        'data-index' => $i,
                                                        'data-name' => 'extra_store_id',
                                                        'required',
                                                        'placeholder' => __('lang.please_select'),
                                                        'wire:model' => 'fill_stores.' . $i . '.extra_store_id',
                                                        'wire:key' => 'extra_store_id_' . $i,
                                                    ]) !!}

                                                </div>
                                                {{-- @error('fill_stores.' . $i . '.extra_store_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror --}}
                                            </div>
                                            <div
                                                class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                @foreach ($fill_stores[$i]['data'] as $x => $fill)
                                                    <div
                                                        class="d-flex justify-content-start align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                                        <div class=" mb-2 d-flex   flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1"
                                                            style="width: 100px">
                                                            <label for="store_fill_id"
                                                                class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                                                                style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.fill') . '*' }}</label>
                                                            <div class="d-flex justify-content-center align-items-center"
                                                                style="background-color: #dedede;
                                                        border: none;
                                                        border-radius: 16px;
                                                        color: #373737;
                                                        box-shadow: 0 8px 6px -5px #bbb;
                                                        width: 100%;
                                                        height: 30px;
                                                        flex-wrap: nowrap;">
                                                                {!! Form::select('store_fill_id', $basic_unit_variations, $fill_stores[$i]['data'][$x]['store_fill_id'], [
                                                                    'class' => 'select2 form-select  store_fill_id',
                                                                    'data-name' => 'store_fill_id',
                                                                    'data-index' => $i,
                                                                    'data-key' => $x,
                                                                    'placeholder' => __('lang.fill'),
                                                                    'wire:model' => 'fill_stores.' . $i . '.data.' . $x . '.store_fill_id',
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                        <div class="mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1"
                                                            style="width: 75px">
                                                            {!! Form::label('quantity', __('lang.quantity'), [
                                                                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                                            ]) !!}
                                                            <input type="text"
                                                                class="form-control quantity initial-balance-input"
                                                                wire:change="count_total_by_variation_stores()"
                                                                wire:model="fill_stores.{{ $i }}.data.{{ $x }}.quantity"
                                                                style="width:100%;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;"
                                                                placeholder = "{{ __('lang.quantity') }}">
                                                            @error('fill_stores.' . $i . 'data' . $x . '.quantity')
                                                                <label
                                                                    class="text-danger validation-error error-msg">{{ $message }}</label>
                                                            @enderror

                                                        </div>

                                                        <div
                                                            class=" {{ $x != count($fill_stores[$i]['data']) - 1 ? 'd-none' : '' }} mt-1  d-flex px-1">
                                                            <button type="button" class="plus-button mx-1 py-2"
                                                                wire:click="addStoreDataRow({{ $i }})">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                            <button class="btn btn-danger mx-1 py-2"
                                                                wire:click="delete_store_data_raw({{ $i }},{{ $x }})">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach

                                </div>


                            </div>
                        </div>

                        {{-- <div class="row {{ $show_store == 0 ? 'd-none' : '' }}">
                            <div class="col-md-3 text-center">

                            </div>
                        </div> --}}

                        <div class="accordion animate__animated  animate__bounceInLeft mb-2 "
                            style="animation-delay: 1.2s;">
                            <div class="accordion-item d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                style=" background-color: transparent;border:none">
                                <h2 class="accordion-header p-0 d-flex justify-content-end align-items-center">
                                    <div class="accordion-button"
                                        style="padding: 5px !important;background-color: #596fd7 !important;color: white !important;border-radius: 6px !important;cursor: pointer;justify-content: space-between;min-width: 140px;font-size: 14px;font-weight: 500"
                                        wire:click="showDimensions()">
                                        <span class="mx-2">
                                            <i class="fas {{ $show_dimensions == 0 ? 'fa-arrow-left' : 'fa-arrow-right' }} d-flex justify-content-center align-items-center"
                                                style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                                        </span>
                                        {{ __('lang.product_dimensions') }}
                                    </div>
                                </h2>
                                <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif  dimensions {{ $show_dimensions == 0 ? 'd-none' : '' }}"
                                    style="overflow-x: auto">

                                    <div
                                        class="mb-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif px-1">
                                        <label for="basic_unit_variation_id"
                                            class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                                            style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.basic_unit_for_import_product') . '*' }}</label>
                                        <div class="input-wrapper" style="width: 100%">

                                            {!! Form::select('basic_unit_variation_id', $basic_unit_variations, $item[0]['basic_unit_variation_id'], [
                                                'id' => 'basic_unit_variation_id',
                                                'class' => ' form-control select2 basic_unit_variation_id',
                                                'data-name' => 'basic_unit_variation_id',
                                                'placeholder' => __('lang.basic_unit_for_import_product'),
                                                'wire:model' => 'item.0.basic_unit_variation_id',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div
                                        class="mb-2  animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                                        {!! Form::label('length', __('lang.length'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                        ]) !!}
                                        <input type="text" wire:model='item.0.length' wire:change='changeSize()'
                                            class='form-control initial-balance-input m-0 length'
                                            style="border:2px solid #ccc;width: 75px;font-size:12px"
                                            placeholder={{ __('lang.length') }} />

                                        @error('item.0.length')
                                            <label
                                                class="text-danger validation-error error-msg">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div
                                        class="mb-2  animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                                        {!! Form::label('width', __('lang.width'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                        ]) !!}
                                        <input type="text" wire:model='item.0.width' wire:change='changeSize()'
                                            class='form-control  initial-balance-input m-0 width'
                                            style="border:2px solid #ccc;width: 75px;font-size:12px"
                                            placeholder={{ __('lang.width') }} />

                                        @error('item.0.width')
                                            <label
                                                class="text-danger validation-error error-msg">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div
                                        class="mb-2  animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                                        {!! Form::label('height', __('lang.height'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                        ]) !!}
                                        <input type="text" wire:model='item.0.height' wire:change='changeSize()'
                                            class='form-control height initial-balance-input m-0'
                                            style="border:2px solid #ccc;width: 75px;font-size:12px"
                                            placeholder={{ __('lang.height') }} />

                                        @error('item.0.height')
                                            <label
                                                class="text-danger validation-error error-msg">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div
                                        class="mb-2  animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                                        {!! Form::label('size', __('lang.size'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                        ]) !!}
                                        <input type="text" wire:model='item.0.size'
                                            class='form-control  initial-balance-input m-0  size'
                                            style="border:2px solid #ccc;width: 75px;font-size:12px"
                                            placeholder={{ __('lang.size') }} />

                                        @error('item.0.size')
                                            <label
                                                class="text-danger validation-error error-msg">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div
                                        class="mb-2  animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                                        {!! Form::label('weight', __('lang.weight'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                        ]) !!}
                                        <input type="text" wire:model='item.0.weight'
                                            placeholder="{{ __('lang.weight') }}"
                                            class='form-control weight initial-balance-input m-0'
                                            style="border:2px solid #ccc;width: 75px;font-size:12px" />

                                        @error('item.0.weight')
                                            <label
                                                class="text-danger validation-error error-msg">{{ $message }}</label>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="accordion animate__animated  animate__bounceInLeft mb-2"
                            style="animation-delay: 1.2s;">
                            <div class="accordion-item d-flex flex-column"
                                style=" background-color: transparent;border:none">
                                <h2 class="accordion-header p-0 d-flex justify-content-end align-items-center">
                                    <div class="accordion-button-down"
                                        style="padding: 5px !important;background-color: #596fd7 !important;color: white !important;border-radius: 6px !important;cursor: pointer;justify-content: space-between;max-width: 140px;font-size: 14px;font-weight: 500"
                                        wire:click="showDiscount()">
                                        <span class="mx-2">
                                            <i class="fas {{ $show_discount == 0 ? 'fa-arrow-down' : 'fa-arrow-up' }} d-flex justify-content-center align-items-center"
                                                style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                                        </span>
                                        {{ __('lang.discount') }}
                                    </div>
                                </h2>
                                <div class="d-flex flex-column  discount {{ $show_discount == 0 ? 'd-none' : '' }}">

                                    @foreach ($prices as $key => $price)
                                        <div class="d-flex  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif  {{ $price['parent_price'] == 1 ? 'd-none' : '' }}"
                                            style="overflow-x: auto">

                                            <div
                                                class="  mb-2 animate__animated animate__bounceInLeft d-flex flex-column
                                                    @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif
                                                    pl-1">
                                                {!! Form::label('price_category', __('lang.price_category'), [
                                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                                ]) !!}
                                                <input type="text" style="width: 100px;border:2px solid #cececf;"
                                                    class="form-control initial-balance-input m-0 price_category"
                                                    name="prices.{{ $key }}.price_category"
                                                    placeholder="{{ __('lang.price_category') }}"
                                                    wire:model="prices.{{ $key }}.price_category"
                                                    maxlength="6">
                                            </div>

                                            <div class="mb-2 animate__animated animate__bounceInLeft d-flex flex-column
                                            @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1"
                                                style="width: 100px">
                                                <label for="fill_id"
                                                    class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                                                    style='font-weight:500;font-size:10px;color:#888'>{{ __('lang.fill') . '*' }}</label>
                                                <div class="d-flex justify-content-center align-items-center"
                                                    style="background-color: #dedede;
                                                border: none;
                                                    border-radius: 16px;
                                                    color: #373737;
                                                    box-shadow: 0 8px 6px -5px #bbb;
                                                    width: 100%;
                                                    height: 30px;
                                                    flex-wrap: nowrap;">
                                                    {!! Form::select('prices.' . $key . '.fill_id', $basic_unit_variations, $prices[$key]['fill_id'], [
                                                        'class' => 'select2 fill_id',
                                                        'data-name' => 'fill_id',
                                                        'data-index' => $key,
                                                        'placeholder' => __('lang.fill'),
                                                        'wire:model' => 'prices.' . $key . '.fill_id',
                                                    ]) !!}
                                                </div>
                                            </div>


                                            <div
                                                class=" mb-2 animate__animated animate__bounceInLeft d-flex flex-column
                                                    @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif
                                                    pl-1">
                                                {!! Form::label('price', __('lang.quantity'), [
                                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                                ]) !!}
                                                <input type="text" style="width: 100px;border:2px solid #cececf;"
                                                    class="form-control initial-balance-input m-0  discount_quantity"
                                                    name="prices.{{ $key }}.discount_quantity"
                                                    wire:model="prices.{{ $key }}.discount_quantity"
                                                    wire:change="changePrice({{ $key }}, 'quantity')"
                                                    placeholder = "{{ __('lang.quantity') }}">
                                                @error('prices.' . $key . '.discount_quantity')
                                                    <label
                                                        class="text-danger validation-error error-msg">{{ $message }}</label>
                                                @enderror
                                            </div>



                                            <div
                                                class=" mb-2 animate__animated animate__bounceInLeft d-flex flex-column
                                                            @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif
                                                            pl-1">
                                                {!! Form::label('b_qty', __('lang.b_qty'), [
                                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                                ]) !!}
                                                <input type="text"
                                                    class="form-control initial-balance-input m-0 bonus_quantity"
                                                    wire:model="prices.{{ $key }}.bonus_quantity"
                                                    name="prices.{{ $key }}.bonus_quantity"
                                                    style="width: 100px;border:2px solid #cececf;"
                                                    wire:change="changePrice({{ $key }}, 'quantity')"
                                                    placeholder = "{{ __('lang.b_qty') }}">
                                                @error('prices.' . $key . '.bonus_quantity')
                                                    <label
                                                        class="text-danger validation-error error-msg">{{ $message }}</label>
                                                @enderror
                                            </div>

                                            <div class="  mb-2 animate__animated animate__bounceInLeft d-flex flex-column
                                                                @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif
                                                                pl-1"
                                                style="width: 160px">
                                                {!! Form::label('customer_type', __('lang.customer_type'), [
                                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                                ]) !!}
                                                <div class="d-flex justify-content-center align-items-center"
                                                    style="background-color: #dedede;
                                                                                border: none;
                                                                            border-radius: 16px;
                                                                            color: #373737;
                                                                            box-shadow: 0 8px 6px -5px #bbb;
                                                                            width: 100%;
                                                                            height: 30px;
                                                                            flex-wrap: nowrap;">
                                                    <select
                                                        wire:model="prices.{{ $key }}.price_customer_types"
                                                        name="prices.{{ $key }}.price_customer_types"
                                                        data-name='price_customer_types'
                                                        data-index="{{ $key }}"
                                                        data-key="{{ $key }}" class="form-control select2"
                                                        placeholder="{{ __('lang.customer_type') }}">
                                                        <option value="0">@lang('lang.please_select')</option>
                                                        @foreach ($customer_types as $type)
                                                            <option value="{{ $type->id }}">
                                                                {{ $type->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="  mb-2 animate__animated animate__bounceInLeft d-flex flex-column
                                                                    @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif
                                                                    pl-1"
                                                style="width: 160px">
                                                {!! Form::label('price_type', __('lang.type'), [
                                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                                ]) !!}
                                                <div class="d-flex justify-content-center align-items-center"
                                                    style="background-color: #dedede;
                                                                        border: none;
                                                                    border-radius: 16px;
                                                                    color: #373737;
                                                                    box-shadow: 0 8px 6px -5px #bbb;
                                                                    width: 100%;
                                                                    height: 30px;
                                                                    flex-wrap: nowrap;">
                                                    {!! Form::select(
                                                        'prices.' . $key . '.price_type',
                                                        ['fixed' => __('lang.fixed'), 'percentage' => __('lang.percentage')],
                                                        null,
                                                        [
                                                            'class' => ' form-select px-2 price_type',
                                                            'placeholder' => __('lang.type'),
                                                            'wire:model' => 'prices.' . $key . '.price_type',
                                                            'wire:change' => 'changePrice(' . $key . ')',
                                                            'style' => 'width:160px;font-size:15px;',
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
                                                        style="font-size: 10px;font-weight: 500"
                                                        for="discount_from_original_price{{ $key }}">@lang('lang.discount_from_original_price')</label>
                                                </div>
                                                {{-- @error('prices.' . $key . '.price_type')
                                                    <label class="text-danger error-msg">{{ $message }}</label>
                                                @enderror --}}
                                            </div>
                                            <div
                                                class=" mb-2 animate__animated animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                                                {!! Form::label(
                                                    'price',
                                                    isset($price['price_type']) && $price['price_type'] == 'fixed' ? __('lang.amount') : __('lang.percent'),
                                                    [
                                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                                    ],
                                                ) !!}
                                                <input type="text" name="prices.{{ $key }}.dinar_price"
                                                    style="width: 100px"
                                                    class="form-control initial-balance-input m-0 price"
                                                    wire:model="prices.{{ $key }}.dinar_price"
                                                    wire:change="changePrice({{ $key }})"
                                                    placeholder = "{{ isset($price['price_type']) && $price['price_type'] == 'fixed' ? __('lang.amount') : __('lang.percent') }}"
                                                    @if (empty($prices[$key]['price_type'])) readonly @endif>
                                                <p class="dollar-cell d-flex flex-row-reverse {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }}"
                                                    style="font-weight:500;font-size:10px;">
                                                    <span>
                                                        {{ $price['price_type'] == 'fixed' ? __('lang.amount') : __('lang.percent') . ' $' }}
                                                    </span>
                                                    :
                                                    <span>
                                                        {{ $this->prices[$key]['price'] ?? '' }}
                                                    </span>
                                                </p>
                                            </div>

                                            <div
                                                class=" mb-2 animate__animated animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                                                {!! Form::label('', __('lang.price'), [
                                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                                ]) !!}
                                                <input type="text"
                                                    name="prices.{{ $key }}.dinar_price_after_desc"
                                                    style="width: 100px;border:2px solid #cececf;"
                                                    class="form-control initial-balance-input m-0 price"
                                                    wire:model="prices.{{ $key }}.dinar_price_after_desc"
                                                    placeholder = "{{ __('lang.price') }}">
                                                <p class="dollar-cell d-flex flex-row-reverse {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }}"
                                                    style="font-weight:500;font-size:10px;">
                                                    <span>
                                                        {{ __('lang.price') . ' $' }}
                                                    </span>
                                                    :
                                                    <span>
                                                        {{ $this->prices[$key]['price_after_desc'] ?? '' }}
                                                    </span>
                                                </p>
                                            </div>

                                            <div
                                                class=" mb-2 animate__animated animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                                                {!! Form::label('total_price', __('lang.total_price'), [
                                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                                ]) !!}
                                                <input type="text"
                                                    name="prices.{{ $key }}.dinar_total_price"
                                                    style="width: 100px;border:2px solid #cececf;"
                                                    class="form-control initial-balance-input m-0 total_price"
                                                    wire:model="prices.{{ $key }}.dinar_total_price"
                                                    placeholder = "{{ __('lang.total_price') }}">
                                                <p class="dollar-cell d-flex flex-row-reverse {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }}"
                                                    style="font-weight:500;font-size:10px;">
                                                    <span>
                                                        {{ __('lang.total_price') . ' $' }}
                                                    </span>
                                                    :
                                                    <span>
                                                        {{ $this->prices[$key]['total_price'] ?? '' }}
                                                    </span>
                                                </p>
                                            </div>

                                            <div
                                                class=" mb-2 animate__animated animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                                                {!! Form::label('piece_price', __('lang.piece_price'), [
                                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                                ]) !!}
                                                <input type="text"
                                                    name="prices.{{ $key }}.dinar_piece_price"
                                                    style="width: 100px;border:2px solid #cececf;"
                                                    class="form-control initial-balance-input m-0 piece_price"
                                                    wire:model="prices.{{ $key }}.dinar_piece_price"
                                                    placeholder = "{{ __('lang.piece_price') }}">
                                                <p class="dollar-cell d-flex flex-row-reverse {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }}"
                                                    style="font-weight:500;font-size:10px;">
                                                    <span>
                                                        {{ __('lang.piece_price') . ' $' }}
                                                    </span>
                                                    :
                                                    <span>
                                                        {{ $this->prices[$key]['piece_price'] ?? '' }}
                                                    </span>
                                                </p>
                                            </div>

                                            <div class=" mb-4 animate__animated animate__bounceInLeft d-flex flex-row justify-content-center  align-items-center pl-1"
                                                style="width: fit-content">
                                                <button type="button" class="btn btn-sm mx-1 btn-primary"
                                                    wire:click="addPriceRow()">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                @if ($key > 0)
                                                    <button class="btn btn-sm mx-1 btn-danger"
                                                        wire:click="delete_price_raw({{ $key }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>


                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input"
                                                    name="prices.{{ $key }}.apply_on_all_customers"
                                                    id="apply_on_all_customers{{ $key }}"
                                                    style="font-size: 0.75rem"
                                                    wire:model="prices.{{ $key }}.apply_on_all_customers"
                                                    wire:change="applyOnAllCustomers({{ $key }})">

                                                <label class="custom-control-label"
                                                    for="apply_on_all_customers{{ $key }}">@lang('lang.apply_on_all_customers')</label>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>



                    </div>

                    {{-- {!! Form::close() !!} --}}
                    <div class="col-sm-12 d-flex">
                        <button type="submit" name="submit" id="submit-save" style="margin: 10px" value="save"
                            class="btn btn-primary pull-right mt-0 btn-flat submit"
                            wire:click.prevent="store()">@lang('lang.save')</button>
                    </div>
                    {{-- <div class="row"> --}}

                    {{-- </div> --}}
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
        document.addEventListener('componentRefreshed', function() {
            // Execute your JavaScript code here after Livewire component refreshes
            const value = localStorage.getItem("showHideDollar");

            var dollarCells = document.getElementsByClassName('dollar-cell');

            for (var i = 0; i < dollarCells.length; i++) {
                if (value === "hide") {
                    dollarCells[i].classList.add('showHideDollarCells')
                }
            }
        });
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
                console.log(select2.select2("val"))
                console.log(index)
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
                icon: 'primary',
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

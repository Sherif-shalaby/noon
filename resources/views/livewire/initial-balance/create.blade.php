<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    {{--  --}}
                    <div class="card-header">
                        @if (!empty($is_raw_material))
                            <h4 class="@if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.add_stock_for_raw_material')</h4>
                        @else
                            <h4 class="@if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.add_initial_balance')</h4>
                        @endif
                    </div>
                    @php
                        $index = 0;
                    @endphp
                    <div class="row mt-2">
                        <div class="col-md-9">
                            <p class="italic mb-0 pl-3"><small>@lang('lang.required_fields_info')</small></p>
                        </div>
                        <div class="col-md-3">
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
                    {{-- {!! Form::open(['id' => 'add_stock_form']) !!} --}}
                    <div class="card-body py-0">
                        {{-- <div class="col-md-12"> --}}
                        <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                            <div
                                class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('store_id', __('lang.store') . '*', [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : ' mx-2 mb-0 h5 width-quarter',
                                ]) !!}
                                <div class="d-flex justify-content-center align-items-center"
                                    style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 60%;
                                        margin: auto;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                    {!! Form::select('store_id', $stores, $item[0]['store_id'], [
                                        'class' => ' form-control select2 store_id',
                                        'data-name' => 'store_id',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'wire:model' => 'item.0.store_id',
                                    ]) !!}
                                    <button type="button" class="add-button" data-toggle="modal"
                                        data-target=".add-store" href="{{ route('store.create') }}"><i
                                            class="fas fa-plus"></i></button>
                                    @include('store.create', ['quick_add' => 1])
                                </div>
                                @error('item.0.store_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div
                                class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('supplier_id ', __('lang.supplier') . '*', [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : 'h5  mx-2 mb-0 width-quarter',
                                ]) !!}
                                <div class="d-flex justify-content-center align-items-center"
                                    style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 60%;
                                        margin: auto;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                    {!! Form::select('supplier_id', $suppliers, $item[0]['supplier_id'], [
                                        'id' => 'supplier_id',
                                        'class' => ' form-control select2 supplier_id',
                                        'data-name' => 'supplier_id',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'wire:model' => 'item.0.supplier_id',
                                    ]) !!}
                                    <button type="button"class="add-button" data-toggle="modal"
                                        data-target=".add-supplier" href="{{ route('suppliers.create') }}"><i
                                            class="fas fa-plus"></i></button>
                                    @include('suppliers.quick_add', ['quick_add' => 1])
                                </div>
                                @error('item.0.supplier_id ')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div
                                class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('name', __('lang.product_name'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : 'h5  mx-2 mb-0 width-quarter',
                                ]) !!}
                                {!! Form::text('name', $item[0]['name'], [
                                    'class' => 'form-control required initial-balance-input my-0',
                                    'wire:model' => 'item.0.name',
                                    'wire:change' => 'confirmCreateProduct()',
                                ]) !!}
                                @error('item.0.name')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            {{-- <div class="col-md-3">
                                {!! Form::label('sku', __('lang.product_code'), ['class' => 'h5']) !!}
                                {!! Form::text('sku', null, [
                                    'class' => 'form-control',
                                    'wire:model' => 'item.0.sku',
                                ]) !!}
                            </div> --}}
                            <div class="col-md-3 d-flex p-0">
                                <div
                                    class="col-md-6 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                    {!! Form::label('product_symbol', __('lang.product_symbol'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : 'h5  mx-2 mb-0 width-quarter',
                                    ]) !!}
                                    {!! Form::text('product_symbol', null, [
                                        'class' => 'initial-balance-input my-0',
                                        'wire:model' => 'item.0.product_symbol',
                                    ]) !!}
                                    @error('item.0.product_symbol')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div
                                    class="col-md-6
                                d-flex mb-2 align-items-center
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label('exchange_rate', __('lang.exchange_rate') . '', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : 'h5  mx-2 mb-0 width-quarter',
                                    ]) !!}
                                    <input type="text" class="form-control  initial-balance-input my-0"
                                        id="exchange_rate" value="{{ $item[0]['exchange_rate'] }}"
                                        placeholder="سعر السوق({{ $exchange_rate }})" wire:model="exchange_rate"
                                        wire:change="changeExchangeRateBasedPrices()">
                                </div>
                            </div>


                            <div
                                class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('category', __('lang.category'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : 'h5  mx-2 mb-0 width-quarter',
                                ]) !!}
                                <div class="d-flex justify-content-center align-items-center"
                                    style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 60%;
                                        margin: auto;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                    {!! Form::select('category_id', $categories, $item[0]['category_id'], [
                                        'class' => 'form-control select2 category_id',
                                        'placeholder' => __('lang.please_select'),
                                        'data-name' => 'category_id',
                                        'id' => 'categoryId',
                                        'wire:model' => 'item.0.category_id',
                                    ]) !!}

                                    <a data-href="{{ route('categories.sub_category_modal') }}"
                                        data-container=".view_modal" style="cursor: pointer"
                                        class="add-button btn-modal openCategoryModal text-white d-flex justify-content-center align-items-center"
                                        data-toggle="modal" data-select_category="0">
                                        <i class="fas fa-plus"></i></a>
                                    {{--                                    @include('categories.create_modal', ['quick_add' => 1]) --}}
                                </div>
                                @error('item.0.category_id')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div
                                class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 1', [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : 'h5  mx-2 mb-0 width-quarter',
                                ]) !!}
                                <div class="d-flex justify-content-center align-items-center"
                                    style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 60%;
                                        margin: auto;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                    {!! Form::select('subcategory_id1', $subcategories1, null, [
                                        'class' => 'form-control select2 subcategory1',
                                        'data-name' => 'subcategory_id1',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subcategory_id1',
                                        'wire:model' => 'item.0.subcategory_id1',
                                    ]) !!}
                                    <a data-href="{{ route('categories.sub_category_modal') }}"
                                        data-container=".view_modal" style="cursor: pointer;"
                                        class="add-button btn-modal  openCategoryModal d-flex justify-content-center align-items-center text-white"
                                        data-toggle="modal" data-select_category="1"><i class="fas fa-plus"></i></a>
                                </div>
                                @error('item.0.subcategory_id1')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div
                                class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 2', [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : 'h5  mx-2 mb-0 width-quarter',
                                ]) !!}
                                <div class="d-flex justify-content-center align-items-center"
                                    style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 60%;
                                        margin: auto;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                    {!! Form::select('subcategory_id2', $subcategories2, $item[0]['subcategory_id2'], [
                                        'class' => 'form-control select2 subcategory2',
                                        'data-name' => 'subcategory_id2',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subCategoryId2',
                                        'wire:model' => 'item.0.subcategory_id2',
                                    ]) !!}
                                    <a data-href="{{ route('categories.sub_category_modal') }}"
                                        data-container=".view_modal" style="cursor: pointer;"
                                        class="add-button btn-modal  openCategoryModal d-flex justify-content-center align-items-center text-white"
                                        data-toggle="modal" data-select_category="2"><i class="fas fa-plus"></i></a>
                                    {{-- <button type="button" class="btn btn-primary btn-sm ml-2  openCategoryModal"
                                        data-toggle="modal" data-target=".createSubCategoryModal"
                                        data-select_category="2"><i class="fas fa-plus"></i></button> --}}
                                </div>
                                @error('item.0.subcategory_id2')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div
                                class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 3', [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : 'h5  mx-2 mb-0 width-quarter',
                                ]) !!}
                                <div class="d-flex justify-content-center align-items-center"
                                    style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 60%;
                                        margin: auto;
                                        height: 30px;
                                        flex-wrap: nowrap;">
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
                                        data-container=".view_modal" style="cursor: pointer;"
                                        class="add-button btn-modal  openCategoryModal d-flex justify-content-center align-items-center text-white"
                                        data-toggle="modal" data-select_category="3"><i class="fas fa-plus"></i></a>
                                </div>
                                @error('item.0.subcategory_id3')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            {{-- +++++++++++++++++++++++ "balance return request +++++++++++++++++++++++ --}}
                            <div
                                class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('balance_return_request', __('lang.balance_return_request'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : 'h5  mx-2 mb-0 width-quarter',
                                ]) !!}

                                {!! Form::text('balance_return_request', $item[0]['balance_return_request'], [
                                    'wire:model' => 'item.0.balance_return_request',
                                    'class' => 'form-control initial-balance-input m-0',
                                ]) !!}
                            </div>


                            {{-- tax accordion  --}}
                            <div class="col-md-12 my-3 p-0">
                                <div class="accordion" id="accordionPanelsStayOpenExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" style="padding: 5px 15px"
                                                type="button" wire:click="showHideTax()" data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false"
                                                aria-controls="panelsStayOpen-collapseOne">
                                                <h6>
                                                    {{ __('lang.product_tax') }}
                                                </h6>
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseOne"
                                            class="accordion-collapse collapse @if ($item[0]['show_tax']) show @endif">
                                            <div class="accordion-body d-flex">

                                                <div
                                                    class="col-md-6  mb-2 mb-lg-1 d-flex justify-content-start align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                    <label for="method"
                                                        class=" @if (app()->isLocale('ar')) d-block text-end @endif h5 mb-0"
                                                        style="width: 25%">{{ __('lang.tax_method') . '*' }}</label>
                                                    <div
                                                        style="background-color: #dedede; border: none;
                                                                border-radius: 16px;
                                                                color: #373737;
                                                                box-shadow: 0 8px 6px -5px #bbb;
                                                                width: 60%;
                                                                margin: auto;
                                                                flex-wrap: nowrap;">
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
                                                </div>
                                                {{-- +++++++++++++++++++++++ "product_tax" selectbox +++++++++++++++++++++++ --}}
                                                <div
                                                    class="col-md-6 d-flex mb-2 mb-lg-1 justify-content-start align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                    <label for="product"
                                                        class=" @if (app()->isLocale('ar')) d-block text-end @endif h5 mb-0"
                                                        style="width: 25%">{{ __('lang.product_tax') . '*' }}</label>
                                                    <div class="d-flex justify-content-center align-items-center"
                                                        style="background-color: #dedede; border: none;
                                                                border-radius: 16px;
                                                                color: #373737;
                                                                box-shadow: 0 8px 6px -5px #bbb;
                                                                width: 60%;
                                                                height: 30px;
                                                                margin: auto;
                                                                flex-wrap: nowrap;">
                                                        <select id="product_tax" class="form-control select2"
                                                            wire:model="item.0.product_tax_id"
                                                            placeholder="{{ __('lang.please_select') }}"
                                                            data-name="product_tax_id">
                                                            <option value="">{{ __('lang.please_select') }}
                                                            </option>
                                                            @foreach ($product_taxes as $tax)
                                                                @if ($tax->status == 'active')
                                                                    <option value="{{ $tax->id }}">
                                                                        {{ $tax->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="add-button" data-toggle="modal"
                                                            data-target="#add_product_tax_modal"
                                                            data-select_category="2"><i class="fas fa-plus"></i>
                                                        </button>
                                                        @include('product-tax.create', [
                                                            'quick_add' => 1,
                                                        ])

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{--                            <div class="col-md-3"> --}}
                                {{--                                {!! Form::label('status', __('lang.status') . ':*', []) !!} --}}
                                {{--                                {!! Form::select('status', --}}
                                {{--                                 ['received' =>  __('lang.received'), 'partially_received' => __('lang.partially_received')] --}}
                                {{--                                 , null, ['class' => 'form-control select2','data-name'=>'status', 'required', --}}
                                {{--                                 'placeholder' => __('lang.please_select'),'wire:model' => 'item.0.status']) !!} --}}
                                {{--                                @error('item.0.status') --}}
                                {{--                                <span class="error text-danger">{{ $message }}</span> --}}
                                {{--                                @enderror --}}
                                {{--                            </div> --}}
                            </div>

                            {{-- size accordion --}}
                            <div class="col-md-12 my-3 p-0">
                                <div class="accordion " id="accordionPanelsStayOpenExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" style="padding: 5px 15px"
                                                type="button" data-bs-toggle="collapse" wire:click="showHideSize()"
                                                data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                                aria-controls="panelsStayOpen-collapseTwo">
                                                <h6>{{ __('lang.product_dimensions') }}</h6>
                                            </button>
                                        </h2>

                                        <div id="panelsStayOpen-collapseTwo"
                                            class="accordion-collapse collapse @if ($item[0]['show_size']) show @endif">
                                            <div class="accordion-body d-flex">

                                                <div
                                                    class="col-md-3 d-flex align-items-center justify-content-between mb-2 mb-lg-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                    {!! Form::label('weight', __('lang.weight'), [
                                                        'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 h5' : 'mx-2 mb-0 h5',
                                                    ]) !!}
                                                    <input type="text" wire:model='item.0.weight'
                                                        wire:change='changeSize()'
                                                        class='form-control weight initial-balance-input m-0' />

                                                    @error('item.0.weight')
                                                        <label class="text-danger error-msg">{{ $message }}</label>
                                                    @enderror
                                                </div>

                                                <div class="col-md-1"></div>

                                                <div
                                                    class="col-md-2 d-flex align-items-center justify-content-between mb-2 mb-lg-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                    {!! Form::label('height', __('lang.height'), [
                                                        'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 h5' : 'mx-2 mb-0 h5',
                                                    ]) !!}
                                                    <input type="text" wire:model='item.0.height'
                                                        wire:change='changeSize()'
                                                        class='form-control height initial-balance-input m-0' />

                                                    @error('item.0.height')
                                                        <label class="text-danger error-msg">{{ $message }}</label>
                                                    @enderror
                                                </div>

                                                <div
                                                    class="col-md-2 d-flex align-items-center justify-content-between mb-2 mb-lg-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                    {!! Form::label('length', __('lang.length'), [
                                                        'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 h5' : 'mx-2 mb-0 h5',
                                                    ]) !!}
                                                    <input type="text" wire:model='item.0.length'
                                                        wire:change='changeSize()'
                                                        class='form-control length initial-balance-input m-0' />
                                                    <br>
                                                    @error('item.0.length')
                                                        <label class="text-danger error-msg">{{ $message }}</label>
                                                    @enderror
                                                </div>

                                                <div
                                                    class="col-md-2 d-flex align-items-center justify-content-between mb-2 mb-lg-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                    {!! Form::label('width', __('lang.width'), [
                                                        'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 h5' : 'mx-2 mb-0 h5',
                                                    ]) !!}
                                                    <input type="text" wire:model='item.0.width'
                                                        wire:change='changeSize()'
                                                        class='form-control width initial-balance-input m-0' />
                                                    <br>
                                                    @error('item.0.width')
                                                        <label class="text-danger error-msg">{{ $message }}</label>
                                                    @enderror
                                                </div>

                                                <div
                                                    class="col-md-2 d-flex align-items-center justify-content-between mb-2 mb-lg-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                    {!! Form::label('size', __('lang.size'), [
                                                        'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 h5' : 'mx-2 mb-0 h5',
                                                    ]) !!}
                                                    <input type="text" wire:model='item.0.size'
                                                        wire:change='changeSize()'
                                                        class='form-control size initial-balance-input m-0' />
                                                    <br>
                                                    @error('item.0.size')
                                                        <label class="text-danger error-msg">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
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
                            <div class="row text-right my-1">
                                <div class="col">
                                    <button class="btn btn btn-primary" wire:click="addRaw()" type="button">
                                        <i class="fa fa-plus"></i> @lang('lang.add')
                                    </button>
                                </div>
                            </div>

                            <div>

                                @foreach ($rows as $index => $row)
                                    @include('initial-balance.partial.raw_unit', [
                                        'index' => $index,
                                    ])
                                @endforeach

                                <div class="fw-bold text-center">
                                    <div class=" mx-3">

                                        <span>
                                            $@lang('lang.total')</span>
                                        {{-- @if ($showColumn) --}}
                                        <span> {{ $this->sum_dollar_tsub_total() }} </span>
                                    </div>

                                    {{-- @endif --}}
                                    <div class="mx-3">

                                        <span>
                                            @lang('lang.total')</span>
                                        <span> {{ $this->sum_sub_total() }} </span>
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-12 text-center mt-1 d-flex justify-content-evenly align-items-center">
                                <h5 class=" fw-bold">@lang('lang.items_count'):
                                    <span class="items_count_span">{{ count($rows) }}</span>
                                </h5>
                                <h5 class=" fw-bold"> @lang('lang.items_quantity'): <span
                                        class="items_quantity_span">{{ $totalQuantity }}</span>
                                </h5>
                            </div>
                        </div>
                        {{-- {!! Form::close() !!} --}}
                        <div class="col-sm-12">
                            <button type="submit" name="submit" id="submit-save" style="margin: 10px"
                                value="save" class="btn btn-primary pull-right btn-flat submit"
                                wire:click.prevent="store()">@lang('lang.save')</button>

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

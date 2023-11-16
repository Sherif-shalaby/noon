@extends('layouts.app')
@section('title', __('lang.edit_products'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.edit_products')
                    </h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ route('products.index') }}">/
                                    @lang('lang.products')</a></li>
                            <li class="breadcrumb @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.edit_products')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">

        <!-- Start row -->
        <div class=" d-flex justify-content-center">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30 p-2">
                    {!! Form::open([
                        'route' => ['products.update', $product->id],
                        'method' => 'put',
                        'enctype' => 'multipart/form-data',
                    ]) !!}
                    <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div
                            class="mb-2 col-md-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('brand', __('lang.brand'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">
                                {!! Form::select('brand_id', $brands, $product->brand_id, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('lang.please_select'),
                                    'id' => 'brand_id',
                                ]) !!}
                                <button type="button" class="add-button d-flex justify-content-center align-items-center"
                                    data-toggle="modal" data-target="#createBrandModal"><i class="fas fa-plus"></i></button>

                            </div>
                        </div>

                        <div
                            class="mb-2 col-md-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('store', __('lang.store'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">
                                @php $selected_stores=$product->stores->pluck('id'); @endphp
                                {!! Form::select('store_id[]', $stores, $selected_stores, [
                                    // 'class' => 'js-example-basic-multiple',
                                    'class' => 'form-control selectpicker',
                                    'multiple' => 'multiple',
                                    'id' => 'store_id',
                                ]) !!}
                                <button type="button" class="add-button d-flex justify-content-center align-items-center"
                                    style="z-index: 10" data-toggle="modal" data-target=".add-store"
                                    href="{{ route('store.create') }}"><i class="fas fa-plus"></i></button>

                            </div>
                        </div>

                        <div
                            class="mb-2 col-md-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('name', __('lang.product_name'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">
                                {!! Form::text('name', $product->name, [
                                    'class' => 'form-control required mater-name-input',
                                ]) !!}
                                <button class="add-button d-flex justify-content-center align-items-center" type="button"
                                    data-toggle="collapse" data-target="#translation_table_product" aria-expanded="false"
                                    aria-controls="collapseExample">
                                    <i class="fas fa-globe"></i>
                                </button>
                            </div>
                            @error('name')
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                            @include('layouts.translation_inputs', [
                                'attribute' => 'name',
                                'translations' => $product->translations,
                                'type' => 'product',
                                'open_input' => true,
                            ])
                        </div>
                        <div class="col-md-3 d-flex">
                            <div
                                class="mb-2 p-0 col-md-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('product_symbol', __('lang.product_symbol'), [
                                    'class' => app()->isLocale('ar')
                                        ? 'd-block text-end  ml-2 mr-0 mb-0 width-quarter'
                                        : 'ml-2 mr-0 mb-0 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                {!! Form::text('product_symbol', isset($product->product_symbol) ? $product->product_symbol : null, [
                                    'class' => 'form-control initial-balance-input m-auto',
                                    'required',
                                ]) !!}
                                <br>
                                @error('product_symbol')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div
                                class="mb-2 p-0 col-md-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('sku', __('lang.product_code'), [
                                    'class' => app()->isLocale('ar')
                                        ? 'd-block text-end  ml-2 mr-0 mb-0 width-quarter'
                                        : 'ml-2 mr-0 mb-0 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                {!! Form::text('product_sku', $product->sku, [
                                    'class' => 'form-control initial-balance-input m-auto',
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div
                                    class="mb-2 col-md-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label('category', __('lang.category'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">
                                        {!! Form::select('category_id', $categories, $product->category_id, [
                                            'class' => 'form-control select2 category',
                                            'placeholder' => __('lang.please_select'),
                                            'id' => 'categoryId',
                                        ]) !!}
                                        <a data-href="{{ route('categories.sub_category_modal') }}"
                                            data-container=".view_modal"
                                            class="add-button btn-modal text-white openCategoryModal d-flex justify-content-center align-items-center"
                                            style="cursor: pointer" data-toggle="modal" data-select_category="0"><i
                                                class="fas fa-plus"></i></a>
                                    </div>
                                    @error('category_id')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div
                                    class="mb-2 col-md-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label('subcategory', __('lang.subcategory') . ' 1', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">
                                        {!! Form::select('subcategory_id1', $categories, $product->subcategory_id1, [
                                            'class' => 'form-control select2 subcategory',
                                            'placeholder' => __('lang.please_select'),
                                            'id' => 'subCategoryId1',
                                        ]) !!}
                                        <a data-href="{{ route('categories.sub_category_modal') }}"
                                            data-container=".view_modal"
                                            class=" btn-modal text-white add-button openCategoryModal d-flex justify-content-center align-items-center"
                                            style="cursor: pointer" data-toggle="modal" data-select_category="1"><i
                                                class="fas fa-plus"></i></a>
                                    </div>
                                    @error('category_id')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div
                                    class="mb-2 col-md-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label('subcategory', __('lang.subcategory') . ' 2', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">
                                        {!! Form::select('subcategory_id2', $categories, $product->subcategory_id2, [
                                            'class' => 'form-control select2 subcategory2',
                                            'placeholder' => __('lang.please_select'),
                                            'id' => 'subCategoryId2',
                                        ]) !!}
                                        <a data-href="{{ route('categories.sub_category_modal') }}"
                                            data-container=".view_modal" style="cursor: pointer"
                                            class="add-button text-white btn-modal openCategoryModal d-flex justify-content-center align-items-center"
                                            data-toggle="modal" data-select_category="2"><i class="fas fa-plus"></i></a>
                                    </div>
                                    @error('subcategory_id2')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div
                                    class="mb-2 col-md-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label('subcategory', __('lang.subcategory') . ' 3', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    <div class="input-wrapper">
                                        {!! Form::select('subcategory_id3', $categories, $product->subcategory_id3, [
                                            'class' => 'form-control select2 subcategory3',
                                            'placeholder' => __('lang.please_select'),
                                            'id' => 'subCategoryId3',
                                        ]) !!}
                                        <a data-href="{{ route('categories.sub_category_modal') }}"
                                            data-container=".view_modal"
                                            class="add-button text-white btn-modal d-flex justify-content-center align-items-center openCategoryModal"
                                            style="cursor: pointer" data-toggle="modal" data-select_category="3"><i
                                                class="fas fa-plus"></i></a>
                                    </div>
                                    @error('subcategory_id3')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>

                                {{-- +++++++++++++++++++++++ "balance return request"  +++++++++++++++++++++++ --}}
                                <div
                                    class="mb-2 col-md-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label('balance_return_request', __('lang.balance_return_request'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                    ]) !!}
                                    {!! Form::text(
                                        'balance_return_request',
                                        isset($product->balance_return_request) ? $product->balance_return_request : null,
                                        [
                                            'class' => 'form-control initial-balance-input m-auto',
                                        ],
                                    ) !!}
                                </div>

                            </div>
                        </div>

                        {{-- tax accordion  --}}
                        <div class="my-3 ">
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button tax-button collapsed" style="padding: 5px 15px"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false"
                                            aria-controls="panelsStayOpen-collapseOne">
                                            <h6>
                                                {{ __('lang.product_tax') }}
                                            </h6>
                                            <span class="tax-accordion-arrow">
                                                <i class="fas fa-arrow-down" style="font-size: 0.8rem"></i>
                                            </span>
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse ">
                                        <div class="accordion-body d-flex">
                                            {{-- +++++++++++++++++++++++ "tax_method" selectbox +++++++++++++++++++++++ --}}
                                            <div
                                                class="col-md-6 mb-1 d-flex justify-content-start align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                                <label for="method"
                                                    class=" @if (app()->isLocale('ar')) d-block text-end @endif mb-0"
                                                    style="width: 25%;font-size: 12px;font-weight: 500;">{{ __('lang.tax_method') . ':*' }}</label>
                                                <div class="input-wrapper">

                                                    <select name="method" id="method" class='form-control select2'
                                                        data-live-search='true'
                                                        placeholder="{{ __('lang.please_select') }}" required>
                                                        <option value="">{{ __('lang.please_select') }}</option>
                                                        <option
                                                            {{ old('method', $product['method']) == 'inclusive' ? 'selected' : '' }}
                                                            value="inclusive">{{ __('lang.inclusive') }}</option>
                                                        <option
                                                            {{ old('method', $product['method']) == 'exclusive' ? 'selected' : '' }}
                                                            value="exclusive">{{ __('lang.exclusive') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- +++++++++++++++++++++++ "product_tax" selectbox +++++++++++++++++++++++ --}}
                                            <div
                                                class="col-md-6 mb-1 d-flex justify-content-start align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                                <label for="product_tax_id"
                                                    class=" @if (app()->isLocale('ar')) d-block text-end @endif mb-0"
                                                    style="width: 25%;font-size: 12px;font-weight: 500;">{{ __('lang.product_tax') . '*' }}</label>
                                                <div class="input-wrapper">
                                                    <select name="product_tax_id" id="product_tax"
                                                        class="form-control select2"
                                                        placeholder="{{ __('lang.please_select') }}" required>
                                                        <option value="">{{ __('lang.please_select') }}</option>
                                                        @foreach ($product_tax as $tax)
                                                            <option @if ($product_tax_id == $tax->id) selected @endif
                                                                value="{{ $tax->id }}">
                                                                {{ $tax->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button"
                                                        class="add-button d-flex justify-content-center align-items-center"
                                                        data-toggle="modal" data-target="#add_product_tax_modal"
                                                        data-select_category="2"><i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- sizes accordion --}}
                        <div class="my-3">
                            <div class="accordion " id="accordionPanelsStayOpenExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button size-button collapsed" style="padding: 5px 15px"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                            aria-controls="panelsStayOpen-collapseTwo">
                                            <h6>{{ __('lang.product_dimensions') }}</h6>
                                            <span class="size-accordion-arrow">
                                                <i class="fas fa-arrow-down" style="font-size: 0.8rem"></i>
                                            </span>
                                        </button>
                                    </h2>

                                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                                        <div
                                            class="accordion-body d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <div
                                                class="col-md-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                                {!! Form::label('height', __('lang.height'), [
                                                    'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0' : 'mx-2 mb-0',
                                                    'style' => 'font-size: 12px;font-weight: 500;',
                                                ]) !!}
                                                {!! Form::text(
                                                    'height',
                                                    isset($product->product_dimensions->height) ? $product->product_dimensions->height : 0,
                                                    [
                                                        'class' => 'form-control height initial-balance-input m-0',
                                                    ],
                                                ) !!}
                                                @error('height')
                                                    <label class="text-danger error-msg">{{ $message }}</label>
                                                @enderror
                                            </div>

                                            <div
                                                class="col-md-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                                {!! Form::label('length', __('lang.length'), [
                                                    'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0' : 'mx-2 mb-0',
                                                    'style' => 'font-size: 12px;font-weight: 500;',
                                                ]) !!}
                                                {!! Form::text(
                                                    'length',
                                                    isset($product->product_dimensions->length) ? $product->product_dimensions->length : 0,
                                                    [
                                                        'class' => 'form-control length initial-balance-input m-0',
                                                    ],
                                                ) !!}
                                                @error('length')
                                                    <label class="text-danger error-msg">{{ $message }}</label>
                                                @enderror
                                            </div>

                                            <div
                                                class="col-md-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                {!! Form::label('width', __('lang.width'), [
                                                    'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0' : 'mx-2 mb-0',
                                                    'style' => 'font-size: 12px;font-weight: 500;',
                                                ]) !!}
                                                {!! Form::text('width', isset($product->product_dimensions->width) ? $product->product_dimensions->width : 0, [
                                                    'class' => 'form-control width initial-balance-input m-0',
                                                ]) !!}
                                                @error('width')
                                                    <label class="text-danger error-msg">{{ $message }}</label>
                                                @enderror
                                            </div>

                                            <div
                                                class="col-md-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                {!! Form::label('size', __('lang.size'), [
                                                    'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0' : 'mx-2 mb-0',
                                                    'style' => 'font-size: 12px;font-weight: 500;',
                                                ]) !!}
                                                {!! Form::text('size', isset($product->product_dimensions->size) ? $product->product_dimensions->size : 0, [
                                                    'class' => 'form-control size initial-balance-input m-0',
                                                ]) !!}
                                                @error('size')
                                                    <label class="text-danger error-msg">{{ $message }}</label>
                                                @enderror
                                            </div>


                                            <div
                                                class="col-md-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                {!! Form::label('weight', __('lang.weight'), [
                                                    'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0' : 'mx-2 mb-0',
                                                    'style' => 'font-size: 12px;font-weight: 500;',
                                                ]) !!}
                                                {!! Form::text(
                                                    'weight',
                                                    isset($product->product_dimensions->weight) ? $product->product_dimensions->weight : 0,
                                                    [
                                                        'class' => 'form-control initial-balance-input m-0',
                                                    ],
                                                ) !!}
                                                <br>
                                                @error('weight')
                                                    <label class="text-danger error-msg">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div
                                                class="col-md-2 d-flex align-items-center pr-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                {!! Form::label('variation', __('lang.basic_unit_for_import_product'), [
                                                    'class' => app()->isLocale('ar') ? 'd-block text-end mb-0' : 'mx-2 mb-0',
                                                    'style' => 'font-size: 12px;font-weight: 500;',
                                                ]) !!}
                                                <div class="input-wrapper">
                                                    {!! Form::select(
                                                        'variation_id',
                                                        $basic_units,
                                                        isset($product->product_dimensions->variations->unit->id) ? $product->product_dimensions->variations->unit->id : 0,
                                                        [
                                                            'class' => 'form-control select2',
                                                            'placeholder' => __('lang.please_select'),
                                                            'id' => 'variation_id',
                                                        ],
                                                    ) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div
                            class="d-flex my-2 @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                            <button class="btn btn-primary add_unit_row" type="button">
                                <i class="fa fa-plus"></i> @lang('lang.add')
                            </button>
                        </div>
                        <div class="col-md-12 product_unit_raws ">
                            @php
                                $index = 0;
                            @endphp
                            @if (!empty($product->variations))
                                @foreach ($product->variations as $index => $variation)
                                    @include('products.product_unit_raw', [
                                        'index' => $index,
                                        'variation' => $variation,
                                    ])
                                @endforeach
                            @else
                                @include('products.product_unit_raw', ['index' => 0])
                            @endif
                            @php
                                if (count($product->variations) > 0) {
                                    $index = count($product->variations) - 1;
                                } else {
                                    $index = 0;
                                }
                            @endphp
                            <input type="hidden" id="raw_unit_index" value="{{ $index }}" />
                        </div>
                        {{-- sizes --}}

                        {{-- crop image --}}
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="container-fluid mt-3">
                                            <div class="row mx-0" style="border: 1px dashed #ddd;">
                                                <div class="pt-2 text-center">
                                                    <label style="font-size: 12px;font-weight: 500;" for="projectinput2"
                                                        class='h5'>
                                                        {{ __('lang.product_image') }}</label>
                                                </div>
                                                <div class=" d-flex justify-content-center align-items-center flex-column">
                                                    <div>
                                                        <div class="mt-3">
                                                            <div class="row">
                                                                <div>
                                                                    <div class="variants">
                                                                        <div class='file file--upload w-100'>
                                                                            <div class="file-input">
                                                                                <input type="file" name="file-input"
                                                                                    id="file-input-image"
                                                                                    class="file-input__input" />
                                                                                <label class="file-input__label"
                                                                                    for="file-input-image">
                                                                                    <i
                                                                                        class="fas fa-cloud-upload-alt"></i>&nbsp;
                                                                                    <span>{{ __('lang.upload_image') }}</span></label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="preview-image-container">
                                                        @if (!empty($product->image))
                                                            <div class="preview">
                                                                <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                                    id="image_footer" alt="">
                                                                <button type="button"
                                                                    class="btn btn-xs btn-danger delete-btn remove_image "
                                                                    data-type="image"><i style="font-size: 25px;"
                                                                        class="fa fa-trash"></i></button>
                                                                <span class="btn btn-xs btn-primary  crop-btn"
                                                                    id="crop-image-btn" data-toggle="modal"
                                                                    data-target="#imageModal"><i style="font-size: 25px;"
                                                                        class="fas fa-crop"></i></span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="cropped_images"></div>
                        {{-- crop image --}}

                        {{-- product description --}}
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="container-fluid">
                                        <div class="form-group">
                                            <label for="details" style="font-size: 12px;font-weight: 500;"
                                                class="h5  @if (app()->isLocale('ar')) text-end @else text-start @endif d-block">{{ __('lang.product_details') }}&nbsp;
                                                <button class="btn btn-primary btn-sm ml-2" type="button"
                                                    data-toggle="collapse" data-target="#translation_details_product"
                                                    aria-expanded="false" aria-controls="collapseExample">
                                                    <i class="fas fa-globe"></i>
                                                </button></label>
                                            {!! Form::textarea('details', $product->details, ['class' => 'form-control', 'id' => 'product_details']) !!}
                                            @include('layouts.translation_textarea', [
                                                'attribute' => 'details',
                                                'translations' => $product->details_translations,
                                                'type' => 'product',
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                @include('products.crop-image-modal')
            </div>
        </div>
    </div>
    </div>
    {{-- @include('store.create', ['quick_add' => $quick_add]) --}}
    @include('store.create', ['quick_add' => $quick_add])

    @include('units.create', ['quick_add' => $quick_add])
    @include('brands.create', ['quick_add' => $quick_add])
    @include('categories.create_modal', ['quick_add' => $quick_add])
    @include('product-tax.create', ['quick_add' => 1])

@endsection
@push('javascripts')
    <link rel="stylesheet" href="//fastly.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    <script src="{{ asset('js/product/product.js') }}"></script>
    <script src="{{ asset('css/crop/crop-image.js') }}"></script>
    <script>
        // edit Case
        @if (!empty($product->image) && isset($product->image))
            document.getElementById("crop-image-btn").addEventListener('click', () => {
                console.log(("#imageModal"))
                setTimeout(() => {
                    launchImageCropTool(document.getElementById("image_footer"));
                }, 500);
            });
            let deleteImageBtn = document.getElementById("deleteBtn");
            if (deleteImageBtn) {
                deleteImageBtn.getElementById("deleteBtn").addEventListener('click', () => {
                    if (window.confirm('Are you sure you want to delete this image?')) {
                        $("#preview").remove();
                    }
                });
            }
        @endif
    </script>
    <script>
        $('.tax-button').on("click", function() {
            $('#panelsStayOpen-collapseOne').toggleClass('show')
            $('.tax-accordion-arrow i').remove();
            if ($('#panelsStayOpen-collapseOne').hasClass('show')) {
                $('.tax-accordion-arrow').append(`<i class="fas fa-arrow-up" style="font-size: 0.8rem"></i>`)
            } else {
                // $('.tax-accordion-arrow').children('1').remove();
                $('.tax-accordion-arrow').append(`<i class="fas fa-arrow-down" style="font-size: 0.8rem"></i>`)
            }
        })
        $('.size-button').on("click", function() {
            $('#panelsStayOpen-collapseTwo').toggleClass('show')
            $('.size-accordion-arrow i').remove();

            if ($('#panelsStayOpen-collapseTwo').hasClass('show')) {
                $('.size-accordion-arrow').append(`<i class="fas fa-arrow-up" style="font-size: 0.8rem"></i>`)
            } else {
                $('.size-accordion-arrow').append(`<i class="fas fa-arrow-down" style="font-size: 0.8rem"></i>`)
            }
        })
    </script>
@endpush

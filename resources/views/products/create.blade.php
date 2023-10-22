@extends('layouts.app')
@section('title', __('lang.add_products'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.add_products')
                </h4>
                <div class="breadcrumb-list">
                    <ul
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif ">
                            <a style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                @lang('lang.dashboard')</a>
                        </li>
                        <li class="breadcrumb @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif ">
                            <a style="text-decoration: none;color: #596fd7" href="{{ route('products.index') }}">/
                                @lang('lang.products')</a>
                        </li>
                        <li class="breadcrumb @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                            aria-current="page">@lang('lang.add_products')</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 ">
                <div
                    class="widgetbar  d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        @lang('lang.products')
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start row -->
    <div class="d-flex justify-content-center">

        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30 p-2">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info') </small></p>
                    </div>
                    <div class="col-md-3">
                        <div class="i-checks">
                            <input id="clear_all_input_form" name="clear_all_input_form" type="checkbox"
                                @if (isset($clear_all_input_form) && $clear_all_input_form == '1') checked @endif class="">
                            <label for="clear_all_input_form" style="font-size: 0.75rem">
                                <strong>
                                    @lang('lang.clear_all_input_form')
                                </strong>
                            </label>
                        </div>
                    </div>
                </div>
                {!! Form::open([
                    'route' => 'products.store',
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ]) !!}
                <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {{-- ++++++++++++++++ Brand ++++++++++++++++ --}}
                    <div
                        class=" col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('brand', __('lang.brand'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
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
                            {!! Form::select('brand_id', $brands, isset($recent_product->brand) ? $recent_product->brand->id : null, [
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
                        ]) !!}
                        <div class="d-flex justify-content-center align-items-center"
                            style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 60%;
                                        height: 30px;
                                        margin: auto;
                                        flex-wrap: nowrap;">
                            {!! Form::select('store_id[]', $stores, isset($recent_product->stores) ? $recent_product->stores : null, [
                                'class' => 'form-control selectpicker',
                                'multiple' => 'multiple',
                                'style' => 'background-color:transparent',
                                'placeholder' => __('lang.please_select'),
                                'id' => 'store_id',
                            ]) !!}
                            <button type="button" class="add-button" data-toggle="modal" data-target=".add-store"
                                href="{{ route('store.create') }}"><i class="fas fa-plus"></i></button>

                        </div>
                    </div>

                    <div
                        class="mb-2 col-md-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                        {!! Form::label('name', __('lang.product_name'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
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

                            {!! Form::text('name', isset($recent_product->name) ? $recent_product->name : null, [
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
                            'translations' => isset($recent_product->translations)
                                ? $recent_product->translations
                                : [],
                            'type' => 'product',
                        ])
                    </div>

                    <div class="col-md-3 d-flex justify-content-between">
                        <div
                            class="mb-2 p-0 col-md-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('product_symbol', __('lang.product_symbol'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            ]) !!}
                            {!! Form::text('product_symbol', null, [
                                'class' => 'form-control initial-balance-input m-auto',
                                'required',
                            ]) !!}

                            @error('product_symbol')
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                        </div>
                        <div
                            class="mb-2 p-0 col-md-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('product_sku', __('lang.product_code'), [
                                'class' => app()->isLocale('ar')
                                    ? 'd-block text-end  mr-2 ml-0 mb-0 width-quarter'
                                    : 'mr-2 ml-0 mb-0 width-quarter',
                            ]) !!}
                            {!! Form::text('product_sku', null, [
                                'class' => 'form-control initial-balance-input m-auto',
                            ]) !!}
                            @error('product_sku')
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>



                    <div class="col-md-12">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                            <div
                                class="mb-2 col-md-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('category', __('lang.category'), [
                                    'class' => app()->isLocale('ar')
                                        ? 'd-block text-end  mr-2 ml-0 mb-0 width-quarter'
                                        : 'mr-2 ml-0 mb-0 width-quarter',
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
                                    {!! Form::select(
                                        'category_id',
                                        $categories,
                                        isset($recent_product->category_id) ? $recent_product->category_id : null,
                                        [
                                            'class' => 'form-control select2 category',
                                            'placeholder' => __('lang.please_select'),
                                            'id' => 'categoryId',
                                            'required',
                                        ],
                                    ) !!}
                                    <a data-href="{{ route('categories.sub_category_modal') }}" data-container=".view_modal"
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
                                    {!! Form::select(
                                        'subcategory_id1',
                                        $subcategories,
                                        isset($recent_product->subcategory_id1) ? $recent_product->subcategory_id1 : null,
                                        [
                                            'class' => 'form-control select2 subcategory',
                                            'placeholder' => __('lang.please_select'),
                                            'id' => 'subcategory_id1',
                                        ],
                                    ) !!}
                                    <a data-href="{{ route('categories.sub_category_modal') }}" data-container=".view_modal"
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
                                    {!! Form::select(
                                        'subcategory_id2',
                                        $subcategories,
                                        isset($recent_product->subcategory_id2) ? $recent_product->subcategory_id2 : null,
                                        [
                                            'class' => 'form-control select2 subcategory2',
                                            'placeholder' => __('lang.please_select'),
                                            'id' => 'subCategoryId2',
                                        ],
                                    ) !!}
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
                                    {!! Form::select(
                                        'subcategory_id3',
                                        $subcategories,
                                        isset($recent_product->subcategory_id3) ? $recent_product->subcategory_id3 : null,
                                        [
                                            'class' => 'form-control select2 subcategory3',
                                            'placeholder' => __('lang.please_select'),
                                            'id' => 'subCategoryId3',
                                        ],
                                    ) !!}
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
                                ]) !!}
                                {!! Form::text('balance_return_request', null, [
                                    'class' => 'form-control initial-balance-input m-auto',
                                ]) !!}
                            </div>

                        </div>

                        {{-- <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.subcategory'), ['class'=>'h5 pt-3']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select(
                                        'subcategory_id[]',
                                        $categories,[],
                                        ['class' => 'js-example-basic-multiple subcategory','multiple'=>"multiple",'placeholder'=> __('lang.please_select'),'id'=>'subCategoryId']
                                    ) !!}
                                    <button type="button" class="btn btn-primary btn-sm ml-2 openCategoryModal" data-toggle="modal" data-target="#createCategoryModal" data-select_category="2"><i class="fas fa-plus"></i></button>
                                </div>
                            </div> --}}
                    </div>
                </div>

                {{-- tax accordion  --}}
                <div class="my-3 ">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button tax-button collapsed" style="padding: 5px 15px"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne"
                                    aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
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
                                            style="width: 25%">{{ __('lang.tax_method') . '*' }}</label>
                                        <div
                                            style="background-color: #dedede; border: none;
                                                    border-radius: 16px;
                                                    color: #373737;
                                                    box-shadow: 0 8px 6px -5px #bbb;
                                                    width: 60%;
                                                    height: 30px;
                                                    margin: auto;
                                                    flex-wrap: nowrap;">
                                            <select name="method" id="method" class='form-control select2'
                                                data-live-search='true' placeholder="{{ __('lang.please_select') }}">
                                                <option value="">{{ __('lang.please_select') }}</option>
                                                <option @if (isset($recent_product->method) && $recent_product->method == 'inclusive') selected @endif
                                                    value="inclusive">
                                                    {{ __('lang.inclusive') }}</option>
                                                <option @if (isset($recent_product->method) && $recent_product->method == 'exclusive') selected @endif
                                                    value="exclusive">
                                                    {{ __('lang.exclusive') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++++++++++ "product_tax" selectbox +++++++++++++++++++++++ --}}
                                    <div
                                        class="col-md-6 mb-1 d-flex justify-content-start align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                        <label for="product"
                                            class=" @if (app()->isLocale('ar')) d-block text-end @endif mb-0"
                                            style="width: 25%">{{ __('lang.product_tax') . '*' }}</label>
                                        <div class="d-flex justify-content-center align-items-center"
                                            style="background-color: #dedede; border: none;
                                                        border-radius: 16px;
                                                        color: #373737;
                                                        box-shadow: 0 8px 6px -5px #bbb;
                                                        width: 40%;
                                                        margin: auto;
                                                        height: 30px;
                                                        flex-wrap: nowrap;">
                                            <select name="product_tax_id" id="product_tax" class="form-control select2"
                                                placeholder="{{ __('lang.please_select') }}">
                                                <option value="">{{ __('lang.please_select') }}</option>
                                                @foreach ($product_tax as $tax)
                                                    @if ($tax->status == 'active')
                                                        <option value="{{ $tax->id }}">
                                                            {{ $tax->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <button type="button" class="add-button" data-toggle="modal"
                                                data-target="#add_product_tax_modal" data-select_category="2"><i
                                                    class="fas fa-plus"></i></button>
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
                                    type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo"
                                    aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
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
                                        ]) !!}
                                        {!! Form::text('height', isset($recent_product->height) ? $recent_product->height : 0, [
                                            'class' => 'form-control height initial-balance-input m-0',
                                        ]) !!}

                                        @error('height')
                                            <label class="text-danger error-msg">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div
                                        class="col-md-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        {!! Form::label('length', __('lang.length'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0' : 'mx-2 mb-0',
                                        ]) !!}
                                        {!! Form::text('length', isset($recent_product->height) ? $recent_product->length : 0, [
                                            'class' => 'form-control length initial-balance-input m-0',
                                        ]) !!}

                                        @error('length')
                                            <label class="text-danger error-msg">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div
                                        class="col-md-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        {!! Form::label('width', __('lang.width'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0' : 'mx-2 mb-0',
                                        ]) !!}
                                        {!! Form::text('width', isset($recent_product->width) ? $recent_product->width : 0, [
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
                                        ]) !!}
                                        {!! Form::text('size', isset($recent_product->size) ? $recent_product->size : 0, [
                                            'class' => 'form-control size initial-balance-input m-0',
                                        ]) !!}
                                        @error('size')
                                            <label class="text-danger error-msg">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div class="col-md-1"></div>

                                    <div
                                        class="col-md-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        {!! Form::label('weight', __('lang.weight'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0' : 'mx-2 mb-0',
                                        ]) !!}
                                        {!! Form::text('weight', isset($recent_product->weight) ? $recent_product->weight : 0, [
                                            'class' => 'form-control initial-balance-input m-0',
                                        ]) !!}

                                        @error('weight')
                                            <label class="text-danger error-msg">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    {{-- <div class="col-md-3">
                                {!! Form::label('unit', __('lang.basic_unit'), ['class'=>'h5 pt-3']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select(
                                        'unit_id',
                                        $units,null,
                                        ['class' => 'form-control select2 unit_id','placeholder'=>__('lang.please_select'),'id'=>'unitId']
                                    ) !!}
                                 <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#create">
                                    <i class="fa fa-plus"></i>
                                </button>
                                </div>
                            </div> --}}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div
                    class="d-flex my-2 @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                    <button class="btn btn-primary add_unit_row " type="button">
                        <i class="fa fa-plus"></i> @lang('lang.add')
                    </button>
                </div>

                <div class="col-md-12 product_unit_raws mx-auto" style="width: 95%">
                    @if (!empty($recent_product->variations))
                        @foreach ($recent_product->variations as $index => $variation)
                            @include('products.product_unit_raw', [
                                'index' => $index,
                                'variation' => $variation,
                            ])
                        @endforeach
                    @else
                        @include('products.product_unit_raw', ['index' => 0])
                    @endif
                    @php
                        if (!empty($recent_product->variations) && count($recent_product->variations) > 0) {
                            $index = count($recent_product->variations) - 1;
                        } else {
                            $index = 0;
                        }
                    @endphp
                    <input type="hidden" id="raw_unit_index" value="{{ $index }}" />
                </div>
                {{-- sizes --}}
                {{-- add prices --}}
                {{-- <div class="col-md-12">
                        <div class="container-fluid pt-5">
                            <div class="row ">
                                <div class="col-md-12 pt-5">
                                    <h4 class="text-primary">{{ __('lang.add_prices_for_different_users') }}</h4>
                                </div>
                                <div class="col-md-12 ">
                                    <table class="table table-bordered" id="consumption_table_price">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;">@lang('lang.type')</th>
                                                <th style="width: 10%;">@lang('lang.price_category')</th>
                                                <th style="width: 10%;">@lang('lang.price')</th>
                                                <th style="width: 10%;">@lang('lang.quantity')</th>
                                                <th style="width: 11%;">@lang('lang.b_qty')</th>
                                                <th style="width: 3%;"></th>
                                                <th style="width: 17%;">@lang('lang.price_start_date')</th>
                                                <th style="width: 17%;">@lang('lang.price_end_date')</th>
                                                <th style="width: 20%;">@lang('lang.customer_type')
                                                    <i class="dripicons-question" data-toggle="tooltip"
                                                        title="@lang('lang.discount_customer_info')"></i>
                                                </th>
                                                <th style="width: 5%;">
                                                    <button class="btn btn-xs btn-primary add_price_row" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @include('product.partial.raw_discount', ['row_id' => 0])
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="raw_price_index" id="raw_price_index" value="1">
                                </div>
                            </div>
                        </div>
                    </div> --}}
                {{-- add prices --}}

                {{-- crop image --}}
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="container-fluid mt-3">
                                    <div class="row mx-0" style="border: 1px dashed #ddd;">
                                        <div class="pt-2 text-center">
                                            <label for="projectinput2" class='h5'>
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
                                                                            for="file-input-image"
                                                                            style="background-color: #596fd7">
                                                                            <i class="fas fa-cloud-upload-alt"></i>&nbsp;
                                                                            <span>{{ __('lang.upload_image') }}</span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="preview-image-container">
                                                    @if (!empty($recent_product->image))
                                                        <div class="preview">
                                                            <img src="{{ asset('uploads/products/' . $recent_product->image) }}"
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
                </div>
                <div id="cropped_images"></div>
                {{-- crop image --}}

                {{-- product description --}}
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="container-fluid">
                                <div class="form-group">
                                    <label for="details"
                                        class="h5  @if (app()->isLocale('ar')) text-end @else text-start @endif d-block">{{ __('lang.product_details') }}&nbsp;
                                        <button class="btn btn-primary btn-sm ml-2" type="button" data-toggle="collapse"
                                            data-target="#translation_details_product" aria-expanded="false"
                                            aria-controls="collapseExample">
                                            <i class="fas fa-globe"></i>
                                        </button></label>

                                    {!! Form::textarea('details', isset($recent_product->details) ? $recent_product->details : null, [
                                        'class' => 'form-control',
                                        'id' => 'product_details',
                                    ]) !!}
                                    @include('layouts.translation_textarea', [
                                        'attribute' => 'details',
                                        'translations' => !empty($recent_product)
                                            ? $recent_product->details_translations
                                            : [],
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
    <div class="view_modal no-print"></div>
    @include('store.create', ['quick_add' => $quick_add])
    @include('units.create', ['quick_add' => $quick_add])
    @include('brands.create', ['quick_add' => $quick_add])
    @include('categories.create_modal', ['quick_add' => 1])
    @include('product-tax.create', ['quick_add' => 1])
@endsection
@push('javascripts')
    <link rel="stylesheet" href="//fastly.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    <script src="{{ asset('js/product/product.js') }}"></script>
    <script src="{{ asset('css/crop/crop-image.js') }}"></script>
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

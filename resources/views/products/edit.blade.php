@extends('layouts.app')
@section('title', __('lang.edit_products'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <style>
        .accordion-item {
            background-color: transparent
        }

        .accordion-button {
            padding: 8px !important;
            /* width: fit-content !important; */
            background-color: #596fd7 !important;
            color: white !important;
            border-radius: 6px !important;
            cursor: pointer;
            justify-content: space-between
        }

        .accordion-content {
            display: none;
            width: fit-content
        }

        .initial-balance-input {
            width: 100%
        }

        .select2-container {
            width: 100% !important
        }

        .select2-selection__rendered {
            font-size: 12px;
            font-weight: 500;
        }

        .preview {
            position: relative !important;
            width: 60px !important;
            height: 60px !important;
            padding: 2px !important;
            box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2) !important;
            margin: 0 10px !important;
            border: 1px solid #ddd !important;
        }

        .delete-btn {
            position: absolute;
            top: 39px !important;
            right: 4px !important;
            border: none;
            cursor: pointer;
            color: #dc3545;
            background-color: white !important;
            width: 15px;
            height: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .delete-btn i {
            font-size: 10px !important;
        }

        .crop-btn {
            position: absolute;
            top: 39px !important;
            left: 4px !important;
            border: none;
            cursor: pointer;
            color: #596fd7;
            background-color: white !important;
            width: 15px;
            height: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .crop-btn i {
            font-size: 10px !important;
        }

        .table-scroll-wrapper {
            width: fit-content;
        }

        .form-select {
            height: 100%;
            padding-bottom: 0;
            padding-top: 0;
            background-color: #dedede !important;
            border-radius: 16px;
            border: 2px solid #cececf;
            font-size: 14px;
            font-weight: 500
        }

        .form-select:focus {
            border-color: #cececf !important;
            outline: 0;
            box-shadow: 0 0 0 0 !important;
            background-color: white !important;
        }

        .store-drop-down .dropdown-menu {
            left: -50px !important
        }
    </style>
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.edit_products')</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ route('products.index') }}">/
                                    @lang('lang.products')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
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
        <div class="row d-flex justify-content-center">
            <!-- Start col -->

            <div class="card m-b-30 p-2">
                {!! Form::open([
                    'route' => ['products.update', $product->id],
                    'method' => 'put',
                    'enctype' => 'multipart/form-data',
                    'id' => 'edit_product_form',
                ]) !!}
                <div class="d-flex justify-content-start align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                    style="margin-top: -5px; position: relative;z-index:999 ;">
                    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div class=" mb-2 animate__animated animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mx-1"
                            style="width: 160px;">
                            {{-- {!! Form::label('store', __('lang.store'), ['class' => 'h5 pt-3']) !!} --}}
                            <div class="d-flex justify-content-center align-items-center"
                                style="background-color: #dedede;
                                            border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 160px;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                @php $selected_stores=$product->stores->pluck('id'); @endphp
                                {!! Form::select('store_id[]', $stores, $selected_stores, [
                                    'class' => 'form-control selectpicker store-drop-down',
                                    'multiple' => 'multiple',
                                    'id' => 'store_id',
                                    'placeholder' => __('lang.store'),
                                ]) !!}
                                <button type="button" class="add-button d-flex justify-content-center align-items-center"
                                    data-toggle="modal" data-target=".add-store" href="{{ route('store.create') }}"><i
                                        class="fas fa-plus"></i></button>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-start align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                    style="overflow-x: auto;">
                    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                        <div class=" mb-2 animate__animated animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mx-1"
                            style="width: 160px !important">
                            {{-- {!! Form::label('brand', __('lang.brand'), ['class' => 'h5 pt-3']) !!} --}}
                            <div class="d-flex justify-content-center align-items-center"
                                style="background-color: #dedede;
                                            border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 160px;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                {!! Form::select('brand_id', $brands, $product->brand_id, [
                                    'class' => 'form-control select2',
                                    'style' => 'width: 160px',
                                    'placeholder' => __('lang.brand'),
                                    'id' => 'brand_id',
                                ]) !!}
                                <button type="button" class="add-button d-flex justify-content-center align-items-center"
                                    data-toggle="modal" data-target="#createBrandModal"><i class="fas fa-plus"></i></button>

                            </div>
                        </div>

                        <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mx-1"
                            style="width: 370px">
                            {{-- {!! Form::label('name', __('lang.product_name'), ['class' => 'h5 pt-3']) !!} --}}
                            <div class="d-flex justify-content-center align-items-center"
                                style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 370px;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                {!! Form::text('name', $product->name, [
                                    'class' => 'form-control  initial-balance-input required',
                                    'placeholder' => __('lang.product_name'),
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

                        <div class="mb-2 animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mx-1"
                            style="width: 75px">
                            {{-- {!! Form::label('product_symbol', __('lang.product_symbol'), ['class' => 'h5 pt-3']) !!} --}}
                            {!! Form::text('product_symbol', isset($product->product_symbol) ? $product->product_symbol : null, [
                                'class' => 'form-control  initial-balance-input',
                                'style' => 'width:75px;margin:0 !important;border:2px solid #ccc',
                                'placeholder' => __('lang.product_symbol'),
                            ]) !!}

                            @error('product_symbol')
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                        </div>

                        <div
                            class="px-1 animate__animated  animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mx-1">
                            {{-- {!! Form::label('sku', __('lang.product_code'), ['class' => 'h5 pt-3']) !!} --}}
                            {!! Form::text('product_sku', $product->sku, [
                                'class' => 'form-control  initial-balance-input',
                                'style' => 'width:75px;margin:0 !important;border:2px solid #ccc',
                                'placeholder' => __('lang.product_code'),
                            ]) !!}
                        </div>

                        {{-- +++++++++++++++++++++++ "balance return request"  +++++++++++++++++++++++ --}}
                        <div
                            class="mb-2 animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif mx-1">
                            {{-- {!! Form::label('balance_return_request', __('lang.balance_return_request'), ['class' => 'h5 pt-3']) !!} --}}
                            {!! Form::text(
                                'balance_return_request',
                                isset($product->balance_return_request) ? $product->balance_return_request : null,
                                [
                                    'class' => 'form-control  initial-balance-input',
                                    'style' => 'width:75px;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;',
                                    'placeholder' => __('lang.balance_return_request'),
                                ],
                            ) !!}
                        </div>
                    </div>




                    <div class="accordion animate__animated  animate__bounceInLeft px-1">
                        <div class="accordion-item d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="border: none">
                            <h2 class="accordion-header p-0 d-flex justify-content-end align-items-center">
                                <div class="accordion-button" onclick="toggleProductAccordion(`productFilling`)">
                                    <span class="productFilling mx-2">
                                        <i class="fas fa-arrow-left d-flex justify-content-center align-items-center"
                                            style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                                    </span>
                                    {{ __('lang.fill') }}
                                </div>
                            </h2>
                            <div id="productFilling" class="accordion-content p-0">
                                <div class="accordion-body d-flex p-0">
                                    <div class="d-flex product_unit_raws[0]">
                                        @php
                                            $index = 0;
                                        @endphp

                                        @if (count($product->variations) > 0)

                                            @foreach ($product->variations as $index => $variation)
                                                <div
                                                    class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">

                                                    @if ($index == 0)
                                                        <div class="px-1 animate__animated  animate__bounceInRight d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                                            style="width: 75px">
                                                            {{-- {!! Form::label('sku', __('lang.product_code'), ['class' => 'h5 pt-3']) !!} --}}
                                                            {!! Form::text('products[0][variations][0][sku]', $variation->sku ?? null, [
                                                                'class' => 'form-control initial-balance-input',
                                                                'style' => 'width:100%;margin:0 !important;border:2px solid #ccc',
                                                                'placeholder' => __('lang.product_code'),
                                                            ]) !!}

                                                            @error('sku.0')
                                                                <label class="text-danger error-msg">{{ $message }}</label>
                                                            @enderror
                                                        </div>

                                                        <div
                                                            class="pl-1 animate__animated  animate__bounceInRight d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                                            {{-- {!! Form::label('unit', __('lang.large_filling'), ['class' => 'h5 pt-3']) !!} --}}
                                                            <div class="d-flex justify-content-center align-items-center"
                                                                style="background-color: #dedede; border: none;
                                                            border-radius: 16px;
                                                            color: #373737;
                                                            box-shadow: 0 8px 6px -5px #bbb;
                                                            width: 100%;
                                                            height: 30px;
                                                            flex-wrap: nowrap;">
                                                                <select name="products[0][variations][0][new_unit_id]"
                                                                    data-name='unit_id' data-index="0"
                                                                    class="form-control unit_select select2 unit_id0"
                                                                    style="width: 100px;" data-key="0">
                                                                    <option value="">
                                                                        {{ __('lang.large_filling') }}</option>
                                                                    @foreach ($units as $unit)
                                                                        <option
                                                                            @if (isset($variation->unit_id) && $variation->unit_id == $unit->id) selected @endif
                                                                            value="{{ $unit->id }}">
                                                                            {{ $unit->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <button type="button"
                                                                    class="add-button d-flex justify-content-center align-items-center add_unit_raw"
                                                                    data-toggle="modal" data-index="0"
                                                                    data-target=".add-unit"
                                                                    href="{{ route('units.create') }}"><i
                                                                        class="fas fa-plus"></i></button>
                                                            </div>
                                                        </div>

                                                        <button
                                                            class="btn btn-sm btn-primary animate__animated  animate__bounceInRight add_small_unit"
                                                            type="button" data-key="0">
                                                            <i class="fa fa-equals"></i>
                                                        </button>

                                                        <input type="hidden"
                                                            name="products[{{ $key ?? 0 }}][variations][{{ $index ?? 0 }}][variation_id]"
                                                            value="{{ $variation->id ?? null }}">
                                                    @else
                                                        @include('products.product_unit_raw', [
                                                            'index' => $index,
                                                            'variation' => $variation,
                                                            'key' => 0,
                                                        ])
                                                    @endif

                                                </div>
                                            @endforeach
                                        @else
                                            <div class="row">

                                                <div class="col-md-2 pl-5">
                                                    {!! Form::label('sku', __('lang.product_code'), ['class' => 'h5 pt-3']) !!}
                                                    {!! Form::text('products[0][variations][0][sku]', $variation->sku ?? null, [
                                                        'class' => 'form-control',
                                                    ]) !!}
                                                    <br>
                                                    @error('sku.0')
                                                        <label class="text-danger error-msg">{{ $message }}</label>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2">
                                                    {!! Form::label('unit', __('lang.large_filling'), ['class' => 'h5 pt-3']) !!}
                                                    <div class="d-flex justify-content-center">
                                                        <select name="products[0][variations][0][new_unit_id]"
                                                            data-name='unit_id' data-index="0"
                                                            class="form-control unit_select select2 unit_id0"
                                                            style="width: 100px;" data-key="0">
                                                            <option value="">{{ __('lang.please_select') }}
                                                            </option>
                                                            @foreach ($units as $unit)
                                                                <option @if (isset($variation->unit_id) && $variation->unit_id == $unit->id) selected @endif
                                                                    value="{{ $unit->id }}">
                                                                    {{ $unit->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm ml-2 add_unit_raw"
                                                            data-toggle="modal" data-index="0" data-target=".add-unit"
                                                            href="{{ route('units.create') }}"><i
                                                                class="fas fa-plus"></i></button>
                                                    </div>
                                                </div>

                                                <div class="col-md-2 pt-4">
                                                    <button class="btn btn btn-warning add_small_unit" type="button"
                                                        data-key="0">
                                                        <i class="fa fa-equals"></i>
                                                    </button>
                                                </div>

                                                <input type="hidden"
                                                    name="products[{{ $key ?? 0 }}][variations][{{ $index ?? 0 }}][variation_id]"
                                                    value="{{ $variation->id ?? null }}">

                                            </div>

                                        @endif

                                        @php
                                            if (count($product->variations) > 0) {
                                                $index = count($product->variations) - 1;
                                            } else {
                                                $index = 0;
                                            }
                                        @endphp

                                        <input type="hidden" id="raw_unit_index[0]" value="{{ $index }}"
                                            data-key="0" />

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>




                <div class="mb-2 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                    style="overflow-x: auto">

                    <div class="accordion animate__animated  animate__bounceInLeft">
                        <div class="accordion-item d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="border: none">
                            <h2 class="accordion-header d-flex justify-content-end align-items-center">
                                <div class="accordion-button" onclick="toggleProductAccordion(`productDimension`)">
                                    <span class="productDimension mx-2">
                                        <i class="fas fa-arrow-left d-flex justify-content-center align-items-center"
                                            style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                                    </span>
                                    {{ __('lang.product_dimensions') }}
                                </div>
                            </h2>
                        </div>
                    </div>


                    <div id='productDimension' class="accordion-content ">
                        <div class="accordion-body d-flex p-0">
                            <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                <div
                                    class="mb-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif px-1">
                                    {{-- {!! Form::label('variation', __('lang.basic_unit_for_import_product'), ['class' => 'h5 pt-3']) !!} --}}
                                    <div class="input-wrapper" style="width: 100%">
                                        {!! Form::select(
                                            'variation_id',
                                            $basic_units,
                                            isset($product->product_dimensions->variations->unit->id) ? $product->product_dimensions->variations->unit->id : 0,
                                            [
                                                'class' => 'form-control select2',
                                                'placeholder' => __('lang.basic_unit_for_import_product'),
                                                'id' => 'products[0][variation_id]',
                                            ],
                                        ) !!}
                                    </div>
                                </div>

                                <div
                                    class="mb-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif px-1">
                                    {{-- {!! Form::label('length', __('lang.length'), ['class' => 'h5 pt-3']) !!} --}}
                                    {!! Form::text(
                                        'length',
                                        isset($product->product_dimensions->length) ? $product->product_dimensions->length : 0,
                                        [
                                            'class' => 'form-control length  initial-balance-input m-0',
                                            'style' => 'border:2px solid #ccc;width: 75px',
                                            'placeholder' => __('lang.length'),
                                            'id' => 'length0',
                                            'data-key' => '0',
                                        ],
                                    ) !!}

                                    @error('length')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div
                                    class="mb-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif px-1">
                                    {{-- {!! Form::label('width', __('lang.width'), ['class' => 'h5 pt-3']) !!} --}}
                                    {!! Form::text('width', isset($product->product_dimensions->width) ? $product->product_dimensions->width : 0, [
                                        'class' => 'form-control width  initial-balance-input m-0',
                                        'style' => 'border:2px solid #ccc;width: 75px',
                                        'placeholder' => __('lang.width'),
                                        'id' => 'width0',
                                        'data-key' => '0',
                                    ]) !!}

                                    @error('width')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div
                                    class="mb-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif px-1">
                                    {{-- {!! Form::label('height', __('lang.height'), ['class' => 'h5 pt-3']) !!} --}}
                                    {!! Form::text(
                                        'height',
                                        isset($product->product_dimensions->height) ? $product->product_dimensions->height : 0,
                                        [
                                            'class' => 'form-control height  initial-balance-input m-0',
                                            'style' => 'border:2px solid #ccc;width: 75px',
                                            'placeholder' => __('lang.height'),
                                            'id' => 'height0',
                                            'data-key' => '0',
                                        ],
                                    ) !!}

                                    @error('height')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>




                                <div
                                    class="mb-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif px-1">
                                    {{-- {!! Form::label('size', __('lang.size'), ['class' => 'h5 pt-3']) !!} --}}
                                    {!! Form::text('size', isset($product->product_dimensions->size) ? $product->product_dimensions->size : 0, [
                                        'class' => 'form-control size  initial-balance-input m-0',
                                        'style' => 'border:2px solid #ccc;width: 75px',
                                        'placeholder' => __('lang.size'),
                                        'id' => 'size0',
                                        'data-key' => '0',
                                    ]) !!}

                                    @error('size')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div
                                    class="mb-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif px-1">
                                    {{-- {!! Form::label('weight', __('lang.weight'), ['class' => 'h5 pt-3']) !!} --}}
                                    {!! Form::text(
                                        'weight',
                                        isset($product->product_dimensions->weight) ? $product->product_dimensions->weight : 0,
                                        [
                                            'class' => 'form-control  initial-balance-input m-0 weight',
                                            'style' => 'border:2px solid #ccc;width: 75px',
                                            'placeholer' => __('lang.weight'),
                                        ],
                                    ) !!}

                                    @error('weight')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion animate__animated  animate__bounceInLeft px-1">
                        <div class="accordion-item d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="border: none">
                            <h2 class="accordion-header   d-flex justify-content-end align-items-center">
                                <div class="accordion-button" onclick="toggleProductAccordion(`productTax`)">
                                    <span class="productTax mx-2">
                                        <i class="fas fa-arrow-left d-flex justify-content-center align-items-center"
                                            style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                                    </span>
                                    {{ __('lang.product_tax') }}
                                </div>
                            </h2>
                        </div>
                    </div>

                    <div id="productTax" class="accordion-content">
                        <div class="accordion-body d-flex flex-row p-0">
                            {{-- +++++++++++++++++++++++ "tax_method" selectbox +++++++++++++++++++++++ --}}
                            <div
                                class=" animate__animated  animate__bounceInRight mb-1 d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                                {{-- <label for="mesthod" class="h5 pt-3">{{ __('lang.tax_method') . ':*' }}</label> --}}
                                <div
                                    style="background-color: #dedede; border: none;
                                                    border-radius: 16px;
                                                    color: #373737;
                                                    box-shadow: 0 8px 6px -5px #bbb;
                                                    width: 100%;
                                                    height: 30px;
                                                    flex-wrap: nowrap;">
                                    <select name="method" id="method" class='form-control select2'
                                        data-live-search='true' placeholder="{{ __('lang.tax_method') }}">
                                        <option value="">{{ __('lang.tax_method') }}</option>
                                        <option {{ old('method', $product['method']) == 'inclusive' ? 'selected' : '' }}
                                            value="inclusive">{{ __('lang.inclusive') }}</option>
                                        <option {{ old('method', $product['method']) == 'exclusive' ? 'selected' : '' }}
                                            value="exclusive">{{ __('lang.exclusive') }}</option>
                                    </select>
                                </div>
                            </div>
                            {{-- +++++++++++++++++++++++ "product_tax" selectbox +++++++++++++++++++++++ --}}
                            <div
                                class=" animate__animated  animate__bounceInRight mb-1 d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                                {{-- <label for="product_tax_id"
                                        class="h5 pt-3">{{ __('lang.product_tax') . ':*' }}</label> --}}
                                <div class="d-flex justify-content-center align-items-center"
                                    style="background-color: #dedede; border: none;
                                                        border-radius: 16px;
                                                        color: #373737;
                                                        box-shadow: 0 8px 6px -5px #bbb;

                                                        height: 30px;
                                                        flex-wrap: nowrap;">
                                    <select name="product_tax_id" id="product_tax" class="form-control select2"
                                        placeholder="{{ __('lang.product_tax') }}">
                                        <option value="">{{ __('lang.product_tax') }}</option>
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

                    <input type="file" name="file-input" id="file-input-image" class="file-input__input" />
                    <label class="file-input__label m-0" for="file-input-image"
                        style="width: 35px;height: 35px;color:white !important">
                        <i class="fas fa-camera"></i></label>


                    <div class="preview-image-container" tyle="display: flex !important;justify-content:center">
                        @if (!empty($product->image))
                            <div class="preview">
                                <img src="{{ asset('uploads/products/' . $product->image) }}" id="image_footer"
                                    alt="">
                                <button type="button" class="btn btn-xs btn-danger delete-btn remove_image "
                                    data-type="image"><i style="font-size: 25px;" class="fa fa-trash"></i></button>
                                <span class="btn btn-xs btn-primary  crop-btn" id="crop-image-btn" data-toggle="modal"
                                    data-target="#imageModal"><i style="font-size: 25px;" class="fas fa-crop"></i></span>
                            </div>
                        @endif
                    </div>
                    <div id="cropped_images"></div>
                </div>

                <div class="mb-2 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                    style="overflow-x: auto">
                    <div class="accordion animate__animated  animate__bounceInLeft px-1">
                        <div class="accordion-item d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="border: none">
                            <h2 class="accordion-header   d-flex justify-content-end align-items-center">
                                <div class="accordion-button" onclick="toggleProductAccordion(`productDetails`)">
                                    <span class="productDetails mx-2">
                                        <i class="fas fa-arrow-left d-flex justify-content-center align-items-center"
                                            style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                                    </span>
                                    {{ __('lang.product_details') }}
                                </div>
                            </h2>
                        </div>
                    </div>
                    <div id="productDetails" class="accordion-content">
                        <div class="accordion-body p-0">
                            <button class="btn btn-primary btn-sm ml-2" type="button" data-toggle="collapse"
                                data-target="#translation_details_product" aria-expanded="false"
                                aria-controls="collapseExample">
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

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
            </div>
            {!! Form::close() !!}
        </div>
        @include('products.crop-image-modal')
    </div>

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
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\UpdateProductRequest', '#edit_product_form') !!}
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
@endpush

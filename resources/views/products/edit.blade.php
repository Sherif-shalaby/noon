@extends('layouts.app')
@section('title', __('lang.edit_products'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.edit_products')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">@lang('lang.products')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.edit_products')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start row -->
    <div class="row d-flex justify-content-center">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30 p-2">
                {!! Form::open([
                    'route' => ['products.update', $product->id],
                    'method' => 'put',
                    'enctype' => 'multipart/form-data',
                ]) !!}
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::label('brand', __('lang.brand'), ['class' => 'h5 pt-3']) !!}
                        <div class="d-flex justify-content-center">
                            {!! Form::select('brand_id', $brands, $product->brand_id, [
                                'class' => 'form-control select2',
                                'placeholder' => __('lang.please_select'),
                                'id' => 'brand_id',
                            ]) !!}
                            <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
                                data-target="#createBrandModal"><i class="fas fa-plus"></i></button>

                        </div>
                    </div>

                    <div class="col-md-3">
                        {!! Form::label('store', __('lang.store'), ['class' => 'h5 pt-3']) !!}
                        <div class="d-flex justify-content-center">
                            @php $selected_stores=$product->stores->pluck('id'); @endphp
                            {!! Form::select('store_id[]', $stores, $selected_stores, [
                                'class' => 'form-control selectpicker ',
                                'multiple' => 'multiple',
                                'id' => 'store_id',
                            ]) !!}
                            <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
                                data-target=".add-store" href="{{ route('store.create') }}"><i
                                    class="fas fa-plus"></i></button>

                        </div>
                    </div>

                    <div class="col-md-3">
                        {!! Form::label('name', __('lang.product_name'), ['class' => 'h5 pt-3']) !!}
                        <div class="d-flex justify-content-center">
                            {!! Form::text('name', $product->name, [
                                'class' => 'form-control required',
                            ]) !!}
                            <button class="btn btn-primary btn-sm ml-2" type="button" data-toggle="collapse"
                                data-target="#translation_table_product" aria-expanded="false"
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
                    <div class="col-md-3">
                        {!! Form::label('sku', __('lang.product_code'), ['class' => 'h5 pt-3']) !!}
                        {!! Form::text('product_sku', $product->sku, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('category', __('lang.category'), ['class' => 'h5 pt-3']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('category_id', $categories, $product->category_id, [
                                        'class' => 'form-control select2 category',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'categoryId',
                                    ]) !!}
                                    <a data-href="{{ route('categories.sub_category_modal') }}" data-container=".view_modal"
                                        class="btn btn-primary text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                                        data-select_category="0"><i class="fas fa-plus"></i></a>
                                </div>
                                @error('category_id')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 1', ['class' => 'h5 pt-3']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('subcategory_id1', $categories, $product->subcategory_id1, [
                                        'class' => 'form-control select2 subcategory',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subCategoryId1',
                                    ]) !!}
                                    <a data-href="{{ route('categories.sub_category_modal') }}" data-container=".view_modal"
                                        class="btn btn-primary text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                                        data-select_category="1"><i class="fas fa-plus"></i></a>
                                </div>
                                @error('category_id')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 2', ['class' => 'h5 pt-3']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('subcategory_id2', $categories, $product->subcategory_id2, [
                                        'class' => 'form-control select2 subcategory2',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subCategoryId2',
                                    ]) !!}
                                    <a data-href="{{ route('categories.sub_category_modal') }}" data-container=".view_modal"
                                        class="btn btn-primary text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                                        data-select_category="2"><i class="fas fa-plus"></i></a>
                                </div>
                                @error('subcategory_id2')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 3', ['class' => 'h5 pt-3']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('subcategory_id3', $categories, $product->subcategory_id3, [
                                        'class' => 'form-control select2 subcategory3',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subCategoryId3',
                                    ]) !!}
                                    <a data-href="{{ route('categories.sub_category_modal') }}"
                                        data-container=".view_modal"
                                        class="btn btn-primary text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                                        data-select_category="3"><i class="fas fa-plus"></i></a>
                                </div>
                                @error('subcategory_id3')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- +++++++++++++++++++++++ "tax_method" selectbox +++++++++++++++++++++++ --}}
                    <div class="col-md-3">
                        <label for="method" class="h5 pt-3">{{ __('lang.tax_method') . ':*' }}</label>
                        <select name="method" id="method" class='form-control select2' data-live-search='true'
                            placeholder="{{ __('lang.please_select') }}" required>
                            <option value="">{{ __('lang.please_select') }}</option>
                            <option {{ old('method', $product['method']) == 'inclusive' ? 'selected' : '' }}
                                value="inclusive">{{ __('lang.inclusive') }}</option>
                            <option {{ old('method', $product['method']) == 'exclusive' ? 'selected' : '' }}
                                value="exclusive">{{ __('lang.exclusive') }}</option>
                        </select>
                    </div>
                    {{-- +++++++++++++++++++++++ "product_tax" selectbox +++++++++++++++++++++++ --}}
                    <div class="col-md-3">
                        <label for="product_tax_id" class="h5 pt-3">{{ __('lang.product_tax') . ':*' }}</label>
                        <div class="d-flex justify-content-center">
                            <select name="product_tax_id" id="product_tax" class="form-control select2"
                                placeholder="{{ __('lang.please_select') }}" required>
                                <option value="">{{ __('lang.please_select') }}</option>
                                @foreach ($product_tax as $tax)
                                    <option
                                     @if ($product_tax_id == $tax->id) selected @endif
        
                                value="{{ $tax->id }}"> {{ $tax->name }}
                                </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
                                data-target="#add_product_tax_modal" data-select_category="2"><i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    {{-- sizes --}}
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 pt-5 ">
                                <h5 class="text-primary">{{ __('lang.product_dimensions') }}</h5>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('height', __('lang.height'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('height', $product->height, [
                                    'class' => 'form-control height',
                                ]) !!}
                                <br>
                                @error('height')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>



                            <div class="col-md-3">
                                {!! Form::label('length', __('lang.length'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('length', $product->length, [
                                    'class' => 'form-control length',
                                ]) !!}
                                <br>
                                @error('length')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                {!! Form::label('width', __('lang.width'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('width', $product->width, [
                                    'class' => 'form-control width',
                                ]) !!}
                                <br>
                                @error('width')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('size', __('lang.size'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('size', $product->size, [
                                    'class' => 'form-control size',
                                ]) !!}
                                <br>
                                @error('size')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('weight', __('lang.weight'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('weight', $product->weight, [
                                    'class' => 'form-control',
                                ]) !!}
                                <br>
                                @error('weight')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 pt-5">
                        <div class="col-md-3">
                            <button class="btn btn btn-primary add_unit_row" type="button">
                                <i class="fa fa-plus"></i> @lang('lang.add')
                            </button>
                        </div>
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
                    <div class="col-md-12 pt-5">
                        <div class="row">
                            <div class="col-md-12 pt-5">
                                <div class="form-group">
                                    <div class="container-fluid mt-3">
                                        <div class="row mx-0" style="border: 1px solid #ddd;padding: 30px 0px;">
                                            <div class="col-12 p3 text-center">
                                                <label for="projectinput2" class='h5'>
                                                    {{ __('lang.product_image') }}</label>
                                            </div>
                                            <div class="col-5">
                                                <div class="mt-3">
                                                    <div class="row">
                                                        <div class="col-10 offset-1">
                                                            <div class="variants">
                                                                <div class='file file--upload w-100'>
                                                                    <div class="file-input">
                                                                        <input type="file" name="file-input"
                                                                            id="file-input-image"
                                                                            class="file-input__input" />
                                                                        <label class="file-input__label"
                                                                            for="file-input-image">
                                                                            <i class="fas fa-cloud-upload-alt"></i>&nbsp;
                                                                            <span>{{ __('lang.upload_image') }}</span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 offset-1">
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
                                        <label for="details" class="h5 pt-5">{{ __('lang.product_details') }}&nbsp;
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
@endpush

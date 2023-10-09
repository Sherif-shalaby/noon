@extends('layouts.app')
@section('title', __('lang.add_products'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.add_products')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">@lang('lang.products')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.add_products')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
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
    <div class="row d-flex justify-content-center">

        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30 p-2">
                <div class="row ">
                    <div class="col-md-9">
                        <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info') </small></p>
                    </div>
                    <div class="col-md-3">
                        <div class="i-checks">
                            <input id="clear_all_input_form" name="clear_all_input_form"
                                   type="checkbox" @if(isset($clear_all_input_form) && $clear_all_input_form == '1') checked @endif
                                   class="">
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
                <div class="row">
                    {{-- ++++++++++++++++ Brand ++++++++++++++++ --}}
                    <div class="col-md-3">
                        {!! Form::label('brand', __('lang.brand'), ['class' => 'h5 pt-3']) !!}
                        <div class="d-flex justify-content-center">
                            {!! Form::select('brand_id', $brands, isset($recent_product->brand) ? $recent_product->brand->id : null, [
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
                            {!! Form::select(
                                'store_id[]',
                                $stores,
                                isset($recent_product->stores) ? $recent_product->stores : null,
                                [
                                    'class' => 'form-control selectpicker',
                                    'multiple' => 'multiple',
                                    'placeholder' => __('lang.please_select'),
                                    'id' => 'store_id',
                                ],
                            ) !!}
                            <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
                                data-target=".add-store" href="{{ route('store.create') }}"><i
                                    class="fas fa-plus"></i></button>

                        </div>
                    </div>

                    <div class="col-md-3">
                        {!! Form::label('name', __('lang.product_name'), ['class' => 'h5 pt-3']) !!}
                        <div class="d-flex justify-content-center">
                            {!! Form::text('name', isset($recent_product->name) ? $recent_product->name : null, [
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
                            'translations' => isset($recent_product->translations) ? $recent_product->translations : [],
                            'type' => 'product',
                        ])
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('product_sku', __('lang.product_code'), ['class' => 'h5 pt-3']) !!}
                        {!! Form::text('product_sku', isset($recent_product->sku) ? $recent_product->sku : null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('category', __('lang.category'), ['class' => 'h5 pt-3']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('category_id', $categories, isset($recent_product->category_id) ? $recent_product->category_id : null, [
                                        'class' => 'form-control select2 category',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'categoryId',
                                        'required',
                                    ]) !!}
                                    <a data-href="{{route('categories.sub_category_modal')}}" data-container=".view_modal" class="btn btn-primary text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                                       data-select_category="0"><i class="fas fa-plus"></i></a>
                                </div>
                                @error('category_id')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 1', ['class' => 'h5 pt-3']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('subcategory_id1', $subcategories, isset($recent_product->subcategory_id1) ? $recent_product->subcategory_id1 : null, [
                                        'class' => 'form-control select2 subcategory',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subcategory_id1',
                                    ]) !!}
                                    <a data-href="{{route('categories.sub_category_modal')}}" data-container=".view_modal" class="btn btn-primary text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                                       data-select_category="1"><i class="fas fa-plus"></i></a>
                                </div>
                                @error('category_id')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 2', ['class' => 'h5 pt-3']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('subcategory_id2', $subcategories, isset($recent_product->subcategory_id2) ? $recent_product->subcategory_id2 : null, [
                                        'class' => 'form-control select2 subcategory2',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subCategoryId2',
                                    ]) !!}
                                    <a data-href="{{route('categories.sub_category_modal')}}" data-container=".view_modal" class="btn btn-primary text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                                       data-select_category="2"><i class="fas fa-plus"></i></a>
                                </div>
                                @error('subcategory_id2')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 3', ['class' => 'h5 pt-3']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('subcategory_id3', $subcategories, isset($recent_product->subcategory_id3) ? $recent_product->subcategory_id3 : null, [
                                        'class' => 'form-control select2 subcategory3',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subCategoryId3',
                                    ]) !!}
                                    <a data-href="{{route('categories.sub_category_modal')}}" data-container=".view_modal" class="btn btn-primary text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
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
                        <select name="method"  id="method" class='form-control select2' data-live-search='true'
                                placeholder="{{ __('lang.please_select') }}">
                            <option value="">{{ __('lang.please_select') }}</option>
                            <option @if(isset($recent_product->method) && $recent_product->method == 'inclusive' ) selected @endif value="inclusive">{{ __('lang.inclusive') }}</option>
                            <option @if(isset($recent_product->method) && $recent_product->method == 'exclusive' ) selected @endif value="exclusive">{{ __('lang.exclusive') }}</option>
                        </select>
                    </div>
                    {{-- +++++++++++++++++++++++ "product_tax" selectbox +++++++++++++++++++++++ --}}
                    <div class="col-md-3">
                        <label for="product" class="h5 pt-3">{{ __('lang.product_tax') . ':*' }}</label>
                        <div class="d-flex justify-content-center">
                            <select name="product_tax_id" id="product_tax" class="form-control select2"
                                    placeholder="{{ __('lang.please_select') }}">
                                <option value="">{{ __('lang.please_select') }}</option>
                                @foreach ($product_tax as $tax)
                                    <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-primary btn-sm ml-2"
                                    data-toggle="modal" data-target="#add_product_tax_modal"
                                    data-select_category="2"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>                    {{-- sizes --}}
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 pt-5 ">
                                <h5 class="text-primary">{{ __('lang.product_dimensions') }}</h5>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('height', __('lang.height'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('height', isset($recent_product->height) ? $recent_product->height : 0, [
                                    'class' => 'form-control height',
                                ]) !!}
                                <br>
                                @error('height')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>



                            <div class="col-md-3">
                                {!! Form::label('length', __('lang.length'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('length', isset($recent_product->height) ? $recent_product->length : 0, [
                                    'class' => 'form-control length',
                                ]) !!}
                                <br>
                                @error('length')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                {!! Form::label('width', __('lang.width'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('width', isset($recent_product->width) ? $recent_product->width : 0, [
                                    'class' => 'form-control width',
                                ]) !!}
                                <br>
                                @error('width')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('size', __('lang.size'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('size', isset($recent_product->size) ? $recent_product->size : 0, [
                                    'class' => 'form-control size',
                                ]) !!}
                                <br>
                                @error('size')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('weight', __('lang.weight'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('weight', isset($recent_product->weight) ? $recent_product->weight : 0, [
                                    'class' => 'form-control',
                                ]) !!}
                                <br>
                                @error('weight')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <button class="btn btn btn-primary add_unit_row" type="button">
                                <i class="fa fa-plus"></i> @lang('lang.add')
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12 product_unit_raws ">
                        @if(!empty($recent_product->variations))
                            @foreach($recent_product->variations as $index=>$variation)
                                @include('products.product_unit_raw', [
                                'index' => $index ,
                                'variation'=>$variation,
                                ])
                            @endforeach
                        @else
                            @include('products.product_unit_raw', ['index' => 0])
                        @endif
                        @php
                        if (!empty(($recent_product->variations))){
                            $index = count($recent_product->variations) - 1;
                        }
                        else{
                            $index = 0;
                        }
                        @endphp
                        <input type="hidden" id="raw_unit_index" value="{{$index}}" />
                    </div>

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

                                        {!! Form::textarea('details', isset($recent_product->details) ? $recent_product->details : null, ['class' => 'form-control', 'id' => 'product_details']) !!}
                                        @include('layouts.translation_textarea', [
                                            'attribute' => 'details',
                                            'translations' => isset($recent_product) ? $recent_product->details_translations : [],
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
@endpush

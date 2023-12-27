@extends('layouts.app')
@section('title', __('lang.add_products'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/product.css') }}">
    <style>
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
    </style>
@endpush
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.add_products')</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ route('products.index') }}">/
                                    @lang('lang.products')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                                aria-current="page">@lang('lang.add_products')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="widgetbar">
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            @lang('lang.products')
                        </a>
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
            <div class="col-lg-12">
                <div class="card pt-0 mb-0 p-2">
                    <div class="row ">

                        <div class="col-md-3 animate__animated animate__bounceInRight" style="animation-delay: 1.1s">
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
                        'id' => 'add_product_form1',
                    ]) !!}
                    <div class="row">
                        {{-- ++++++++++++++++ stores ++++++++++++++++ --}}
                        <div class="col-12 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="position: relative;z-index: 2;">

                            <div class=" mb-2 p-0">
                                {!! Form::label('store', __('lang.store'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                    'style' => 'font-weight:500;font-size:10px;color:#888',
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
                                    <select id="store_id" name="store_id[]" id = 'store_id' class="form-control select2"
                                        multiple="multiple">
                                        <option value="">@lang('lang.please_select')</option>
                                        @foreach ($stores as $store)
                                            <option value="{{ $store->id }}">
                                                {{ $store->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="button"
                                        class=" add-button d-flex justify-content-center align-items-center"
                                        id="add_new_store" data-toggle="modal" data-target="#createStoreModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                @error('store_id')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 product_raws">
                            @for ($i = 0; $i < 3; $i++)
                                @include('products.partials.product_row', ['key' => $i])
                            @endfor
                            <input type="hidden" id="raw_product_index" value="2" />
                        </div>
                        <div class="col-md-12 mb-3 d-flex justify-content-end">
                            <button class="btn btn btn-success add_product_row" type="button">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="view_modal no-print"></div>
    @include('products.partials.add_store_modal')
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
    <script src="{{ asset('css/crop/crop-multi-image.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\ProductRequest', '#add_product_form1') !!}
    <script>
        $(document).ready(function() {
            // Counter to keep track of the number of rows
            var rowCount = 1;

            // Event handler for the Add Product button
            $('#addProductRow').click(function() {
                // Clone the product section and update IDs and names
                var clonedSection = $('#product-section').clone();

                // Update IDs and names to make them unique
                clonedSection.find('[id]').each(function() {
                    var newId = $(this).attr('id') + '_' + rowCount;
                    $(this).attr('id', newId);
                });

                clonedSection.find('[name]').each(function() {
                    var newName = $(this).attr('name') + '[]';
                    $(this).attr('name', newName);
                });

                // Append the cloned section to the page
                $('#product-section').after(clonedSection);

                // Increment the row count
                rowCount++;
            });
        });
    </script>
@endpush

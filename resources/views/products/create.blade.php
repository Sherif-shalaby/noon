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
{{--                        <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info') </small></p>--}}
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
                    'id' => 'add_product_form1'
                ]) !!}
                <div class="row">
                    {{-- ++++++++++++++++ stores ++++++++++++++++ --}}
                    <div class="col-md-3">
                        {!! Form::label('store', __('lang.store'), ['class' => 'h5 pt-3']) !!}
                        <div class="d-flex justify-content-center">
                            {{-- {!! Form::select(
                                'store_id[]',
                                $stores,
                                isset($recent_product->stores) ? $recent_product->stores : null,
                                [
                                    'class' => 'form-control selectpicker',
                                    'multiple' => 'multiple',
                                    'placeholder' => __('lang.please_select'),
                                    'id' => 'store_id',
                                ],
                            ) !!} --}}
                            <select id="store_id" name="store_id[]" id = 'store_id' class="form-control select2" multiple="multiple">
                                <option value="">@lang('lang.please_select')</option>
                                @foreach ( $stores as $store)
                                    <option value="{{ $store->id }}">
                                        {{ $store->name }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="button" class="btn btn-primary btn-sm ml-2" id="add_new_store" data-toggle="modal"
                                    data-target="#createStoreModal">
                                    <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        @error('store_id')
                        <label class="text-danger error-msg">{{ $message }}</label>
                        @enderror
                    </div>


                    <div class="col-md-12 product_raws">
                        @for ($i = 0; $i < 3; $i++)
                            @include('products.partials.product_row',['key' => $i])
                        @endfor
                        <input type="hidden" id="raw_product_index" value="2" />
                    </div>
                    <div class="col-md-12 pt-5">
                        <div class="col-md-3">
                            <button class="btn btn btn-primary add_product_row" type="button">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                </div>
                {!! Form::close() !!}
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
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\ProductRequest','#add_product_form1'); !!}
    <script>
        $(document).ready(function () {
            // Counter to keep track of the number of rows
            var rowCount = 1;

            // Event handler for the Add Product button
            $('#addProductRow').click(function () {
                // Clone the product section and update IDs and names
                var clonedSection = $('#product-section').clone();

                // Update IDs and names to make them unique
                clonedSection.find('[id]').each(function () {
                    var newId = $(this).attr('id') + '_' + rowCount;
                    $(this).attr('id', newId);
                });

                clonedSection.find('[name]').each(function () {
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

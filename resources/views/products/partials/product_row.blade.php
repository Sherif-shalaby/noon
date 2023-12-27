{{--@dd($errors->all())--}}
    <div class="d-flex flex-wrap">
        <input type="hidden" name="products[{{$key ?? 0 }}]" value="{{$product->id ?? null}}">
        {{-- ++++++++++++++++ Brand ++++++++++++++++ --}}
        <div class="col-md-3">
            {!! Form::label('brand', __('lang.brand'), ['class' => 'h5 pt-3']) !!}
            <div class="d-flex justify-content-center">
                {!! Form::select('products['.$key.'][brand_id]', $brands, $key == 0 && isset($recent_product->brand) ? $recent_product->brand->id : null, [
                    'class' => 'form-control select2',
                    'placeholder' => __('lang.please_select'),
                    'id' => 'brand_id'.$key,
                ]) !!}
                <button type="button" class="btn btn-primary btn-sm ml-2 btn-add-modal" data-toggle="modal" data-key="{{ $key }}"
                        data-target="#createBrandModal"><i class="fas fa-plus"></i></button>

            </div>
        </div>
        {{-- ++++++++++++++++ product name ++++++++++++++++ --}}
        <div class="col-md-3">
            {!! Form::label('name', __('lang.product_name'), ['class' => 'h5 pt-3']) !!}
            <div class="d-flex justify-content-center">
                {!! Form::text('products['.$key.'][name]', $key == 0 && isset($recent_product->name) ? $recent_product->name : null, [
                    'class' => 'form-control required',
                ]) !!}
                <button class="btn btn-primary btn-sm ml-2" type="button" data-toggle="collapse"
                        data-target="#translation_table_product" aria-expanded="false"
                        aria-controls="collapseExample">
                    <i class="fas fa-globe"></i>
                </button>
            </div>
            @error('products.' . $key . '.name')
            <label class="text-danger error-msg">{{ $message }}</label>
            @enderror

            @include('layouts.translation_inputs', [
                'attribute' => 'name',
                'translations' =>  $key == 0 && isset($recent_product->translations) ? $recent_product->translations : [],
                'type' => 'product',
            ])
        </div>
        {{-- ++++++++++++++++ product symbol ++++++++++++++++ --}}
        <div class="col-md-1">
            {!! Form::label('product_symbol', __('lang.product_symbol'), ['class' => 'h5 pt-3']) !!}
            {!! Form::text('products['.$key.'][product_symbol]',  null, [
                'class' => 'form-control',
            ]) !!}
            <br>
            @error('products.' . $key .'.product_symbol')
            <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>
        {{-- ++++++++++++++++ product sku ++++++++++++++++ --}}
        <div class="col-md-2">
            {!! Form::label('product_sku', __('lang.product_code'), ['class' => 'h5 pt-3']) !!}
            {!! Form::text('products['.$key.'][product_sku]',  null, [
                'class' => 'form-control',
            ]) !!}
            <br>
            @error('products.' . $key .'.product_sku')
            <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>
        {{-- ++++++++++++++++ product categories ++++++++++++++++ --}}
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3" data-key="{{ $key }}">
                    {!! Form::label('category', __('lang.category'), ['class' => 'h5 pt-3']) !!}
                    <div class="d-flex justify-content-center">
                            {!! Form::select('products['.$key.'][category_id]', $categories1, $key == 0 && isset($recent_product->category_id) ? $recent_product->category_id : null, [
                                'class' => 'form-control select2 category',
                                'placeholder' => __('lang.please_select'),
                                'id' => 'categoryId'.$key,

                            ]) !!}
                        {{-- <a data-href="{{route('categories.sub_category_modal')}}"  data-key="{{ $key }}" data-container=".view_modal" class="btn btn-primary btn-add-modal text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                           data-select_category="0" data-target="#translation_table_product"><i class="fas fa-plus"></i></a> --}}

                           <a   data-href="{{ route('categories.sub_category_modal') }}" data-container=".view_modal"
                                class="btn btn-primary text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                                data-select_category="0"><i class="fas fa-plus"></i>
                            </a>
                    </div>
                    @error('products.' . $key .'.category_id')
                    <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-3">
                    {!! Form::label('subcategory', __('lang.subcategory') . ' 1', ['class' => 'h5 pt-3']) !!}
                    <div class="d-flex justify-content-center">
                        {!! Form::select('products['.$key.'][subcategory_id1]', $categories2, $key == 0 && isset($recent_product->subcategory_id1) ? $recent_product->subcategory_id1 : null, [
                            'class' => 'form-control select2 subcategory',
                            'placeholder' => __('lang.please_select'),
                            'id' => 'subcategory_id1'.$key,'data-key' => $key
                        ]) !!}
                        <a data-href="{{route('categories.sub_category_modal')}}" data-key="{{ $key }}" data-container=".view_modal" class="btn btn-primary btn-add-modal text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                           data-select_category="1"><i class="fas fa-plus"></i></a>
                    </div>
                    @error('products.' . $key .'.category_id')
                    <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>

                <div class="col-md-3">
                    {!! Form::label('subcategory', __('lang.subcategory') . ' 2', ['class' => 'h5 pt-3']) !!}
                    <div class="d-flex justify-content-center">
                        {!! Form::select('products['.$key.'][subcategory_id2]', $categories3, $key == 0 && isset($recent_product->subcategory_id2) ? $recent_product->subcategory_id2 : null, [
                            'class' => 'form-control select2 subcategory2',
                            'placeholder' => __('lang.please_select'),
                            'id' => 'subCategoryId2'.$key, 'data-key' => $key
                        ]) !!}
                        <a data-href="{{route('categories.sub_category_modal')}}" data-key="{{ $key }}" data-container=".view_modal" class="btn btn-primary btn-add-modal text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                           data-select_category="2"><i class="fas fa-plus"></i></a>
                    </div>
                    @error('products.' . $key .'.subcategory_id2')
                    <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>

                <div class="col-md-3">
                    {!! Form::label('subcategory', __('lang.subcategory') . ' 3', ['class' => 'h5 pt-3']) !!}
                    <div class="d-flex justify-content-center">
                        {!! Form::select('products['.$key.'][subcategory_id3]', $categories4, $key == 0 && isset($recent_product->subcategory_id3) ? $recent_product->subcategory_id3 : null, [
                            'class' => 'form-control select2 subcategory3',
                            'placeholder' => __('lang.please_select'),
                            'id' => 'subCategoryId3'.$key, 'data-key' => $key
                        ]) !!}
                        <a data-href="{{route('categories.sub_category_modal')}}" data-key="{{ $key }}" data-container=".view_modal" class="btn btn-primary btn-add-modal text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                           data-select_category="3"><i class="fas fa-plus"></i></a>
                    </div>
                    @error('products.' . $key .'.subcategory_id3')
                    <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>
            </div>
        </div>
        {{-- +++++++++++++++++++++++ "tax_method" selectbox +++++++++++++++++++++++ --}}
        <div class="col-md-3">
            <label for="method" class="h5 pt-3">{{ __('lang.tax_method') . ':*' }}</label>
            <select name="products[{{$key}}][method]"  id="method{{ $key }}" class='form-control select2' data-live-search='true'
                    placeholder="{{ __('lang.please_select') }}">
                <option value="">{{ __('lang.please_select') }}</option>
                <option @if( $key == 0 && isset($recent_product->method) && $recent_product->method == 'inclusive'  ) selected @endif value="inclusive">{{ __('lang.inclusive') }}</option>
                <option @if( $key == 0 && isset($recent_product->method) && $recent_product->method == 'exclusive' ) selected @endif value="exclusive">{{ __('lang.exclusive') }}</option>
            </select>
        </div>
        {{-- +++++++++++++++++++++++ "product_tax" selectbox +++++++++++++++++++++++ --}}
        <div class="col-md-3">
            <label for="product" class="h5 pt-3">{{ __('lang.product_tax') . ':*' }}</label>
            <div class="d-flex justify-content-center">
                <select name="products[{{$key}}][product_tax_id]" id="product_tax{{$key}}" class="form-control select2"
                        placeholder="{{ __('lang.please_select') }}">
                    <option value="">{{ __('lang.please_select') }}</option>
                    @foreach ($product_tax as $tax)
                        <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-primary btn-add-modal btn-sm ml-2" data-key="{{ $key }}"
                        data-toggle="modal" data-target="#add_product_tax_modal"
                        data-select_category="2"><i class="fas fa-plus"></i></button>
            </div>
        </div>
        {{-- +++++++++++++++++++++++ "balance return request"  +++++++++++++++++++++++ --}}
        <div class="col-md-3">
            {!! Form::label('balance_return_request', __('lang.balance_return_request'), ['class' => 'h5 pt-3']) !!}
            {!! Form::text('products['.$key.'][balance_return_request]',  null, [
                'class' => 'form-control',
            ]) !!}
        </div>
{{--        <div class="col-md-12 pt-5">--}}
{{--            <div class="col-md-3">--}}
{{--                <button class="btn btn btn-primary add_unit_row" type="button" data-key="{{ $key }}">--}}
{{--                    <i class="fa fa-plus"></i> @lang('lang.add')--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="col-md-12 product_unit_raws[{{$key}}] ">
            <div class="row">
                <div class="col-md-2 pl-5">
                    {!! Form::label('sku', __('lang.product_code'),['class'=>'h5 pt-3']) !!}
                    {!! Form::text('products['.$key.'][variations][0][sku]',$variation->sku ?? null, [
                        'class' => 'form-control'
                    ]) !!}
                    <br>
                    @error('products.' . $key . '.variations.0.sku')
                    <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>
                {{-- =========== تعبئة =========== --}}
                <div class="col-md-2">
                    {!! Form::label('unit', __('lang.large_filling'), ['class'=>'h5 pt-3']) !!}
                    <div class="d-flex justify-content-center">
                        <select name="products[{{ $key }}][variations][0][new_unit_id]"  data-name='unit_id' data-index="0"  class="form-control unit_select select2 unit_id0{{$key ??''}}" style="width: 100px;" data-key="{{ $key }}" id="{{$key}}">
                            <option value="">{{__('lang.please_select')}}</option>
                            @foreach($units as $unit)
                                <option @if($key == 0 &&  isset($variation->unit_id) &&($variation->unit_id == $unit->id)) selected @endif  value="{{$unit->id}}">{{$unit->name}}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-primary btn-add-modal btn-sm ml-2 add_unit_raw" data-toggle="modal" data-key="{{$key}}" data-index="0" data-target=".add-unit" href="{{route('units.create')}}"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                {{-- +++++++ Equal Button +++++++ --}}
                <div class="col-md-2 pt-4 mt-3">
                    <button class="btn btn btn-warning add_small_unit" type="button" data-key="{{ $key }}">
                        <i class="fa fa-equals"></i>
                    </button>
                </div>

                @include('products.product_unit_raw')
                <input type="hidden" id="raw_unit_index[{{ $key }}]" value="0" />
            </div>

        </div>

        {{-- sizes --}}
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pt-5 ">
                    <h5 class="text-primary">{{ __('lang.product_dimensions') }}</h5>
                </div>
                <div class="col-md-2">
                    {!! Form::label('height', __('lang.height'), ['class' => 'h5 pt-3']) !!}
                    {!! Form::text('products['.$key.'][height]', isset($recent_product->product_dimensions->height) ? $recent_product->product_dimensions->height : 0, [
                        'class' => 'form-control height', 'id' => 'height'.$key, 'data-key' => $key
                    ]) !!}
                    <br>
                    @error('height')
                    <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>



                <div class="col-md-2">
                    {!! Form::label('length', __('lang.length'), ['class' => 'h5 pt-3']) !!}
                    {!! Form::text('products['.$key.'][length]', isset($recent_product->product_dimensions->length) ? $recent_product->product_dimensions->length : 0, [
                        'class' => 'form-control length','id' => 'length'.$key, 'data-key' => $key,
                    ]) !!}
                    <br>
                    @error('length')
                    <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>

                <div class="col-md-2">
                    {!! Form::label('width', __('lang.width'), ['class' => 'h5 pt-3']) !!}
                    {!! Form::text('products['.$key.'][width]', isset($recent_product->product_dimensions->width) ? $recent_product->product_dimensions->width : 0, [
                        'class' => 'form-control width','id' => 'width'.$key,'data-key' => $key
                    ]) !!}
                    <br>
                    @error('width')
                    <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2">
                    {!! Form::label('size', __('lang.size'), ['class' => 'h5 pt-3']) !!}
                    {!! Form::text('products['.$key.'][size]', isset($recent_product->product_dimensions->size) ? $recent_product->product_dimensions->size : 0, [
                        'class' => 'form-control size','id' => 'size'.$key ,'data-key' => $key
                    ]) !!}
                    <br>
                    @error('size')
                    <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2">
                    {!! Form::label('weight', __('lang.weight'), ['class' => 'h5 pt-3']) !!}
                    {!! Form::text('products['.$key.'][weight]', isset($recent_product->product_dimensions->weight) ? $recent_product->product_dimensions->weight : 0, [
                        'class' => 'form-control','data-key' => $key
                    ]) !!}
                    <br>
                    @error('weight')
                    <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2">
                    {!! Form::label('variation', __('lang.basic_unit_for_import_product'), ['class' => 'h5 pt-3']) !!}
                    {!! Form::select('products['.$key.'][variation_id]', [], null, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'products['.$key.'][variation_id]',
                    ]) !!}
                </div>
            </div>

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
                                            {{ __('lang.product_image') }}
                                        </label>
                                    </div>
                                    <div class="col-5">
                                        <div class="mt-3">
                                            <div class="row">
                                                <div class="col-10 offset-1">
                                                    <div class="variants">
                                                        <div class='file file--upload w-100'>
                                                            <div class="file-input">
                                                                <input type="file" name="file-input"
                                                                    id="file-input-image{{ $key }}" data-key="{{ $key }}"
                                                                    class="file-input__input" />
                                                                <label class="file-input__label"
                                                                    for="file-input-image{{ $key }}" data-key="{{ $key }}">
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
                                        <div class="preview-image-container{{ $key }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            <div id="cropped_images{{ $key }}"></div>
                        {{--                     crop image --}}
{{--        <div class="col-md-3">--}}
{{--            <input type="file" name="products[{{ $key }}][image]" class="form-control">--}}
{{--        </div>--}}
    </div>
    @include('products.partials.crop-multi-imge-modal',['key' => $key])

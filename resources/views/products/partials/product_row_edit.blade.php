{{--@dd($errors->all())--}}
    <div class="d-flex flex-wrap">
        <input type="hidden" name="products[{{$key ?? 0 }}]" value="{{$product->id ?? null}}">
        {{-- ++++++++++++++++ product categories ++++++++++++++++ --}}
        <div class="col-md-12">
            <div class="row">
                {{-- +++++++++++++++++ category +++++++++++++++++ --}}
                <div class="col-md-3" data-key="{{ $key }}">
                    {!! Form::label('category', __('lang.category'). ' 1', ['class' => 'h5 pt-3']) !!}
                    <div class="d-flex justify-content-center">
                            {!! Form::select('products['.$key.'][category_id]', $categories1, $key == 0 && isset($recent_product->category_id) ? $recent_product->category_id : null, [
                                'class' => 'form-control select2 category',
                                'placeholder' => __('lang.please_select'),
                                'id' => 'categoryId'.$key,

                            ]) !!}

                             <a  data-href="{{ route('categories.sub_category_modal') }}" data-container=".view_modal"
                                class="btn btn-primary text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                                data-select_category="0"><i class="fas fa-plus"></i>
                            </a>
                    </div>
                    @error('products.' . $key .'.category_id')
                    <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>
                {{-- +++++++++++++++++ sub_category1 +++++++++++++++++ --}}
                <div class="col-md-3">
                    {!! Form::label('subcategory', __('lang.category') . ' 2', ['class' => 'h5 pt-3']) !!}
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
                {{-- +++++++++++++++++ sub_category2 +++++++++++++++++ --}}
                <div class="col-md-3">
                    {!! Form::label('subcategory', __('lang.category') . ' 3', ['class' => 'h5 pt-3']) !!}
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
                {{-- +++++++++++++++++ sub_category3 +++++++++++++++++ --}}
                <div class="col-md-3">
                    {!! Form::label('subcategory', __('lang.category') . ' 4', ['class' => 'h5 pt-3']) !!}
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
    </div>
    @include('products.partials.crop-multi-imge-modal',['key' => $key])

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
          background-color: #eee;
          border-radius: 6px;
      }
  </style>
  <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
      <input type="hidden" name="products[{{ $key ?? 0 }}]" value="{{ $product->id ?? null }}">
      {{-- ++++++++++++++++ Brand ++++++++++++++++ --}}
      <div
          class="col-md-2 mb-2 animate__animated animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
          {!! Form::label('brand', __('lang.brand'), [
              'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0 ' : ' mb-0 ',
              'style' => 'font-size: 12px;font-weight: 500;',
          ]) !!}
          <div class="d-flex justify-content-center align-items-center"
              style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
              {!! Form::select(
                  'products[' . $key . '][brand_id]',
                  $brands,
                  $key == 0 && isset($recent_product->brand) ? $recent_product->brand->id : null,
                  [
                      'class' => 'form-control select2',
                      'placeholder' => __('lang.please_select'),
                      'id' => 'brand_id' . $key,
                  ],
              ) !!}
              <button type="button" class="add-button d-flex justify-content-center align-items-center"
                  data-toggle="modal" data-target="#createBrandModal"><i class="fas fa-plus"></i></button>

          </div>
      </div>
      {{-- ++++++++++++++++ stores ++++++++++++++++ --}}
      <div class="mb-2 col-md-2 animate__animated animate__bounceInLeft d-flex flex-column @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
          style="position: relative;z-index: 2;">
          {!! Form::label('store', __('lang.store'), [
              'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : 'mx-2 mb-0 ',
              'style' => 'font-size: 12px;font-weight: 500;',
          ]) !!}
          <div class="d-flex justify-content-center align-items-center"
              style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
              {!! Form::select(
                  'products[' . $key . '][store_id[]]',
                  $stores,
                  $key == 0 && isset($recent_product->stores) ? $recent_product->stores : null,
                  [
                      'class' => 'form-control selectpicker',
                      'multiple' => 'multiple',
                      'placeholder' => __('lang.please_select'),
                      'id' => 'store_id' . $key,
                  ],
              ) !!}
              <button type="button" class="add-button d-flex justify-content-center align-items-center"
                  data-toggle="modal" data-target=".add-store" href="{{ route('store.create') }}"><i
                      class="fas fa-plus"></i></button>
          </div>
          @error('store_id')
              <label class="text-danger error-msg">{{ $message }}</label>
          @enderror
      </div>
      {{-- ++++++++++++++++ product name ++++++++++++++++ --}}
      <div
          class="mb-2 col-md-2 animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
          {!! Form::label('name', __('lang.product_name'), [
              'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 ' : 'mx-2 mb-0 ',
              'style' => 'font-size: 12px;font-weight: 500;',
          ]) !!}
          <div class="d-flex justify-content-center align-items-center"
              style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
              {!! Form::text(
                  'products[' . $key . '][name]',
                  $key == 0 && isset($recent_product->name) ? $recent_product->name : null,
                  [
                      'class' => 'form-control required mater-name-input',
                      'style' => 'border:2px solid #ccc',
                  ],
              ) !!}
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
              'translations' =>
                  $key == 0 && isset($recent_product->translations) ? $recent_product->translations : [],
              'type' => 'product',
          ])
      </div>
      {{-- ++++++++++++++++ product symbol ++++++++++++++++ --}}

      <div
          class="mb-2 col-md-2 animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
          {!! Form::label('product_symbol', __('lang.product_symbol'), [
              'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 ' : 'mx-2 mb-0 ',
              'style' => 'font-size: 12px !important;font-weight: 500;',
          ]) !!}
          {!! Form::text('products[' . $key . '][product_symbol]', null, [
              'class' => 'form-control initial-balance-input',
              'style' => 'width:100%;margin:0 !important;border:2px solid #ccc',
          ]) !!}

          @error('product_symbol')
              <label class="text-danger error-msg">{{ $message }}</label>
          @enderror
      </div>
      {{-- ++++++++++++++++ product sku ++++++++++++++++ --}}
      <div
          class="mb-2 col-md-2 animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
          {!! Form::label('product_sku', __('lang.product_code'), [
              'class' => app()->isLocale('ar') ? 'd-block text-end  mr-2 ml-0 mb-0 ' : 'mr-2 ml-0 mb-0 ',
              'style' => 'font-size: 12px;font-weight: 500;',
          ]) !!}
          {!! Form::text('products[' . $key . '][product_sku]', null, [
              'class' => 'form-control initial-balance-input',
              'style' => 'width:100%;margin:0 !important;border:2px solid #ccc',
          ]) !!}

          @error('product_sku')
              <label class="text-danger error-msg">{{ $message }}</label>
          @enderror
      </div>

      {{-- +++++++++++++++++++++++ "balance return request"  +++++++++++++++++++++++ --}}
      <div
          class="mb-2 col-md-2 animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
          {!! Form::label('balance_return_request', __('lang.balance_return_request'), [
              'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
              'style' => 'font-size: 12px;font-weight: 500;',
          ]) !!}
          {!! Form::text('products[' . $key . '][balance_return_request]', null, [
              'class' => 'form-control initial-balance-input',
              'style' => 'width:100%;margin:0 !important;border:2px solid #ccc',
          ]) !!}
      </div>


      <div
          class="d-flex mb-1 animate__animated  animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif align-items-center">

          <button style="height: fit-content;width: 150px"
              class="btn btn btn-primary add_unit_row col-md-2 d-flex justify-content-between align-items-center mr-3"
              type="button" data-key="{{ $key }}">
              <i class="fa fa-plus"></i> @lang('lang.add')
          </button>



          <div class="col-md-10  product_unit_raws[{{ $key }}] ">
              @include('products.product_unit_raw')
              <input type="hidden" id="raw_unit_index[{{ $key }}]" value="0" />
          </div>
      </div>



      <div class="accordion mb-1 animate__animated  animate__bounceInLeft">
          <div class="accordion-item d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
              style="border: none">
              <h2 class="accordion-header col-md-2 d-flex justify-content-end align-items-center">
                  <div class="accordion-button" style="width: 150px"
                      onclick="toggleProductAccordion(`productCategories{{ $key }}`)">
                      <span class="productCategories{{ $key }} mx-2">
                          <i class="fas fa-arrow-left d-flex justify-content-center align-items-center"
                              style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                      </span>
                      {{ __('lang.categories') }}
                  </div>
              </h2>
              <div id="productCategories{{ $key }}" class="accordion-content col-md-10">
                  <div class="accordion-body d-flex p-0">
                      {{-- ++++++++++++++++ product categories ++++++++++++++++ --}}
                      <div class="col-md-12">
                          <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                              <div class="mb-2 col-md-3 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                  data-key="{{ $key }}">
                                  {!! Form::label('category', __('lang.category'), [
                                      'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                                      'style' => 'font-size: 12px;font-weight: 500;',
                                  ]) !!}
                                  <div class="d-flex justify-content-center align-items-center"
                                      style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 70%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                      {!! Form::select(
                                          'products[' . $key . '][category_id]',
                                          $categories,
                                          $key == 0 && isset($recent_product->category_id) ? $recent_product->category_id : null,
                                          [
                                              'class' => 'form-control select2 category',
                                              'placeholder' => __('lang.please_select'),
                                              'id' => 'categoryId' . $key,
                                          ],
                                      ) !!}
                                      <a data-href="{{ route('categories.sub_category_modal') }}"
                                          data-container=".view_modal"
                                          class="openCategoryModal text-white add-button  d-flex justify-content-center align-items-center"
                                          style="cursor: pointer" data-toggle="modal" data-select_category="0"><i
                                              class="fas fa-plus"></i></a>
                                  </div>
                                  @error('category_id')
                                      <label class="text-danger error-msg">{{ $message }}</label>
                                  @enderror
                              </div>
                              <div
                                  class="mb-2 col-md-3 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                  {!! Form::label('subcategory', __('lang.subcategory') . ' 1', [
                                      'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                                      'style' => 'font-size: 12px;font-weight: 500;',
                                  ]) !!}
                                  <div class="d-flex justify-content-center align-items-center"
                                      style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 70%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                      {!! Form::select(
                                          'products[' . $key . '][subcategory_id1]',
                                          $subcategories,
                                          $key == 0 && isset($recent_product->subcategory_id1) ? $recent_product->subcategory_id1 : null,
                                          [
                                              'class' => 'form-control select2 subcategory',
                                              'placeholder' => __('lang.please_select'),
                                              'id' => 'subcategory_id1' . $key,
                                              'data-key' => $key,
                                          ],
                                      ) !!}
                                      <a data-href="{{ route('categories.sub_category_modal') }}"
                                          data-container=".view_modal"
                                          class="openCategoryModal text-white add-button  d-flex justify-content-center align-items-center"
                                          style="cursor: pointer" data-toggle="modal" data-select_category="1"><i
                                              class="fas fa-plus"></i></a>
                                  </div>
                                  @error('category_id')
                                      <label class="text-danger error-msg">{{ $message }}</label>
                                  @enderror
                              </div>

                              <div
                                  class="mb-2 col-md-3 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                  {!! Form::label('subcategory', __('lang.subcategory') . ' 2', [
                                      'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                                      'style' => 'font-size: 12px;font-weight: 500;',
                                  ]) !!}
                                  <div class="d-flex justify-content-center align-items-center"
                                      style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 70%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                      {!! Form::select(
                                          'products[' . $key . '][subcategory_id2]',
                                          $subcategories,
                                          $key == 0 && isset($recent_product->subcategory_id2) ? $recent_product->subcategory_id2 : null,
                                          [
                                              'class' => 'form-control select2 subcategory2',
                                              'placeholder' => __('lang.please_select'),
                                              'id' => 'subCategoryId2' . $key,
                                              'data-key' => $key,
                                          ],
                                      ) !!}
                                      <a data-href="{{ route('categories.sub_category_modal') }}"
                                          data-container=".view_modal"
                                          class="openCategoryModal text-white add-button  d-flex justify-content-center align-items-center"
                                          style="cursor: pointer" data-toggle="modal" data-select_category="2"><i
                                              class="fas fa-plus"></i></a>
                                  </div>
                                  @error('subcategory_id2')
                                      <label class="text-danger error-msg">{{ $message }}</label>
                                  @enderror
                              </div>

                              <div
                                  class="mb-2 col-md-3 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                  {!! Form::label('subcategory', __('lang.subcategory') . ' 3', [
                                      'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                                      'style' => 'font-size: 12px;font-weight: 500;',
                                  ]) !!}
                                  <div class="d-flex justify-content-center align-items-center"
                                      style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 70%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                      {!! Form::select(
                                          'products[' . $key . '][subcategory_id3]',
                                          $subcategories,
                                          $key == 0 && isset($recent_product->subcategory_id3) ? $recent_product->subcategory_id3 : null,
                                          [
                                              'class' => 'form-control select2 subcategory3',
                                              'placeholder' => __('lang.please_select'),
                                              'id' => 'subCategoryId3' . $key,
                                              'data-key' => $key,
                                          ],
                                      ) !!}
                                      <a data-href="{{ route('categories.sub_category_modal') }}"
                                          data-container=".view_modal"
                                          class="  openCategoryModal text-white add-button  d-flex justify-content-center align-items-center"
                                          style="cursor: pointer" data-toggle="modal" data-select_category="3"><i
                                              class="fas fa-plus"></i></a>
                                  </div>
                                  @error('subcategory_id3')
                                      <label class="text-danger error-msg">{{ $message }}</label>
                                  @enderror
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>



      <div class="accordion mb-1 animate__animated  animate__bounceInLeft">
          <div class="accordion-item d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
              style="border: none">
              <h2 class="accordion-header  col-md-2 d-flex justify-content-end align-items-center">
                  <div class="accordion-button" onclick="toggleProductAccordion(`productTax{{ $key }}`)"
                      style="width: 150px">
                      <span class="productTax{{ $key }} mx-2">
                          <i class="fas fa-arrow-left d-flex justify-content-center align-items-center"
                              style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                      </span>
                      {{ __('lang.product_tax') }}
                  </div>
              </h2>
              <div id="productTax{{ $key }}" class="accordion-content col-md-10">
                  <div class="accordion-body d-flex p-0">
                      {{-- +++++++++++++++++++++++ "tax_method" selectbox +++++++++++++++++++++++ --}}
                      <div
                          class="col-md-6 animate__animated  animate__bounceInRight mb-1 d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                          <label for="method"
                              class=" @if (app()->isLocale('ar')) d-block text-end @endif mb-0"
                              style="width: 25%;font-size: 12px;font-weight: 500;">{{ __('lang.tax_method') . '*' }}</label>
                          <div
                              style="background-color: #dedede; border: none;
                                                    border-radius: 16px;
                                                    color: #373737;
                                                    box-shadow: 0 8px 6px -5px #bbb;
                                                    width: 32%;
                                                    height: 30px;
                                                    flex-wrap: nowrap;">
                              <select name="products[{{ $key }}][method]" id="method{{ $key }}"
                                  class='form-control select2' data-live-search='true'
                                  placeholder="{{ __('lang.please_select') }}">
                                  <option value="">{{ __('lang.please_select') }}</option>
                                  <option @if ($key == 0 && isset($recent_product->method) && $recent_product->method == 'inclusive') selected @endif value="inclusive">
                                      {{ __('lang.inclusive') }}
                                  </option>
                                  <option @if ($key == 0 && isset($recent_product->method) && $recent_product->method == 'exclusive') selected @endif value="exclusive">
                                      {{ __('lang.exclusive') }}
                                  </option>
                              </select>
                          </div>
                      </div>
                      {{-- +++++++++++++++++++++++ "product_tax" selectbox +++++++++++++++++++++++ --}}
                      <div
                          class="col-md-6 animate__animated  animate__bounceInRight mb-1 d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                          <label for="product"
                              class=" @if (app()->isLocale('ar')) d-block text-end @endif mb-0"
                              style="width: 25%;font-size: 12px;font-weight: 500;">{{ __('lang.product_tax') . ':*' }}</label>
                          <div class="d-flex justify-content-center align-items-center"
                              style="background-color: #dedede; border: none;
                                                        border-radius: 16px;
                                                        color: #373737;
                                                        box-shadow: 0 8px 6px -5px #bbb;

                                                        height: 30px;
                                                        flex-wrap: nowrap;">
                              <select name="products[{{ $key }}][product_tax_id]"
                                  id="product_tax{{ $key }}" class="form-control select2"
                                  placeholder="{{ __('lang.please_select') }}">
                                  <option value="">{{ __('lang.please_select') }}</option>
                                  @foreach ($product_tax as $tax)
                                      <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                                  @endforeach
                              </select>
                              <button type="button"
                                  class="add-button d-flex justify-content-center align-items-center"
                                  data-toggle="modal" data-target="#add_product_tax_modal"
                                  data-select_category="2"><i class="fas fa-plus"></i></button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>


      <div class="accordion mb-1 animate__animated  animate__bounceInLeft">
          <div class="accordion-item d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
              style="border: none">
              <h2 class="accordion-header col-md-2 d-flex justify-content-end align-items-center">
                  <div class="accordion-button" style="width: 150px"
                      onclick="toggleProductAccordion(`productDimension{{ $key }}`)">
                      <span class="productDimension{{ $key }} mx-2">
                          <i class="fas fa-arrow-left d-flex justify-content-center align-items-center"
                              style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                      </span>
                      {{ __('lang.product_dimensions') }}
                  </div>
              </h2>
              <div id='productDimension{{ $key }}' class="accordion-content col-md-10">
                  <div class="accordion-body d-flex p-0">
                      {{-- sizes --}}
                      <div class="col-md-12">
                          <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                              <div
                                  class="mb-2 col-md-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                  {!! Form::label('height', __('lang.height'), [
                                      'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                                      'style' => 'font-size: 12px;font-weight: 500;',
                                  ]) !!}
                                  {!! Form::text(
                                      'products[' . $key . '][height]',
                                      isset($recent_product->product_dimensions->height) ? $recent_product->product_dimensions->height : 0,
                                      [
                                          'class' => 'form-control height  initial-balance-input m-0',
                                          'style' => 'border:2px solid #ccc',
                                      ],
                                  ) !!}

                                  @error('height')
                                      <label class="text-danger error-msg">{{ $message }}</label>
                                  @enderror
                              </div>



                              <div
                                  class="mb-2 col-md-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                  {!! Form::label('length', __('lang.length'), [
                                      'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                                      'style' => 'font-size: 12px;font-weight: 500;',
                                  ]) !!}
                                  {!! Form::text(
                                      'products[' . $key . '][length]',
                                      isset($recent_product->product_dimensions->length) ? $recent_product->product_dimensions->length : 0,
                                      [
                                          'class' => 'form-control length  initial-balance-input m-0',
                                          'style' => 'border:2px solid #ccc',
                                      ],
                                  ) !!}

                                  @error('length')
                                      <label class="text-danger error-msg">{{ $message }}</label>
                                  @enderror
                              </div>

                              <div
                                  class="mb-2 col-md-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                  {!! Form::label('width', __('lang.width'), [
                                      'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                                      'style' => 'font-size: 12px;font-weight: 500;',
                                  ]) !!}
                                  {!! Form::text(
                                      'products[' . $key . '][width]',
                                      isset($recent_product->product_dimensions->width) ? $recent_product->product_dimensions->width : 0,
                                      [
                                          'class' => 'form-control width  initial-balance-input m-0',
                                          'style' => 'border:2px solid #ccc',
                                      ],
                                  ) !!}

                                  @error('width')
                                      <label class="text-danger error-msg">{{ $message }}</label>
                                  @enderror
                              </div>

                              <div
                                  class="mb-2 col-md-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                  {!! Form::label('size', __('lang.size'), [
                                      'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                                      'style' => 'font-size: 12px;font-weight: 500;',
                                  ]) !!}
                                  {!! Form::text(
                                      'products[' . $key . '][size]',
                                      isset($recent_product->product_dimensions->size) ? $recent_product->product_dimensions->size : 0,
                                      [
                                          'class' => 'form-control size  initial-balance-input m-0',
                                          'style' => 'border:2px solid #ccc',
                                      ],
                                  ) !!}

                                  @error('size')
                                      <label class="text-danger error-msg">{{ $message }}</label>
                                  @enderror
                              </div>

                              <div
                                  class="mb-2 col-md-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                  {!! Form::label('weight', __('lang.weight'), [
                                      'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                                      'style' => 'font-size: 12px;font-weight: 500;',
                                  ]) !!}
                                  {!! Form::text(
                                      'products[' . $key . '][weight]',
                                      isset($recent_product->product_dimensions->weight) ? $recent_product->product_dimensions->weight : 0,
                                      [
                                          'class' => 'form-control  initial-balance-input m-0',
                                          'style' => 'border:2px solid #ccc',
                                      ],
                                  ) !!}

                                  @error('weight')
                                      <label class="text-danger error-msg">{{ $message }}</label>
                                  @enderror
                              </div>

                              <div
                                  class="mb-2 col-md-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                                  {!! Form::label('variation', __('lang.basic_unit_for_import_product'), [
                                      'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                                      'style' => 'font-size: 12px;font-weight: 500;',
                                  ]) !!}
                                  <div class="input-wrapper">

                                      {!! Form::select('products[' . $key . '][variation_id]', [], null, [
                                          'class' => 'form-control select2',
                                          'placeholder' => __('lang.please_select'),
                                          'id' => 'products[' . $key . '][variation_id]',
                                      ]) !!}
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>


      <div class="accordion mb-1 animate__animated  animate__bounceInLeft">
          <div class="accordion-item d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
              style="border: none">
              <h2 class="accordion-header col-md-2 d-flex justify-content-end align-items-center">
                  <div class="accordion-button" style="width: 150px"
                      onclick="toggleProductAccordion(`productImage{{ $key }}`)">
                      <span class="productImage{{ $key }} mx-2">
                          <i class="fas fa-arrow-left d-flex justify-content-center align-items-center"
                              style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                      </span>
                      {{ __('lang.product_image') }}
                  </div>
              </h2>
              <div id="productImage{{ $key }}" class="accordion-content col-md-10">
                  <div class="accordion-body d-flex p-0">

                      {{-- crop image --}}
                      <div class="col-md-12 animate__animated  animate__bounceInRight">
                          <div class="row mx-0" style="border: 3px dashed #ddd;">

                              <div class="d-flex flex-column">
                                  <div class="d-flex justify-content-center align-items-center">
                                      <div class="variants">
                                          <div class='file file--upload w-100'>
                                              <div class="file-input">
                                                  <input type="file" name="file-input"
                                                      id="file-input-image{{ $key }}"
                                                      data-key="{{ $key }}" class="file-input__input" />
                                                  <label class="file-input__label m-4"
                                                      for="file-input-image{{ $key }}"
                                                      data-key="{{ $key }}">
                                                      <i class="fas fa-cloud-upload-alt"></i>&nbsp;
                                                      <span>{{ __('lang.upload_image') }}</span></label>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="preview-image-container{{ $key }}"
                                  style="display: flex !important;justify-content:center">
                              </div>
                          </div>
                      </div>
                      <div id="cropped_images{{ $key }}"></div>


                  </div>
              </div>
          </div>
      </div>



      {{--                     crop image --}}
      {{--        <div class="col-md-3"> --}}
      {{--            <input type="file" name="products[{{ $key }}][image]" class="form-control"> --}}
      {{--        </div> --}}
  </div>
  @include('products.partials.crop-multi-imge-modal', ['key' => $key])

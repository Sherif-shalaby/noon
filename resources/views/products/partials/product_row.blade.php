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
  </style>


  <div class="d-flex justify-content-start align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
      style="overflow-x: auto">
      <input type="hidden" name="products[{{ $key ?? 0 }}]" value="{{ $product->id ?? null }}">

      <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
          {{-- ++++++++++++++++ product name ++++++++++++++++ --}}
          <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1"
              style="width: 200px">
              {{-- {!! Form::label('name', __('lang.product_name'), [
                  'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 ' : 'mx-2 mb-0 ',
                  'style' => 'font-size: 12px;font-weight: 500;',
              ]) !!} --}}
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
                          'style' => 'border:2px solid #ccc;font-size: 12px;font-weight: 500;',
                          'placeholder' => __('lang.product_name'),
                      ],
                  ) !!}
                  <button class="add-button d-flex justify-content-center align-items-center" type="button"
                      data-toggle="collapse" data-target="#translation_table_product" aria-expanded="false"
                      aria-controls="collapseExample">
                      <i class="fas fa-globe"></i>
                  </button>
              </div>
              @error('products.' . $key . '.name')
                  <label class="text-danger error-msg">{{ $message }}</label>
              @enderror
              @include('layouts.translation_inputs', [
                  'attribute' => 'name',
                  'translations' =>
                      $key == 0 && isset($recent_product->translations) ? $recent_product->translations : [],
                  'type' => 'product',
              ])
          </div>
          {{-- ++++++++++++++++ product sku ++++++++++++++++ --}}
          <div class="mb-2  animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1"
              style="width: 75px">
              {{-- {!! Form::label('product_sku', __('lang.product_code'), [
                  'class' => app()->isLocale('ar') ? 'd-block text-end  mr-2 ml-0 mb-0 ' : 'mr-2 ml-0 mb-0 ',
                  'style' => 'font-size: 12px;font-weight: 500;',
              ]) !!} --}}
              {!! Form::text('products[' . $key . '][product_sku]', null, [
                  'class' => 'form-control initial-balance-input',
                  'style' => 'width:100%;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;',
                  'placeholder' => __('lang.product_code'),
              ]) !!}

              @error('products.' . $key . '.product_sku')
                  <label class="text-danger error-msg">{{ $message }}</label>
              @enderror
          </div>


          {{-- ++++++++++++++++ product symbol ++++++++++++++++ --}}
          <div class="mb-2 animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1"
              style="width: 75px">
              {{-- {!! Form::label('product_symbol', __('lang.product_symbol'), [
                  'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 ' : 'mx-2 mb-0 ',
                  'style' => 'font-size: 12px !important;font-weight: 500;',
              ]) !!} --}}
              {!! Form::text('products[' . $key . '][product_symbol]', null, [
                  'class' => 'form-control initial-balance-input',
                  'style' => 'width:100%;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;',
                  'placeholder' => __('lang.product_symbol'),
              ]) !!}

              @error('products.' . $key . '.product_symbol')
                  <label class="text-danger error-msg">{{ $message }}</label>
              @enderror
          </div>
          {{-- ++++++++++++++++ Brand ++++++++++++++++ --}}
          <div class=" mb-2 animate__animated animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1"
              style="width: 160px">
              {{-- {!! Form::label('brand', __('lang.brand'), [
                  'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0 ' : ' mb-0 ',
                  'style' => 'font-size: 12px;font-weight: 500;',
              ]) !!} --}}
              <div class="d-flex justify-content-center align-items-center"
                  style="background-color: #dedede;
                  border: none;
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
                          'placeholder' => __('lang.brand'),
                          'id' => 'brand_id' . $key,
                      ],
                  ) !!}
                  <button type="button"
                      class="add-button btn-add-modal d-flex justify-content-center align-items-center"
                      data-toggle="modal" data-key="{{ $key }}" data-target="#createBrandModal"><i
                          class="fas fa-plus"></i></button>

              </div>
          </div>
          {{-- +++++++++++++++++++++++ "balance return request"  +++++++++++++++++++++++ --}}
          <div class="mb-2 animate__animated  animate__bounceInLeft d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1"
              style="width: 75px">
              {{-- {!! Form::label('balance_return_request', __('lang.balance_return_request'), [
                  'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                  'style' => 'font-size: 12px;font-weight: 500;',
              ]) !!} --}}
              {!! Form::text('products[' . $key . '][balance_return_request]', null, [
                  'class' => 'form-control initial-balance-input',
                  'style' => 'width:100%;margin:0 !important;border:2px solid #ccc;font-size: 12px;font-weight: 500;',
                  'placeholder' => __('lang.balance_return_request'),
              ]) !!}
          </div>


      </div>


      <div class="accordion animate__animated  animate__bounceInLeft">
          <div class="accordion-item d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
              style="border: none">
              <h2 class="accordion-header p-0 d-flex justify-content-end align-items-center">
                  <div class="accordion-button"
                      onclick="toggleProductAccordion(`productCategories{{ $key }}`)">
                      <span class="productCategories{{ $key }} mx-2">
                          <i class="fas fa-arrow-left d-flex justify-content-center align-items-center"
                              style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                      </span>
                      {{ __('lang.categories') }}
                  </div>
              </h2>
              <div id="productCategories{{ $key }}" class="accordion-content p-0">
                  <div class="accordion-body d-flex p-0">
                      {{-- ++++++++++++++++ product categories ++++++++++++++++ --}}
                      <div class="col-md-12 p-0">
                          <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                              <div class=" px-1 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                  data-key="{{ $key }}" style="min-width: 135px;height: fit-content;">
                                  {{-- {!! Form::label('category', __('lang.category'), [
                                      'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                                      'style' => 'font-size: 12px;font-weight: 500;',
                                  ]) !!} --}}
                                  <div class="d-flex justify-content-center align-items-center"
                                      style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;
                                        ">
                                      {!! Form::select(
                                          'products[' . $key . '][category_id]',
                                          $categories1,
                                          $key == 0 && isset($recent_product->category_id) ? $recent_product->category_id : null,
                                          [
                                              'class' => 'form-control select2 category',
                                              'style' => 'font-size: 12px !important;font-weight: 500;',
                                              'placeholder' => __('lang.category'),
                                              'id' => 'categoryId' . $key,
                                          ],
                                      ) !!}
                                      <a data-href="{{ route('categories.sub_category_modal') }}"
                                          data-key="{{ $key }}" data-container=".view_modal"
                                          class="openCategoryModal btn-add-modal text-white add-button  d-flex justify-content-center align-items-center"
                                          style="cursor: pointer" data-toggle="modal" data-select_category="0"><i
                                              class="fas fa-plus"></i></a>
                                  </div>
                                  @error('products.' . $key . '.category_id')
                                      <label class="text-danger error-msg">{{ $message }}</label>
                                  @enderror
                              </div>


                              <div class=" px-1 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                  style="min-width: 135px;height: fit-content;">
                                  {{-- {!! Form::label('subcategory', __('lang.subcategory') . ' 1', [
                                      'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                                      'style' => 'font-size: 12px;font-weight: 500;',
                                  ]) !!} --}}
                                  <div class="d-flex justify-content-center align-items-center"
                                      style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                      {!! Form::select(
                                          'products[' . $key . '][subcategory_id1]',
                                          $categories2,
                                          $key == 0 && isset($recent_product->subcategory_id1) ? $recent_product->subcategory_id1 : null,
                                          [
                                              'class' => 'form-control select2 subcategory',
                                              'placeholder' => __('lang.subcategory'),
                                              'id' => 'subcategory_id1' . $key,
                                              'data-key' => $key,
                                          ],
                                      ) !!}
                                      <a data-href="{{ route('categories.sub_category_modal') }}"
                                          data-key="{{ $key }}" data-container=".view_modal"
                                          class="openCategoryModal text-white add-button btn-add-modal d-flex justify-content-center align-items-center"
                                          style="cursor: pointer" data-toggle="modal" data-select_category="1"><i
                                              class="fas fa-plus"></i></a>
                                  </div>
                                  @error('products.' . $key . '.category_id')
                                      <label class="text-danger error-msg">{{ $message }}</label>
                                  @enderror
                              </div>

                              <div class="px-1 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                  style="min-width: 135px;height: fit-content;">
                                  {{-- {!! Form::label('subcategory', __('lang.subcategory') . ' 2', [
                                      'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                                      'style' => 'font-size: 12px;font-weight: 500;',
                                  ]) !!} --}}
                                  <div class="d-flex justify-content-center align-items-center"
                                      style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                      {!! Form::select(
                                          'products[' . $key . '][subcategory_id2]',
                                          $categories3,
                                          $key == 0 && isset($recent_product->subcategory_id2) ? $recent_product->subcategory_id2 : null,
                                          [
                                              'class' => 'form-control select2 subcategory2',
                                              'placeholder' => __('lang.subcategory'),
                                              'id' => 'subCategoryId2' . $key,
                                              'data-key' => $key,
                                          ],
                                      ) !!}
                                      <a data-href="{{ route('categories.sub_category_modal') }}"
                                          data-key="{{ $key }}" data-container=".view_modal"
                                          class="openCategoryModal text-white add-button btn-add-modal d-flex justify-content-center align-items-center"
                                          style="cursor: pointer" data-toggle="modal" data-select_category="2"><i
                                              class="fas fa-plus"></i></a>
                                  </div>
                                  @error('products.' . $key . '.subcategory_id2')
                                      <label class="text-danger error-msg">{{ $message }}</label>
                                  @enderror
                              </div>

                              <div class="px-1 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                  style="min-width: 135px;height: fit-content;">
                                  {{-- {!! Form::label('subcategory', __('lang.subcategory') . ' 3', [
                                      'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                                      'style' => 'font-size: 12px;font-weight: 500;',
                                  ]) !!} --}}
                                  <div class="d-flex justify-content-center align-items-center"
                                      style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                                      {!! Form::select(
                                          'products[' . $key . '][subcategory_id3]',
                                          $categories4,
                                          $key == 0 && isset($recent_product->subcategory_id3) ? $recent_product->subcategory_id3 : null,
                                          [
                                              'class' => 'form-control select2 subcategory3',
                                              'placeholder' => __('lang.subcategory'),
                                              'id' => 'subCategoryId3' . $key,
                                              'data-key' => $key,
                                          ],
                                      ) !!}
                                      <a data-href="{{ route('categories.sub_category_modal') }}"
                                          data-key="{{ $key }}" data-container=".view_modal"
                                          class="  openCategoryModal text-white add-button btn-add-modal d-flex justify-content-center align-items-center"
                                          style="cursor: pointer" data-toggle="modal" data-select_category="3"><i
                                              class="fas fa-plus"></i></a>
                                  </div>
                                  @error('products.' . $key . '.subcategory_id3')
                                      <label class="text-danger error-msg">{{ $message }}</label>
                                  @enderror
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="accordion animate__animated  animate__bounceInLeft px-1">
          <div class="accordion-item d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
              style="border: none">
              <h2 class="accordion-header p-0 d-flex justify-content-end align-items-center">
                  <div class="accordion-button"
                      onclick="toggleProductAccordion(`productFilling{{ $key }}`)">
                      <span class="productFilling{{ $key }} mx-2">
                          <i class="fas fa-arrow-left d-flex justify-content-center align-items-center"
                              style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                      </span>
                      {{ __('lang.fill') }}
                  </div>
              </h2>
              <div id="productFilling{{ $key }}" class="accordion-content p-0">
                  <div class="accordion-body d-flex p-0">

                      <div class=" product_unit_raws[{{ $key }}] d-flex">
                          <div
                              class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">

                              <div class="px-1 animate__animated  animate__bounceInRight d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                  style="width: 75px">
                                  {{-- {!! Form::label('sku', __('lang.product_code'), ['class' => 'h5 pt-3']) !!} --}}

                                  {!! Form::text('products[' . $key . '][variations][0][sku]', $variation->sku ?? null, [
                                      'class' => 'form-control initial-balance-input',
                                      'style' => 'width:100%;margin:0 !important;border:2px solid #ccc',
                                      'placeholder' => __('lang.product_code'),
                                  ]) !!}

                                  @error('products.' . $key . '.variations.0.sku')
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
                                      <select name="products[{{ $key }}][variations][0][new_unit_id]"
                                          data-name='unit_id' data-index="0"
                                          class="form-control unit_select select2 unit_id0{{ $key ?? '' }}"
                                          style="width: 100px;" data-key="{{ $key }}"
                                          id="{{ $key }}>
                                          <option value="">{{ __('lang.large_filling') }}
                                          </option>
                                          @foreach ($units as $unit)
                                              <option @if ($key == 0 && isset($variation->unit_id) && $variation->unit_id == $unit->id) selected @endif
                                                  value="{{ $unit->id }}">{{ $unit->name }}</option>
                                          @endforeach
                                      </select>
                                      <button type="button"
                                          class="add-button btn-add-modal d-flex justify-content-center align-items-center add_unit_raw"
                                          data-toggle="modal" data-key="{{ $key }}" data-index="0"
                                          data-target=".add-unit" href="{{ route('units.create') }}"><i
                                              class="fas fa-plus"></i></button>
                                  </div>
                              </div>

                              <button
                                  class="btn btn-sm btn-primary add_small_unit animate__animated  animate__bounceInRight"
                                  type="button" data-key="{{ $key }}">
                                  <i class="fa fa-equals"></i>
                              </button>

                              @include('products.product_unit_raw')
                              <input type="hidden" id="raw_unit_index[{{ $key }}]" value="0" />
                          </div>
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
                  <div class="accordion-button"
                      onclick="toggleProductAccordion(`productDimension{{ $key }}`)">
                      <span class="productDimension{{ $key }} mx-2">
                          <i class="fas fa-arrow-left d-flex justify-content-center align-items-center"
                              style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                      </span>
                      {{ __('lang.product_dimensions') }}
                  </div>
              </h2>
          </div>
      </div>

      <div id='productDimension{{ $key }}' class="accordion-content ">
          <div class="accordion-body d-flex p-0">
              {{-- sizes --}}
              <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                  <div
                      class="mb-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif px-1">
                      {{-- {!! Form::label('variation', __('lang.basic_unit_for_import_product'), [
                              'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                              'style' => 'font-size: 12px;font-weight: 500;',
                          ]) !!} --}}
                      <div class="input-wrapper" style="width: 100%">

                          {!! Form::select('products[' . $key . '][variation_id]', [], null, [
                              'class' => 'form-control select2',
                              'placeholder' => __('lang.basic_unit_for_import_product'),
                              'id' => 'products[' . $key . '][variation_id]',
                          ]) !!}
                      </div>
                  </div>

                  <div
                      class="mb-2  animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                      {{-- {!! Form::label('length', __('lang.length'), [
                              'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                              'style' => 'font-size: 12px;font-weight: 500;',
                          ]) !!} --}}
                      {!! Form::text(
                          'products[' . $key . '][length]',
                          isset($recent_product->product_dimensions->length) ? $recent_product->product_dimensions->length : '',
                          [
                              'class' => 'form-control length  initial-balance-input m-0',
                              'style' => 'border:2px solid #ccc;width: 75px',
                              'placeholder' => __('lang.length'),
                          ],
                      ) !!}

                      @error('length')
                          <label class="text-danger error-msg">{{ $message }}</label>
                      @enderror
                  </div>

                  <div
                      class="mb-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                      {{-- {!! Form::label('width', __('lang.width'), [
                              'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                              'style' => 'font-size: 12px;font-weight: 500;',
                          ]) !!} --}}
                      {!! Form::text(
                          'products[' . $key . '][width]',
                          isset($recent_product->product_dimensions->width) ? $recent_product->product_dimensions->width : '',
                          [
                              'class' => 'form-control width  initial-balance-input m-0',
                              'style' => 'border:2px solid #ccc;width: 75px',
                              'placeholder' => __('lang.width'),
                          ],
                      ) !!}

                      @error('width')
                          <label class="text-danger error-msg">{{ $message }}</label>
                      @enderror
                  </div>

                  <div
                      class="mb-2  animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                      {{-- {!! Form::label('height', __('lang.height'), [
                              'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                              'style' => 'font-size: 12px;font-weight: 500;',
                          ]) !!} --}}
                      {!! Form::text(
                          'products[' . $key . '][height]',
                          isset($recent_product->product_dimensions->height) ? $recent_product->product_dimensions->height : '',
                          [
                              'class' => 'form-control height  initial-balance-input m-0',
                              'style' => 'border:2px solid #ccc;width: 75px',
                              'placeholder' => __('lang.height'),
                          ],
                      ) !!}

                      @error('height')
                          <label class="text-danger error-msg">{{ $message }}</label>
                      @enderror
                  </div>
                  <div
                      class="mb-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                      {{-- {!! Form::label('size', __('lang.size'), [
                              'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                              'style' => 'font-size: 12px;font-weight: 500;',
                          ]) !!} --}}
                      {!! Form::text(
                          'products[' . $key . '][size]',
                          isset($recent_product->product_dimensions->size) ? $recent_product->product_dimensions->size : '',
                          [
                              'class' => 'form-control size  initial-balance-input m-0',
                              'style' => 'border:2px solid #ccc;width: 75px',
                              'placeholder' => __('lang.size'),
                          ],
                      ) !!}

                      @error('size')
                          <label class="text-danger error-msg">{{ $message }}</label>
                      @enderror
                  </div>

                  <div
                      class="mb-2 animate__animated  animate__bounceInRight d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                      {{-- {!! Form::label('weight', __('lang.weight'), [
                              'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                              'style' => 'font-size: 12px;font-weight: 500;',
                          ]) !!} --}}
                      {!! Form::text(
                          'products[' . $key . '][weight]',
                          isset($recent_product->product_dimensions->weight)
                              ? $recent_product->product_dimensions->weight
                              : __('lang.weight'),
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
                  <div class="accordion-button" onclick="toggleProductAccordion(`productTax{{ $key }}`)">
                      <span class="productTax{{ $key }} mx-2">
                          <i class="fas fa-arrow-left d-flex justify-content-center align-items-center"
                              style="font-size: 0.8rem;color:black;background-color: white;width: 20px;height: 20px;border-radius: 50%"></i>
                      </span>
                      {{ __('lang.product_tax') }}
                  </div>
              </h2>
          </div>
      </div>

      <div id="productTax{{ $key }}" class="accordion-content">
          <div class="accordion-body d-flex flex-row p-0">
              {{-- +++++++++++++++++++++++ "tax_method" selectbox +++++++++++++++++++++++ --}}
              <div
                  class=" animate__animated  animate__bounceInRight mb-1 d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                  {{-- <label for="method" class=" @if (app()->isLocale('ar')) d-block text-end @endif mb-0"
                      style="font-size: 12px;font-weight: 500;">{{ __('lang.tax_method') . '*' }}</label> --}}
                  <div
                      style="background-color: #dedede; border: none;
                                                    border-radius: 16px;
                                                    color: #373737;
                                                    box-shadow: 0 8px 6px -5px #bbb;
                                                    width: 100%;
                                                    height: 30px;
                                                    flex-wrap: nowrap;">
                      <select name="products[{{ $key }}][method]" id="method{{ $key }}"
                          class='form-control select2' data-live-search='true'
                          placeholder="{{ __('lang.tax_method') }}">
                          <option value="">{{ __('lang.tax_method') }}</option>
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
                  class=" animate__animated  animate__bounceInRight mb-1 d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif pl-1">
                  {{-- <label for="product" class=" @if (app()->isLocale('ar')) d-block text-end @endif mb-0"
                      style="font-size: 12px;font-weight: 500;">{{ __('lang.product_tax') . ':*' }}</label> --}}
                  <div class="d-flex justify-content-center align-items-center"
                      style="background-color: #dedede; border: none;
                                                        border-radius: 16px;
                                                        color: #373737;
                                                        box-shadow: 0 8px 6px -5px #bbb;

                                                        height: 30px;
                                                        flex-wrap: nowrap;">
                      <select name="products[{{ $key }}][product_tax_id]"
                          id="product_tax{{ $key }}" class="form-control select2"
                          placeholder="{{ __('lang.product_tax') }}">
                          <option value="">{{ __('lang.product_tax') }}</option>
                          @foreach ($product_tax as $tax)
                              <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                          @endforeach
                      </select>
                      <button type="button"
                          class="add-button btn-add-modal d-flex justify-content-center align-items-center"
                          data-toggle="modal" data-target="#add_product_tax_modal" data-key="{{ $key }}"
                          data-select_category="2"><i class="fas fa-plus"></i></button>
                  </div>
              </div>
          </div>
      </div>



      <input type="file" name="file-input" id="file-input-image{{ $key }}"
          data-key="{{ $key }}" class="file-input__input" />
      <label class="file-input__label m-0" for="file-input-image{{ $key }}" data-key="{{ $key }}"
          style="width: 35px;height: 35px;">
          <i class="fas fa-camera"></i>
      </label>


      <div class="preview-image-container{{ $key }}"
          style="display: flex !important;justify-content:center">
      </div>

      <div id="cropped_images{{ $key }}"></div>

  </div>


  @include('products.partials.crop-multi-imge-modal', ['key' => $key])

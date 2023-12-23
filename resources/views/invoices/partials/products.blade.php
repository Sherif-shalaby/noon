<div class="col-xl-2 p-0 special-col animate__animated animate__bounceInLeft"
    style="animation-delay: 1.55s;height: 600px;overflow: scroll">
    <div class="card-app">
        <div class="title-card-app">
            الاقسام
            <div for="" class="d-flex justify-content-center align-items-center text-nowrap gap-1" wire:ignore>
                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                    style="padding: 2px">
                    {{-- الاقسام --}}
                    <div class="col-md-4  d-flex flex-column" style="padding: 2px">

                        <select class="form-control depart1 select2" wire:model="department_id1"
                            data-name="department_id1">
                            <option value="0 " readonly selected>اختر </option>
                            @foreach ($departments as $depart)
                                @if ($depart->parent_id === 1)
                                    <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                    {{-- @if ($depart->subCategories->count() > 0) --}}
                                    {{-- @include('categories.category-select', ['categories' => $depart->subCategories, 'prefix' => '-']) --}}
                                    {{-- @endif --}}
                                @endif
                            @endforeach
                        </select>


                        <select class="form-control depart select2" wire:model="department_id2"
                            data-name="department_id2">
                            <option value="0 " readonly selected>اختر </option>
                            @foreach ($departments as $depart)
                                @if ($depart->parent_id === 2)
                                    <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                    {{-- @if ($depart->subCategories->count() > 0) --}}
                                    {{-- @include('categories.category-select', ['categories' => $depart->subCategories, 'prefix' => '-']) --}}
                                    {{-- @endif --}}
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4  d-flex flex-column" style="padding: 2px">
                        <select class="form-control depart select2" wire:model="department_id3"
                            data-name="department_id3">
                            <option value="0 " readonly selected>اختر </option>
                            @foreach ($departments as $depart)
                                @if ($depart->parent_id === 3)
                                    <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                    {{-- @if ($depart->subCategories->count() > 0) --}}
                                    {{-- @include('categories.category-select', ['categories' => $depart->subCategories, 'prefix' => '-']) --}}
                                    {{-- @endif --}}
                                @endif
                            @endforeach
                        </select>

                        <select class="form-control depart select2" wire:model="department_id4"
                            data-name="department_id4">
                            <option value="0 " readonly selected>اختر </option>
                            @foreach ($departments as $depart)
                                @if ($depart->parent_id === 4)
                                    <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                    {{-- @if ($depart->subCategories->count() > 0) --}}
                                    {{-- @include('categories.category-select', ['categories' => $depart->subCategories, 'prefix' => '-']) --}}
                                    {{-- @endif --}}
                                @endif
                            @endforeach
                        </select>

                    </div>
                    <div class="col-md-4  d-flex flex-column" style="padding: 2px">

                        {!! Form::label('brand_id', __('lang.brand') . '*', [
                            'class' => 'mb-3',
                            'style' => 'font-size: 12px;font-weight: 500;',
                        ]) !!}

                        {!! Form::select('brand_id', $brands, $brand_id, [
                            'class' => 'select2 form-control',
                            'data-live-search' => 'true',
                            'id' => 'brand_id',
                            'required',
                            'placeholder' => __('lang.please_select'),
                            'data-name' => 'brand_id',
                            'wire:model' => 'brand_id',
                        ]) !!}
                        @error('brand_id')
                            <span style="font-size: 12px;font-weight: 500;"
                                class="error text-danger">{{ $message }}</span>
                        @enderror

                    </div>




                </div>
            </div>
        </div>
        <div class="p-1 body-card-app">
            <div class="nav nav-pills main-tap " id="v-pills-tab" role="tablist" aria-orientation="vertical">
                {{-- <div class="row flex-wrap" style="width: 100%"> --}}
                @if ($allproducts and $allproducts != null)
                    @forelse ($allproducts as $product)
                        <div class="col-md-6 d-flex justify-content-between flex-column align-items-center p-0 order-btn"
                            wire:click='add_product({{ $product->id }})'
                            style="min-height: 50px;border:1px solid #ccc;">
                            @if ($product->image)
                                <div style="width: 60px;height: 60px;">
                                    <img src="{{ asset('uploads/products/' . $product->image) }}"
                                        alt="{{ $product->name }}" class=""
                                        style="width:100%;
                                            height:100%">
                                </div>
                            @else
                                <div style="width: 60px;height: 60px;">
                                    <img src="{{ asset('uploads/' . $settings['logo']) }}" alt="{{ $product->name }}"
                                        class=""
                                        style="width:100%;
                                            height:100%">
                                </div>
                            @endif
                            <div>
                                <span
                                    style="width: 100%;font-size: 12px;font-weight: 500; word-break: break-all;display: block;">{{ $product->sku }}
                                </span>
                                <span
                                    style="width: 100%;font-size: 12px;font-weight: 500; word-break: break-all;display: block;">{{ $product->name }}</span>
                                {{--                                            <span class="badge badge-{{ $product->productdetails?->quantity_available < 1 ? 'danger': 'success' }}"> --}}
                                {{--                                                {{ $product->store?->quantity_available < 1 ? __('out_of_stock'): __('available') }} --}}
                                {{--                                            </span> --}}
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <span>عفوا لايوجد منتجات فى هذا القسم</span>
                        </div>
                    @endforelse
                @else
                    <p>جميع المنتجات</p>
                    @foreach ($variations as $variation)
                        <div class="col-md-6 order-btn" wire:click='add_product({{ $variation->id }})'>
                            @if ($product->image)
                                <img src="{{ asset('uploads/products/' . $product->image) }}"
                                    alt="{{ $variation->product->name }}" class="img-thumbnail" width="100px">
                            @else
                                <img src="{{ asset('uploads/' . $settings['logo']) }}"
                                    alt="{{ $variation->product->name }}" class="img-thumbnail" width="100px">
                            @endif
                            <div>
                                <span>{{ $variation->sku }} </span>
                                <span>{{ $variation->product->name }}</span>
                            </div>
                            <hr />
                    @endforeach
                @endif
                {{-- </div> --}}
            </div>
        </div>
    </div>
</div>

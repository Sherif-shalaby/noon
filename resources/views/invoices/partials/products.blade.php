<div class="col-xl-3 p-0 special-col" style="height: 300px;overflow: scroll">
    <div class="card-app">
        <div class="title-card-app">
            الاقسام
            <div for="" class="d-flex align-items-center text-nowrap gap-1" wire:ignore>
                {{-- الاقسام --}}
                <select class="form-control depart select2" wire:model="department_id" data-name="department_id">
                    <option value="0 " readonly selected>اختر </option>
                    @foreach ($departments as $depart)
                        @if ($depart->parent_id === null)
                            <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                            @if ($depart->subCategories->count() > 0)
                                @include('categories.category-select', [
                                    'categories' => $depart->subCategories,
                                    'prefix' => '-',
                                ])
                            @endif
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="p-1">
            <div class="nav nav-pills main-tap " id="v-pills-tab" role="tablist" aria-orientation="vertical">
                {{-- <div class="row flex-wrap" style="width: 100%"> --}}
                @if ($allproducts and $allproducts != null)
                    @forelse ($allproducts as $product)
                        <div class="col-md-4 d-flex justify-content-between flex-column align-items-center p-0 order-btn"
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

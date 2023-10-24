<div class="col-xl-2 special-col">
    <div class="card-app" >
        <div class="title-card-app">
            الأصناف الرئيسية
            <div for="" class="d-flex align-items-center text-nowrap gap-1" wire:ignore>
                {{-- الاقسام --}}
                <select class="form-control depart" wire:model="department_id">
                    <option  value="0 " readonly selected >اختر </option>
                    @foreach ($departments as $depart)
                        <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="body-card-app">
            <div class="nav flex-column nav-pills main-tap " id="v-pills-tab" role="tablist"
                 aria-orientation="vertical">
                 <div class="row">
                    @if($allproducts and $allproducts != null)
                        @forelse ($allproducts as $product)
                            <div class="col-md-6 order-btn" wire:click='add_product({{ $product->id }})' >
                                @if ($product->image)
                                    <img src="{{ asset('uploads/products/' . $product->image) }}"
                                        alt="{{ $product->name }}" class="img-thumbnail" width="100px">
                                @else
                                    <img src="{{ asset('uploads/'.$settings['logo']) }}" alt="{{ $product->name }}"
                                        class="img-thumbnail" width="100px">
                                @endif
                                <div>
                                    <span>{{ $product->sku }} </span>
                                    <span>{{ $product->name }}</span>
                                    {{--                                            <span class="badge badge-{{ $product->productdetails?->quantity_available < 1 ? 'danger': 'success' }}">--}}
                                    {{--                                                {{ $product->store?->quantity_available < 1 ? __('out_of_stock'): __('available') }}--}}
                                    {{--                                            </span>--}}
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
                            <div class="col-md-6 order-btn" wire:click='add_product({{ $variation->id }})' >
                                @if ($product->image)
                                    <img src="{{ asset('uploads/products/' . $product->image) }}"
                                        alt="{{ $variation->product->name }}" class="img-thumbnail" width="100px">
                                @else
                                    <img src="{{ asset('uploads/'.$settings['logo']) }}" alt="{{ $variation->product->name }}"
                                        class="img-thumbnail" width="100px">
                                @endif
                                <div>
                                    <span>{{ $variation->sku }} </span>
                                    <span>{{ $variation->product->name }}</span>
                            </div>
                            <hr/>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-12 col-2">
    <div class="card-app">

        <div class="body-card-app w">
            <div class="nav flex-column nav-pills main-tap " id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <div class="row">
                    @if ($allproducts)
                        @forelse ($allproducts as $product)
                            <div class="col-md-3 mb-1 order-btn" wire:click='add_product({{ $product->id }})'>
                                @if ($product->image)
                                    <img src="{{ asset('uploads/products/' . $product->image) }}"
                                        alt="{{ $product->name }}" class="img-thumbnail" width="100px;"
                                        style="height: 55px!important">
                                @else
                                    <img src="{{ asset('uploads/' . $settings['logo']) }}" alt="{{ $product->name }}"
                                        class="img-thumbnail" width="100px;" style="height: 55px!important">
                                @endif
                                <div>
                                    <span>{{ $product->name }}</span>

                                </div>

                            </div>
                        @empty
                            <div class="col-md-12">
                                <span>عفوا لايوجد منتجات فى هذا القسم</span>
                            </div>
                        @endforelse
                    @else
                        <p>جميع المنتجات</p>
                        {{-- @foreach ($variations as $variation)
                            <div class="col-md-4 order-btn" wire:click='add_product({{ $variation->id }})' >
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
                        @endforeach --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

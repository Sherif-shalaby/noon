<div class="row mb-2">
    <div class="col-xl-2 ">
    </div>
    <div class="col-xl-7 ">
        <div class="row">
            <div class="col-md-3 m-t-15">
                <div class="search-box input-group">
                    <input type="search" name="search_by_product_symbol" id="search_by_product_symbol" wire:model.debounce.200ms="search_by_product_symbol"
                           placeholder="@lang('lang.enter_product_symbol')"
                           class="form-control" autocomplete="off">

                    @if(!empty($search_by_product_symbol))
                        <ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2" style="top: 37.423px; left: 39.645px; width: 90.2%;overflow: auto !important;height: 600px !important; border: 1px solid #ccc !important;">
                            @foreach($search_result as $product)
                                <li class="ui-menu-item" wire:click="add_product({{$product->id}})">
                                    <div id="ui-id-73" tabindex="-1" class="ui-menu-item-wrapper">
                                        @if ($product->image)
                                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                 alt="{{ $product->name }}" class="img-thumbnail" width="100px">
                                        @else
                                            <img src="{{ asset('uploads/'.$settings['logo']) }}" alt="{{ $product->name }}"
                                                 class="img-thumbnail" width="100px">
                                        @endif
                                        {{$product->product_symbol ?? ''}} - {{$product->name}}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    {{--                                    {{$search_result->links()}}--}}
                </div>
            </div>
            <div class="col-md-7 m-t-15">
                <div class="search-box input-group">
                    <button type="button" class="btn btn-secondary" id="search_button"><i
                            class="fa fa-search"></i>
                    </button>
                    <input type="search" name="search_product" id="search_product" wire:model.debounce.200ms="searchProduct"
                        placeholder="@lang('lang.enter_product_name_to_print_labels')"
                        class="form-control" autocomplete="off">

                    @if(!empty($search_result) && !empty($searchProduct))
                        <ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2" style="top: 37.423px; left: 39.645px; width: 90.2%;overflow: auto !important;height: 600px !important; border: 1px solid #ccc !important;">
                            @foreach($search_result as $product)
                                <li class="ui-menu-item" wire:click="add_product({{$product->id}})">
                                    <div id="ui-id-73" tabindex="-1" class="ui-menu-item-wrapper">
                                        @if ($product->image)
                                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                 alt="{{ $product->name }}" class="img-thumbnail" width="100px">
                                        @else
                                            <img src="{{ asset('uploads/'.$settings['logo']) }}" alt="{{ $product->name }}"
                                                 class="img-thumbnail" width="100px">
                                        @endif
                                            {{$product->sku ?? ''}} - {{$product->name}}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 ">
    </div>

</div>

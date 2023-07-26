@php
    $index=$index??'';
@endphp

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#select_products_modal"
        style="margin-top: 15px;">
    @lang('lang.select_products')
</button>
<div class="modal fade" id="select_products_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" wire:ignore
     aria-hidden="true" style="width: 100%;">
    <div class="modal-dialog modal-lg" role="document" id="select_products_modal">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">@lang( 'lang.select_products' )</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table id="product_selection_table" class="table" style="width: auto">
                        <thead>
                        <tr>
                            <th>@lang('lang.select')</th>
                            <th>@lang('lang.image')</th>
                            <th>@lang('lang.product_name')</th>
                            <th>@lang('lang.sku')</th>
                            <th>@lang('lang.category')</th>
                            <th>@lang('lang.subcategories_name')</th>
                            <th>@lang('lang.height')</th>
                            <th>@lang('lang.length')</th>
                            <th>@lang('lang.width')</th>
                            <th>@lang('lang.size')</th>
                            <th>@lang('lang.unit')</th>
                            <th>@lang('lang.weight')</th>
                            <th>@lang('lang.stores')</th>
                            <th>@lang('lang.brand')</th>
                            <th>@lang('lang.discount')</th>
                            <th>@lang('added_by')</th>
                            <th>@lang('updated_by')</th>
                            <th>@lang('lang.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $index=>$product)
                            <tr>
                                <td>
                                    <input type="checkbox" name="product_selected" class="product_selected" value="{{$product->id}}" wire:model="selectedProducts"/>
                                </td>
                                <td><img src="{{!empty($product->image)?'/uploads/products/'.$product->image:'/uploads/'.$settings['logo']}}" style="width: 50px; height: 50px;" alt="{{ $product->name }}" ></td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->sku}}</td>
                                <td>{{$product->category->name}}</td>
                                <td>
                                    @foreach($product->subcategories as $subcategory)
                                        {{$subcategory->name}}<br>
                                    @endforeach
                                </td>
                                <td>{{$product->height}}</td>
                                <td>{{$product->length}}</td>
                                <td>{{$product->width}}</td>
                                <td><span class="text-primary">{{$product->size}}</span></td>
                                <td>{{!empty($product->unit)?$product->unit->name:''}}</td>
                                <td>{{$product->weight}}</td>
                                <td>
                                    @foreach($product->stores as $store)
                                        {{$store->name}}<br>
                                    @endforeach
                                </td>
                                <td>{{!empty($product->brand)?$product->brand->name:''}}</td>
                                <td>
                                    @foreach($product->product_prices as $price)
                                        {{$price->price_category." : ".$price->price}} <br>
                                    @endforeach
                                </td>
                                <td>
                                    @if ($product->created_by  > 0 and $product->created_by != null)
                                        {{ $product->created_at->diffForHumans() }} <br>
                                        {{ $product->created_at->format('Y-m-d') }}
                                        ({{ $product->created_at->format('h:i') }})
                                        {{ ($product->created_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                        {{ $product->createBy?->name }}
                                    @else
                                        {{ __('no_update') }}
                                    @endif
                                </td>
                                <td>
                                    @if ($product->edited_by  > 0 and $product->edited_by != null)
                                        {{ $product->updated_at->diffForHumans() }} <br>
                                        {{ $product->updated_at->format('Y-m-d') }}
                                        ({{ $product->updated_at->format('h:i') }})
                                        {{ ($product->updated_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                        {{ $product->updateBy?->name }}
                                    @else
                                        {{ __('no_update') }}
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <li>

                                                <a href="{{route('products.edit', $product->id)}}" class="btn" target="_blank"><i class="dripicons-document-edit"></i> @lang('lang.update')</a>

                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a data-href="{{route('products.destroy', $product->id)}}"
                                                   {{-- data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}" --}}
                                                   class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                    @lang('lang.delete')</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            {{-- @include('products.edit',$product) --}}
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="16" style="text-align: right">@lang('lang.total')</th>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="add-selected-btn" wire:click="fetchSelectedProducts()">@lang( 'lang.add' )</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'lang.close' )</button>
            </div>

        </div>
    </div>
</div>

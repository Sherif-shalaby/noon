
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header d-flex align-items-center">

                        @if (!empty($is_raw_material))
                            <h4>@lang('lang.add_stock_for_raw_material')</h4>
                        @else
                            <h4>@lang('lang.add-stock')</h4>
                        @endif
                    </div>
                    {!! Form::open([ 'id' => 'add_stock_form']) !!}
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    {!! Form::label('store_id', __('lang.store') . ':*', []) !!}
                                    {!! Form::select('store_id', $stores, !empty($recent_stock)&&!empty($recent_stock->store_id)?$recent_stock->store_id:session('user.store_id'), ['class' => 'select form-control', 'data-live-search' => 'true', 'required', 'placeholder' => __('lang.please_select'), 'wire:model' => 'store_id']) !!}
                                    @error('store_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-8 m-t-15 offset-md-1">
                                <div class="search-box input-group">
                                    <button type="button" class="btn btn-secondary" id="search_button"><i
                                            class="fa fa-search"></i>
                                    </button>
                                    <input type="search" name="search_product" id="search_product" wire:model.debounce.500ms="searchProduct"
                                           placeholder="@lang('lang.enter_product_name_to_print_labels')"
                                           class="form-control" autocomplete="off">
                                    <button type="button" class="btn btn-success  btn-modal"
                                            data-href="{{ route('products.create') }}?quick_add=1"
                                            data-container=".view_modal"><i class="fa fa-plus"></i>
                                    </button>
                                    @if(!empty($search_result))
                                        <ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2" style="top: 37.423px; left: 39.645px; width: 90.9%;">
                                            @foreach($search_result as $product)
                                                <li class="ui-menu-item" wire:click="fetchProduct({{$product->id}})">
                                                    <div id="ui-id-73" tabindex="-1" class="ui-menu-item-wrapper">
                                                        <img src="https://mahmoud.s.sherifshalaby.tech/uploads/995_image.png" width="50px" height="50px">
                                                         {{$product->sku ?? ''}} - {{$product->name}}
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
{{--                                    {{$search_result->links()}}--}}
                                </div>

                            </div>
                            <div class="col-md-2">
{{--                                <button type="button" id="dollar_section" class="btn btn-primary ml-4" style="margin-top: 15px;" wire:click="ShowDollarCol"> <i class="fa fa-eye-slash" aria-hidden="true"></i> </button>--}}

{{--                                @include('quotation.partials.product_selection')--}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table" style="width: auto" >
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        {{--                                        <th style="width: 7%" class="col-sm-8">@lang('lang.image')</th>--}}
                                        <th style="width: 10%" class="col-sm-8">@lang('lang.products')</th>
                                        <th style="width: 10%" >@lang('lang.sku')</th>
                                        <th style="width: 10%">@lang('lang.quantity')</th>
                                        <th style="width: 10%">@lang('lang.unit')</th>
                                        <th style="width: 10%">@lang('lang.fill')</th>
                                        <th style="width: 10%">@lang('lang.total_quantity')</th>
                                        @if ($showColumn)
                                            <th style="width: 10%">@lang('lang.purchase_price') (@lang('lang.per_piece')) $</th>
                                            <th style="width: 10%">@lang('lang.selling_price') $</th>
                                            <th style="width: 10%">@lang('lang.sub_total') $</th>
                                        @endif
                                        <th style="width: 10%">@lang('lang.purchase_price') (@lang('lang.per_piece')) </th>
                                        <th style="width: 10%">@lang('lang.selling_price') </th>
                                        <th style="width: 10%">@lang('lang.sub_total')</th>
                                        <th style="width: 10%">@lang('lang.size')</th>
                                        <th style="width: 10%">@lang('lang.total_size')</th>
                                        <th style="width: 10%">@lang('lang.weight')</th>
                                        <th style="width: 10%">@lang('lang.total_weight')</th>
                                        @if ($showColumn)
                                            <th style="width: 10%">@lang('lang.cost') (@lang('lang.per_piece')) $</th>
                                            <th style="width: 10%">@lang('lang.total_cost') $</th>
                                        @endif
                                        <th style="width: 10%">@lang('lang.cost') (@lang('lang.per_piece'))</th>
                                        <th style="width: 10%">@lang('lang.total_cost')</th>
                                        <th style="width: 10%">@lang('lang.new_stock')</th>
                                        <th style="width: 10%">@lang('lang.change_current_stock')</th>
                                        <th style="width: 10%">@lang('lang.action')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($selectedProductData) && !empty($selectedProductData) )
                                        @foreach($selectedProductData  as $index => $product)
{{--                                            {{$selectedProductData}}--}}
                                            @include('add-stock.partials.product_row')
                                        @endforeach
                                        <tr>
                                            <td colspan="9" style="text-align: right"> @lang('lang.total')</td>
                                            @if ($showColumn)
                                                <td> {{$this->sum_dollar_tsub_total()}} </td>
                                                <td></td>
                                                <td></td>
                                            @endif
                                            <td> {{$this->sum_sub_total()}} </td>
                                            <td></td>
                                            <td style="">
                                                {{$this->sum_size() ?? 0}}
                                            </td>
                                            <td></td>
                                            <td  style=";">
                                                {{$this->sum_weight() ?? 0}}
                                            </td>
                                            <td></td>
                                            @if ($showColumn)
                                                <td>
                                                    {{$this->sum_dollar_total_cost() ?? 0}}
                                                </td>
                                                <td></td>
                                            @endif
                                            <td  style=";">
                                                {{$this->sum_total_cost() ?? 0}}
                                            </td>

                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 text-center mt-1 ">
                            <h4>@lang('lang.items_count'):
                                <span class="items_count_span" style="margin-right: 15px;">{{count($selectedProductData)}}</span>
                                <br> @lang('lang.items_quantity'): <span
                                    class="items_quantity_span" style="margin-right: 15px;">{{array_sum($quantity)}}</span>
                            </h4>
                        </div>
                        <br>
                    </div>
                    {!! Form::close() !!}
                    <div class="col-sm-12">
                        <button type="submit" name="submit" id="submit-save" style="margin: 10px" value="save"
                                class="btn btn-primary pull-right btn-flat submit" wire:click.prevent = "store()">@lang( 'lang.save' )</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{--<!-- This will be printed -->--}}
<div class="view_modal no-print" ></div>
<section class="invoice print_section print-only" id="receipt_section"> </section>


@push('javascripts')
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.hook('message.processed', (message, component) => {
                if (message.updateQueue && message.updateQueue.some(item => item.payload.event === 'updated:selectedProducts')) {
                    $('.product_selected').on('click', function (event) {
                        event.stopPropagation();
                        var value = $(this).prop('checked');
                        var productId = $(this).val();
                        Livewire.find(component.fingerprint).set('selectedProducts.' + productId, value);
                    });
                }
            });
        });
        document.addEventListener('livewire:load', function () {
            Livewire.on('closeModal', function () {
                // Close the modal using Bootstrap's modal API
                $('#select_products_modal').modal('hide');
            });
        });

        document.addEventListener('livewire:load', function () {
            Livewire.on('printInvoice', function (htmlContent) {
                // Set the generated HTML content
                // $("#receipt_section").html(htmlContent);

                // Trigger the print action
                window.print();
            });
        });

    </script>
@endpush

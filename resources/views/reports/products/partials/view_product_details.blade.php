<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $product->name }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <label style="font-weight: bold;" for="">@lang('lang.sku'): </label>
                                {{ $product->sku }} <br>
                                <label style="font-weight: bold;" for="">@lang('lang.category'): </label>
                                {{ $product->category->name ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.subcategories_name'): </label>
                                {{ $product->subCategory1->name ?? '' }} <br>
                                {{ $product->subCategory2->name ?? '' }} <br>
                                {{ $product->subCategory3->name ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.brand'): </label>
                                {{ $product->brand->name ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.unit'): </label>
                                @if (!empty($product->variations))
                                    @foreach ($product->variations as $variant)
                                        @if (!empty($variant->unit_id->name))
                                            {{ $variant->unit_id->name }} = {{ $variant->equal }}
                                            {{ $variant->basic_unit_id->name }}<br>
                                        @endif
                                    @endforeach
                                @endif
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.tax'): </label>
                                @if (!empty($product->tax->name))
                                    {{ $product->tax->name }}
                                @endif
                                <br>
                            </div>
                            <div class="col-md-6">
                                <label style="font-weight: bold;" for="">@lang('lang.height'): </label>
                                {{ $product->height ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.length'): </label>
                                {{ $product->length ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.width'): </label>
                                {{ $product->width ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.size'): </label>
                                {{ $product->size ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.weight'): </label>
                                {{ $product->weight ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.created_by'): </label>
                                {{ $product->createBy?->name ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.updated_by'): </label>
                                {{ $product->updatedBy?->name ?? '' }}
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-sm-12 col-md-12 invoice-col">
                            <div class="thumbnail">
                                <img src="{{ !empty($product->image) ? '/uploads/products/' . $product->image : '/uploads/' . $settings['logo'] }}"
                                    class="img-fluid" alt="{{ $product->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <br>
                        <h4>@lang('lang.stock_details')</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-success text-white">
                                    <th>@lang('lang.name')</th>
                                    <th>@lang('lang.sku')</th>
                                    <th>@lang('lang.store_name')</th>
                                    <th>@lang('lang.current_stock')</th>
                                    <th>@lang('lang.unit')</th>
                                    {{--                                <th>@lang('lang.selling_price')</th> --}}
                                    {{--                                <th>@lang('lang.selling_price') $ </th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stock_details as $stock_detail)
                                    <tr>
                                        <td>
                                            {{ $stock_detail->product->name }}
                                        </td>
                                        <td>{{ $stock_detail->product->sku ?? '' }}</td>
                                        <td>{{ $stock_detail->store->name ?? '' }}</td>
                                        <td>{{ @num_format($stock_detail->quantity_available) }}</td>
                                        <td> {{ $stock_detail->variations->unit->name ?? '' }}</td>
                                        {{--                                    <td>{{ @num_format($stock_detial->price) }}</td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <br>
                        <h4>@lang('lang.sales')</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-success text-white">
                                    <th>@lang('lang.name')</th>
                                    <th>@lang('lang.sku')</th>
                                    <th>@lang('lang.invoice_no')</th>
                                    <th>@lang('lang.date')</th>
                                    <th>@lang('lang.quantity')</th>
                                    <th>@lang('lang.price')</th>
                                    <th>@lang('lang.price') $</th>
                                    <th>@lang('lang.discount')</th>
                                    <th>@lang('lang.sub_total')</th>
                                    <th>@lang('lang.sub_total') $</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>
                                            @if (!empty($sale->variation->name) && $sale->variation->name != 'Default')
                                                {{ $sale->variation->name }}
                                            @else
                                                {{ $sale->product->name }}
                                            @endif
                                        </td>
                                        <td>{{ $sale->variation->sub_sku ?? '' }}</td>
                                        <td>{{ $sale->transaction->invoice_no ?? '' }}</td>
                                        <td>{{ !empty($sale->transaction->transaction_date) ? @format_date($sale->transaction->transaction_date) : '' }}
                                        </td>
                                        <td>{{ @num_format($sale->quantity) }}</td>
                                        <td>{{ @num_format($sale->sell_price) }}</td>
                                        <td>{{ @num_format($sale->dollar_sell_price) }}</td>
                                        <td>{{ @num_format($sale->product_discount_amount) }}</td>
                                        <td>{{ @num_format($sale->sub_total) }}</td>
                                        <td>{{ @num_format($sale->dollar_sub_total) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">@lang('lang.total'):</th>
                                    <td>{{ @num_format($sales->sum('quantity')) }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ @num_format($sales->sum('product_discount_amount')) }}</td>
                                    <td>{{ @num_format($sales->sum('sub_total')) }}</td>
                                    <td> {{ @num_format($sales->sum('dollar_sub_total')) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <br>
                        <h4>@lang('lang.add_stock')</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-success text-white">
                                    <th>@lang('lang.name')</th>
                                    <th>@lang('lang.sku')</th>
                                    <th>@lang('lang.invoice_no')</th>
                                    <th>@lang('lang.date')</th>
                                    <th>@lang('lang.quantity')</th>
                                    <th>@lang('lang.price')</th>
                                    <th>@lang('lang.price') $</th>
                                    <th>@lang('lang.sub_total')</th>
                                    <th>@lang('lang.sub_total')$</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($add_stocks as $add_stock)
                                    <tr>
                                        <td>
                                            @if (!empty($add_stock->variation->name) && $add_stock->variation->name != 'Default')
                                                {{ $add_stock->variation->name }}
                                            @else
                                                {{ $add_stock->product->name }}
                                            @endif
                                        </td>
                                        <td>{{ $add_stock->variation->sub_sku ?? '' }}</td>
                                        <td>{{ $add_stock->transaction->invoice_no ?? '' }}</td>
                                        <td>{{ !empty($add_stock->transaction->transaction_date) ? @format_date($add_stock->transaction->transaction_date) : '' }}
                                        </td>
                                        <td>{{ @num_format($add_stock->quantity) }}</td>
                                        <td>{{ @num_format($add_stock->purchase_price) }}</td>
                                        <td>{{ @num_format($add_stock->dollarpurchase_price) }}</td>
                                        <td>{{ @num_format($add_stock->sub_total) }}</td>
                                        <td>{{ @num_format($add_stock->dollar_sub_total) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">@lang('lang.total'):</th>
                                    <td>{{ @num_format($add_stocks->sum('quantity')) }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ @num_format($add_stocks->sum('sub_total')) }}</td>
                                    <td>{{ @num_format($add_stocks->sum('dollar_sub_total')) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('lang.close')</button>
            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

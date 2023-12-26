<div>
    <div class="card-body">
        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
        <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
            <div class="div1"></div>
        </div>
        <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
            <div class="div2 table-scroll-wrapper">
                <!-- content goes here -->
                <div style="min-width: 1300px;max-height: 90vh;overflow: auto">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('lang.image')</th>
                                <th style="">@lang('lang.name')</th>
                                <th>@lang('lang.product_code')</th>
                                <th class="sum">@lang('lang.current_stock')</th>
                                <th>@lang('lang.quantity_to_be_removed')</th>
                                <th>@lang('lang.expired_stock')</th>
                                <th>@lang('lang.date_of_expired_stock')</th>
                                <th>@lang('lang.date_of_purchase_of_the_expired_stock')</th>
                                <th>@lang('lang.avg_purchase_price')</th>
                                <th>@lang('lang.value_of_removed_stock')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($addStockLines))
                                @foreach ($addStockLines as $i => $stock_line)
                                    <tr>
                                        <td><img src="{{ $stock_line->product->image }}" height="50px" width="50px">
                                        </td>
                                        <td>
                                            <input type="hidden" wire:model="rows.{{ $i }}.stock_line_id" />
                                            {{-- @if ($stock_line->variation->name != 'Default') --}}
                                            {{ $stock_line->variation->unit->name }}
                                            {{-- @else
                                Default
                            @endif --}}
                                        </td>
                                        <td>{{ $stock_line->variation->sku ?? '' }}</td>
                                        <td>{{ number_format($stock_line->avail_current_stock - $stock_line->expired_current_stock, 3) }}
                                        </td>
                                        <td> <input type="text"
                                                wire:model="rows.{{ $i }}.quantity_to_remove"
                                                wire:change="changeStockRemovedValue({{ $i }})" /></td>
                                        <td>{{ $stock_line->expired_current_stock }}</td>
                                        <td>{{ $stock_line->exp_date }}</td>
                                        <td>{{ $stock_line->date_of_purchase_of_the_expired_stock_removed }}</td>
                                        <td>{{ number_format($stock_line->avg_purchase_price) }}
                                            {{-- <input type="text" wire:model="rows.{{$i}}.avg_purchase_price" /> --}}

                                        </td>
                                        <td>
                                            @if (isset($stock_line->quantity_of_expired_stock_removed))
                                                {{ $stock_line->quantity_of_expired_stock_removed }}
                                            @else
                                                {{ $this->rows[$i]['quantity_of_damaged_stock_removed'] }}
                                            @endif
                                        </td>
                                        {{-- <td>@if (isset($stock_line->value_of_removed_stocks)){{$stock_line->value_of_removed_stocks}} @else {{0}}@endif</td>
                        <td>{{number_format($stock_line->avg_purchase_price)}}</td>
                        <td>{{0}}</td> --}}
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="view_modal no-print">
                    </div>
                </div>
            </div>
        </div>
        <input hidden value="" name="total_shortage_value" id="total_shortage_value">
        <button style="margin-left: 25px" class="btn btn-primary check_pass" wire:click="save">Save</button>
        <a style="margin-left: 25px" id="cancel_btn" class="btn btn-danger text-white ">Cancel</a>
    </div>
</div>

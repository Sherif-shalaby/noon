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
                                <th>@lang('lang.damaged_stock')</th>
                                <th>@lang('lang.date_of_damaged_stock')</th>
                                <th>@lang('lang.date_of_purchase_of_the_damaged_stock')</th>
                                <th>@lang('lang.avg_purchase_price')</th>
                                <th>@lang('lang.value_of_removed_stock')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($addStockLines))
                                @foreach ($addStockLines as $i => $stock_line)
                                    <tr>
                                        <td>
                                            <span
                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                style="font-size: 12px;font-weight: 600"
                                                data-tooltip="@lang('lang.image')">
                                                <img src="{{ $stock_line->product->image }}" height="50px"
                                                    width="50px">
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                style="font-size: 12px;font-weight: 600"
                                                data-tooltip="@lang('lang.name')">
                                                <input type="hidden"
                                                    wire:model="rows.{{ $i }}.stock_line_id" />
                                                {{ $stock_line->variation->unit->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                style="font-size: 12px;font-weight: 600"
                                                data-tooltip="@lang('lang.product_code')">
                                                {{ $stock_line->variation->sku ?? '' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                style="font-size: 12px;font-weight: 600"
                                                data-tooltip="@lang('lang.current_stock')">
                                                {{ number_format($stock_line->avail_current_stock - $stock_line->damaged_current_stock, num_of_digital_numbers()) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                style="font-size: 12px;font-weight: 600"
                                                data-tooltip="@lang('lang.quantity_to_be_removed')">
                                                <input type="text initial-balance-input width-full"
                                                    wire:model="rows.{{ $i }}.quantity_to_remove"
                                                    wire:change="changeStockRemovedValue({{ $i }})" />
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                style="font-size: 12px;font-weight: 600"
                                                data-tooltip="@lang('lang.damaged_stock')">
                                                {{ $stock_line->damaged_current_stock }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                style="font-size: 12px;font-weight: 600"
                                                data-tooltip="@lang('lang.date_of_damaged_stock')">
                                                {{ $stock_line->exp_date }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                style="font-size: 12px;font-weight: 600"
                                                data-tooltip="@lang('lang.date_of_purchase_of_the_damaged_stock')">
                                                {{ $stock_line->date_of_purchase_of_the_damaged_stock_removed }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                style="font-size: 12px;font-weight: 600"
                                                data-tooltip="@lang('lang.avg_purchase_price')">
                                                {{ number_format($stock_line->avg_purchase_price) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                style="font-size: 12px;font-weight: 600"
                                                data-tooltip="@lang('lang.value_of_removed_stock')">
                                                @if (isset($stock_line->quantity_of_damaged_stock_removed))
                                                    {{ $stock_line->quantity_of_damaged_stock_removed }}
                                                @else
                                                    {{ $this->rows[$i]['quantity_of_damaged_stock_removed'] }}
                                                @endif
                                            </span>
                                        </td>
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
        <button class="btn mx-2 my-1 btn-primary check_pass" wire:click="save">Save</button>
        <a id="cancel_btn" class="btn mx-2 my-1 btn-danger text-white ">Cancel</a>
    </div>

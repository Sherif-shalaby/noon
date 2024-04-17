<div>
    <div class="card-body">
        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
        <div class="table-responsive">
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
                    @if(!empty($addStockLines))
                    @foreach($addStockLines as $i=>$stock_line)
                    <tr>
                        <td><img src="{{$stock_line->product->image}}" height="50px" width="50px"></td>
                        <td>
                            <input type="hidden" wire:model="rows.{{$i}}.stock_line_id" />
                            {{ $stock_line->variation->unit->name}}
                        </td>
                        <td>{{$stock_line->variation->sku??''}}</td>
                        <td>{{ number_format($stock_line->avail_current_stock - $stock_line->damaged_current_stock,num_of_digital_numbers())  }}</td>
                        <td> <input type="text" wire:model="rows.{{$i}}.quantity_to_remove" wire:change="changeStockRemovedValue({{$i}})" /></td>
                        <td>{{$stock_line->damaged_current_stock}}</td>
                        <td>{{$stock_line->exp_date}}</td>
                        <td>{{$stock_line->date_of_purchase_of_the_damaged_stock_removed}}</td>
                        <td>{{number_format($stock_line->avg_purchase_price)}}
                        </td>
                        <td>@if(isset($stock_line->quantity_of_damaged_stock_removed)){{$stock_line->quantity_of_damaged_stock_removed}} @else {{$this->rows[$i]['quantity_of_damaged_stock_removed']}}@endif</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="view_modal no-print" >
            </div>
        </div>
        <input hidden value="" name="total_shortage_value" id="total_shortage_value">
        <button style="margin-left: 25px" class="btn btn-primary check_pass" wire:click="save">Save</button>
        <a style="margin-left: 25px" id="cancel_btn" class="btn btn-danger text-white ">Cancel</a>
    </div>
</div>

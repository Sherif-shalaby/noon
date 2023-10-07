 <div class="d-flex flex-wrap justify-content-between align-items-center py-2 rounded-3 text-center"
     style="background-color: rgba(241, 241, 241, 0.439);">
     <div style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
         class=" px-0 d-flex justify-content-center align-items-center flex-column">
         <span class="mb-2">@lang('lang.sku')</span>
         <input type="text" class="form-control sku" wire:model="rows.{{ $index }}.sku" required>
         @error('rows.' . $index . '.sku')
             <label class="text-danger error-msg">{{ $message }}</label>
         @enderror
     </div>

     <div style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
         class=" px-0 d-flex justify-content-center align-items-center flex-column">
         <span class="mb-2">@lang('lang.quantity')</span>
         <input type="text" class="form-control quantity" wire:change="calculateTotalQuantity()"
             wire:model="rows.{{ $index }}.quantity" style="width: 100px;" required>
         @error('quantity')
             <span class="error text-danger">{{ $message }}</span>
         @enderror
     </div>

     <div style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
         class=" px-0 d-flex justify-content-center align-items-center flex-column">
         <span class="mb-2">@lang('lang.unit')</span>
         <div class="d-flex justify-content-center">
             <select wire:model="rows.{{ $index }}.unit_id" data-name='unit_id' data-index="{{ $index }}"
                 required class="form-control select2 unit_id{{ $index }}" style="width: 100px;">
                 <option value="">{{ __('lang.please_select') }}</option>
                 @foreach ($units as $unit)
                     <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                 @endforeach
             </select>
             <button type="button" class="btn btn-primary btn-sm ml-2 add_unit_raw" data-toggle="modal"
                 data-index="{{ $index }}" data-target=".add-unit" href="{{ route('units.create') }}"><i
                     class="fas fa-plus"></i></button>
         </div>
     </div>

     <div style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
         class=" px-0 d-flex justify-content-center align-items-center flex-column">
         <span class="mb-2">@lang('lang.fill_from_basic_unit')</span>
         <input type="text" class="form-control unit_equal" wire:model="rows.{{ $index }}.equal"
             style="width: 100px;" required>
     </div>

     <div style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
         class=" px-0 d-flex justify-content-center align-items-center flex-column">
         <span class="mb-2">@lang('lang.basic_unit')</span>
         <select wire:model="rows.{{ $index }}.basic_unit_id" data-name='basic_unit_id'
             data-index="{{ $index }}" required class="form-control select2" style="width: 100px;">
             <option value="">{{ __('lang.please_select') }}</option>
             @foreach ($units as $unit)
                 <option value="{{ $unit->id }}">{{ $unit->name }}</option>
             @endforeach
         </select>
     </div>

     <div style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
         class=" px-0 d-flex justify-content-center align-items-center flex-column">
         <span class="mb-2">@lang('lang.to_get_sell_price')</span>
         <div class="d-flex justify-content-between">
             <select class="custom-select " style="width:55px;" wire:model="rows.{{ $index }}.fill_type"
                 wire:change="changeFilling({{ $index }})">
                 <option selected value="fixed">-</option>
                 <option value="percent">%</option>
             </select>
             <div class="input-group-prepend">
                 <input type="text" class="form-control" wire:model="rows.{{ $index }}.fill_quantity"
                     wire:change="changeFilling({{ $index }})" style="width: 100px;" required>
             </div>
             {{--  --}}
         </div>
     </div>

     <div style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
         class=" px-0 d-flex justify-content-center align-items-center flex-column">
         <span class="mb-2">@lang('lang.purchase_price')$</span>
         <input type="text" class="form-control" wire:model="rows.{{ $index }}.dollar_purchase_price"
             wire:change="changePurchasePrice({{ $index }})" style="width: 100px;" required>
         @error('dollar_purchase_price')
             <span class="error text-danger">{{ $message }}</span>
         @enderror
     </div>

     <div style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
         class=" px-0 d-flex justify-content-center align-items-center flex-column">
         <span class="mb-2">@lang('lang.selling_price')$</span>
         <input type="text" class="form-control " wire:model="rows.{{ $index }}.dollar_selling_price"
             wire:change="changeSellingPrice({{ $index }})" style="width: 100px;" required>
         @error('dollar_selling_price')
             <span class="error text-danger">{{ $message }}</span>
         @enderror
     </div>

     <div style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
         class=" px-0 d-flex justify-content-center align-items-center flex-column">
         <span class="mb-2">@lang('lang.sub_total') $</span>
         @if (isset($rows[$index]['quantity']) &&
                 (isset($rows[$index]['dollar_purchase_price']) || isset($rows[$index]['purchase_price'])))
             <span class="sub_total_span">
                 {{ $this->dollar_sub_total($index) }}
             </span>
         @endif
     </div>

     <div style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
         class=" px-0 d-flex justify-content-center align-items-center flex-column">
         <span class="mb-2">@lang('lang.purchase_price')</span>
         <input type="text" class="form-control" wire:model="rows.{{ $index }}.purchase_price"
             style="width: 100px;" required>
         @error('purchase_price')
             <span class="error text-danger">{{ $message }}</span>
         @enderror
     </div>

     <div style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
         class=" px-0 d-flex justify-content-center align-items-center flex-column">
         <span class="mb-2">@lang('lang.selling_price')</span>
         <input type="text" class="form-control " wire:model="rows.{{ $index }}.selling_price"
             style="width: 100px;" required>
         @error('selling_price')
             <span class="error text-danger">{{ $message }}</span>
         @enderror
     </div>

     <div style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
         class=" px-0 d-flex justify-content-center align-items-center flex-column">
         <span class="mb-2">@lang('lang.sub_total')</span>
         @if (isset($rows[$index]['quantity']) && (isset($rows[$index]['purchase_price']) || isset($dollar_purchase_price)))
             <span class="sub_total_span">
                 {{ $this->sub_total($index) }}
             </span>
         @endif
     </div>

     <div style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
         class=" px-0 d-flex justify-content-center align-items-center flex-column">
         <span class="mb-2">@lang('lang.new_stock')</span>
         <span class="current_stock_text">
             {{ $this->total_quantity($index) ?? 0 }}
         </span>
     </div>

     <div style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 70px"
         class=" px-0 d-flex justify-content-center align-items-center flex-column">
         <div class="btn btn-sm btn-danger py-0 px-1 " wire:click="delete_product({{ $index }})">
             <i class="fa fa-trash"></i>
         </div>
     </div>



     <div style="width: 100%" class="accordion mt-3 p-3" id="accordionPanelsStayOpenExample">
         <div class="accordion-item">
             <h2 class="accordion-header">
                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                     data-bs-target="#panelsStayOpen-collapse{{ $index }}" aria-expanded="true"
                     aria-controls="panelsStayOpen-collapse{{ $index }}">
                     Sales
                 </button>
             </h2>
             <div id="panelsStayOpen-collapse{{ $index }}" class="accordion-collapse collapse">
                 <div
                     class="accordion-body d-flex flex-wrap justify-content-between align-items-center py-2 rounded-3 text-center">
                     <div
                         style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 40px;border: 2px solid rgb(198, 198, 198)">
                         {!! Form::select('price_type', ['fixed' => __('lang.fixed'), 'percentage' => __('lang.percentage')], null, [
                             // 'id' => 'price_type',
                             'class' => ' form-control select2 price_type',
                             'data-name' => 'price_type',
                             'data-index' => $index,
                             'placeholder' => __('lang.please_select'),
                             'wire:model' => 'rows.' . $index . '.price_type',
                         ]) !!}
                         @error('rows.' . $index . '.price_type')
                             <br>
                             <label class="text-danger error-msg">{{ $message }}</label>
                         @enderror
                     </div>

                     <div
                         style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 55px">
                         <input type="text" class="form-control price_category"
                             wire:model="rows.{{ $index }}.price_category" maxlength="6">
                     </div>

                     <div
                         style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 55px">
                         <input type="text" class="form-control price"
                             wire:model="rows.{{ $index }}.price" placeholder="{{ __('lang.price') }}">
                     </div>

                     <div
                         style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 55px">
                         <input type="text" class="form-control discount_quantity"
                             wire:model="rows.{{ $index }}.discount_quantity"
                             placeholder="{{ __('lang.quantity') }}">

                     </div>

                     <div
                         style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 55px">
                         <input type="text" class="form-control bonus_quantity"
                             wire:model="rows.{{ $index }}.bonus_quantity"
                             placeholder="{{ __('lang.b_qty') }}">

                     </div>

                     <div
                         style="width: 180px;font-size: 12px;background-color: white;border-radius: 6px;margin: 6px;padding: 8px;height: 45px;border: 2px solid rgb(198, 198, 198)">
                         <select wire:model="rows.{{ $index }}.price_customer_types"
                             style="background-color: #dedede;
                                                                border-radius: 16px;
                                                                color: #373737;
                                                                box-shadow: 0 8px 6px -5px #bbb;
                                                                width: 100%;
                                                                margin: auto;
                                                                flex-wrap: nowrap;"
                             data-name='price_customer_types' data-index="{{ $index }}"
                             class="form-control js-example-basic-multiple" multiple='multiple'
                             placeholder="{{ __('lang.please_select') }}">
                             @foreach ($customer_types as $type)
                                 <option value="{{ $type->id }}">{{ $type->name }}
                                 </option>
                             @endforeach
                         </select>

                     </div>

                     <div class="btn btn-sm btn-danger py-0 px-1 "
                         wire:click="delete_price_raw({{ $index }})">
                         <i class="fa fa-trash"></i>
                     </div>

                 </div>
             </div>
         </div>
     </div>

     <div>
         <span colspan="8" style="text-align: right"> @lang('lang.total')</span>
         @if ($showColumn)
             <span> {{ $this->sum_dollar_tsub_total() }} </span>
             <span></span>
             <span></span>
         @endif
         <span> {{ $this->sum_sub_total() }} </span>
         <span></span>
     </div>
 </div>

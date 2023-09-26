<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">

                        @if (!empty($is_raw_material))
                            <h4>@lang('lang.add_stock_for_raw_material')</h4>
                        @else
                            <h4>@lang('lang.add_initial_balance')</h4>
                        @endif
                    </div>
                    @php
                        $index=0;
                    @endphp
                    {{-- {!! Form::open(['id' => 'add_stock_form']) !!} --}}
                    <div class="card-body">
                        {{-- <div class="col-md-12"> --}}
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('store_id', __('lang.store') . ':*', []) !!}
                                {!! Form::select(
                                    'store_id',
                                    $stores,
                                    !empty($recent_stock) && !empty($recent_stock->store_id) ? $recent_stock->store_id : session('user.store_id'),
                                    [
                                        'class' => ' form-control select2 store_id',
                                        'data-name'=>'store_id',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'wire:model' => 'item.0.store_id',
                                    ],
                                ) !!}


                                {{-- {{$item[0]['store_id']}} --}}
                                @error('item.0.store_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('supplier_id ', __('lang.supplier') . ':*', []) !!}
                                {!! Form::select(
                                    'supplier_id',
                                    $suppliers,
                                    !empty($recent_stock) && !empty($recent_stock->supplier_id) ? $recent_stock->supplier_id : session('user.supplier_id'),
                                    [
                                        'class' => ' form-control select2 supplier_id',
                                        'data-name'=>'supplier_id',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'wire:model' => 'item.0.supplier_id',
                                    ],
                                ) !!}
                                @error('item.0.supplier_id ')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('name', __('lang.product_name'), ['class' => 'h5']) !!}
                                {!! Form::text('name', null, [
                                    'class' => 'form-control required',
                                    'wire:model' => 'item.0.name',
                                    'wire:change'=>'confirmCreateProduct()'
                                ]) !!}
                                @error('item.0.name')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            {{-- <div class="col-md-3">
                                {!! Form::label('sku', __('lang.product_code'), ['class' => 'h5']) !!}
                                {!! Form::text('sku', null, [
                                    'class' => 'form-control',
                                    'wire:model' => 'item.0.sku',
                                ]) !!}
                            </div> --}}
                            <div class="col-md-3">
                                {!! Form::label('exchange_rate', __('lang.exchange_rate') . ':', []) !!}
                                <input type="text"  class="form-control" id="exchange_rate" wire:model="exchange_rate" wire:change="changeExchangeRateBasedPrices()">
                            </div>

                            <div class="col-md-3">
                                {!! Form::label('category', __('lang.category'), ['class' => 'h5']) !!}
                                {!! Form::select('category_id', $categories, null, [
                                    'class' => 'form-control select2 category_id',
                                    'placeholder' => __('lang.please_select'),
                                    'data-name'=>'category_id',
                                    'id' => 'categoryId',
                                    'wire:model' => 'item.0.category_id'
                                ]) !!}
                                @error('item.0.category_id')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                      
                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 1', ['class'=>'h5 ']) !!}
                                {{-- <div class="d-flex justify-content-center"> --}}
                                    {!! Form::select(
                                        'subcategory_id1',
                                        $subcategories1,null,
                                        [
                                        'class' => 'form-control select2 subcategory',
                                        'data-name'=>'subcategory_id1',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subCategoryId1',
                                        'wire:model' => 'item.0.subcategory_id1',
                                        ],
                                    ) !!}
                                    {{-- <button type="button" class="btn btn-primary btn-sm ml-2 openCategoryModal" data-toggle="modal" data-target="#createCategoryModal" data-select_category="2"><i class="fas fa-plus"></i></button>
                                </div> --}}
                                @error('item.0.subcategory_id1')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 2', ['class'=>'h5 ']) !!}
                                {{-- <div class="d-flex justify-content-center"> --}}
                                    {!! Form::select(
                                        'subcategory_id2',
                                        $subcategories2,null,
                                        [
                                        'class' => 'form-control select2 subcategory2',
                                        'data-name'=>'subcategory_id2',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subCategoryId2',
                                        'wire:model' => 'item.0.subcategory_id2',
                                        ],
                                    ) !!}
                                    {{-- <button type="button" class="btn btn-primary btn-sm ml-2 openCategoryModal" data-toggle="modal" data-target="#createCategoryModal" data-select_category="2"><i class="fas fa-plus"></i></button>
                                </div> --}}
                                @error('item.0.subcategory_id2')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 3', ['class'=>'h5 ']) !!}
                                {{-- <div class="d-flex justify-content-center"> --}}
                                    {!! Form::select(
                                        'subcategory_id3',
                                        $subcategories3,null,
                                        [
                                        'class' => 'form-control select2 subcategory3',
                                        'data-name'=>'subcategory_id3',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subCategoryId3',
                                        'wire:model' => 'item.0.subcategory_id3',
                                        ],
                                    ) !!}
                                    {{-- <button type="button" class="btn btn-primary btn-sm ml-2 openCategoryModal" data-toggle="modal" data-target="#createCategoryModal" data-select_category="2"><i class="fas fa-plus"></i></button>
                                </div> --}}
                                @error('item.0.subcategory_id3')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                {!! Form::label('status', __('lang.status') . ':*', []) !!}
                                {!! Form::select('status',
                                 ['received' =>  __('lang.received'), 'partially_received' => __('lang.partially_received')]
                                 , null, ['class' => 'form-control select2','data-name'=>'status', 'required',
                                 'placeholder' => __('lang.please_select'),'wire:model' => 'item.0.status']) !!}
                                @error('item.0.status')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- sizes --}}
                        <div class="row">
                            <div class="col-md-12 pt-5 ">
                                <h5 class="text-primary">{{ __('lang.product_dimensions') }}</h5>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('height', __('lang.height'), ['class' => 'h5 pt-3']) !!}
                                <input type="text" wire:model='item.0.height' wire:change='changeSize()' class='form-control height'/>
                                <br>
                                @error('item.0.height')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>



                            <div class="col-md-3">
                                {!! Form::label('length', __('lang.length'), ['class' => 'h5 pt-3']) !!}
                                <input type="text" wire:model='item.0.length' wire:change='changeSize()' class='form-control length'/>
                                <br>
                                @error('item.0.length')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                {!! Form::label('width', __('lang.width'), ['class' => 'h5 pt-3']) !!}
                                <input type="text" wire:model='item.0.width' wire:change='changeSize()' class='form-control width'/>
                                <br>
                                @error('item.0.width')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('size', __('lang.size'), ['class' => 'h5 pt-3']) !!}
                                <input type="text" wire:model='item.0.size' wire:change='changeSize()' class='form-control size'/>
                                <br>
                                @error('item.0.size')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-md-3">
                                {!! Form::label('quantity', __('lang.quantity')."*", ['class' => 'h5']) !!}
                                <input type="number" class="form-control quantity"  name="quantity" required >
                            </div> --}}
                            <div class="col-md-3">
                                {!! Form::label('weight', __('lang.weight'),['class'=>'h5']) !!}
                                <input type="text" wire:model='item.0.weight' wire:change='changeSize()' class='form-control weight'/>
                                <br>
                                @error('item.0.weight')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('divide_costs', __('lang.divide_costs') . ':', []) !!}
                                {!! Form::select('divide_costs', ['size' =>  __('lang.size'), 'weight' => __('lang.weight'), 'price' => __('lang.price')], 'Please Select',
                                 ['class' => 'select2 form-control', 'data-name'=>'divide_costs','wire:model'=>'item.0.divide_costs', 'required',  'placeholder' => __('lang.please_select')]) !!}
                                @error('item.0.divide_costs')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div class="col-md-3">
                                {!! Form::label('unit', __('lang.basic_unit') . ':', []) !!}
                                {!! Form::select(
                                    'unit_id',
                                    $basic_units,null,
                                    ['class' => 'form-control select2 unit_id',
                                    'placeholder'=>__('lang.please_select'), 'data-name'=>'unit_id',
                                    'wire:model'=>'item.0.unit_id', 'required',
                                    'id'=>'unitId']
                                ) !!}
                                @error('item.0.unit_id')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}
                        </div>
                        <div class="row text-right">
                            <div class="col">
                                <button class="btn btn btn-primary" wire:click="addRaw()" type="button">
                                    <i class="fa fa-plus"></i> @lang('lang.add')
                                </button>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-8 m-t-15 offset-md-1">
                               

                            </div>
                            <div class="col-md-2 pt-3">
                                <button type="button" class="btn btn-primary btn-sm ml-2 " wire:click=addRaw()>
                                    <i class="fa fa-plus"></i> @lang('lang.add')
                                </button>
                            </div>
                        </div> --}}
                        <br>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table" style="width: auto" >
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="width: 10%" >@lang('lang.sku')</th>
                                        <th style="width: 10%">@lang('lang.quantity')</th>
                                        <th style="width: 10%">@lang('lang.unit')</th>
                                        <th style="width: 10%">@lang('lang.fill_from_basic_unit')</th>
                                        <th style="width: 10%">@lang('lang.basic_unit')</th>
                                        <th style="width: 10%">@lang('lang.to_get_sell_price')</th>
                                        <th style="width: 10%">@lang('lang.purchase_price')$</th>
                                        <th style="width: 10%">@lang('lang.selling_price') $</th>
                                        <th style="width: 10%">@lang('lang.sub_total') $</th>
                                        <th style="width: 10%">@lang('lang.purchase_price')</th>
                                        <th style="width: 10%">@lang('lang.selling_price') </th>
                                        <th style="width: 10%">@lang('lang.sub_total')</th>
                                        <th style="width: 10%">@lang('lang.new_stock')</th>
                                        <th style="width: 10%">@lang('lang.change_current_stock')</th>
                                        <th style="width: 10%">@lang('lang.action')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rows as $index=>$row)
                                        @include('initial-balance.partial.raw_unit',['index'=>$index])
                                        @endforeach
                                        <tr>
                                            <td colspan="8" style="text-align: right"> @lang('lang.total')</td>
                                            {{-- @if ($showColumn) --}}
                                                <td> {{$this->sum_dollar_tsub_total()}} </td>
                                                <td></td>
                                                <td></td>
                                            {{-- @endif --}}
                                            <td> {{$this->sum_sub_total()}} </td>
                                            <td></td>
                                            {{-- <td style="">
                                                {{$this->sum_size() ?? 0}}
                                            </td> --}}
                                            {{-- <td></td> --}}
                                            {{-- <td  style=";">
                                                {{$this->sum_weight() ?? 0}}
                                            </td> --}}
                                            {{-- <td></td> --}}
                                            {{-- @if ($showColumn) --}}
                                                {{-- <td>
                                                    {{$this->sum_dollar_total_cost() ?? 0}}
                                                </td> --}}
                                                {{-- <td></td> --}}
                                            {{-- @endif --}}
                                            {{-- <td  style=";">
                                                {{$this->sum_total_cost() ?? 0}}
                                            </td> --}}

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 text-center mt-1 ">
                            <h4>@lang('lang.items_count'):
                                <span class="items_count_span" style="margin-right: 15px;">{{count($rows)}}</span>
                                <br> @lang('lang.items_quantity'): <span
                                    class="items_quantity_span" style="margin-right: 15px;">{{$totalQuantity}}</span>
                            </h4>
                        </div>
                        <br>
                    </div>
                    {{-- {!! Form::close() !!} --}}
                    <div class="col-sm-12">
                        <button type="submit" name="submit" id="submit-save" style="margin: 10px" value="save"
                            class="btn btn-primary pull-right btn-flat submit"
                            wire:click.prevent="store()">@lang('lang.save')</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <!-- This will be printed --> --}}
<div class="view_modal no-print"></div>
<section class="invoice print_section print-only" id="receipt_section"> </section>


@push('javascripts')
    <script>

        document.addEventListener('livewire:load', function() {
            $('.js-example-basic-multiple').select2({
                placeholder: LANG.please_select,
                tags: true
            });
            // $('.select2').select2();
            Livewire.hook('message.processed', (message, component) => {
                if (message.updateQueue && message.updateQueue.some(item => item.payload.event ===
                        'updated:selectedProducts')) {
                    $('.product_selected').on('click', function(event) {
                        event.stopPropagation();
                        var value = $(this).prop('checked');
                        var productId = $(this).val();
                        Livewire.find(component.fingerprint).set('selectedProducts.' + productId,
                            value);
                    });
                }
            });
        });
        document.addEventListener('livewire:load', function() {
            Livewire.on('closeModal', function() {
                // Close the modal using Bootstrap's modal API
                $('#select_products_modal').modal('hide');
            });
        });

        document.addEventListener('livewire:load', function() {
            Livewire.on('printInvoice', function(htmlContent) {
                window.print();
            });
        });
        $(document).on('change','select', function(e) { 
            var name = $(this).data('name');
            var index = $(this).data('index');
            var select2 = $(this); // Save a reference to $(this)
            Livewire.emit('listenerReferenceHere',{
                var1 :name,
                var2 :select2.select2("val") ,
                var3:index
            });
            
        });



    window.addEventListener('showCreateProductConfirmation', function () {
        Swal.fire({
            title: "{{__('lang.this_product_exists_before')}}"+"<br>"+"{{__('lang.continue_to_add_stock')}}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('create');
            }else{
                Livewire.emit('cancelCreateProduct');
            }
        });
    });

    </script>
@endpush

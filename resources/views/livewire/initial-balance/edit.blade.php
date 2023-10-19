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
                        $index = 0;
                    @endphp
                    <div class="row mt-2">
                        <div class="col-md-9">
                            <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info')</small></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('store_id', __('lang.store') . ':*', []) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('store_id', $stores, $item[0]['store_id'], [
                                        'class' => ' form-control select2 store_id',
                                        'data-name' => 'store_id',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'wire:model' => 'item.0.store_id',
                                    ]) !!}
                                    <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
                                        data-target=".add-store" href="{{ route('store.create') }}"><i
                                            class="fas fa-plus"></i></button>
                                    @include('store.create', ['quick_add' => 1])
                                </div>
                                @error('item.0.store_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('supplier_id ', __('lang.supplier') . ':*', []) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('supplier_id', $suppliers, $item[0]['supplier_id'], [
                                        'id' => 'supplier_id',
                                        'class' => ' form-control select2 supplier_id',
                                        'data-name' => 'supplier_id',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'wire:model' => 'item.0.supplier_id',
                                    ]) !!}
                                    <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
                                        data-target=".add-supplier" href="{{ route('suppliers.create') }}"><i
                                            class="fas fa-plus"></i></button>
                                    @include('suppliers.quick_add', ['quick_add' => 1])
                                </div>
                                @error('item.0.supplier_id ')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('name', __('lang.product_name'), ['class' => 'h5']) !!}
                                {!! Form::text('name', $item[0]['name'], [
                                    'class' => 'form-control required',
                                    'wire:model' => 'item.0.name',
                                    'wire:change' => 'confirmCreateProduct()',
                                ]) !!}
                                @error('item.0.name')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                {!! Form::label('product_symbol', __('lang.product_symbol'), ['class' => 'h5']) !!}
                                {!! Form::text('product_symbol', $item[0]['product_symbol'], [
                                    'class' => 'form-control',
                                    'wire:model' => 'item.0.product_symbol',
                                ]) !!}
                                @error('item.0.product_symbol')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('exchange_rate', __('lang.exchange_rate') . ':', []) !!}
                                <input type="text" class="form-control" id="exchange_rate"
                                    value="{{ $item[0]['exchange_rate'] }}"
                                    placeholder="سعر السوق({{ $exchange_rate }})" wire:model="exchange_rate"
                                    wire:change="changeExchangeRateBasedPrices()">
                            </div>

                            <div class="col-md-3">
                                {!! Form::label('category', __('lang.category'), ['class' => 'h5']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('category_id', $categories, $item[0]['category_id'], [
                                        'class' => 'form-control select2 category_id',
                                        'placeholder' => __('lang.please_select'),
                                        'data-name' => 'category_id',
                                        'id' => 'categoryId',
                                        'wire:model' => 'item.0.category_id',
                                    ]) !!}
                                    <a data-href="{{ route('categories.sub_category_modal') }}"
                                        data-container=".view_modal"
                                        class="btn btn-modal btn-primary text-white btn-sm ml-2 openCategoryModal"
                                        data-toggle="modal" data-select_category="0"><i class="fas fa-plus"></i></a>
                                    {{--                                    @include('categories.create_modal', ['quick_add' => 1]) --}}
                                </div>
                                @error('item.0.category_id')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 1', ['class' => 'h5 ']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('subcategory_id1', $subcategories1, $item[0]['subcategory_id1'], [
                                        'class' => 'form-control select2 subcategory1',
                                        'data-name' => 'subcategory_id1',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subcategory_id1',
                                        'wire:model' => 'item.0.subcategory_id1',
                                    ]) !!}
                                    <a data-href="{{ route('categories.sub_category_modal') }}"
                                        data-container=".view_modal"
                                        class="btn btn-primary text-white btn-sm ml-2 openCategoryModal"
                                        data-toggle="modal" data-select_category="1"><i class="fas fa-plus"></i></a>
                                </div>
                                @error('item.0.subcategory_id1')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 2', ['class' => 'h5 ']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('subcategory_id2', $subcategories2, $item[0]['subcategory_id2'], [
                                        'class' => 'form-control select2 subcategory2',
                                        'data-name' => 'subcategory_id2',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subCategoryId2',
                                        'wire:model' => 'item.0.subcategory_id2',
                                    ]) !!}
                                    <a data-href="{{ route('categories.sub_category_modal') }}"
                                        data-container=".view_modal"
                                        class="btn btn-primary text-white btn-sm ml-2 openCategoryModal"
                                        data-toggle="modal" data-select_category="2"><i class="fas fa-plus"></i></a>
                                    {{-- <button type="button" class="btn btn-primary btn-sm ml-2  openCategoryModal"
                                        data-toggle="modal" data-target=".createSubCategoryModal"
                                        data-select_category="2"><i class="fas fa-plus"></i></button> --}}
                                </div>
                                @error('item.0.subcategory_id2')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.subcategory') . ' 3', ['class' => 'h5 ']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('subcategory_id3', $subcategories3, $item[0]['subcategory_id3'], [
                                        'class' => 'form-control select2 subcategory3',
                                        'data-name' => 'subcategory_id3',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subCategoryId3',
                                        'wire:model' => 'item.0.subcategory_id3',
                                    ]) !!}
                                    {{-- <button type="button" class="btn btn-primary btn-sm ml-2 openCategoryModal"
                                        data-toggle="modal" data-target=".createSubCategoryModal"
                                        data-select_category="3"><i class="fas fa-plus"></i></button> --}}
                                    <a data-href="{{ route('categories.sub_category_modal') }}"
                                        data-container=".view_modal"
                                        class="btn btn-primary btn-sm ml-2 text-white openCategoryModal"
                                        data-toggle="modal" data-select_category="3"><i class="fas fa-plus"></i></a>
                                </div>
                                @error('item.0.subcategory_id3')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="method" class="h5 pt-3">{{ __('lang.tax_method') . ':*' }}</label>
                                {!! Form::select(
                                    'method',
                                    ['inclusive' => __('lang.inclusive'), 'exclusive' => __('lang.exclusive')],
                                    $item[0]['method'],
                                    [
                                        'id' => 'method',
                                        'class' => ' form-control select2 method',
                                        'data-name' => 'method',
                                        'placeholder' => __('lang.please_select'),
                                        'wire:model' => 'item.0.method',
                                    ],
                                ) !!}
                            </div>
                            {{-- +++++++++++++++++++++++ "product_tax" selectbox +++++++++++++++++++++++ --}}
                            <div class="col-md-3">
                                <label for="product" class="h5 pt-3">{{ __('lang.product_tax') . ':*' }}</label>
                                <div class="d-flex justify-content-center">
                                    <select id="product_tax" class="form-control select2"
                                        wire:model="item.0.product_tax_id" placeholder="{{ __('lang.please_select') }}"
                                        data-name="product_tax_id">
                                        <option value="">{{ __('lang.please_select') }}</option>
                                        @foreach ($product_taxes as $tax)
                                            @if ($tax->status == 'active')
                                                <option value="{{ $tax->id }}"
                                                    {{ $item[0]['product_tax_id'] == $tax->id ? 'selected' : '' }}>
                                                    {{ $tax->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary btn-sm ml-2 select_sub_category"
                                        data-toggle="modal" data-target="#add_product_tax_modal"
                                        data-select_category="2"><i class="fas fa-plus"></i></button>
                                    @include('product-tax.create', ['quick_add' => 1])
                                </div>
                            </div>
                            {{-- +++++++++++++++++++++++ "balance return request"  +++++++++++++++++++++++ --}}
                            <div class="col-md-3">
                                {!! Form::label('balance_return_request', __('lang.balance_return_request'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('balance_return_request', $item[0]['balance_return_request'], [
                                    'wire:model' => 'item.0.balance_return_request',
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>

                        {{-- sizes --}}
                        <div class="row">
                            <div class="col-md-12 pt-5 ">
                                <h5 class="text-primary">{{ __('lang.product_dimensions') }}</h5>
                            </div>

                            <div class="col-md-3">
                                {!! Form::label('weight', __('lang.weight'), ['class' => 'h5 pt-3']) !!}
                                <input type="text" wire:model='item.0.weight' wire:change='changeSize()'
                                    class='form-control weight' />
                                <br>
                                @error('item.0.weight')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-2">
                                {!! Form::label('height', __('lang.height'), ['class' => 'h5 pt-3']) !!}
                                <input type="text" wire:model='item.0.height' wire:change='changeSize()'
                                    class='form-control height' />
                                <br>
                                @error('item.0.height')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>



                            <div class="col-md-2">
                                {!! Form::label('length', __('lang.length'), ['class' => 'h5 pt-3']) !!}
                                <input type="text" wire:model='item.0.length' wire:change='changeSize()'
                                    class='form-control length' />
                                <br>
                                @error('item.0.length')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                {!! Form::label('width', __('lang.width'), ['class' => 'h5 pt-3']) !!}
                                <input type="text" wire:model='item.0.width' wire:change='changeSize()'
                                    class='form-control width' />
                                <br>
                                @error('item.0.width')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('size', __('lang.size'), ['class' => 'h5 pt-3']) !!}
                                <input type="text" wire:model='item.0.size' wire:change='changeSize()'
                                    class='form-control size' />
                                <br>
                                @error('item.0.size')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                        </div>

                        <br>
                        {{-- add prices --}}
                        {{-- <div class="row">
                                    <div class="col-md-12 pt-5">
                                        <h4 class="text-primary">{{ __('lang.add_prices_for_different_users') }}</h4>
                                    </div>
                                    <div class="col-md-12 ">
                                        <table class="table table-bordered" id="consumption_table_price">
                                            <thead>
                                                <tr>
                                                    <th style="width: 3%;">#</th>
                                                    <th style="width: 10%;">@lang('lang.type')</th>
                                                    <th style="width: 10%;">@lang('lang.price_category')</th>
                                                    <th style="width: 10%;">@lang('lang.price')</th>
                                                    <th style="width: 10%;">@lang('lang.quantity')</th>
                                                    <th style="width: 11%;">@lang('lang.b_qty')</th>
                                                    <th style="width: 20%;">@lang('lang.customer_type')
                                                        <i class="dripicons-question" data-toggle="tooltip"
                                                            title="@lang('lang.discount_customer_info')"></i>
                                                    </th>
                                                    <th style="width: 5%;">
                                                        <button class="btn btn-xs btn-primary" wire:click="addPriceRaw()"
                                                            type="button">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($priceRow as $index => $row)
                                                    @include('products.product_raw_price', [
                                                        'index' => $index,
                                                    ])
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="raw_price_index" id="raw_price_index"
                                            value="1">
                                    </div>
                        </div>
                        <br><br>
                        <div class="row text-right">
                            <div class="col">
                                <button class="btn btn btn-primary" wire:click="addRaw()" type="button">
                                    <i class="fa fa-plus"></i> @lang('lang.add')
                                </button>
                            </div>
                        </div>
                        <br>
                        {{-- add prices --}}
                        <br>
                        <div class="row text-right">
                            <div class="col">
                                <button class="btn btn btn-primary" wire:click="addRaw()" type="button">
                                    <i class="fa fa-plus"></i> @lang('lang.add')
                                </button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table" style="width: auto">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="width: 10%">@lang('lang.sku')</th>
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
                                            {{-- <th style="width: 10%">@lang('lang.change_current_stock')</th> --}}
                                            <th style="width: 10%">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rows as $index => $row)
                                            @include('initial-balance.partial.raw_unit', [
                                                'index' => $index,
                                            ])
                                        @endforeach
                                        <tr>
                                            <td colspan="9" style="text-align: right"> @lang('lang.total')</td>
                                            {{-- @if ($showColumn) --}}
                                            <td> {{ $this->sum_dollar_tsub_total() }} </td>
                                            <td></td>
                                            <td></td>
                                            {{-- @endif --}}
                                            <td> {{ $this->sum_sub_total() }} </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 text-center mt-1 ">
                            <h4>@lang('lang.items_count'):
                                <span class="items_count_span" style="margin-right: 15px;">{{ count($rows) }}</span>
                                <br> @lang('lang.items_quantity'): <span class="items_quantity_span"
                                    style="margin-right: 15px;">{{ $totalQuantity }}</span>
                            </h4>
                        </div>
                        <br>
                    </div>
                    {{-- {!! Form::close() !!} --}}
                    <div class="col-sm-12">
                        <button type="submit" name="submit" id="submit-save" style="margin: 10px" value="save"
                            class="btn btn-primary pull-right btn-flat submit"
                            wire:click.prevent="edit()">@lang('lang.edit')</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <!-- This will be printed --> --}}
<div class="view_modal no-print"></div>
<section class="invoice print_section print-only" id="receipt_section"> </section>
@include('units.create', ['quick_add' => 1])


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
        $(document).on('change', 'select', function(e) {

            var name = $(this).data('name');
            console.log(name)
            if (name != undefined) {
                var index = $(this).data('index');
                var key = $(this).data('key');
                var select2 = $(this);
                Livewire.emit('listenerReferenceHere', {
                    var1: name,
                    var2: select2.select2("val"),
                    var3: index,
                    var4: key
                });
            }

        });
        window.addEventListener('showCreateProductConfirmation', function() {
            Swal.fire({
                title: "{{ __('lang.this_product_exists_before') }}" + "<br>" +
                    "{{ __('lang.continue_to_add_stock') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('create');
                } else {
                    Livewire.emit('cancelCreateProduct');
                }
            });
        });

        $(document).on("click", ".add_price_row", function() {
            let row_id = parseInt($("#raw_price_index").val());
            $("#raw_price_index").val(row_id + 1);
            $.ajax({
                method: "get",
                url: "/product/get-raw-price",
                data: {
                    row_id: row_id
                },
                success: function(result) {
                    $("#consumption_table_price > tbody").prepend(result);
                },
            });
        });
        $(document).on("click", ".remove_row", function() {
            row_id = $(this).closest("tr").data("row_id");
            $(this).closest("tr").remove();
        });
    </script>
@endpush

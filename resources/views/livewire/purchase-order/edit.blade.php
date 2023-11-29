
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    {{-- +++++++++++++++++++++++++ card-header +++++++++++++++++++ --}}
                    <div class="card-header d-flex align-items-center">
                        <h4>@lang('lang.edit_purchase_order')</h4>
                    </div>
                    <div class="row ">
                        <div class="col-md-9">
                            <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info')</small></p>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>
                                    {!! Form::checkbox('change_exchange_rate_to_supplier', 1, false,['wire:model' => 'change_exchange_rate_to_supplier']) !!}
                                    @lang('lang.change_exchange_rate_to_supplier')
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- +++++++++++++++++++++++++ card-body" +++++++++++++++++++ --}}
                    {!! Form::open([ 'id' => 'purchase_order_form']) !!}
                        <div class="card-body">
                            {{-- ============ filter ============ --}}
                            <div class="col-md-12">
                                <div class="row">
                                    {{-- ////////////////// stores filter ////////////////// --}}
                                    <div class="col-md-3">
                                        {!! Form::label('store_id', __('lang.store') . ':*', []) !!}
                                        {!! Form::select('store_id', $stores, $store_id, [
                                            'class' => 'form-control select2',
                                            'data-name' => 'store_id',
                                            'data-live-search' => 'true',
                                            'required',
                                            'placeholder' => __('lang.please_select'),
                                            'wire:model' => 'store_id'
                                        ]) !!}
                                        @error('store_id')
                                        <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- ////////////////// suppliers filter ////////////////// --}}
                                    <div class="col-md-3">
                                        {!! Form::label('supplier_id', __('lang.supplier') . ':*', []) !!}
                                        <div class="d-flex justify-content-center" wire:ignore>
                                            {!! Form::select('supplier_id', $suppliers, $supplier, [
                                                'class' => 'form-control select2',
                                                // 'data-live-search' => 'true',
                                                'placeholder' => __('lang.please_select'),
                                                // +++++++++++++ 26-11-2023 المشكلة هنا +++++++++++++
                                                'data-name' => 'supplier_id',
                                                // 'wire:model' => 'supplier_id2',
                                                'wire:change' => 'changeExchangeRate()'
                                            ]) !!}
                                        </div>
                                        @error('supplier')
                                        <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- ////////////////// product_number inputField : رقم طلب الشراء  ////////////////// --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('po_no', __('lang.po_no'). ':*', []) !!}
                                            {!! Form::text('po_no', $po_no, ['class' => 'form-control','required', 'readonly',
                                            'placeholder' => __('lang.po_no')]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            {{-- ++++++++++++++++++++++ search inputFields ++++++++++++++++++++++ --}}
                            <div class="row">
                                {{-- ++++++ "البحث "برمز المنتج ++++++ --}}
                                <div class="col-md-3 m-t-15">
                                    <div class="search-box input-group">
                                        <input type="search" name="search_by_product_symbol" id="search_by_product_symbol" wire:model.debounce.200ms="search_by_product_symbol"
                                            placeholder="@lang('lang.enter_product_symbol')"
                                            class="form-control" autocomplete="off">

                                        @if(!empty($search_result) && !empty($search_by_product_symbol))
                                            <ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2" style="top: 37.423px; left: 39.645px; width: 90.2%;">
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
                                    </div>
                                </div>
                                {{-- ++++++ "البحث "باسم المنتج" و "الباركود ++++++ --}}
                                <div class="col-md-7 m-t-15">
                                    <div class="search-box input-group">
                                        <button type="button" class="btn btn-secondary" id="search_button"><i
                                                class="fa fa-search"></i>
                                        </button>
                                        <input type="search" name="search_product" id="search_product" wire:model.debounce.200ms="searchProduct"
                                            placeholder="@lang('lang.enter_product_name_to_print_labels')"
                                            class="form-control" autocomplete="off">

                                        @if(!empty($search_result) && !empty($searchProduct))
                                            <ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2" style="top: 37.423px; left: 39.645px; width: 90.2%;">
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
                            <br>
                            {{-- ++++++++++++++++++++++ Left Sidebar : Products : filters ++++++++++++++++++++++ --}}
                            <div class="row">
                                <div class="col-md-3 border border-1 mr-1 p-0">
                                    {{-- ============= filter : الموردين ============= --}}
                                    <div class="p-3 text-center font-weight-bold "  style="background-color: #eee;" wire:ignore>
                                        <div class="form-group">
                                            {!! Form::label('supplier_id', __('lang.supplier'), []) !!}
                                            {!! Form::select('supplier_id', $suppliers, null, [
                                                'class' => 'form-control select2',
                                                'data-live-search' => 'true',
                                                'id' => 'supplier_id2',
                                                'placeholder' => __('lang.please_select'),
                                                'data-name' => 'supplier',
                                                'wire:model' => 'supplier_id',
                                            ]) !!}
                                        </div>
                                        @error('supplier_id2')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- ============= filter : العلامة التجارية ============= --}}
                                    <div class="p-3 text-center font-weight-bold "  style="background-color: #eee;" wire:ignore>
                                        <div class="form-group">
                                            {!! Form::label('brand_id', __('lang.brand') . ':', []) !!}
                                            {!! Form::select('brand_id', $brands, null ,
                                            ['class' => 'select2 form-control brand_class', 'id'=>'brand_id', 'required', 'placeholder' => __('lang.please_select'),
                                            'data-name' => 'brand_id','wire:model' => 'brand_id']) !!}
                                            @error('brand_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- ============= filter : الأقسام الرئيسيه ============= --}}
                                    <div class="p-3 text-center font-weight-bold "  style="background-color: #eee;" wire:ignore>
                                        الأقسام الرئيسيه
                                        <div for="" class="d-flex align-items-center text-nowrap gap-1">
                                            {{-- الاقسام --}}
                                            <select class="form-control depart select2" wire:model="department_id" data-name="department_id">
                                                <option  value="0" readonly selected >اختر </option>
                                                @foreach ($departments as $depart)
                                                    <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- /////////// products of filters :  filters المنتجات اسفل ال /////////// --}}
                                    <div class="p-2">
                                        @include('purchase_order.partials.products')
                                    </div>
                                </div>
                                {{-- +++++++++++++++++++++ جدول المنتجات +++++++++++++++++++++ --}}
                                <div class="table-responsive col-md-8 border m-0 p-0 border-1">
                                    <table class="table" style="width: auto" >
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="width: 10%" class="col-sm-8">@lang('lang.products')</th>
                                                <th style="width: 10%">@lang('lang.quantity')</th>
                                                <th style="width: 10%">@lang('lang.purchase_price')$</th>
                                                <th style="width: 10%">@lang('lang.dinar_purchase_price')  </th>
                                                <th style="width: 10%">@lang('lang.dollar_total_prices')</th>
                                                <th style="width: 10%">@lang('lang.dinar_total_prices')</th>
                                                <th style="width: 10%">@lang('lang.current_stock')</th>
                                                <th style="width: 10%">@lang('lang.delete')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($items))
                                            {{-- {{ dd($items) }} --}}
                                            @foreach($items  as $index => $product)
                                                @include('purchase_order.partials.product_row')
                                            @endforeach
                                            <tr>
                                                {{-- +++++++++ Task : "مجموع اجمالي التكاليف" +++++++++ --}}
                                                <td colspan="5" style="text-align: right"> @lang('lang.total')</td>
                                                <td> {{$this->sum_dollar_sub_total()}} </td>
                                                {{-- <td></td>  --}}
                                                {{-- <td></td>
                                                <td> {{$this->sum_sub_total()}} </td>
                                                <td></td> --}}
                                                <td>
                                                    {{$this->sum_dinar_sub_total() ?? 0}}
                                                </td>
                                                {{-- <td></td>
                                                <td  style=";">
                                                    {{$this->sum_total_cost() ?? 0}}
                                                </td> --}}

                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- ++++++++++++++++++++++ total_quantity ++++++++++++++++++++++ --}}
                            <div class="col-md-12 text-center mt-1 ">
                                <h4>@lang('lang.items_count'):
                                    <span class="items_count_span" style="margin-right: 15px;">{{!empty($items)? count($items) : 0}}</span>
                                    <br> @lang('lang.items_quantity'): <span
                                        class="items_quantity_span" style="margin-right: 15px;">{{ $this->total_quantity() }}</span>
                                </h4>
                            </div>
                            <br>
                            {{-- ++++++++++++++++++++++ total ++++++++++++++++++++++ --}}
                            <div class="col-md-12">
                                <div class="col-md-3 offset-md-8 text-right">
                                    <h3> @lang('lang.total') :
                                        @if($paying_currency == 2)
                                            {{$this->sum_dollar_total_cost() ?? 0.00}}
                                        @else
                                            {{$this->sum_total_cost() ?? 0.00}}
                                        @endif
                                        <span class="final_total_span"></span> </h3>
                                        <input type="hidden" name="total_subtotal" id="total_subtotal_input" value="{{$this->sum_total_cost() ?? 0.00}}">

                                </div>
                            </div>
                            <br>
                            {{-- ++++++++++++++++++++++++ details textarea ++++++++++++++++++++++++ --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('details', __('lang.details'), []) !!}
                                        {{-- {!! Form::textarea('details', null, ['class' => 'form-control', 'rows' => 3]) !!} --}}
                                        <textarea name="details" class="form-control" rows="3" wire:model="details"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ++++++++++++++++++++ submit ++++++++++++++++++++ --}}
                        <div class="col-sm-12">
                            <button type="submit" name="submit" id="submit-save"
                                style="margin: 10px" value="save"
                                class="btn btn-primary pull-right btn-flat submit" wire:click.prevent="store()">@lang('lang.save')</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
{{--<!-- This will be printed -->--}}
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
                $("#receipt_section").html(htmlContent);

                // Trigger the print action
                window.print();
            });
        });
        $(document).on("click", "#clear_all_input_form", function () {
            var value = $('#clear_all_input_form').is(':checked')?1:0;
            $.ajax({
                method: "get",
                url: "/create-or-update-system-property/clear_all_input_stock_form/"+value,
                contentType: "html",
                success: function (result) {
                    if (result.success) {
                        Swal.fire("Success", response.msg, "success");
                    }
                },
            });
        });
        // ++++++++++++++++++ when click on filters , execute updatedDepartmentId() ++++++++++++++++++
        $(document).ready(function()
        {
            // --------- when select "option" in "selectbox" ---------
            $('select').on('change', function(e)
            {
                var name = $(this).data('name');
                var index = $(this).data('index');
                var select2 = $(this); // Save a reference to $(this)
                Livewire.emit('listenerReferenceHere',{
                    var1 :name,
                    var2 :select2.select2("val") ,
                    var3:index
                });
            });
        });
        // --------- to save "select option" in "selectbox" ---------
        document.addEventListener('livewire:load', function () {
            // "categories" filter
            $('.depart').select().on('change', function (e) {
                @this.set('department_id', $(this).val());
            });
            // "brands" filter
            $('.brand_class').select().on('change', function (e) {
                @this.set('brand_id', $(this).val());
            });
            // "supplier_class" filter
            $('.supplier_class').select().on('change', function (e) {
                @this.set('supplier_id', $(this).val());
            });
        });

    </script>
@endpush

<div class="animate-in-page">

    <section class="forms">
        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3">
                        {{-- +++++++++++++++++++++++++ card-header +++++++++++++++++++ --}}
                        <div class="card-header d-flex align-items-center  @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif  animate__animated animate__fadeInUp"
                            style="animation-delay: 1.1s">
                            <h4>@lang('lang.edit_purchase_order')</h4>
                        </div>
                        <div class="row ">
                            {{-- <div class="col-md-9  animate__animated animate__bounceInRight" style="animation-delay: 1.1s">
                                <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info')</small></p>
                            </div> --}}
                            <div class="col-md-3 animate__animated animate__bounceInRight" style="animation-delay: 1.1s">
                                <div class="form-group">
                                    <label>
                                        {!! Form::checkbox('change_exchange_rate_to_supplier', 1, false, [
                                            'wire:model' => 'change_exchange_rate_to_supplier',
                                        ]) !!}
                                        @lang('lang.change_exchange_rate_to_supplier')
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++++ card-body" +++++++++++++++++++ --}}
                        {!! Form::open(['id' => 'purchase_order_form']) !!}
                        <div class="card-body">
                            {{-- ============ filter ============ --}}
                            <div class="col-md-12">
                                <div
                                    class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {{-- ////////////////// stores filter ////////////////// --}}
                                    <div class="col-md-3 d-flex mb-2  animate__animated animate__bounceInLeft  align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                        style="animation-delay: 1.15s">
                                        {!! Form::label('store_id', __('lang.store') . '*', [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                            'style' => 'font-size: 12px;font-weight: 500;',
                                        ]) !!}
                                        <div class="input-wrapper">

                                            {!! Form::select('store_id', $stores, $store_id, [
                                                'class' => 'form-control select2',
                                                'data-name' => 'store_id',
                                                'data-live-search' => 'true',
                                                'required',
                                                'placeholder' => __('lang.please_select'),
                                                'wire:model' => 'store_id',
                                            ]) !!}
                                        </div>
                                        @error('store_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- ////////////////// suppliers filter ////////////////// --}}
                                    <div class="col-md-3 animate__animated animate__bounceInLeft d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                        style="animation-delay: 1.2s">
                                        {!! Form::label('supplier_id', __('lang.supplier') . '*', [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                            'style' => 'font-size: 12px;font-weight: 500;',
                                        ]) !!}
                                        <div class="input-wrapper" wire:ignore>
                                            {!! Form::select('supplier_id', $suppliers, $supplier, [
                                                'class' => 'form-control select2',
                                                // 'data-live-search' => 'true',
                                                'placeholder' => __('lang.please_select'),
                                                // +++++++++++++ 26-11-2023 المشكلة هنا +++++++++++++
                                                'data-name' => 'supplier_id',
                                                // 'wire:model' => 'supplier_id2',
                                                'wire:change' => 'changeExchangeRate()',
                                            ]) !!}
                                        </div>
                                        @error('supplier')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- ////////////////// product_number inputField : رقم طلب الشراء  ////////////////// --}}
                                    <div class="col-md-3  animate__animated animate__bounceInLeft d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                        style="animation-delay: 1.25s">
                                        {!! Form::label('po_no', __('lang.po_no') . '*', [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                                            'style' => 'font-size: 12px;font-weight: 500;',
                                        ]) !!}
                                        {!! Form::text('po_no', $po_no, [
                                            'class' => 'form-control m-0 initial-balance-input width-full',
                                            'required',
                                            'readonly',
                                            'placeholder' => __('lang.po_no'),
                                        ]) !!}
                                    </div>


                                    {{-- ++++++++++++++++++++++ search inputFields ++++++++++++++++++++++ --}}

                                    {{-- ++++++ "البحث "برمز المنتج ++++++ --}}
                                    <div class="col-md-3 animate__animated animate__bounceInLeft d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                                        style="animation-delay: 1.3s">
                                        <div class="search-box input-group">
                                            <input type="search" name="search_by_product_symbol"
                                                id="search_by_product_symbol"
                                                wire:model.debounce.200ms="search_by_product_symbol"
                                                placeholder="@lang('lang.enter_product_symbol')" class="form-control" autocomplete="off">

                                            @if (!empty($search_result) && !empty($search_by_product_symbol))
                                                <ul id="ui-id-1" tabindex="0"
                                                    class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2"
                                                    style="top: 37.423px; left: 39.645px; width: 90.2%;">
                                                    @foreach ($search_result as $product)
                                                        <li class="ui-menu-item"
                                                            wire:click="add_product({{ $product->id }})">
                                                            <div id="ui-id-73" tabindex="-1"
                                                                class="ui-menu-item-wrapper">
                                                                @if ($product->image)
                                                                    <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                                        alt="{{ $product->name }}" class="img-thumbnail"
                                                                        width="100px">
                                                                @else
                                                                    <img src="{{ asset('uploads/' . $settings['logo']) }}"
                                                                        alt="{{ $product->name }}" class="img-thumbnail"
                                                                        width="100px">
                                                                @endif
                                                                {{ $product->product_symbol ?? '' }} -
                                                                {{ $product->name }}
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                        {{-- ++++++ "البحث "باسم المنتج" و "الباركود ++++++ --}}

                                        <div class="search-box input-group">
                                            <button type="button" class="btn btn-secondary" id="search_button"><i
                                                    class="fa fa-search"></i>
                                            </button>
                                            <input type="search" name="search_product" id="search_product"
                                                wire:model.debounce.200ms="searchProduct"
                                                placeholder="@lang('lang.enter_product_name_to_print_labels')" class="form-control" autocomplete="off">

                                            @if (!empty($search_result) && !empty($searchProduct))
                                                <ul id="ui-id-1" tabindex="0"
                                                    class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2"
                                                    style="top: 37.423px; left: 39.645px; width: 90.2%;">
                                                    @foreach ($search_result as $product)
                                                        <li class="ui-menu-item"
                                                            wire:click="add_product({{ $product->id }})">
                                                            <div id="ui-id-73" tabindex="-1"
                                                                class="ui-menu-item-wrapper">
                                                                @if ($product->image)
                                                                    <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                                        alt="{{ $product->name }}"
                                                                        class="img-thumbnail" width="100px">
                                                                @else
                                                                    <img src="{{ asset('uploads/' . $settings['logo']) }}"
                                                                        alt="{{ $product->name }}"
                                                                        class="img-thumbnail" width="100px">
                                                                @endif
                                                                {{ $product->sku ?? '' }} - {{ $product->name }}
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>



                            {{-- ++++++++++++++++++++++ Left Sidebar : Products : filters ++++++++++++++++++++++ --}}
                            <div class="row">
                                <div class="col-md-3  border border-1 p-0 animate__animated animate__lightSpeedInLeft"
                                    style="height: 90vh;overflow: scroll;animation-delay: 1.35s">
                                    {{-- ============= filter : الموردين ============= --}}
                                    <div class="p-3 text-center font-weight-bold " style="background-color: #eee;"
                                        wire:ignore>
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
                                    <div class="p-3 text-center font-weight-bold " style="background-color: #eee;"
                                        wire:ignore>
                                        <div class="form-group">
                                            {!! Form::label('brand_id', __('lang.brand') . ':', []) !!}
                                            {!! Form::select('brand_id', $brands, null, [
                                                'class' => 'select2 form-control brand_class',
                                                'id' => 'brand_id',
                                                'required',
                                                'placeholder' => __('lang.please_select'),
                                                'data-name' => 'brand_id',
                                                'wire:model' => 'brand_id',
                                            ]) !!}
                                            @error('brand_id')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- ============= filter : الأقسام الرئيسيه ============= --}}
                                    <div class="p-3 text-center font-weight-bold " style="background-color: #eee;"
                                        wire:ignore>
                                        الأقسام الرئيسيه
                                        <div for="" class="d-flex align-items-center text-nowrap gap-1">
                                            {{-- الاقسام --}}
                                            <select class="form-control depart select2" wire:model="department_id"
                                                data-name="department_id">
                                                <option value="0" readonly selected>اختر </option>
                                                @foreach ($departments as $depart)
                                                    <option value="{{ $depart->id }}">{{ $depart->name }}
                                                    </option>
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
                                <div class="table-responsive col-md-9 border m-0 p-0 border-1 animate__animated animate__lightSpeedInRight  @if (app()->isLocale('ar')) dir-rtl @endif"
                                    style="height: 90vh;overflow: scroll;animation-delay: 1.35s">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="width: 10%" class="col-sm-8">@lang('lang.products')</th>
                                                <th style="width: 10%">@lang('lang.quantity')</th>
                                                <th style="width: 10%" class="dollar-cell">@lang('lang.purchase_price')$</th>
                                                <th style="width: 10%">@lang('lang.dinar_purchase_price') </th>
                                                <th style="width: 10%" class="dollar-cell">@lang('lang.dollar_total_prices')</th>
                                                <th style="width: 10%">@lang('lang.dinar_total_prices')</th>
                                                <th style="width: 10%">@lang('lang.current_stock')</th>
                                                <th style="width: 10%">@lang('lang.delete')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($items))
                                                {{-- {{ dd($items) }} --}}
                                                @foreach ($items as $index => $product)
                                                    @include('purchase_order.partials.product_row')
                                                @endforeach
                                                <tr>
                                                    {{-- +++++++++ Task : "مجموع اجمالي التكاليف" +++++++++ --}}
                                                    <td colspan="5" style="text-align: right">
                                                        @lang('lang.total')
                                                    </td>
                                                    <td class="dollar-cell"> {{ $this->sum_dollar_sub_total() }} </td>
                                                    {{-- <td></td>  --}}
                                                    {{-- <td></td>
                                                <td> {{$this->sum_sub_total()}} </td>
                                                <td></td> --}}
                                                    <td>
                                                        {{ $this->sum_dinar_sub_total() ?? 0 }}
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
                            <div class="col-md-12 text-center mt-1 animate__animated animate__lightSpeedInLeft"
                                style="animation-delay: 1.4s">
                                <div class="col-md-3 offset-md-8 text-right">
                                    <h4>@lang('lang.items_count'):
                                        <span class="items_count_span"
                                            style="margin-right: 15px;">{{ !empty($items) ? count($items) : 0 }}</span>
                                        @lang('lang.items_quantity'): <span class="items_quantity_span"
                                            style="margin-right: 15px;">{{ $this->total_quantity() }}</span>
                                    </h4>
                                </div>
                            </div>

                            {{-- ++++++++++++++++++++++ total ++++++++++++++++++++++ --}}
                            <div class="col-md-12 animate__animated animate__lightSpeedInRight"
                                style="animation-delay: 1.45s">
                                <div class="col-md-3 offset-md-8 text-right">
                                    <h3> @lang('lang.total') :
                                        @if ($paying_currency == 2)
                                            {{ $this->sum_dollar_total_cost() ?? 0.0 }}
                                        @else
                                            {{ $this->sum_total_cost() ?? 0.0 }}
                                        @endif
                                        <span class="final_total_span"></span>
                                    </h3>
                                    <input type="hidden" name="total_subtotal" id="total_subtotal_input"
                                        value="{{ $this->sum_total_cost() ?? 0.0 }}">

                                </div>
                            </div>

                            {{-- ++++++++++++++++++++++++ details textarea ++++++++++++++++++++++++ --}}
                            <div class="row justify-content-between animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                style="animation-delay: 1.5s;">

                                {!! Form::label('details', __('lang.details'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end h5  mb-3 width-fit' : ' mb-3 h5 width-fit',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                {{-- {!! Form::textarea('details', null, ['class' => 'form-control', 'rows' => 3]) !!} --}}
                                <textarea name="details" class="form-control initial-balance-input width-full" rows="3" wire:model="details"></textarea>

                            </div>
                        </div>
                        {{-- ++++++++++++++++++++ submit ++++++++++++++++++++ --}}
                        <div class="col-sm-12 animate__animated animate__lightSpeedInLeft"
                            style="animation-delay: 1.55s">
                            <button type="submit" name="submit" id="submit-save" style="margin: 10px"
                                value="save" class="btn btn-primary pull-right btn-flat submit"
                                wire:click.prevent="store()">@lang('lang.save')</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- <!-- This will be printed --> --}}
<section class="invoice print_section print-only" id="receipt_section"> </section>


@push('javascripts')
    <script>
        document.addEventListener('livewire:load', function() {
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
                // Set the generated HTML content
                $("#receipt_section").html(htmlContent);

                // Trigger the print action
                window.print();
            });
        });
        $(document).on("click", "#clear_all_input_form", function() {
            var value = $('#clear_all_input_form').is(':checked') ? 1 : 0;
            $.ajax({
                method: "get",
                url: "/create-or-update-system-property/clear_all_input_stock_form/" + value,
                contentType: "html",
                success: function(result) {
                    if (result.success) {
                        Swal.fire("Success", response.msg, "success");
                    }
                },
            });
        });
        // ++++++++++++++++++ when click on filters , execute updatedDepartmentId() ++++++++++++++++++
        $(document).ready(function() {
            // --------- when select "option" in "selectbox" ---------
            $('select').on('change', function(e) {
                var name = $(this).data('name');
                var index = $(this).data('index');
                var select2 = $(this); // Save a reference to $(this)
                Livewire.emit('listenerReferenceHere', {
                    var1: name,
                    var2: select2.select2("val"),
                    var3: index
                });
            });
        });
        // --------- to save "select option" in "selectbox" ---------
        document.addEventListener('livewire:load', function() {
            // "categories" filter
            $('.depart').select().on('change', function(e) {
                @this.set('department_id', $(this).val());
            });
            // "brands" filter
            $('.brand_class').select().on('change', function(e) {
                @this.set('brand_id', $(this).val());
            });
            // "supplier_class" filter
            $('.supplier_class').select().on('change', function(e) {
                @this.set('supplier_id', $(this).val());
            });
        });
    </script>
@endpush

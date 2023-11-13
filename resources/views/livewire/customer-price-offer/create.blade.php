<section class="forms">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div
                        class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @endif">
                        <h4>@lang('lang.customer_price_offer')</h4>
                    </div>
                    <div class="row align-items-center mb-2">
                        <div class="col-md-9">
                            <p class="italic pl-3 mb-0"><small>@lang('lang.required_fields_info') </small></p>
                        </div>
                        <div class="col-md-3">
                            <div class="i-checks">
                                <input id="clear_all_input_form" name="clear_all_input_form" type="checkbox"
                                    @if (isset($clear_all_input_stock_form) && $clear_all_input_stock_form == '1') checked @endif class="">
                                <label for="clear_all_input_form" style="font-size: 0.75rem">
                                    <strong>
                                        @lang('lang.clear_all_input_form')
                                    </strong>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- {!! Form::open([ 'id' => 'add_st ock_form']) !!} --}}
                    <form action="{{ route('pos.store') }}">
                        <div class="card-body py-0">
                            <div class="col-md-12">
                                <div
                                    class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {{-- ++++++++++++++++++++++ stores filter ++++++++++++++++++++++ --}}
                                    <div
                                        class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label
                                            class="mx-2 mb-0 width-fit @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="store_id">
                                            @lang('lang.store')<span style="color:#dc3545;">*</span>
                                        </label>
                                        <div
                                            class=" input-wrapper d-flex justify-content-between align-items-center width-fit">
                                            <select class=" initial-balance-input m-auto client"
                                                style="width: 100%; border:2px solid #ccc" wire:model="store_id"
                                                id="Client_Select" required>
                                                <option value="" readonly selected> {{ __('lang.please_select') }}
                                                </option>
                                                @foreach ($stores as $store)
                                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('store_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- ++++++++++++++++++++++ customer filter ++++++++++++++++++++++ --}}
                                    <div
                                        class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label for="customer_id"
                                            class="mx-2 mb-0 width-fit @if (app()->isLocale('ar')) d-block text-end @endif">
                                            @lang('lang.customers')<span style="color:#dc3545;">*</span>
                                        </label>
                                        <div
                                            class=" input-wrapper width-fit d-flex justify-content-between align-items-center">
                                            <select class=" initial-balance-input m-auto client"
                                                style="width: 100%; border:2px solid #ccc" wire:model="customer_id"
                                                id="Client_Select" required>
                                                <option value="" readonly selected> {{ __('lang.please_select') }}
                                                </option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('customer_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- ++++++++++++++++++++++ search inputField ++++++++++++++++++++++ --}}

                                    <div class="col-md-6 mb-2">
                                        <div class="search-box input-group">
                                            {{-- ++++++++++++++++++++++ search_button ++++++++++++++++++++++ --}}
                                            <button type="button" class="btn btn-secondary" id="search_button"><i
                                                    class="fa fa-search"></i>
                                            </button>
                                            <input type="search" name="search_product" id="search_product"
                                                wire:model.debounce.200ms="searchProduct"
                                                placeholder="@lang('lang.enter_product_name_to_print_labels')" class="form-control" autocomplete="off">
                                            {{-- ++++++++++ search_result  ++++++++++ --}}
                                            @if (!empty($search_result))
                                                <ul id="ui-id-1" tabindex="0"
                                                    class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2"
                                                    style="top: 37.423px; left: 39.645px; width: 90.2%;">
                                                    @foreach ($search_result as $product)
                                                        <li class="ui-menu-item"
                                                            wire:click="add_product({{ $product->id }})">
                                                            <div id="ui-id-73" tabindex="-1"
                                                                class="ui-menu-item-wrapper">
                                                                <img src="https://mahmoud.s.sherifshalaby.tech/uploads/995_image.png"
                                                                    width="50px" height="50px">
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

                            {{-- ++++++++++++++++++++++ products ++++++++++++++++++++++ --}}
                            <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div class="col-md-2 border border-1 p-0" style="height: 90vh;overflow: scroll">
                                    {{-- +++++++++++++++++++++ الأقسام الرئيسيه ++++++++++++++++++++++ --}}
                                    <div class="p-3 text-center font-weight-bold " style="background-color: #eee;">
                                        الأقسام الرئيسيه
                                        <div for="" class="d-flex align-items-center text-nowrap gap-1"
                                            wire:ignore>
                                            {{-- الاقسام --}}
                                            <select class="form-control select2" data-name="department_id"
                                                wire:model="department_id">
                                                <option value="" readonly selected>اختر </option>
                                                @foreach ($departments as $depart)
                                                    <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++++++++ المنتجات +++++++++++++++++++++ --}}
                                    <div class="p-2">
                                        @foreach ($products as $product)
                                            <div class="order-btn" style="cursor: pointer"
                                                wire:click='add_product({{ $product->id }})'>
                                                <span>{{ $product->name }}</span>
                                                <span>{{ $product->sku }} </span>
                                            </div>
                                            <hr />
                                        @endforeach
                                    </div>
                                </div>
                                <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif col-md-10 border border-1"
                                    style="height: 90vh;overflow: scroll">
                                    {{-- +++++++++++++++++++++ جدول المنتجات +++++++++++++++++++++ --}}
                                    <table class="table" style="width: auto">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="width: 10%;text-align: center" class="col-sm-8">
                                                    @lang('lang.products')</th>
                                                <th style="width: 10%;text-align: center">@lang('lang.quantity')</th>
                                                {{-- <th style="width: 10%;text-align: center">@lang('lang.purchase_price')$</th>  --}}
                                                <th style="width: 20%" class="dollar-cell">@lang('lang.selling_price')$</th>
                                                {{-- <th style="width: 10%;text-align: center">@lang('lang.sub_total')$</th>  --}}
                                                {{-- <th style="width: 10%;text-align: center">@lang('lang.purchase_price')  </th> --}}
                                                <th style="width: 20%">@lang('lang.selling_price') </th>
                                                {{-- <th style="width: 10%;text-align: center">@lang('lang.sub_total')</th> --}}
                                                {{-- <th style="width: 10%;text-align: center">@lang('lang.cost')$</th>  --}}
                                                <th style="width: 15%;text-align: center" class="dollar-cell">
                                                    @lang('lang.total_cost')$</th>
                                                {{-- <th style="width: 10%;text-align: center">@lang('lang.cost') </th>  --}}
                                                <th style="width: 10%;text-align: center">@lang('lang.total_cost')</th>
                                                <th style="width: 10%;text-align: center">@lang('lang.current_stock')</th>
                                                <th style="width: 5%;text-align: center">@lang('lang.delete')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($items))
                                                @foreach ($items as $index => $product)
                                                    @include('customer_price_offer.partials.product_row')
                                                @endforeach
                                                <tr>
                                                    {{-- +++++++++ Task : "مجموع اجمالي التكاليف" +++++++++ --}}
                                                    <td class="text-center" colspan="5"
                                                        style="text-align: right;font-size: 14px;font-weight: 500;">
                                                        @lang('lang.total')
                                                    </td>
                                                    <td class="text-center dollar-cell"
                                                        style="font-size: 14px;font-weight: 500;">
                                                        {{ $this->sum_dollar_sub_total() }} </td>
                                                    {{-- <td></td>  --}}
                                                    {{-- <td></td>
                                                <td> {{$this->sum_sub_total()}} </td>
                                                <td></td> --}}
                                                    <td class="text-center" style="font-size: 14px;font-weight: 500;">
                                                        {{ $this->sum_dinar_sub_total() ?? 0 }}
                                                    </td>
                                                    {{-- <td></td>
                                                <td  style=";">
                                                    {{$this->sum_total_cost() ?? 0}}
                                                </td> --}}
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- ++++++++ total_quantity ++++++++++  --}}
                            <div class="col-md-12 text-center mt-1 ">
                                <h4>@lang('lang.items_count'):
                                    <span class="items_count_span"
                                        style="margin-right: 15px;">{{ !empty($items) ? count($items) : 0 }}</span>
                                    <br> @lang('lang.items_quantity'): <span class="items_quantity_span"
                                        style="margin-right: 15px;">{{ $this->total_quantity() }}</span>
                                </h4>
                            </div>

                            {{-- ++++++++ total ++++++++++  --}}
                            <div class="col-md-12">
                                <div class="col-md-3 offset-md-8 text-right">
                                    <h3> @lang('lang.total') :
                                        @if ($paying_currency == 2)
                                            {{ $this->sum_dollar_total_cost() ?? 0.0 }}
                                        @else
                                            {{ $this->sum_total_cost() ?? 0.0 }}
                                        @endif
                                        <span class="final_total_span"></span>
                                    </h3>
                                </div>
                            </div>
                            <br>

                            <div
                                class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {{-- ========= block_qty ========= --}}
                                <div
                                    class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <div class="form-group">
                                        <div class="i-checks">
                                            <input type="checkbox" id="block_qty" name="block_qty"
                                                class="form-control-custom" value="" wire:model="block_qty"
                                                required />
                                            <label for="block_qty"><strong>@lang('lang.block_qty')</strong></label>
                                        </div>
                                    </div>
                                </div>
                                {{-- ========= block_for_days ========= --}}
                                <div
                                    class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label(
                                        'block_for_days',
                                        __('lang.block_for_days') . ':<span style="color:#dc3545;">*</span>',
                                        [
                                            'class' => ' app()->isLocale("ar")? d-block text-end mx-2 mb-0 width-quarter : mx-2 mb-0 width-quarter',
                                        ],
                                        false,
                                    ) !!}
                                    <div class="input-wrapper">

                                        {!! Form::text('block_for_days', 1, [
                                            'class' => 'form-control initial-balance-input m-auto app()->isLocale("ar")?  text-end  : text-start',
                                            'style' => 'width: 100%',
                                            'placeholder' => __('lang.block_for_days'),
                                            'wire:model' => 'block_for_days',
                                            'required',
                                        ]) !!}
                                    </div>
                                    @error('block_for_days')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- ========= validity_days ========= --}}
                                <div
                                    class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label(
                                        'validity_days',
                                        __('lang.validity_days') . ':<span style="color:#dc3545;">*</span>',
                                        ['class' => ' app()->isLocale("ar")? d-block text-end mx-2 mb-0 width-quarter : mx-2 mb-0 width-quarter'],
                                        false,
                                    ) !!}
                                    {{-- {!! Form::label('validity_days', __('lang.validity_days') . ':') !!} --}}
                                    <div class="input-wrapper">

                                        {!! Form::text('validity_days', null, [
                                            'class' => 'form-control initial-balance-input m-auto app()->isLocale("ar")?  text-end  : text-start',
                                            'style' => 'width: 100%',
                                            'placeholder' => __('lang.validity_days'),
                                            'wire:model' => 'validity_days',
                                            'required',
                                        ]) !!}
                                    </div>
                                    @error('validity_days')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- ========= tax ========= --}}
                                <div
                                    class="col-md-3  mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label
                                        class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                        for="tax_method">@lang('lang.tax')</label>
                                    <div class="input-wrapper">
                                        <select class=" initial-balance-input m-auto p-0"
                                            style="width: 100%;border:2px solid #ccc;border-radius:12px"
                                            name="tax_method" id="tax_method" wire:model='tax_method'>
                                            <option value="" selected>{{ __('lang.please_select') }}</option>
                                            @foreach ($taxes as $tax)
                                                <option data-rate="{{ $tax->rate }}" value="{{ $tax->id }}">
                                                    {{ $tax->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- ========= discount_type ========= --}}
                                <div
                                    class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label('discount_type', __('lang.discount_type'), [
                                        'class' => ' app()->isLocale("ar")? d-block text-end mx-2 mb-0 width-quarter : mx-2 mb-0 width-quarter',
                                    ]) !!}
                                    <div class="input-wrapper">

                                        {!! Form::select('discount_type', ['fixed' => 'Fixed', 'percentage' => 'Percentage'], 'fixed', [
                                            'class' => ' initial-balance-input m-auto p-0',
                                            'style' => 'width:100%;border:2px solid #ccc;border-radius:12px',
                                            'placeholder' => __('lang.please_select'),
                                            'data-live-search' => 'true',
                                            'wire:model' => 'discount_type',
                                        ]) !!}
                                    </div>
                                </div>
                                {{-- ========= discount_value ========= --}}
                                <div
                                    class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {!! Form::label('discount_value', __('lang.discount_value'), [
                                        'class' => ' app()->isLocale("ar")? d-block text-end mx-2 mb-0 width-quarter : mx-2 mb-0 width-quarter',
                                    ]) !!}
                                    <div class="input-wrapper">

                                        {!! Form::text('discount_value', null, [
                                            'class' => ' initial-balance-input px-2 m-auto app()->isLocale("ar")? text-end : text-start',
                                            'style' => 'width:100%;',
                                            'placeholder' => __('lang.discount_value'),
                                            'wire:model' => 'discount_value',
                                        ]) !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{-- ++++++++++++++++++++ submit ++++++++++++++++++++ --}}
                        <div class="col-sm-12">
                            <button type="submit" name="submit" id="submit-save" style="margin: 10px"
                                value="save" class="btn btn-primary pull-right btn-flat submit"
                                wire:click.prevent = "store()">@lang('lang.save')</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
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
                // $("#receipt_section").html(htmlContent);

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
                        // Swal.fire("Success", response.msg, "success");
                        Swal.fire({
                            title: "Success",
                            text: response.status,
                            icon: "success",
                            timer: 1000, // Set the timer to 1000 milliseconds (1 second)
                            showConfirmButton: false // This will hide the "OK" button
                        });

                    }
                },
            });
        });

        $(document).ready(function() {
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
    </script>
@endpush

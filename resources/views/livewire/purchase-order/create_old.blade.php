<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header d-flex align-items-center">
                        <h4>@lang('lang.purchase_order')</h4>
                    </div>
                    <div class="row ">
                        <div class="col-md-9">
                            <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info') </small></p>
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
                    {{-- +++++++++++++++++++++ form +++++++++++++++++ --}}
                    <form action="{{ route('pos.store') }}">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    {{-- ////////////////// stores filter ////////////////// --}}
                                    <div class="col-md-4">
                                        <label for="store_id" class="text-primary">
                                            @lang('lang.store'):<span style="color:#dc3545;">*</span>
                                        </label>
                                        <div class="d-flex justify-content-center">
                                            <select class="form-control client" wire:model="store_id" id="Client_Select"
                                                required>
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
                                    {{-- ////////////////// suppliers filter ////////////////// --}}
                                    <div class="col-md-4">
                                        <label for="customer_id" class="text-primary">
                                            @lang('lang.suppliers'):<span style="color:#dc3545;">*</span>
                                        </label>
                                        <div class="d-flex justify-content-center">
                                            <select class="form-control client" wire:model="supplier_id"
                                                id="Client_Select" required>
                                                <option value="" readonly selected> {{ __('lang.please_select') }}
                                                </option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('customer_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- ////////////////// product_number inputField : رقم طلب الشراء  ////////////////// --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('po_no', __('lang.po_no') . ':*', []) !!}
                                            {!! Form::text('po_no', $po_no, [
                                                'class' => 'form-control',
                                                'required',
                                                'readonly',
                                                'placeholder' => __('lang.po_no'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            {{-- ++++++++++++++++++++++ search inputField ++++++++++++++++++++++ --}}
                            <div class="row">
                                <div class="col-md-8 m-t-15 offset-md-2">
                                    <div class="search-box input-group">
                                        {{-- ++++++++++++++++++++++ search_button ++++++++++++++++++++++ --}}
                                        <button type="button" class="btn btn-secondary" id="search_button"><i
                                                class="fa fa-search"></i>
                                        </button>
                                        <input type="search" name="search_product" id="search_product"
                                            wire:model.debounce.200ms="searchProduct" placeholder="@lang('lang.enter_product_name_to_print_labels')"
                                            class="form-control" autocomplete="off">
                                        {{-- ++++++++++ search_result  ++++++++++ --}}
                                        @if (!empty($search_result))
                                            <ul id="ui-id-1" tabindex="0"
                                                class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2"
                                                style="top: 37.423px; left: 39.645px; width: 90.2%;">
                                                @foreach ($search_result as $product)
                                                    <li class="ui-menu-item"
                                                        wire:click="add_product({{ $product->id }})">
                                                        <div id="ui-id-73" tabindex="-1" class="ui-menu-item-wrapper">
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
                            <br>
                            {{-- ++++++++++++++++++++++ products ++++++++++++++++++++++ --}}
                            <div class="row">
                                <div class="col-md-2 border border-1 mr-3 p-0">
                                    {{-- +++++++++++++++++++++ الأقسام الرئيسيه ++++++++++++++++++++++ --}}
                                    <div class="p-3 text-center font-weight-bold " style="background-color: #eee;">
                                        الأقسام الرئيسيه
                                        <div for="" class="d-flex align-items-center text-nowrap gap-1"
                                            wire:ignore>
                                            {{-- /////////// الاقسام /////////// --}}
                                            <select class="form-control select2" data-name="department_id"
                                                wire:model="department_id">
                                                <option value="" readonly selected>اختر </option>
                                                @foreach ($departments as $depart)
                                                    <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- /////////// المنتجات /////////// --}}
                                    <div class="p-2">
                                        @foreach ($products as $product)
                                            <div class="order-btn" wire:click='add_product({{ $product->id }})'>
                                                <span>{{ $product->name }}</span>
                                                <span>{{ $product->sku }} </span>
                                            </div>
                                            <hr />
                                        @endforeach
                                    </div>
                                </div>
                                <div class="table-responsive col-md-9 border border-1">
                                    {{-- +++++++++++++++++++++ جدول المنتجات +++++++++++++++++++++ --}}
                                    <table class="table" style="width: auto">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="width: 10%" class="col-sm-8">@lang('lang.products')</th>
                                                <th style="width: 10%">@lang('lang.quantity')</th>
                                                <th style="width: 10%">@lang('lang.purchase_price')$</th>
                                                {{-- <th style="width: 20%">@lang('lang.selling_price')$</th> --}}
                                                {{-- <th style="width: 10%">@lang('lang.sub_total')$</th>  --}}
                                                <th style="width: 10%">@lang('lang.dinar_purchase_price') </th>
                                                {{-- <th style="width: 20%">@lang('lang.selling_price') </th> --}}
                                                {{-- <th style="width: 10%">@lang('lang.sub_total')</th> --}}
                                                {{-- <th style="width: 10%">@lang('lang.cost')$</th>  --}}
                                                <th style="width: 10%">@lang('lang.dollar_total_prices')</th>
                                                {{-- <th style="width: 10%">@lang('lang.cost') </th>  --}}
                                                <th style="width: 10%">@lang('lang.dinar_total_prices')</th>
                                                <th style="width: 10%">@lang('lang.current_stock')</th>
                                                <th style="width: 10%">@lang('lang.delete')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($items))
                                                @foreach ($items as $index => $product)
                                                    @include('purchase_order.partials.product_row')
                                                @endforeach
                                                <tr>
                                                    {{-- +++++++++ Task : "مجموع اجمالي التكاليف" +++++++++ --}}
                                                    <td colspan="5" style="text-align: right"> @lang('lang.total')
                                                    </td>
                                                    <td> {{ $this->sum_dollar_sub_total() }} </td>
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
                            {{-- ++++++++ total_quantity ++++++++++  --}}
                            <div class="col-md-12 text-center mt-1 ">
                                <h4>@lang('lang.items_count'):
                                    <span class="items_count_span"
                                        style="margin-right: 15px;">{{ !empty($items) ? count($items) : 0 }}</span>
                                    <br> @lang('lang.items_quantity'): <span class="items_quantity_span"
                                        style="margin-right: 15px;">{{ $this->total_quantity() }}</span>
                                </h4>
                            </div>
                            <br>
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
                                    <input type="hidden" name="total_subtotal" id="total_subtotal_input"
                                        value="{{ $this->sum_total_cost() ?? 0.0 }}">

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

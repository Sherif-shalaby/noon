<section class="app my-3 no-print" style="padding: 0 20px;">
    <div class="">
        {!! Form::open(['route' => 'pos.store', 'method' => 'post']) !!}
        <div class="">

            <div>
                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div
                        class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                        {!! Form::label('brand_id', __('lang.brand') . '*', [
                            'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : ' mx-2 mb-0 h5 width-quarter',
                            'style' => 'font-size: 12px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::select('brand_id', $brands, $brand_id, [
                                'class' => 'select2 form-control',
                                'data-live-search' => 'true',
                                'id' => 'brand_id',
                                'required',
                                'placeholder' => __('lang.please_select'),
                                'data-name' => 'brand_id',
                                'wire:model' => 'brand_id',
                            ]) !!}
                        </div>
                        @error('brand_id')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++++++ مخزن ++++++++++++++++++++++ --}}
                    <div
                        class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                        {!! Form::label('store_id', __('lang.store') . '*', [
                            'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : ' mx-2 mb-0 h5 width-quarter',
                            'style' => 'font-size: 12px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::select('store_id', $stores, $store_id, [
                                'class' => 'select2 form-control',
                                'data-live-search' => 'true',
                                'id' => 'store_id',
                                'required',
                                'placeholder' => __('lang.please_select'),
                                'data-name' => 'store_id',
                                'wire:model' => 'store_id',
                                'wire:change' => 'changeAllProducts',
                            ]) !!}
                        </div>
                        @error('store_id')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- ++++++++++++++++++++++ نقاط البيع +++++++++++++++++++++ --}}
                    <div
                        class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                        {!! Form::label('store_pos_id', __('lang.pos') . '*', [
                            'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : ' mx-2 mb-0 h5 width-quarter',
                            'style' => 'font-size: 12px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper">
                            {!! Form::select('store_pos_id', $store_pos, $store_pos_id, [
                                'class' => 'select2 form-control',
                                'data-name' => 'store_pos_id',
                                'data-live-search' => 'true',
                                'required',
                                'placeholder' => __('lang.please_select'),
                                'wire:model' => 'store_pos_id',
                            ]) !!}
                        </div>
                        @error('store_pos_id')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- +++++++++++++++++++++++++ حالة السداد ++++++++++++++++++++++++++++ --}}
                    {{--                    <div class="col-md-2"> --}}
                    {{--                        <div class="form-group"> --}}
                    {{--                            {!! Form::label('payment_status', __('lang.payment_status') . ':', []) !!} --}}
                    {{--                            {!! Form::select('payment_status', ['pending' => __('lang.pending'),'paid' => __('lang.paid'), 'partial' => __('lang.partial')],'paid', ['class' => 'form-control select2' ,'data-name'=>'payment_status', 'data-live-search' => 'true', 'placeholder' => __('lang.please_select'), 'wire:model' => 'payment_status']) !!} --}}
                    {{--                            @error('payment_status') --}}
                    {{--                            <span class="error text-danger">{{ $message }}</span> --}}
                    {{--                            @enderror --}}
                    {{--                        </div> --}}
                    {{--                    </div> --}}
                    {{-- +++++++++++++++++ Customers Dropdown +++++++++++++++++ --}}
                    <div
                        class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <label for="" class=" @if (app()->isLocale('ar')) d-block text-end @endif h5 mb-0"
                            style="font-size: 12px;font-weight: 500;">العملاء</label>
                        <div class="input-wrapper">
                            <select class="form-control client select2" wire:model="client_id" id="client_id"
                                data-name="client_id">
                                <option value="0 " readonly>اختر </option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ $client_id == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="add-button d-flex justify-content-center align-items-center"
                                data-toggle="modal" data-target="#add_customer"><i class="fas fa-plus"></i></button>
                        </div>
                        @error('client_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- +++++++++++++++++ Customers Dropdown +++++++++++++++++ --}}

                @include('invoices.partials.search')
            </div>


            <div>
                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                    <div class="col-md-3">

                        <div style="background-color: #E6E6E6;color: black;border-right adius: 16px;box-shadow: 5px 8px 4px -5px #bbb inset;"
                            class=" d-flex mb-3 justify-content-between rounded p-2">


                            <div class="col-md-6 p-0 form-check-inline checkbox-dark d-flex">
                                <input type="checkbox" id="from_a_to_z" wire:model="from_a_to_z"
                                    name="customCheckboxInline2" class="sorting_filter filterInput">
                                <label style="font-size: 11px;font-weight: 600;" for="from_a_to_z"
                                    class="checkbox-inline filterLabel mb-0 ml-2">
                                    @lang('lang.from_a_to_z')
                                </label>
                            </div>

                            <div class="col-md-6 p-0 form-check-inline checkbox-dark d-flex">
                                <input type="checkbox" id="from_z_to_a" wire:model="from_z_to_a"
                                    name="customCheckboxInline2" class="sorting_filter filterInput">
                                <label style="font-size: 11px;font-weight: 600;"
                                    class="checkbox-inline filterLabel mb-0 ml-2"
                                    for="from_z_to_a">@lang('lang.from_z_to_a')</label>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div style="background-color: #E6E6E6;color: black;border-right adius: 16px;box-shadow: 5px 8px 4px -5px #bbb inset;"
                            class=" d-flex mb-3 justify-content-between rounded  p-2">
                            <div class="col-md-6 p-0 form-check-inline checkbox-dark d-flex">

                                <input type="checkbox" id="highest_price" wire:model="highest_price"
                                    name="customCheckboxInline2" class="sorting_filter filterInput">
                                <label style="font-size: 11px;font-weight: 600;"
                                    class="checkbox-inline filterLabel mb-0 ml-2"
                                    for="highest_price">@lang('lang.highest_price')</label>

                            </div>

                            <div class="col-md-6 p-0 form-check-inline checkbox-dark d-flex">

                                <input type="checkbox" id="lowest_price" wire:model="lowest_price"
                                    name="customCheckboxInline2" class="sorting_filter filterInput">
                                <label style="font-size: 11px;font-weight: 600;"
                                    class="checkbox-inline filterLabel mb-0 ml-2"
                                    for="lowest_price">@lang('lang.lowest_price')</label>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">

                        <div style="background-color: #E6E6E6;color: black;border-right adius: 16px;box-shadow: 5px 8px 4px -5px #bbb inset;"
                            class=" d-flex mb-3 justify-content-between rounded p-2  dollar-cell">
                            <div class="col-md-6 p-0 form-check-inline checkbox-dark d-flex">

                                <input type="checkbox" id="dollar_highest_price" wire:model="dollar_highest_price"
                                    name="customCheckboxInline2" class="sorting_filter filterInput">
                                <label style="font-size: 11px;font-weight: 600;"
                                    class="checkbox-inline filterLabel mb-0 ml-2"
                                    for="dollar_highest_price">@lang('lang.dollar_highest_price')</label>

                            </div>

                            <div class="col-md-6 p-0 form-check-inline checkbox-dark d-flex">

                                <input type="checkbox" id="dollar_lowest_price" wire:model="dollar_lowest_price"
                                    name="customCheckboxInline2" class="sorting_filter filterInput">
                                <label style="font-size: 11px;font-weight: 600;"
                                    class="checkbox-inline filterLabel mb-0 ml-2"
                                    for="dollar_lowest_price">@lang('lang.dollar_lowest_price')</label>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">

                        <div style="background-color: #E6E6E6;color: black;border-right adius: 16px;box-shadow: 5px 8px 4px -5px #bbb inset;"
                            class=" d-flex mb-3 justify-content-between rounded p-2">
                            <div class="col-md-6 p-0 form-check-inline checkbox-dark d-flex">
                                <input class="sorting_filter filterInput" type="checkbox" id="nearest_expiry_filter"
                                    wire:model="nearest_expiry_filter" name="customCheckboxInline2">
                                <label style="font-size: 11px;font-weight: 600;"
                                    class="checkbox-inline filterLabel mb-0 ml-2"
                                    for="nearest_expiry_filter">@lang('lang.nearest_expiry_filter')</label>

                            </div>

                            <div class="col-md-6 p-0 form-check-inline checkbox-dark d-flex">

                                <input class="sorting_filter filterInput" type="checkbox" id="longest_expiry_filter"
                                    wire:model="longest_expiry_filter" name="customCheckboxInline2">
                                <label style="font-size: 11px;font-weight: 600;"
                                    class="checkbox-inline filterLabel mb-0 ml-2"
                                    for="longest_expiry_filter">@lang('lang.longest_expiry_filter')</label>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="row g-3 cards hide-print @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            @include('invoices.partials.products')
            <div class="col-xl-10 special-medal-col">
                <div class="card-app ">
                    <div class="body-card-app content py-2 ">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="body-card-app">
                                <div
                                    class="table-responsive box-table @if (app()->isLocale('ar')) dir-rtl @endif">
                                    <table class="table">
                                        <tr>
                                            <th style="font-weight: 700;font-size: 10px;text-align: center">
                                                @lang('lang.product')</th>
                                            <th style="font-weight: 700;font-size: 10px;text-align: center">
                                                @lang('lang.quantity')</th>
                                            <th style="font-weight: 700;font-size: 10px;text-align: center">
                                                @lang('lang.extra')</th>
                                            <th style="font-weight: 700;font-size: 10px;text-align: center">
                                                @lang('lang.unit')</th>
                                            <th style="font-weight: 700;font-size: 10px;text-align: center">
                                                @lang('lang.price')</th>
                                            <th class="dollar-cell"
                                                style="font-weight: 700;font-size: 10px;text-align: center">
                                                @lang('lang.price') $ </th>
                                            <th style="font-weight: 700;font-size: 10px;text-align: center">
                                                @lang('lang.exchange_rate')</th>
                                            <th style="font-weight: 700;font-size: 10px;text-align: center">
                                                @lang('lang.discount')</th>
                                            <th style="font-weight: 700;font-size: 10px;text-align: center">
                                                @lang('lang.discount_category')</th>
                                            <th style="font-weight: 700;font-size: 10px;text-align: center">
                                                @lang('lang.sub_total')</th>
                                            <th class="dollar-cell"
                                                style="font-weight: 700;font-size: 10px;text-align: center">
                                                @lang('lang.sub_total') $</th>
                                            <th style="font-weight: 700;font-size: 10px;text-align: center">
                                                @lang('lang.current_stock')</th>
                                            <th style="font-weight: 700;font-size: 10px;text-align: center">
                                                @lang('lang.action')</th>
                                        </tr>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach ($items as $key => $item)
                                            <tr>
                                                <td style="font-weight: 700;font-size: 10px;"
                                                    class="px-1 border-right ">

                                                    {{ $item['product']['name'] }}

                                                </td>

                                                <td class="px-1 border-right ">
                                                    <div class="d-flex align-items-center gap-1 " style="width: 80px">
                                                        <div class=" add-num control-num d-flex justify-content-center align-items-center"
                                                            style="width: 15px;height: 15px;border-right adius: 50%;color: white;background-color: #596fd7"
                                                            wire:click="increment({{ $key }})">
                                                            <i style="font-size: 10px;width: 50px;font-weight: 600"
                                                                class="fa-solid fa-plus"></i>
                                                        </div>
                                                        <input class="form-control p-1 text-center"
                                                            style="width: 50px" type="text" min="1"
                                                            wire:model="items.{{ $key }}.quantity"
                                                            Wire:change="subtotal({{ $key }})">
                                                        @error("items.$key.quantity")
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <div class="decrease-num control-num d-flex justify-content-center align-items-center"
                                                            style="width: 15px;height: 15px;border-right adius: 50%;color: white;background-color: #596fd7"
                                                            wire:click="decrement({{ $key }})">
                                                            <i style="font-size: 10px;width: 50px;font-weight: 600"
                                                                class="fa-solid fa-minus"></i>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="px-1 border-right "
                                                    style="font-weight: 700;font-size: 10px;">
                                                    {{ $item['extra_quantity'] }}
                                                </td>

                                                <td class="px-1 border-right ">
                                                    <select class="form-control"
                                                        style="height:30% !important;width:50px;"
                                                        wire:model="items.{{ $key }}.unit_id"
                                                        wire:change="changeUnit({{ $key }})">
                                                        <option value="0.00">select</option>
                                                        @if (!empty($item['variation']))
                                                            @foreach ($item['variation'] as $i => $var)
                                                                <option value="{{ $var['id'] }}"
                                                                    {{ $i == 0 ? 'selected' : '' }}>
                                                                    {{ $var['unit']['name'] ?? '' }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>

                                                <td class="px-1 border-right "
                                                    style="font-weight: 700;font-size: 10px;">
                                                    {{ $item['price'] ?? '' }}
                                                </td>

                                                <td class="px-1 border-right dollar-cell"
                                                    style="font-weight: 700;font-size: 10px;">
                                                    {{ number_format($item['dollar_price'] ?? 0, 2) }}
                                                </td>

                                                <td class="px-1 border-right ">
                                                    <input style="font-weight: 700;font-size: 10px;width: 75px"
                                                        class="form-control p-1 text-center" type="text"
                                                        min="1"
                                                        wire:model="items.{{ $key }}.exchange_rate">
                                                </td>

                                                <td class="px-1 border-right ">
                                                    <input class="form-control p-1 text-center" style="width:35px"
                                                        type="text" min="1" readonly
                                                        wire:model="items.{{ $key }}.discount_price">
                                                </td>
                                                <td class="px-1 border-right ">
                                                    <select class="form-control discount_category "
                                                        style="height:30% !important;width:50px;font-size:14px;"
                                                        wire:model="items.{{ $key }}.discount"
                                                        wire:change="subtotal({{ $key }})">
                                                        <option selected value="0">select</option>
                                                        @if (!empty($item['discount_categories']))
                                                            @if (!empty($client_id))
                                                                @foreach ($item['discount_categories'] as $discount)
                                                                    @if ($discount['price_category'] !== null)
                                                                        {{--                                                                        @if (in_array($client_id, $discount['price_customer_types'])) --}}
                                                                        <option value="{{ $discount['id'] }}">
                                                                            {{ $discount['price_category'] }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                @foreach ($item['discount_categories'] as $discount)
                                                                    @if ($discount['price_category'] !== null)
                                                                        <option value="{{ $discount['id'] }}">
                                                                            {{ $discount['price_category'] ?? '' }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    </select>
                                                </td>
                                                <td class="px-1 border-right "
                                                    style="font-weight: 700;font-size: 10px;">
                                                    {{ $item['sub_total'] ?? 0 }}
                                                </td>
                                                <td class="px-1 border-right dollar-cell"
                                                    style="font-weight: 700;font-size: 10px;">
                                                    {{ $item['dollar_sub_total'] ?? 0 }}
                                                </td>
                                                <td class="px-1 border-right ">
                                                    <span class="current_stock"
                                                        style="font-weight: 700;font-size: 10px;">
                                                        {{ $item['quantity_available'] }}
                                                        {{-- @if (!empty($item['stock_units']))
                                                            @foreach ($item['stock_units'] as $i => $value)
                                                            @if (!empty($value))
                                                                @foreach ($value as $x => $v)
                                                                    {{$v}} {{$x}}
                                                                @endforeach
                                                                @endif
                                                            @endforeach
                                                        @endif --}}
                                                    </span>
                                                </td>
                                                <td class="text-center px-1 border-right">
                                                    <div class="btn btn-sm btn-success py-0 px-1 my-1"
                                                        wire:click="changePrice({{ $key }})">
                                                        <i class="fas fa-undo"></i>
                                                    </div>
                                                    <div class="btn btn-sm btn-danger py-0 px-1"
                                                        wire:click="delete_item({{ $key }})">
                                                        <i class="fas fa-trash-can"></i>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('invoices.partials.rightSidebar')
        </div>
        {!! Form::close() !!}
    </div>
</section>
@include('customers.quick_add', ['quick_add' => 1])



{{-- <!-- This will be printed --> --}}
<section class="invoice print_section print-only" id="receipt_section"> </section>
@push('javascripts')
    <script>
        document.addEventListener('livewire:load', function() {
            $('.depart').select().on('change', function(e) {
                @this.set('department_id', $(this).val());
            });
        });
        document.addEventListener('livewire:load', function() {
            $('#store_id').select();
            // Trigger Livewire updates when the select2 value changes
            $('#store_id').on('change', function(e) {
                @this.set('store_id', $(this).val());
            });
        });
        document.addEventListener('livewire:load', function() {
            Livewire.on('printInvoice', function(htmlContent) {
                // Set the generated HTML content
                $("#receipt_section").html(htmlContent);
                // Trigger the print action
                window.print("#receipt_section");
            });
        });
        window.addEventListener('quantity_not_enough', function(event) {
            var id = event.detail.id;
            Swal.fire({
                title: "{{ __('lang.out_of_stock') }}" + "<br>",
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: LANG.cancel,
                cancelButtonText: LANG.po,
            }).then((result) => {
                if (result.isConfirmed) {} else {
                    Livewire.emit('create_purchase_order', id);
                }
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

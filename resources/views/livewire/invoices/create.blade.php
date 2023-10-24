
<section class="app my-3 no-print" style="margin-top: 35px!important;">
    <div class="" >
        {!! Form::open(['route' => 'pos.store','method'=>'post' ]) !!}
        <div class="row">
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('brand_id', __('lang.brand') . ':*', []) !!}
                            {!! Form::select('brand_id', $brands, $brand_id,
                            ['class' => 'select2 form-control', 'data-live-search' => 'true','id'=>'brand_id', 'required', 'placeholder' => __('lang.please_select'),
                             'data-name' => 'brand_id','wire:model' => 'brand_id']) !!}
                            @error('brand_id')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 pt-3">
                        <div class="form-check-inline checkbox-dark">
                            <input type="checkbox" id="from_a_to_z" wire:model="from_a_to_z" name="customCheckboxInline2">
                            <label for="from_a_to_z">@lang('lang.from_a_to_z')</label>
                        </div>
                    </div>
                    <div class="col-md-4 pt-3">
                        <div class="form-check-inline checkbox-dark">
                            <input type="checkbox" id="from_z_to_a" wire:model="from_z_to_a" name="customCheckboxInline2">
                            <label for="from_z_to_a">@lang('lang.from_z_to_a')</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check-inline checkbox-dark">
                            <input type="checkbox" id="highest_price" wire:model="highest_price" name="customCheckboxInline2">
                            <label for="highest_price">@lang('lang.highest_price')</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check-inline checkbox-dark">
                            <input type="checkbox" id="lowest_price" wire:model="lowest_price" name="customCheckboxInline2">
                            <label for="lowest_price">@lang('lang.lowest_price')</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check-inline checkbox-dark">
                            <input type="checkbox" id="dollar_highest_price" wire:model="dollar_highest_price" name="customCheckboxInline2">
                            <label for="dollar_highest_price">@lang('lang.dollar_highest_price')</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check-inline checkbox-dark">
                            <input type="checkbox" id="dollar_lowest_price" wire:model="dollar_lowest_price" name="customCheckboxInline2">
                            <label for="dollar_lowest_price">@lang('lang.dollar_lowest_price')</label>
                        </div>
                    </div>
                 
                    <div class="col-md-4">
                        <div class="form-check-inline checkbox-dark">
                            <input type="checkbox" id="nearest_expiry_filter" wire:model="nearest_expiry_filter" name="customCheckboxInline2">
                            <label for="nearest_expiry_filter">@lang('lang.nearest_expiry_filter')</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check-inline checkbox-dark">
                            <input type="checkbox" id="longest_expiry_filter" wire:model="longest_expiry_filter" name="customCheckboxInline2">
                            <label for="longest_expiry_filter">@lang('lang.longest_expiry_filter')</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="row">
                    {{-- ++++++++++++++++++++++ مخزن ++++++++++++++++++++++ --}}
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('store_id', __('lang.store') . ':*', []) !!}
                            {!! Form::select('store_id', $stores, $store_id,
                            ['class' => 'select2 form-control', 'data-live-search' => 'true','id'=>'store_id', 'required', 'placeholder' => __('lang.please_select'),
                             'data-name' => 'store_id','wire:model' => 'store_id', 'wire:change' => 'changeStorePos']) !!}
                            @error('store_id')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- ++++++++++++++++++++++ نقاط البيع +++++++++++++++++++++ --}}
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('store_pos_id', __('lang.pos') . ':*', []) !!}
                            {!! Form::select('store_pos_id', $store_pos, $store_pos_id, ['class' => 'select2 form-control','data-name'=>'store_pos_id', 'data-live-search' => 'true', 'required', 'placeholder' => __('lang.please_select'), 'wire:model' => 'store_pos_id']) !!}
                            @error('store_pos_id')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- +++++++++++++++++++++++++ حالة السداد ++++++++++++++++++++++++++++ --}}
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('payment_status', __('lang.payment_status') . ':', []) !!}
                            {!! Form::select('payment_status', ['pending' => __('lang.pending'),'paid' => __('lang.paid'), 'partial' => __('lang.partial')],'paid', ['class' => 'form-control select2' ,'data-name'=>'payment_status', 'data-live-search' => 'true', 'placeholder' => __('lang.please_select'), 'wire:model' => 'payment_status']) !!}
                            @error('payment_status')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- +++++++++++++++++ Customers Dropdown +++++++++++++++++ --}}
                    <div class="col-md-2">
                        <label for="" class="text-primary">العملاء</label>
                        <div class="d-flex justify-content-center">
                            
                            <select class="form-control client select2" wire:model="client_id" id="client_id" data-name="client_id">
                                <option  value="0 " readonly >اختر </option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{$client_id==$customer->id?'selected':''}}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-sm ml-2 text-white" style="background-color: #6e81dc;" data-toggle="modal" data-target="#add_customer"><i class="fas fa-plus"></i></button>
                        </div>
                        @error('client_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @include('invoices.partials.search')
            </div>
        </div>
        <div class="row g-3 cards hide-print ">
            @include('invoices.partials.products')
            <div class="col-xl-7 special-medal-col">
                <div class="card-app ">
                    <div class="body-card-app content py-2 ">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="body-card-app">
                                <div class="table-responsive box-table ">
                                    <table class="table">
                                        <tr>
                                            <th >@lang('lang.product')</th>
                                            <th >@lang('lang.quantity')</th>
                                            <th >@lang('lang.extra')</th>
                                            <th >@lang('lang.unit')</th>
                                            <th >@lang('lang.price')</th>
{{--                                        @if(!empty($showColumn))--}}
                                            <th >@lang('lang.price') $ </th>
                                            <th> @lang('lang.exchange_rate')</th>
{{--                                        @endif--}}
                                            <th >@lang('lang.discount')</th>
                                            <th >@lang('lang.discount_category')</th>
                                            <th >@lang('lang.sub_total')</th>
                                            <th >@lang('lang.sub_total') $</th>
                                            <th >@lang('lang.current_stock')</th>
                                            <th >@lang('lang.action')</th>
                                        </tr>
                                        @php
                                          $total = 0;
                                        @endphp
                                        @foreach ($items as $key => $item)
                                            <tr>
                                                <td >
                                                    {{$item['product']['name']}}
                                                </td>
                                                <td >
                                                    <div class="d-flex align-items-center gap-1 " style="width: 80px">
                                                        <div class=" add-num control-num"
                                                            wire:click="increment({{$key}})">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </div>
                                                        <input class="form-control p-1 text-center" style="width: 50px" type="text" min="1"
                                                            wire:model="items.{{ $key }}.quantity" Wire:change="subtotal({{$key}})">
                                                        @error("items.$key.quantity")
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <div class="decrease-num control-num"
                                                            wire:click="decrement({{ $key }})">
                                                            <i class="fa-solid fa-minus"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{$item['extra_quantity']}}</td>
                                                <td>
                                                    <select class="form-control" style="height:30% !important;width:100px;" wire:model="items.{{ $key }}.unit_id"  wire:change="changeUnit({{$key}})">
                                                        <option value="0.00">select</option>
                                                         @if(!empty($item['variation']))
                                                           @foreach($item['variation'] as $i=>$var)
                                                                <option value="{{$var['id']}}" {{$i==0?'selected':''}}>
                                                                    {{$var['unit']['name']??''}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                                <td >
                                                    {{$item['price']??''}}
                                                </td>
                                                    <td >
                                                        {{ number_format($item['dollar_price']??0 , 2)}}
                                                    </td>
                                                    <td>
                                                        <input class="form-control p-1 text-center" style="width: 65px" type="text" min="1"
                                                               wire:model="items.{{ $key }}.exchange_rate">
                                                    </td>

                                                <td >
                                                    <input class="form-control p-1 text-center" style="width: 65px" type="text" min="1" readonly
                                                                              wire:model="items.{{ $key }}.discount_price">
                                                </td>
                                                <td>
                                                    <select class="form-control discount_category " style="height:30% !important;width:80px;font-size:14px;" wire:model="items.{{ $key }}.discount"  wire:change="subtotal({{$key}})">
                                                        <option selected value="0">select</option>
                                                        @if(!empty($item['discount_categories']))
                                                            @if(!empty($client_id))
                                                                @foreach($item['discount_categories'] as $discount)
                                                                    @if($discount['price_category']!==null)
{{--                                                                        @if(in_array($client_id, $discount['price_customer_types']))--}}
                                                                            <option value="{{$discount['id']}}" >{{$discount['price_category']}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                @foreach($item['discount_categories'] as $discount)
                                                                    @if($discount['price_category']!==null)
                                                                        <option value="{{$discount['id']}}">{{ $discount['price_category'] ?? ''}} </option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    </select>
                                                </td>
                                                <td>
                                                    {{ $item['sub_total']??0 }}
                                                </td>
                                                <td>
                                                    {{$item['dollar_sub_total']??0}}
                                                </td>
                                                <td>
                                                    <span class="current_stock"> {{$item['quantity_available']??0}} </span>
                                                </td>
                                                <td  class="text-center">
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
                                            <hr />
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
@include('customers.quick_add',['quick_add'=>1])



{{--<!-- This will be printed -->--}}
<section class="invoice print_section print-only" id="receipt_section"> </section>
@push('javascripts')
    <script>
        document.addEventListener('livewire:load', function () {
            $('.depart').select().on('change', function (e) {
                @this.set('department_id', $(this).val());
            });
        });
        // document.addEventListener('livewire:load', function () {
        //     $('.client').select();
        //     // Trigger Livewire updates when the select2 value changes
        //     $('.client').on('change', function (e) {
        //     @this.set('client_id', $(this).val());
        //     });
        // });
        document.addEventListener('livewire:load', function () {
            $('#store_id').select();
            // Trigger Livewire updates when the select2 value changes
            $('#store_id').on('change', function (e) {
            @this.set('store_id', $(this).val());
            });
        });
        document.addEventListener('livewire:load', function () {
            Livewire.on('printInvoice', function (htmlContent) {
                // Set the generated HTML content
                $("#receipt_section").html(htmlContent);
                // Trigger the print action
                window.print("#receipt_section");
            });
        });
        // document.addEventListener('livewire:load', function () {
        //     Livewire.on('hideModal', function ($customer) {
        //         $(".modal-backdrop").removeClass("show");
        //         $("#add_customer").removeClass("show");
        //
        //     });
        // });
        // document.addEventListener('livewire:load', function () {
        //     Livewire.on('customerAdded', function ($customer) {
        //         // Re-render the Livewire component to refresh the <select>
        //         Livewire.emit('refreshSelect');
        //     });
        // });
        {{--window.addEventListener('showCreateProductConfirmation', function() {--}}
        {{--    Swal.fire({--}}
        {{--        title: "{{ __('lang.this_product_exists_before') }}" + "<br>" +--}}
        {{--            "{{ __('lang.continue_to_add_stock') }}",--}}
        {{--        icon: 'warning',--}}
        {{--        showCancelButton: true,--}}
        {{--        confirmButtonText: 'Yes',--}}
        {{--        cancelButtonText: 'No',--}}
        {{--    }).then((result) => {--}}
        {{--        if (result.isConfirmed) {--}}
        {{--            Livewire.emit('create');--}}
        {{--        } else {--}}
        {{--            Livewire.emit('cancelCreateProduct');--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}
        $(document).ready(function() {
            $('select').on('change', function(e) {

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
    </script>

@endpush
